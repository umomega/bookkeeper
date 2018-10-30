<?php

namespace Bookkeeper\Providers;

use Bookkeeper\Observers\AccountObserver;
use Bookkeeper\Finance\Account;
use Illuminate\Support\ServiceProvider;
use Bookkeeper\Support\Currencies\CurrencyHelper;

class AppServiceProvider extends ServiceProvider
{

    const VERSION = '1.0-alpha.0';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Account::observe(AccountObserver::class);
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
        require_once __DIR__ . '/../Support/snippets.php';
    }

    /**
     * Registers services
     */
    protected function registerServices()
    {
        $this->app->singleton(CurrencyHelper::class, function ($app) {
            return new CurrencyHelper;
        });
    }
}
