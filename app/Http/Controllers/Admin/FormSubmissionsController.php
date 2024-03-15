<?php
namespace App\Http\Controllers\Admin;

use App\Exports\GeneralExcelExport;
use App\Exports\IdeaSubmissionsExport;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\Admodels\PostModel;
use App\Models\ContactModel;
use App\Models\CountryModel;
use App\Models\User;
use Auth;
use Config;
use DB;
use File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\YourIdeasModel;

class FormSubmissionsController extends AdminBaseController {
	protected $roleNames;
	private $excelExportHeaders = [];

	public function __construct(Request $request) {

		parent::__construct($request);
	}

	private function searchFilter($searchFields, Request $request) {
		foreach ($searchFields as $field) {
			if (!empty($request->input($field['field_name']))) {
				switch ($field['queryType']) {
				case 'LIKE':
					$this->data['submissionList'] = $this->data['submissionList']->where($field['field_name'], 'LIKE', '%' . $request->input($field['field_name']) . '%');
					break;

				case '=':
				default:
					$this->data['submissionList'] = $this->data['submissionList']->where($field['field_name'], '=', $request->input($field['field_name']));
					break;
				}
			}
		}
	}

	/**
	 * list all registration with email id
	 *@param Request $request
	 *
	 *@return View
	 */
	public function index(Request $request) {

		switch ($request->formType) {

		case "contact-us-submissions":
			$page = "admin.registrations.contact-us-submissions";

			$submissionList = ContactModel::filter()
				->with(['subject'])
				->when(request()->input('from_date'), function ($q) {
					$q->whereRaw('DATE(cm_created_at) >= "' . date('Y-m-d', strtotime(request()->input('from_date'))) . '"');
				})
				->when(request()->input('to_date'), function ($q) {
					$q->whereRaw('DATE(cm_created_at) <= "' . date('Y-m-d', strtotime(request()->input('to_date'))) . '"');
				})
				->orderBy('cm_created_at', 'desc');

			// $this->data['filterDOM'] = ContactModel::getFilterDom($request);
			$this->data['submissionList'] = $submissionList;
			break;

		case "user-registrations":
			$page = "admin.registrations.user-registrations";

			$submissionList = User::filter()
				->when(request()->input('from_date'), function ($q) {
					$q->whereRaw('DATE(created_at) >= "' . date('Y-m-d', strtotime(request()->input('from_date'))) . '"');
				})
				->when(request()->input('to_date'), function ($q) {
					$q->whereRaw('DATE(created_at) <= "' . date('Y-m-d', strtotime(request()->input('to_date'))) . '"');
				})
				->where('is_admin', '=', 2)
				->where('is_system_account', '=', 2)
				->where('is_backend_user', '=', 2)
				->orderBy('created_at', 'desc');

			$this->data['filterDOM'] = User::getFilterDom($request);
			$this->data['submissionList'] = $submissionList;
			break;

		default:
			break;
		}

		$this->data['formType'] = $request->formType;
		$this->data['submissionList'] = $this->data['submissionList']->paginate(20)
			->appends(request()->except('page'));

		$this->data['registrationData'] = $this->data['submissionList']->toJson();

		return view($page, $this->data);
	}

	/**
	 * list individual registration with email id
	 *@param Request $request
	 *
	 *@return View
	 */

	public function details(Request $request, $registerType = "", $id = "") {
		if (!empty($registerType) && !empty($id)) {
			switch ($registerType) {

			case "user-registrations":
				$this->data['registrant'] = User::where('id', $id)->first();
				$page = 'admin.registrations.user-registrations-details';
				break;

			default:
				break;
			}

			if (empty($this->data['registrant'])) {
				$msg = '<div class="alert alert-danger">Registrant Not found</div>';
				return redirect()->to(apa('registrations/' . $registerType, true))->with('userMessage', $msg);
			}
			return view($page, $this->data);

		} else {
			return redirect()->to(apa('registrations/' . $registerType, true))->with('userMessage', "This page doesn't exist!");
		}
	}

