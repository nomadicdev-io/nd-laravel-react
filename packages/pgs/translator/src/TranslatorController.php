<?php
namespace Pgs\Translator;

use App\Exports\GeneralExcelExport;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Imports\GeneralExcelImport;
use App\User as User;
use Config;
use DB;
use File;
use Illuminate\Http\Request;
use Input;
use Intervention\Image\Exception\NotReadableException;
use Maatwebsite\Excel\Facades\Excel;
use Pgs\Translator\TranslationLanguageModels;
use Pgs\Translator\TranslatorModel;
use Validator;

class TranslatorController extends AdminBaseController {

	public function __construct(Request $request) {
		
		// $this->is_admin_login();
		$this->data['hasPluploader'] = false;
		$this->data['hasTextEditor'] = false;
		parent::__construct($request);

	}

	public function index(Request $request) {
		// die;
		$this->data['languages'] = TranslationLanguageModels::all();
		$translationModel = TranslatorModel::orderBy('key', 'asc')->orderBy('locale','asc');
		if ($request->input('search')) {
			if ($request->input('search_type')) {
				$translationModel->where('group', '=', $request->input('search_type'));
			}

			if ($request->input('search_locale')) {
				$translationModel->where('locale', '=', $request->input('search_locale'));
			}

			if ($request->input('search_key')) {
				$translationModel->where('key', '=', $request->input('search_key'));
			}

			if ($request->input('search_text')) {
				$translationModel->where('value', 'LIKE', '%' . $request->input('search_text') . '%');
			}
		}
		$this->data['translations'] = $translationModel->paginate(100)->appends(request()->except('page'));
		return view('pgs.translator.list', $this->data);

	}

	public function create(Request $request) {

		$this->data['languages'] = TranslationLanguageModels::all();
		if ($request->input('createbtnsubmit')) {
			$inputs = [
				'key' => $request->input('key'),
				'text' => $request->input('text'),
				'type' => $request->input('type'),
			];

			$rules = [
				'key' => 'required',
				'text' => 'required',
				'type' => 'required',
			];

			$messages = [
				'key.required' => 'Translation Key is required',
				'text' => 'Translation Text is required',
				'type' => 'Translation Type is required',
			];

			$validator = \Validator::make($inputs, $rules, $messages);

			if ($validator->fails()) {

				$messages = $validator->messages()->all();
				$userMessage = '<ul class="alert alert-danger">';
				foreach ($messages as $message) {
					$userMessage .= '<li>' . $message . '</li>';
				}
				$userMessage .= '</ul>';
				return Redirect(route('create_translation'))->with('userMessage', $userMessage);

			} else {
				$dataArr = [];
				$userMessage = '';
				foreach ($inputs['text'] as $locale => $langtext) {
					if ($langtext) {
						$data = [];
						$data['locale'] = $locale;
						$data['group'] = $inputs['type'];
						$data['key'] = $inputs['key'];
						$data['value'] = $langtext;
						
						try {
							$translation=TranslatorModel::where('locale',$locale)
							                ->where('group',$inputs['type'])
											->where('key',$inputs['key'])->first();
                            if(empty($translation)){
								$translation=TranslatorModel::Create($data);
								$userMessage .= 'Translation Created for ' . $locale . ' The Text is : ' . $langtext . ', ';
								\Artisan::call('translations:export {group}', ['group'=>'messages']);
							}else{
								$userMessage .= 'Translation Exists for ' . $locale . ' The Text is : ' . $langtext . ', ';
							}
							
						} catch (\Exception $e) {
							$userMessage .= 'Translation Exists for ' . $locale . ' The Text is : ' . $langtext . ', ';
						}
					} else {
						$request->flash();
						$userMessage .= 'Nothing to create for : ' . $locale . ', ';
						
					}
				}
				$userMessage =$this->custom_message($userMessage,'success');
				
				return Redirect(route('create_translation'))->with('userMessage', $userMessage);

			}
		}
		return view('pgs.translator.add', $this->data);
	}
	public function addLanguage(Request $request) {

		$this->data['languages'] = TranslationLanguageModels::all();
		if ($request->input('createbtnsubmit')) {
			$inputs = [
				'locale' => strip_tags($request->input('locale')) ,
				'name' => strip_tags($request->input('name')),
			];

			$rules = [
				'locale' => 'required|unique:translator_languages',
				'name' => 'required',
			];

			$messages = [
				'locale.required' => 'locale is required',
				'locale.unique' => 'Already Added',
				'name.required' => 'Name is required',
			];

			$validator = \Validator::make($inputs, $rules, $messages);

			if ($validator->fails()) {

				$messages = $validator->messages()->all();
				$userMessage= '<ul class="alert alert-danger">';
				foreach ($messages as $message) {
					$userMessage .= '<li>' . $message . '</li>';
				}
				$userMessage .= '</ul>';
				
				return Redirect(route('add-language'))->with('userMessage', $userMessage);

			} else {
				try {

				  TranslationLanguageModels::create($inputs); 
				  \Artisan::call('translations:export {group}', ['group'=>'messages']);
				  $userMessage= 'Language Added Successfully ';
				  $userMessage =$this->custom_message($userMessage,'success');

				} catch (\Exception $e) {
					$userMessage =$this->custom_message($e->getMessage(),'success');
				}
			
				
				return Redirect(route('add-language'))->with('userMessage', $userMessage);

			}
		}
		return view('pgs.translator.language', $this->data);
	}

