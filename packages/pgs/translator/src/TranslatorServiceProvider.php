<?php
namespace Pgs\Translator;

use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
	// protected $defer = true;
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
		$this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'translator');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/pgs/translator'),
        ]);
		
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		// $this->app->make('Pgs\Translator\TranslatorController');
	}
}