	public function downloadRegistration($formType, Request $request) {
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 500);
		list($fileName, $export) = $this->createExcelExportObject($formType, $request);
		return Excel::download($export, $fileName);
	}

	public function downloadZip($formType, Request $request) {
		$file = new Filesystem;
		$file->cleanDirectory(storage_path('app/exports'));
		return $this->createZip($formType, $request);
	}

	private function createZip($formType, $request) {

		list($fileName, $export) = $this->createExcelExportObject($formType, $request);
		$excelimport = Excel::store($export, $fileName);

		$zipArr[] = storage_path('app/' . $fileName);

		switch ($formType) {
		case "contact-us-submissions":
			$registrations = ContactModel::filter($request)->get();
			break;
		case "user-registrations":
			$registrations = User::filter($request)->get();
			break;
		default:
			break;
		}

		foreach ($registrations as $registration) {
			$zipArr[] = $this->createZipDownload($request, $registration, false, null);
		}

		return $this->createZipDownload($request, null, true, $zipArr);
	}

	protected function createZipDownload(Request $request, $registrant, $download = true, $massDownloads = null) {
		$public_dir = storage_path('app/exports');

		/*Will be a Mass Download including all individual Zips & excel sheet*/
		if (empty($registrant) && !empty($massDownloads)) {

			$zipFileName = 'export-' . rand() . '.zip';
			$zip = new \ZipArchive;

			if ($zip->open($public_dir . DIRECTORY_SEPARATOR . $zipFileName, \ZipArchive::CREATE) === TRUE) {
				
				foreach ($massDownloads as $file) {
					if (\File::exists($file)) {
						$extension = \File::extension($file);
						$fileInsideZipName = pathinfo($file)['filename'] . '.' . $extension;
						$zip->addFile($file, $fileInsideZipName);
					}
				}

				$zip->close();
				/* Delete File after adding to zip */
				foreach ($massDownloads as $file) {
					\File::delete($file);
				}
			}
		}

		/*Will be a single Zip which is not a mass download */
		if (!empty($registrant)) {

			$data = [
				['folder' => 'bd_trade_license', 'label' => 'trade_license', 'file' => @$registrant->getMeta('bd_trade_license_file')],
				['folder' => 'emirates_id', 'label' => 'emirates_id', 'file' => @$registrant->getMeta('emirates_id_file')],
			];

			$registrantName = $registrant->getName();
			$zipFileName = $registrantName . '_attachments_' . rand() . '.zip';
			$zip = new \ZipArchive;

			$paths = [];

			if ($zip->open($public_dir . DIRECTORY_SEPARATOR . $zipFileName, \ZipArchive::CREATE) === TRUE) {
				foreach ($data as $key => $record) {
					if (!empty($record['file'])) {
						$file = $record['file'];
						$pathToFile = storage_path('app' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR) . $record['folder'] . DIRECTORY_SEPARATOR . $file;
						$paths[] = $pathToFile;
						if (!empty($file) && \File::exists($pathToFile)) {
							$extension = \File::extension($file);
							$fileInsideZipName = $registrantName . '_' . $record['label'] . '.' . $extension;
							$zip->addFile($pathToFile, $fileInsideZipName);
						}
					}
				}
				$zip->close();
			}
		}

		if (!empty($zipFileName)) {
			$filetopath = $public_dir . '/' . $zipFileName;
			if ($download) {

				$headers = array(
					'Content-Type' => 'application/octet-stream',
				);

				if (file_exists($filetopath)) {
					return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
				}
			} else {
				return $filetopath;
			}
		}

		return null;
	}

	private function prepareData($formType, $dataObject, Request $request) {
		$data = [];
		$slNo = 1;

		switch ($formType) {
		case "contact-us-submissions":
			foreach ($dataObject as $val) {
				$eachRow = [
					$slNo,
					!empty($val->getName()) ? $val->getName() : "N/A",
					!empty($val->getPhoneNumber()) ? $val->getPhoneNumber() : "N/A",
					!empty($val->getEmailAddress()) ? $val->getEmailAddress() : "N/A",
					!empty($val->subject) ? $val->subject->post_title : "N/A",
					!empty($val->getMessage()) ? $val->getMessage() : "N/A",
					$val->getCreatedAt(),
				];

				$data[] = $eachRow;
				$slNo++;
			}
			break;

		case "user-registrations":
			foreach ($dataObject as $val) {

				$userData = array_merge(
					array_values($val->getOwnershipInformation()),
					array_values($val->getBusinessInformation()),
					array_values($val->getActivitiesInformation())
				);

				$userDataValues = array_map(function($info) use($val) {
					if(!in_array($info['label'], $this->excelExportHeaders)) {
						$this->excelExportHeaders[] = $info['label'];
					}
					unset($info['label']);
					return $info['content'];
				}, $userData);

				$eachRow = array_merge([$slNo], $userDataValues, [$val->getCreatedAt()]);
				$data[] = $eachRow;
				$slNo++;
			}

			$this->excelExportHeaders = array_merge(['Sl. No'], $this->excelExportHeaders, ['Registered On']);
			break;

		default:
			break;
		}
		return $data;
	}

	private function createExcelExportObject($formType, $request) {

		switch ($formType) {
		case "contact-us-submissions":
			$dataObject = ContactModel::filter()
				->when(request()->input('event_date'), function ($q) {
					$q->whereRaw('DATE(cm_event_date) = "' . date('Y-m-d', strtotime(request()->input('event_date'))) . '"');
				})
				->when(request()->input('from_date'), function ($q) {
					$q->whereRaw('DATE(cm_created_at) >= "' . date('Y-m-d', strtotime(request()->input('from_date'))) . '"');
				})
				->when(request()->input('to_date'), function ($q) {
					$q->whereRaw('DATE(cm_created_at) <= "' . date('Y-m-d', strtotime(request()->input('to_date'))) . '"');
				})
				->orderBy('cm_created_at', 'desc')
				->get();
				
				$headers = [
					'Sl No',
					'Name',
					'Phone Number',
					'Email Address',
					'Subject',
					'Message',
					'Date',
				];
			break;

		case "user-registrations":
			$dataObject = User::filter()
				->when(request()->input('from_date'), function ($q) {
					$q->whereRaw('DATE(created_at) >= "' . date('Y-m-d', strtotime(request()->input('from_date'))) . '"');
				})
				->when(request()->input('to_date'), function ($q) {
					$q->whereRaw('DATE(created_at) <= "' . date('Y-m-d', strtotime(request()->input('to_date'))) . '"');
				})
				->orderBy('created_at', 'desc')
				->where('is_admin', '=', 2)
				->where('is_system_account', '=', 2)
				->where('is_backend_user', '=', 2)
				->get();
			$headers = [];
			break;

		default:
			break;
		}

		if (empty($dataObject)) {
			return false;
		}

		$data = $this->prepareData($formType, $dataObject, $request);

		$fileName = $formType . "-List-" . date('Y-m-d-H:i:s') . ".xlsx";
		$export = new GeneralExcelExport($request, $data, [
			'headers' => !empty($headers) ? $headers : $this->excelExportHeaders,
		]);
		return [$fileName, $export];
	}

	public function viewAttachments($filename, $type) {

		$path = storage_path('app/uploads/' . $type . '/' . $filename);
		if (!File::exists($path)) {
			abort(404);
		}
		$file = File::get($path);
		$type = File::mimeType($path);
		$response = \Response::make($file, 200);
		$response->header("Content-Type", $type);
		ob_end_clean();
		return $response;

	}

	public function downloadRegistrantAttachment(Request $request, $formType, $fileType, $id) {

		if (empty($formType)) {
			return redirect()->to(apa('dashboard'));
		}

		switch ($formType) {
		case "user-registrations":
			$model = User::findorfail($id);
			$directories = [
				'emirates_id_file' => 'emirates_id',
				'bd_trade_license_file' => 'bd_trade_license',
			];
			break;
		}

		$fileName = "";
		$fileContents = "";

		if (!empty($model)) {
			$fileName = $model->getMeta($fileType);
			$fileContents = storage_path('app/uploads/' . $directories[$fileType] . '/' . $fileName);
		} else {
			return redirect()->to(\URL::to('/'))->with('userMessage', lang('invalid_request'));
		}

		if (!empty($fileContents) && File::exists($fileContents)) {
			return response()->download($fileContents, $directories[$fileType] . '.' . pathinfo($fileContents)['extension']);
		} else {
			return redirect()->to(\URL::to('/'))->with('userMessage', lang('invalid_request'));
		}
	}

	public function ideaSubmission(Request $request)
	{
        
		$this->data['ideaSubmission'] =YourIdeasModel::filter($request)
													   ->orderBy('created_at','desc')
													   ->paginate(20);
		
		$this->data['filterDOM']=YourIdeasModel::getFilterDom($request);
	    return view('admin.idea_submission.list',$this->data);
	}

	public function ideaDownload(Request $request)
	{
		ini_set('memory_limit', '1024M');
		ini_set('max_execution_time', 500);
		$export = new IdeaSubmissionsExport($request);
		ob_end_clean();
		return Excel::download($export, 'Idea Submissions '.date('Y-m-d').'.xlsx');
	}

}