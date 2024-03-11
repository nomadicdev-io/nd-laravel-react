<?php

namespace App\Http\Middleware;

use Closure;

class User {
	protected $rolesPermitted = ['Frontend User'];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (auth()->user() && auth()->user()->hasAnyRole($this->rolesPermitted)) {
			return $next($request);
		}

		return redirect()->to('/');
	}
}
