<?php

namespace Bookkeeper\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    const VERSION = '0.10-alpha.0';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHelpers();

        $this->registerServices();
    }

    /**
     * Registers helper methods
     */
    protected function registerHelpers()
    {
        require_once __DIR__ . '/../Support/helpers.php';

        require_once __DIR__ . '/../Html/Builders/snippets.php';
    }

    /**
     * Registers services
     */
    protected function registerServices()
    {
        $this->app->singleton('Bookkeeper\Html\Builders\FormsHtmlBuilder', function ($app) {
            return $app->make('Bookkeeper\Html\Builders\FormsHtmlBuilder');
        });
    }
}
