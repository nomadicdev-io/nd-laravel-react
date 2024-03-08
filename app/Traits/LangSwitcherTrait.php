<?php
namespace App\Traits;
use App;
use Illuminate\Http\Request;
/*
| Language Switcher Trait ,
 */
trait LangSwitcherTrait {
/*
 * Set the language
 * @param String
 * @return response
 */
	public function setlanguage(Request $request, $lang) {
		$allowedLangs = ['en', 'ar'];

		if ($this->data['websiteSettings'] && $this->data['websiteSettings']->getMeta('disable_language') != 'none') {
			$allowedLangs = [$this->data['websiteSettings']->getMeta('disable_language')];
		}

		if (!in_array($lang, $allowedLangs)) {
			return redirect()->to('page-not-found');
		}

		$request->session()->put('lang', $lang);

		$redirectURL = url()->previous();

		if (strpos($redirectURL, $request->getSchemeAndHttpHost()) !== 0) {
			$redirectURL = null;
		}

		$redirect = redirect()->to('/' . $lang);

		if ($this->data['websiteSettings']->disable_arabic == 2) {
			$message = $this->custom_message('Arabic version will be coming soon.', 'success');
			if (!empty($redirectURL)) {
				$redirect = redirect()->to($this->formatRedirectUrl($redirectURL))->with('homeMessage', $message);
			}
			$redirect = redirect()->to('/')->with('homeMessage', $message);

		}
		

		if (!empty($redirectURL)) {
			$redirect = redirect()->to($this->formatRedirectUrl($redirectURL));
		}

		return $redirect;
	}

/*
 * Format The redirect URL with appropriate language prefix
 * @param String
 * @return String
 */
	private function formatRedirectUrl($redirectURL) {
		$segments = str_replace(url('/'), '', $redirectURL);
		$segments = array_filter(explode('/', $segments));
		array_shift($segments);
		array_unshift($segments, session()->get('lang'));
		return implode('/', $segments);
	}

}
?>