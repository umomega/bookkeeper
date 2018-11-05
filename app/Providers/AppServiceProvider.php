<?php

namespace Bookkeeper\Providers;

use Bookkeeper\Observers\AccountObserver;
use Bookkeeper\Observers\TransactionObserver;
use Bookkeeper\Observers\JobObserver;
use Bookkeeper\Finance\Account;
use Bookkeeper\Finance\Transaction;
use Bookkeeper\Finance\Job;
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
        Transaction::observe(TransactionObserver::class);
        Job::observe(JobObserver::class);

        $this->registerViewBindings();
    }

    /**
     * Registers view bindings
     */
    public function registerViewBindings()
    {
        if ( ! is_installed())
        {
            return;
        }

        view()->composer('transactions.create', function ($view)
        {
            $accounts = Account::all();
            $view->with('accounts', $accounts->pluck('name', 'id')->toArray());
            $view->with('accountCurrencies', $accounts
                ->pluck('currency', 'id')->toArray());
        });

        view()->composer('transactions.edit', function ($view)
        {
            $accounts = Account::all();
            $view->with('accounts', $accounts->pluck('name', 'id')->toArray());
            $view->with('accountCurrencies', $accounts
                ->pluck('currency', 'id')->toArray());
        });
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
