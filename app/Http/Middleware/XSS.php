<?php

namespace App\Http\Middleware;

use Closure;

class XSS {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (!empty($request->all())) {
			$this->_get_post_data($request);
			$this->_get_post_meta_data($request);
		}

		return $next($request);
	}

	public function validateFileContents($file, $needlesArray = null) {

		if (empty($needlesArray)) {
			$needlesArray = ['<?php', 'eval', 'gzuncomp'];
		}

		foreach ($needlesArray as $needle) {
			if (strpos(file_get_contents($file), $needle) !== false) {
				return false;
				break;
			}
		}

		return true;
	}

	protected function _get_post_data($request) {

		if ($request->hasFile('file')) {
			$isValid = $this->validateFileContents($request->file('file'));
			if (!$isValid) {
				return false;
			}
		}

		if (empty($request->post) || !isset($request->post)) {
			return true;
		}

		foreach ($request->post as $key => $postData) {
			$post_array['post'][$key] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $postData);
		}

		$request->merge($post_array);
		return true;
	}

	protected function _get_post_meta_data($request) {
		if ($request->hasFile('file')) {
			$isValid = $this->validateFileContents($request->file('file'));
			if (!$isValid) {
				return false;
			}
		}

		if (empty($request->meta) || !isset($request->meta)) {
			return true;
		}

		foreach ($request->meta as $key => $postData) {
			foreach ($postData as $key2 => $data) {
				$meta_array['meta'][$key][$key2] = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data);
			}
		}

		$request->merge($meta_array);
		return true;
	}
}
