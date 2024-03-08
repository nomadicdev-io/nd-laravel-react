<?php

namespace App\Http\Middleware;

use Closure;

class IsUserAllowedToViewPage {

	private $rolesPermitted = [
		"VIP User",
		"Management Member",
		"Super Admin",
		"System Administrator",
	];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!auth()->user()) {
			return redirect('/');
		}

		if (auth()->user()->hasAnyRole($this->rolesPermitted)) {
			return $next($request);
		}

		//Else, redirect to programme listing page -- need to look into the lang part
		return redirect()->to(route('list-programmes', ['lang' => 'ar']));
	}
}
