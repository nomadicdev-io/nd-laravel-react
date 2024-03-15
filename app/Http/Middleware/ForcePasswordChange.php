<?php

namespace App\Http\Middleware;

use Closure;

class ForcePasswordChange {

	// protected $frontendRoles = ['Entity Member', 'VIP User', 'Management Member'];
	// protected $backendRoles = ['Super Admin', 'System Administrator', 'Business Administrator', 'Programme Team Coordinator'];

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (auth()->user()->force_password_change == 1  && auth()->user()->status == 1) {
			return redirect()->to(route('admin_change_password'));
		}
		return $next($request);
	}
}
