<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IsInstallationComplete
{
    /**
        * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
    */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(!Storage::exists('installed')){
			return redirect()->to(route('web-installer'));
			//return redirect()->to('/')->with('userMessage',lang('invalid_request'));
		}

        return $next($request);
    }
}
