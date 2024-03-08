<?php
namespace App\Http\Controllers\Admin;

use App\Exports\GeneralExcelExport;
use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Imports\GeneralExcelImport;
use App\Models\Admodels\PostModel;
use Carbon\Carbon;
use DB,Storage;
use File,Image;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admodels\PostMediaModel;
use Illuminate\Http\UploadedFile;

class DataImportController extends AdminBaseController {
	protected $roleNames;
	private $excelExportHeaders = [];                
	protected $imageDimension = [];                

	public function __construct(Request $request) {
		parent::__construct($request);
		$this->imageDimension = \Config::get('pgsimagedimensions');
	}

	public function importPostData(Request $request) {
		
		// Todo - File Request
		ini_set("memory_limit", "1024M");
		ini_set("max_execution_time", 500);
		if (!empty($request->file('post_import'))) {

			$result = Excel::toArray(new GeneralExcelImport(), $request->file('post_import'))[0];
			$header = $result[0];

			unset($result[0]);
			try {
				DB::beginTransaction();
				$post_type='';
				foreach ($result as $row) {
					$postData = [];
					$postMetaData = [];
					foreach ($row as $key => $item) {
						if($key=="post_type"){
							$post_type=$item;
						}
						$field = $header[$key];
						if (strpos($field, "post_") === 0) {
							$postData[$field] = $item;
						} elseif (strpos($field, "meta-") === 0) {
							$metakeyArr = explode('-', $field);
							$metakey = Arr::last($metakeyArr);
							if (isset($metakeyArr[1]) && $metakeyArr[1] == "datetime") {
								$item=str_replace("'","",$item);
								$val1 = Carbon::parse($item)->format($this->postDateFormat);
								$postMetaData[$metakey] = $this->_getCarbonObject($val1, $this->postDateFormat);
							}elseif(isset($metakeyArr[1]) && $metakeyArr[1] == "imageupload"){
								$postMetaData[$metakey] =$this->fileFromUrl($item,$post_type,$metakey);
							} else {
								$postMetaData[$metakey] = $item;
							}

						}
					}

					$postDetails = PostModel::create($postData);
					if (!empty($postMetaData)) {
						$postDetails->syncMeta($postMetaData);
					}
				}
				DB::commit();
			} catch (\Exception $ex) {
				DB::rollback();

				$messsage = $this->custom_message($ex->getMessage(), 'error');
				return redirect()->to(apa('import-posts', true))->with('errorMessage', $messsage);
			}

			$messsage = $this->custom_message("Data Imported Successfully", 'success');
			return redirect()->to(apa('import-posts', true))->with('userMessage', $messsage);
		}
		$this->data['postTypes'] = PostModel::select('post_type')->distinct('post_type')->get();

		return view('admin.import_data.list', $this->data);
	}
	// Translation export
	public function exportPostData(Request $request) {
		
		$post_type = $request->input('post_type');

		$postModel = PostModel::where('post_type', $post_type)->get();
		if (empty($postModel)) {
			$message = $this->custom_message('Data not found', 'error');
			return redirect()->to(route('import-posts'))->with('errorMessage', $message);
		}

		$first = $postModel->first();
		$headers = [];

		foreach ($first->toArray() as $key => $item) {
			if (is_array($item)) {
				$sub = $key;
				foreach ($item as $key => $subitem) {
					$subKey = $sub . '-' . $subitem['type'] . '-' . $subitem['key'];
					
					if(checkFileOrNot($subitem['value'])){
						if (Storage::disk('local')->has('/public/post/' . $subitem['value'])) {
							$subKey = $sub . '-imageupload-' . $subitem['key'];
						}
					}
					array_push($headers, $subKey);
				}
			} else {
				array_push($headers, $key);
			}

		}

		ini_set("memory_limit", "1024M");
		ini_set("max_execution_time", 500);
		ob_start();

		$slNo = 1;
		$data = [];
		foreach ($postModel as $row) {
			$rowitem = [];
			foreach ($headers as $i => $head) {
				$rowitem[$head] = null;
			}
			foreach ($row->toArray() as $key => $item) {
				if (is_array($item)) {
					$sub = $key;
					foreach ($item as $key => $subitem) {

						$subKey = $sub . '-' . $subitem['type'] . '-' . $subitem['key'];
						$value = $subitem['value'];
						if(checkFileOrNot($subitem['value'])){
							if (Storage::disk('local')->has('/public/post/' . $subitem['value'])) {
								$value = PPO($subitem['value']);
								$subKey = $sub . '-imageupload-' . $subitem['key'];
							}
						}
						$rowitem[$subKey] = $value;

					}
				} else {
					$rowitem[$key] = $item;
				}
			}
			$data[] = $rowitem;
		}

		$fileName = $post_type . ".xlsx";
		$export = new GeneralExcelExport($request, $data, [
			'headers' => $headers,
		]);
		if (ob_get_contents()) {
			ob_end_clean();
		}

		return Excel::download($export, $fileName);
	}
	private function _getCarbonObject($dateStr, $sourceFormat) {

		$dateObj = Carbon::createFromFormat($sourceFormat, $dateStr);

		if (!$dateObj) {
			return false;
		}

		return $dateObj;
	}
    private function fileFromUrl($url,$post_type,$fieldName)
	{
		if(!empty($url)){
			$contents = file_get_contents($url);
			$name = substr($url, strrpos($url, '/') + 1);
			$nameArr =explode('.',$name);
			$nameOnly=(isset($nameArr[0]))?$nameArr[0]:'';
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$fileName = md5(microtime()) . '.' . $ext;
			$file= \Storage::put('public/post/'.$fileName, $contents);
			$mediaType = 'image';
			switch ($ext) {
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
					$mediaType = 'file';
					break;
				case 'mp4':
					$mediaType = 'video';
					break;
			}
			$fileNamedim=$fieldName.'_file';
			$data = [
				'pm_name' => $nameOnly,
				'pm_orig_name' => $name,
				'pm_file_hash' => $fileName,
				'pm_media_type' => $mediaType,
				'pm_owner_id' => 1,
				'pm_file_type' => null,
				'pm_extension' => $ext,
				'pm_size' => null,
				'pm_cat' => $fileNamedim,
				'pm_status' => 1,
			];
	
		
				$newData = PostMediaModel::create($data);
	
				
				if (!empty($this->imageDimension[$fileNamedim])) {
					$this->resize_image($fileName, 'public/post', $this->imageDimension[$fileNamedim]);
				} 
	
			return $fileName;
		}
		
		return "";
	}
	public function optimizeImages(Request $request)
    {

        $postMedia = PostMediaModel::where('pm_status', '1')->paginate(100);
      
        foreach ($postMedia as $media) {

            $slug = $media->pm_cat;
            $pm_hash = $media->pm_file_hash;
		   
            if (!empty($this->imageDimension[$slug])) {
                $this->resize_and_crop_image2($pm_hash, 'public/post/', $this->imageDimension[$slug]);
            }elseif(!empty($this->imageDimension[$slug.'_file'])){
				$this->resize_and_crop_image2($pm_hash, 'public/post/', $this->imageDimension[$slug.'_file']);
			}
			
        }

        echo "completed";
        echo $postMedia->links('pagination::bootstrap-4');
        die;
    }

