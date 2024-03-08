<?php

namespace App\Http\Controllers\Admin;
ini_set('max_execution_time', 300);

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\PostMediaModel;
use App\Models\User as User;
use Auth;
use Config;
use File;
use Illuminate\Http\Request;
use Input;
use Redirect;

class PostMediaController extends AdminBaseController {

	private $pageSlug;
	public $tree = array();
	private $uploadPath = 'public/post';

	protected $allowedFileExtensions = [];
	protected $imageDimesions = [];

	public function __construct(Request $request) {
		parent::__construct($request);
		$this->imageDimesions = \Config::get('pgsimagedimensions');
		$this->allowedFileExtensions = ['jpeg', 'jpg', 'png', 'svg', 'gif', 'bmp', 'webp', 'pdf', 'docx', 'doc', 'xls', 'xlsx', 'odt','mp4','mp3'];
	}

	public function index() {

		$this->data['fileList'] = PostMediaModel::where('pm_owner_id', '=', Auth::user()->id)
			->paginate(5);
		
	}

	public function create(Request $request) {

		if ($request->hasFile('file')) {

			// If a custom path has been defined
			if (!empty($request->input('uploadPath'))) {
				$this->uploadPath = $request->input('uploadPath');
			}

			

			$file = $this->store_file('file', $this->uploadPath);

			$data = null;
			if (!empty($file)) {

				$nameOnly = basename($request->file('file')->getClientOriginalName(), '.' . $request->file('file')->getClientOriginalExtension());
				$extension = strtolower($request->file('file')->getClientOriginalExtension());
				$size = $request->file('file')->getSize();
				$mimeType = $request->file('file')->getClientMimeType();
				$mediaType = 'unknown';
				if (!in_array($extension, $this->allowedFileExtensions)) {
					return response()->json(array('status' => false, 'data' => $responseData, 'message' => lang('invalid_file')));
				}
               
				switch ($extension) {
				case 'jpeg':
				case 'jpg':
				case 'png':
				case 'svg':
				case 'gif':
				case 'bmp':
				case 'webp':
					$mediaType = 'image';
					break;

				case 'pdf':
				case 'docx':
				case 'doc':
				case 'xls':
				case 'xlsx':
				case 'odt':
			   case 'mp4':
					$mediaType = 'file';
					break;
				}

				$data = [
					'pm_name' => $nameOnly,
					'pm_orig_name' => $file[1],
					'pm_file_hash' => $file[0],
					'pm_media_type' => $mediaType,
					'pm_owner_id' => (Auth::user()) ? Auth::user()->id : null,
					'pm_file_type' => $mimeType,
					'pm_extension' => $extension,
					'pm_size' => $size,
					'pm_cat' => $request->input('name'),
					'pm_status' => 2,
				];

				try {
					$newData = PostMediaModel::create($data);

					$responseData = [
						'fileName' => $file[0],
						'name' => $nameOnly . '.' . $extension,
						'fieldName' => $request->input('name'),
						'size' => $size,
						'mimeType' => $mimeType,
						'id' => $newData->pm_id,
					];

					$postSlug = $request->input('slug');

					$name = $request->input('name');

					if (!empty($postSlug) && !empty($this->imageDimesions[$request->input('name')])) {

						$this->resize_image($file[0], $this->uploadPath, $this->imageDimesions[$request->input('name')]);
						
					} else if (!empty($this->imageDimesions[$request->input('slug')])) {
						$this->resize_image($file[0], $this->uploadPath, $this->imageDimesions[$request->input('slug')], false);
					}

					return response()->json(array('status' => true, 'data' => $responseData));
				} catch (Exception $e) {
					return response()->json(array('status' => false, 'data' => $responseData, 'message' => lang('db_operation_failed')));
				}

			}

		}

		return response()->json(array('status' => false, 'message' => lang('no_file_uploaded')));
	}

