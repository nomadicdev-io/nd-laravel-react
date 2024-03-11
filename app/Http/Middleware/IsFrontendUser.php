<?php

namespace App\Http\Middleware;

use Closure;

class IsFrontendUser {

		/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (! auth()->user() ) {
			return redirect('/ar');
		}
				
		if( ! auth()->user()->can('Access User') ){
			\Auth::logout();
			\Session::flush();
			return redirect('/ar');
		}

		return redirect('/ar');
	}
}