	public function update(Request $request) {
		$id = $request->input('id');
		$value = $request->input('value');
		$response = ['status' => false];
		if (!empty($id) && !empty($value)) {
			$model = TranslatorModel::find($id);
			if (!empty($model)) {
				$model->update(['value' => $value]);
				$model->save();
				$response = ['status' => true];
			}
			\Artisan::call('translations:export {group}', ['group'=>'messages']);
		}
		return response()->json($response);
	}

	public function delete(Request $request, $id) {

		$translation = TranslatorModel::find($id);
		$userMessage = 'Translation Deleted Successfully';

		if (empty($translation)) {
			$errorMessage = 'Error , No Record found.';
			return redirect()->to(route('translate_index'))->with('errorMessage', $errorMessage);
		}

		$translation->delete();
		return redirect()->to(route('translate_index'))->with('userMessage', $userMessage);
	}
	public function deleteLang(Request $request, $id) {

		$language = TranslationLanguageModels::find($id);
	

		if (empty($language)) {
			
			$errorMessage =$this->custom_message('Error , No Record found.','error');
			return redirect()->to(route('add-language'))->with('errorMessage', $errorMessage);
		}

		$language->delete();
		$userMessage =$this->custom_message('Language Deleted Successfully','success');
		return redirect()->to(route('add-language'))->with('userMessage', $userMessage);
	}

	// Translation import
	public function importTranslations(Request $request) {

		// Todo - File Request
		ini_set("memory_limit", "1024M");
		ini_set("max_execution_time", 500);
		if (!empty($request->file('translations_import'))) {
			// $result = Excel::toArray(new GeneralExcelImport(), storage_path('app/pgstranslations.xlsx'))[0];
			$result = Excel::toArray(new GeneralExcelImport(), $request->file('translations_import'))[0];

			try {
				DB::beginTransaction();
				foreach ($result as $item) {
					if (!empty($item[0])) {
						$inputs = [
							'locale' => $item[0] != "*" ? $item[0] : "en",
							'namespace' => "*",
							'group' => "messages",
							'key' => $item[1],
							'value' => !empty($item[2]) ? $item[2] : $item[1],
							'unstable' => 0,
							'locked' => 0,
							'updated_at' => date("Y-m-d H:i:s"),
						];

						$oldRecord = TranslatorModel::where('key', $item[1])
							->where('locale', $item[0])
							->first();

						if (!empty($oldRecord)) {
							$oldRecord->fill($inputs)->save();
						} else {
							TranslatorModel::create($inputs);
						}

						DB::commit();
					}
				}
				\Artisan::call('translations:export {group}', ['group'=>'messages']);
			} catch (\Exception $ex) {
				DB::rollback();
				
			}
			return redirect()->to(apa('translator', true))->with('userMessage', "Updated");
		}
	}

	// Translation export
	public function exportTranslations(Request $request) {
		$translationModel = TranslatorModel::when($request->input('search_locale'), function ($q) use ($request) {
				$q->where('locale', '=', $request->input('search_locale'));
			})
			->when($request->input('search_key'), function ($q) use ($request) {
				$q->where('key', '=', $request->input('search_key'));
			})
			->when($request->input('search_text'), function ($q) use ($request) {
				$q->where('value', 'LIKE', '%' . $request->input('search_text') . '%');
			})
			->where('group', '=', 'messages')
			->orderBy('id', 'asc')
			->get();

		$data = [];

		ini_set("memory_limit", "1024M");
		ini_set("max_execution_time", 500);
		ob_start();
		$headers = [
			'locale',
			// 'namespace',
			// 'group',
			'key',
			'value',
			// 'unstable',
			// 'locked',
		];

		$slNo = 1;

		foreach ($translationModel as $item) {
			$eachRow = [
				$item->locale,
				// $item->namespace,
				// $item->group,
				$item->key,
				$item->value,
				// $item->unstable,
				// $item->locked,
			];

			$data[] = $eachRow;
			$slNo++;
		}

		$fileName = "pgstranslations.xlsx";
		$export = new GeneralExcelExport($request, $data, [
			'headers' => $headers,
		]);
		if (ob_get_contents()) ob_end_clean();
		return Excel::download($export, $fileName);
	}

}