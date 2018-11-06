<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Finance\Transaction;
use Bookkeeper\Finance\Account;
use Bookkeeper\Support\Currencies\Cruncher;
use Carbon\Carbon;

class OverviewController extends BookkeeperController {

    /**
     * Shows the overview
     *
     * @return view
     */
    public function index() {
        $start = Carbon::now()->endOfMonth()->subYear()->addSecond();
        $end = Carbon::now()->endOfMonth();

        $transactions = Transaction::whereExcluded(0)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $statistics = (new Cruncher())
            ->compileStatisticsFor($transactions, $start, $end);

        $accounts = Account::all();
        $total = 0;

        if($statistics) {
            $currencyHelper = resolve('Bookkeeper\Support\Currencies\CurrencyHelper');

            foreach($accounts as $account)
            {
                $total += ($account->balance/$currencyHelper->getRateFor($account->getKey()));
            }

            $total = currency_string_for(floor($total), get_default_account());
        }

        return $this->compileView('overview.index', compact('statistics', 'accounts', 'total'));
    }

}
