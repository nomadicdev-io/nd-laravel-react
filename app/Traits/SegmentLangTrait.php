<?php
namespace App\Traits;
use App;
use Illuminate\Http\Request;
/*
| Language Switcher Trait ,
 */
trait SegmentLangTrait {
	/*
		* Set the language
		* @param String
		* @return response
	*/
	public function _SegmentLangTrait() {

		$this->middleware(function ($request, $next) {
			$lang = null;

			$languages = ['en', 'ar'];

			$reqLang = request()->segment(1);
			$defaultLang = (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->getMeta('default_lang') : 'ar';

			$disabledLang = (!empty($this->data['websiteSettings'])) ? $this->data['websiteSettings']->getMeta('disable_language') : '';

			// Use the default language
			$lang = $defaultLang;

			// If the requested language is available, use that.
			if (!empty($reqLang) && in_array($reqLang, $languages)) {
				$lang = $reqLang;
			}
			// If language is stored in the session, use that.
			else if (session()->has('lang')) {
				$lang = session()->get('lang');
			}

			// Check if the selected language is disabled or not, if it's disabled, use an alternate language.
			if (!empty($disabledLang) && $disabledLang != "none") {
				switch ($disabledLang) {
				case 'en':
					$lang = 'ar';
					break;

				case 'ar':
					$lang = 'en';
					break;
				}
			}

			// Update locale and session
			$this->data['lang'] = $lang;
			session()->put('lang', $lang);
			\App::setLocale($lang);

			return $next($request);
		});
	}
}
?>