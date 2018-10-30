<?php

namespace Bookkeeper\Observers;

use Bookkeeper\Finance\Account;

class AccountObserver
{

    /**
     * Handle the account "saved" event.
     *
     * @param  \Bookkeeper\Finance\Account  $account
     * @return void
     */
    public function saved(Account $account)
    {
        if($account->default == '1')
        {
            Account::where('id', '<>', $account->getKey())
                ->where('default', 1)->update(['default' => 0]);
        } else {
            if(count($accounts = Account::where('default', 1)->get()) == 0) {
                Account::first()->update(['default' => 1]);
            }
        }
    }

    /**
     * Handle the account "deleted" event.
     *
     * @param  \Bookkeeper\Finance\Account  $account
     * @return void
     */
    public function deleted(Account $account)
    {
        if($account->default == '1')
        {
            if($account = Account::first()) {
                $account->update(['default' => 1]);
            }
        }
    }

}