    protected function resize_and_crop_image2($fileName, $destinationPath, $dimensions = array(), $oldFileName = '')
    {

        if (empty($destinationPath)) {
            return false;
        }

        if (empty($fileName)) {
            return false;
        }


		$sourcePath = storage_path('app/') . $destinationPath;

        $sourceImage = $sourcePath . DIRECTORY_SEPARATOR . $fileName;
		$mimeType =\File::mimeType( $sourceImage);
		
        if (!empty($dimensions) && File::exists($sourceImage)) {
			
            foreach ($dimensions as $key => $dim) {
			
                $crop = (isset($dim['crop'])) ? $dim['crop'] : $crop;
		
                if ($key == "large" || $key == "small" || $key == "thumb") {
				
                    if (!File::isDirectory($sourcePath. '/' . $key . "/")) {
                        File::makeDirectory($sourcePath . '/' . $key);
                    }
					
					if (!File::exists(storage_path('app/public/post/'.$key.'/') . $fileName)) {
                        if ($crop) {
							Image::make($sourceImage)
								->fit($dim['width'], $dim['height'])
								->interlace()
								->save($sourcePath . '/' . $key . '/' . $fileName)
								->destroy();
						} else {
	
							Image::make($sourceImage)
								->resize($dim['width'], $dim['height'], function ($constraint) {
									$constraint->aspectRatio();
									$constraint->upsize();
								})
								->interlace()
								->save($sourcePath . '/' . $key . '/' . $fileName)
								->destroy();
	
						}
					}
					
					
						try {
							$webpfile = explode('.', $fileName);
							$webpfileName = $webpfile[0] . '.webp';
							if (!File::exists(storage_path('app/public/post/'.$key.'/') . $webpfileName)) {
								
							
								$filePath = $sourcePath . $key . DIRECTORY_SEPARATOR . $fileName;
								$mimeType = $mimeType;
								$fileObjectwebp = new UploadedFile(
									$filePath,
									$fileName,
									$mimeType,
									1234,
									false,
									true
								);
								\Webp::make($fileObjectwebp)->save($sourcePath . '/' . $webpfileName);
								\Webp::make($fileObjectwebp)->save($sourcePath . '/' . $key . '/' . $webpfileName);
							}
							
						} catch (\Exception$ex) {
							//pre($ex->getMessage());
						}
					
                    
                }

            }
        }

    }


