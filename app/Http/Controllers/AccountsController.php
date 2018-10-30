<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Finance\Account;
use Bookkeeper\Support\Currencies\Cruncher;
use Carbon\Carbon;

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
     * @param int $id
     * @return Response
     */
    public function transactions($id)
    {
        $account = Account::findOrFail($id);

        $transactions = $account->transactions()
            ->sortable()->paginate();

        return $this->compileView('accounts.transactions', compact('account', 'transactions'), trans('transactions.title'));
    }

    /**
     * Shows overview for the account.
     *
     * @param int $id
     * @return Response
     */
    public function overview($id)
    {
        $account = Account::findOrFail($id);

        $start = Carbon::now()->endOfMonth()->subYear()->addSecond();
        $end = Carbon::now()->endOfMonth();

        $transactions = $account->transactions()
            ->whereExclude(0)
            ->whereReceived(1)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $statistics = (new Cruncher())
            ->compileAccountStatisticsFor($transactions, $account, $start, $end);

        return $this->compileView('accounts.overview', compact('account', 'statistics'), trans('overview.index'));
    }

}
