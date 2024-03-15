<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
		 $this->app->bind('path.lang', function() { return storage_path('app/lang'); });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Paginator::defaultView('vendor.pagination.bootstrap-4');
		 \Schema::defaultStringLength(191);
		   $this->loadTranslationsFrom(storage_path('app/lang'), 'PGSTRANS');
		 \Illuminate\Support\Collection::macro('recursively_strip_tag', function () {
			return $this->map(function ($value) {
				if (is_array($value) || is_object($value)) {
					return collect($value)->recursively_strip_tag();
				}

				return preg_replace("#<script(.*?)>(.*?)</script>#is", '', $value);
			});
		});
    }
}