	public function general_file_import(Request $request)
	{
		ini_set("memory_limit", "1024M");
		ini_set("max_execution_time", 500);
	
		if (!empty($request->file('import_file')) && !empty($request->input('model_name')) ) {
			$tablename=$request->input('model_name');
			$ModelName=DIRECTORY_SEPARATOR .'App'.$tablename;
			$result = Excel::toArray(new GeneralExcelImport(), $request->file('import_file'))[0];
			$header = $result[0];

			unset($result[0]);
			
			try {
				DB::beginTransaction();
				$post_type='';
				foreach ($result as $row) {
					$dataArray = [];
					foreach ($row as $key => $item) {
						if($key=="post_type"){
							$post_type=$item;
						}
						$field = $header[$key];
						$dataArray[$field]= $item;

						/* IF DATE
							$dataArray[$field] = Carbon::parse($item)->format($this->postDateFormat);
						
						IF IMAGE
							$dataArray[$field] =$this->fileFromUrl($item,$Model,$field); */
						
						
					}
                  
				 $ModelName::insert($dataArray);
					
				}
				DB::commit();
			} catch (\Exception $ex) {
				DB::rollback();

				$messsage = $this->custom_message($ex->getMessage(), 'error');
				return redirect()->to(apa('import-data', true))->with('errorMessage', $messsage);
			}

			$messsage = $this->custom_message("Data Imported Successfully", 'success');
			return redirect()->to(apa('import-data', true))->with('userMessage', $messsage);
		
		}
		$this->data['postTypes'] = PostModel::select('post_type')->distinct('post_type')->get();


		$path = app_path() . DIRECTORY_SEPARATOR . "Models";
		$this->data['models']=$this->getModels($path);
		
		return view('admin.import_data.general_file_import', $this->data);
	}


	protected function getModels($path){
		$out = [];
		
		$results = scandir($path);
		foreach ($results as $result) {
			if ($result === '.' or $result === '..') continue;
			$filename = $path . DIRECTORY_SEPARATOR . $result;
			if (is_dir($filename)) {
				$out = array_merge($out, $this->getModels($filename));
			}else{
				$nameSpace =str_replace(app_path(),'',$filename);
				$nameSpace =str_replace('.php','',$nameSpace);
				$out[] =[
					'name'=>str_replace('.php','',$result),
					'value'=>$nameSpace,
				];
			}
		}
		return $out;
	}

	public function general_file_export(Request $request) {
		
		$tablename = $request->input('table_name');
		$ModelName=DIRECTORY_SEPARATOR .'App'.$tablename;
		
		$Model =  $ModelName::get();
		
		if(!empty($Model) && $Model->isNotEmpty()){
			$first = $Model->first();
			$headers = [];
	
			foreach ($first->toArray() as $key => $item) {
				if($key=="meta"){
					continue;
				 }
				 $headers[] = $key;
			}
	
			ini_set("memory_limit", "1024M");
			ini_set("max_execution_time", 500);
			ob_start();
	
			$slNo = 1;
			$data = [];
			foreach ($Model as $row) {
				
				$rowitem = [];
				
				foreach ($row->toArray() as $key => $item) {
					if($key=="meta"){
                       continue;
					}
					$rowitem[$key] = $item;
				}
				$data[] = $rowitem;
			}
			$tableModelname= $this->getModelName($ModelName);
			$fileName = $tableModelname ."-".date('Y-m-d'). ".xlsx";
			
			$export = new GeneralExcelExport($request, $data, [
				'headers' => $headers,
			]);
			if (ob_get_contents()) {
				ob_end_clean();
			}
			return Excel::download($export, $fileName);

		}else {
			$message = $this->custom_message('Data not found', 'error');
			return redirect()->to(route('import-data'))->with('errorMessage', $message);
		}

		
	}
	protected function getModelName($ModelName)
	{
        $list=explode(DIRECTORY_SEPARATOR,$ModelName);
		return end($list);
	}
}