	public function save_youtube_video(Request $request) {
		if (!$request->ajax()) {
			return redirect()->to(apa('dashboard'));
		}
		
		if ($request->input('youtubeURL')) {

			$youtubeURL = $request->input('youtubeURL');
			$videoID = getYoutubeVideoID($youtubeURL);
			if (empty($videoID)) {
				return response()->json(array('status' => false, 'message' => lang('invalid_youtube_url')));
			}

			$data = [
				'pm_media_type' => 'video',
				'pm_cat' => 'video',
				'pm_lang' => $request->input('videoLang'),
				'pm_name' => $videoID,
				'pm_title' => $request->input('videoTitle'),
				'pm_title_arabic' => $request->input('videoTitleAr'),
				'pm_source' => $request->input('videoSource'),
				'pm_source_arabic' => $request->input('videoSourceAr'),
				'pm_status' => 1,
			];

			try {

				$customImageId = $request->input('customImage');

				$postDetails = PostMediaModel::find($customImageId);

				if (!empty($customImageId)) {
					PostMediaModel::where('pm_post_id', '=', $postDetails->post_id)->update($data);
				} else {
					$postDetails = PostMediaModel::create($data);
				}

				$responseData = [
					'video' => $videoID,
					'fileName' => $postDetails->pm_file_hash,
					'title' => $postDetails->pm_title,
					'titleAR' => $postDetails->pm_title_arabic,
					'source' => $postDetails->pm_source,
					'sourceAR' => $postDetails->pm_source_arabic,
					'lang' => $postDetails->pm_lang,
					'fieldName' => 'video',
					'size' => $videoID,
					'type' => 'video',
					'id' => $postDetails->pm_id,
				];

				return response()->json(array('status' => true, 'data' => $responseData));
			} catch (Exception $e) {
				return response()->json(array('status' => false, 'data' => $responseData, 'message' => lang('db_operation_failed')));
			}

		}

		return response()->json(array('status' => false, 'message' => lang('no_file_uploaded')));
	}

	public function delete($fileID, Request $request) {

		$postMedia = PostMediaModel::where('pm_file_hash', $fileID)->orWhere('pm_id', $fileID)->first();
		if (empty($postMedia)) {
			return response()->json(['status' => false, 'message' => lang('invalid_file')]);
		}

		try {
			$request->flash();

			$update = $postMedia->where('pm_owner_id', '=', Auth::user()->id)
			    ->where('pm_file_hash', $fileID)->orWhere('pm_id', $fileID)
				->update(['pm_status' => 3]);
			$postMedia->delete();
		} catch (\Exception $e) {
			$request->flash();
			//return response()->json(['status' => false, 'message' => lang('invalid_file')]);
		}

		return response()->json(['status' => true, 'message' => lang('file_deleted')]);
	}
	public function update_priority(Request $request) {

		$gallaeryIds = $request->ids;
		$priority = 1;

		foreach ($gallaeryIds as $galId) {
			PostMediaModel::where('pm_id', '=', $galId)->update(['pm_priority' => $priority]);
			$priority++;

		}

	}

	public function update_text(Request $request) {
		$id = $request->_text_id;
		$dbColoumn = $request->_text_type;
		$_text = (empty($request->_text)) ? "NULL" : $request->_text;
		try {
			PostMediaModel::where('pm_id', '=', $id)->update([$dbColoumn => $_text]);
			return response()->json(['status' => true, 'message' => 'Text Updated']);
		} catch (\Exception $ex) {
			$request->flash();
			if ($request->ajax()) {
				return response()->json(['status' => false, 'message' => 'Cannot update text']);
			}

			return redirect()->to(apa('/dashboard'))->with('errorMessage', lang('invalid_request'));
		}

	}

	public function post_media_download($fileID, Request $request) {

		if (empty($fileID)) {return response()->json(['status' => false, 'message' => lang('invalid_file')]);}

		try {

			if (Auth::user()) {
				if (Auth::user()->isAdmin()) {
					$fileDetails = PostMediaModel::where('pm_id', '=', $fileID)->first();
					
				} else {
					$fileDetails = PostMediaModel::join('users as U', 'U.id', '=', 'pm_owner_id')
						->where('pm_id', '=', $fileID)
						->where('pm_owner_id', '=', Auth::user()->id)
						->first();
				}
			}

			

			if (empty($fileDetails)) {
				
				return redirect()->to(apa('/dashboard'))->with('errorMessage', lang('invalid_request'));
			}

			if ($fileDetails->pm_type == 'video' && empty($fileDetails->pm_extension)) {
				
				return redirect()->to(apa('/dashboard'))->with('errorMessage', 'Youtube video cannot be downloaded');
			}

			
			$pathToFile = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'post' . DIRECTORY_SEPARATOR . $fileDetails->pm_file_hash);
			
			$name = $fileDetails->pm_name . '.' . $fileDetails->pm_extension;

			

			return response()->download($pathToFile, $name);
		} catch (\Exception $ex) {
			
			$request->flash();
			
			return redirect()->to(apa('/dashboard'))->with('errorMessage', lang('invalid_request'));
		}
		
		return redirect()->to(apa('/dashboard'))->with('errorMessage', lang('invalid_request'));

	}

	public function download_file_from_file_name($fileName) {

		$return = redirect()->to(apa('dashboard'));

		if (\File::exists(storage_path('app/public/post/') . $fileName)) {
			$return = response()->download(storage_path('app/public/post/') . $fileName);
		}

		return $return;
	}
}