<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin {
	protected $rolesPermitted = [];
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
		// dd(auth()->user()->can('Access Admin'));
		if (auth()->user()->isSuperAdmin() || auth()->user()->can('Access Admin')) {
			return $next($request);				
		}
		
		\Auth::logout();
		\Session::flush();
		return redirect('/ar');
	}
}