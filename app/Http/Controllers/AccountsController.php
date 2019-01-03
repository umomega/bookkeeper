<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Support\Currencies\Cruncher;
use Illuminate\Http\Request;
use Bookkeeper\Exports\TransactionsInAccountExport;
use Maatwebsite\Excel\Facades\Excel;

class AccountsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $resourceMultiple = 'accounts';
    protected $resourceSingular = 'account';
    protected $resourceName = 'Account';
    protected $resourceTitleProperty = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.account', \Bookkeeper\Finance\Account::class);
    }

    /**
     * Shows transactions for the account.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transactions(Request $request, $id)
    {
        $account = $this->modelPath::findOrFail($id);

        $transactions = $account->transactions();

        if(empty($request->input('q')))
        {
            $transactions = $transactions->sortable(['created_at' => 'desc'])->paginate();
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
        $account = $this->modelPath::findOrFail($id);

        $statistics = (new Cruncher())->compileStatisticsFor(['filter' => 'account', 'id' => (int)$account->getKey()]);

        return $this->compileView('accounts.show', compact('account', 'statistics'), $account->name);
    }

    /**
     * Exports the given resource
     *
     * @param int $id
     * @return download
     */
    public function export($id)
    {
        $export = new TransactionsInAccountExport;
        $export->id = $id;

        return Excel::download($export, 'account-' . date('Y-m-d H:i:s') . '.' . request('format', 'xlsx'));
    }

}
