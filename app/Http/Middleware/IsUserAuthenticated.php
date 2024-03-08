<?php

namespace App\Http\Middleware;

use App\Models\Admodels\PostModel;
use Closure;

class IsUserAuthenticated {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$redirectURL = "";

		$websiteSettings = PostModel::where('post_type', 'setting')->first();

		// If user doesn't have any role assigned yet, sign them out.
		// if (auth()->user() && !auth()->user()->isSuperAdmin()) {
		// 	if (auth()->user()->roles->count() == 0) {
		// 		\Auth::logout();
		// 		\Session::flush();
		// 		return redirect()->to(route('home', ['ar']));
		// 	}
		// }

		// Redirect to sign in page if the user isn't authenticated
		// if (empty(auth()->user()) || (!empty(auth()->user())) && !auth()->user()->isUser()) {
		if (empty(auth()->user())) {
			$lang = (!empty($request->lang)) ? $request->lang : $websiteSettings->getMeta('default_lang');
			return redirect()->to(route('home', ['lang' => $lang]));
		}

		return $next($request);
	}
}
