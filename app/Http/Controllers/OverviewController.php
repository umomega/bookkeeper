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
        return $this->compileView('overview.index');
    }

}
