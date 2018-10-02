<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Finance\Transaction;
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

        $transactions = Transaction::whereReceived(1)
            ->whereExclude(0)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $statistics = (new Cruncher())
            ->compileStatisticsFor($transactions, $start, $end);

        return $this->compileView('overview.index', compact('statistics'));
    }

}
