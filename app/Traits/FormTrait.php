<?php
namespace App\Traits;
use App;
use Illuminate\Http\Request;
trait FormTrait {
	protected function generateFormElements(Request $request) {

		$formElementsCollection = self::$formElement;
		$formElements = [];

		foreach ($formElementsCollection as $key => $formElement) {

			$formElements[$key] = [
				'field_name' => $key,
				'field_label' => !empty($formElement['label']) ? $formElement['label'] : "",
				'field_type' => !empty($formElement['type']) ? $formElement['type'] : "",
				'field_helper_text' => !empty($formElement['helper_text']) ? $formElement['helper_text'] : "",
			];

			switch ($formElement['type']) {
			case "select":
				$formElement['data'] = (!empty($formElement['data'])) ? $formElement['data'] : [];
				$modelArr = (!empty($formElement['model'])) ? $formElement['model'] : [];

				if (!empty($modelArr)) {
					$modelName = isset($modelArr['src']) ? $modelArr['src'] : null;
					$modelArrSrc = isset($modelArr['arr']) ? $modelArr['arr'] : null;
					$modelTitleKey = isset($modelArr['title_key']) ? \App::getLocale() == "en" ? $modelArr['title_key'] : $modelArr['title_key_arabic'] : null;
					$modelCondition = isset($modelArr['condition']) ? $modelArr['condition'] : null;
					$modelSortBy = isset($modelArr['sortBy']) ? $modelArr['sortBy'] : null;

					$postCollectionKey = isset($modelArr['post_collection']) ? $modelArr['post_collection'] : null;
					$categoryParentId = isset($modelArr['category_parent_id']) ? $modelArr['category_parent_id'] : null;

					if ($modelName) {
						if ($postCollectionKey) {
							$dataModel = $modelName::where('post_type', $postCollectionKey)
								->orderBy('post_title', 'asc')
								->get();
						} else {
							$dataModel = $modelName::when($modelCondition, function ($q) use ($modelCondition) {
								$q->where([$modelCondition]);
							})
								->when($modelSortBy, function ($q) use ($modelSortBy, $modelTitleKey) {
									$q->orderBy($modelTitleKey, $modelSortBy);
								})
								->get();
						}
					}

					$selectArr = [];

					if (!empty($dataModel) && !empty(($modelTitleKey))) {
						foreach ($dataModel as $d) {
							$selectArr[$d->getKey()] = (!empty($d->getData($modelTitleKey))) ? $d->getData($modelTitleKey) : lang($modelTitleKey);
						}

					} else if (!empty($modelArrSrc)) {
						foreach ($modelArrSrc as $key => $item) {
							$selectArr[$key] = $item;
						}
					}

					$formElements[$key]['field_data'] = $selectArr;
				}
				break;

			case "radio":
				$formElements[$key]['field_data'] = (!empty($formElement['data'])) ? $formElement['data'] : [];
				break;

			case "fileupload":
				$formElements[$key]['field_mimes'] = (!empty($formElement['mimes'])) ? $formElement['mimes'] : [];
				break;

			default:
				break;
			}

		}

		$formElementsHtml = view('frontend.partials.form-generator', ['formElements' => $formElements])->render();
		return $formElementsHtml;
	}

	protected function generateForm(Request $request, $formsToGenerate) {
		foreach ($formsToGenerate as $form) {
			// It would be like exampleFormHtml
			$this->data[\Str::camel($form . '_form_html')] = $this->generateFormElements($request, $form);
		}
	}

	// Returns the jQuery validator rules and message
	protected function generateFormValidation(Request $request) {
		// Get selected form elements
		$fields = [];
		$formRules = [];
		$formMessages = [];
		$messagesMap = [
			'required' => lang('field_required'),
			'myEmail' => lang('invalid_email'),
			'alphanumeric' => lang('no_spcl_char'),
			'url' => lang('invalid_url'),
			'equalTo' => lang('password_mismatch'),
			'checkIfRegistered' => lang('already_exists'),
			'validEmiratesId' => lang('invalid_emirates_id'),
		];

		
		$formElementsCollection = self::$formElement;
		foreach ($formElementsCollection as $k => $v) {
			$validationRules = !empty($v['validation']) ? explode('|', $v['validation']) : "";
			if (!empty($validationRules)) {
				$fields[$k] = $validationRules;
			}
		}
		

		if (!empty($fields) && count($fields) > 0) {
			// Generate rules
			foreach ($fields as $k => $field) {
				foreach ($field as $rule) {
					if (is_string($rule)) {

						switch ($rule) {
						// Most of these validation rules will be set as 'true'
						case "required":
						case "myEmail":
						case "alphanumeric":
						case "url":
						case "checkIfRegistered":
						case "validEmiratesId":
							$formRules[$k][$rule] = true;
							break;

						// Check min/max length of characters
						case (preg_match('/min/', $rule) ? true : false):
						case (preg_match('/max/', $rule) ? true : false):
							$x = explode(':', $rule);
							$formRules[$k][$x[0]] = intval($x[1]);
							break;

						// Used mainly for password confirmation
						case (preg_match('/equalTo/', $rule) ? true : false):
							$x = explode(':', $rule);
							$formRules[$k][$x[0]] = $x[1];
							break;
						}
					}
				}
			}

			// Generate messages
			foreach ($fields as $k => $field) {
				foreach ($field as $rule) {
					if (is_string($rule)) {
						$message = "";
						if (array_key_exists($rule, $messagesMap)) {
							$message = $messagesMap[$rule];
							$formMessages[$k][$rule] = $message;
						} else if (strpos($rule, 'min') !== false) {
							$x = explode(':', $rule);
							$message = trans('messages.min_x_chars_required', ['Y' => $x[1], 'X' => lang($k)]);
							$formMessages[$k][$x[0]] = $message;
						} else if (strpos($rule, 'max') !== false) {
							$x = explode(':', $rule);
							$message = trans('messages.max_x_chars_required', ['Y' => $x[1], 'X' => lang($k)]);
							$formMessages[$k][$x[0]] = $message;
						} else if (strpos($rule, 'equalTo') !== false) {
							// Used mainly for password confirmation
							$x = explode(':', $rule);
							$formMessages[$k][$x[0]] = $messagesMap[$x[0]];
						}
					}
				}
			}
		}

		return  ['formRules' => json_encode($formRules), 'formMessages' => json_encode($formMessages)];
	}
}
?>