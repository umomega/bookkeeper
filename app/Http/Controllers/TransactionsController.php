<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;
use Bookkeeper\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $resourceMultiple = 'transactions';
    protected $resourceSingular = 'transaction';
    protected $resourceName = 'Transaction';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.transaction', \Bookkeeper\Finance\Transaction::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(empty($request->input('q')))
        {
            $transactions = $this->modelPath::sortable(['created_at' => 'desc'])->filteredByType()->paginate();
            $isSearch = false;
        } else {
            $transactions = $this->modelPath::search($request->input('q'), null, true)->groupBy('id')->get();
            $isSearch = true;
        }

        return $this->compileView('transactions.index', compact('transactions', 'isSearch'));
    }

    /**
     * Show the form for repeating the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function repeat($id)
    {
        $transaction = $this->modelPath::findOrFail($id);

        return $this->compileView('transactions.repeat', compact('transaction'));
    }

    /**
     * Downloads an invoice
     *
     * @param int $id
     * @return Download
     */
    public function downloadInvoice($id)
    {
        $transaction = $this->modelPath::findOrFail($id);

        $info = json_decode($transaction->invoice);

        return \Storage::download('invoices/' . $info->store_name, $info->name);
    }

    /**
     * Deletes an invoice
     *
     * @param int $id
     * @return response
     */
    public function deleteInvoice($id)
    {
        $transaction = $this->modelPath::findOrFail($id);

        if($info = json_decode($transaction->invoice)) {
            \Storage::delete('invoices/' . $info->store_name);
        }

        $transaction->update(['invoice' => null]);

        $this->notify('transactions.deleted_invoice');

        return redirect()->back();
    }

    /**
     * Exports the given resource
     *
     * @return download
     */
    public function export()
    {
        return Excel::download(new TransactionsExport, 'transactions-' . date('Y-m-d H:i:s') . '.' . request('format', 'xlsx'));
    }

}
