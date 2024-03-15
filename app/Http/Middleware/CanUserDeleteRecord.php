<?php

namespace App\Http\Middleware;

use Closure;

class CanUserDeleteRecord {

	protected $rolesPermitted = [
		"Super Admin",
		"System Administrator",
		"Business Administrator",
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

		//Else, redirect the user with an error message like "Access Denied"
		return redirect()->to(route('admin_dashboard'))->with($this->custom_message(lang('access_denied'), 'warning'));
	}

	private function custom_message($userMessage, $type = 'error') {

		if (is_object($userMessage)) {
			$string = '<ol>';
			$messages = $userMessage->messages();
			foreach ($messages->all() as $message) {
				$string .= '<li>' . $message . '</li>';
			}
			$string .= '</ol>';
			$userMessage = $string;
		}
		return view('admin.common.alerts.' . $type, ['userMessage' => $userMessage])->render();
	}
}
