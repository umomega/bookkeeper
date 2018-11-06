<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Finance\Account;
use Bookkeeper\Support\Currencies\Cruncher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Account::class;
    protected $resourceMultiple = 'accounts';
    protected $resourceSingular = 'account';
    protected $resourceName = 'Account';
    protected $resourceTitleProperty = 'name';

    /**
     * Shows transactions for the account.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transactions(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $transactions = $account->transactions();

        if(empty($request->input('q')))
        {
            $transactions = $transactions->sortable()->paginate();
            $isSearch = false;
        } else {
            $transactions = $transactions->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        return $this->compileView('accounts.transactions', compact('account', 'transactions', 'isSearch'), $account->name);
    }

    /**
     * Shows overview for the account.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        $start = Carbon::now()->endOfMonth()->subYear()->addSecond();
        $end = Carbon::now()->endOfMonth();

        $transactions = $account->transactions()
            ->whereExcluded(0)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $statistics = (new Cruncher())
            ->compileAccountStatisticsFor($transactions, $account, $start, $end);

        return $this->compileView('accounts.show', compact('account', 'statistics'), $account->name);
    }

}
