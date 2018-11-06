<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Finance\Transaction;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class TransactionsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Transaction::class;
    protected $resourceMultiple = 'transactions';
    protected $resourceSingular = 'transaction';
    protected $resourceName = 'Transaction';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(empty($request->input('q')))
        {
            $transactions = Transaction::sortable(['created_at' => 'desc'])->filteredByType()->paginate();
            $isSearch = false;
        } else {
            $transactions = Transaction::search($request->input('q'), null, true)->groupBy('id')->get();
            $isSearch = true;
        }

        return $this->compileView('transactions.index', compact('transactions', 'isSearch'));
    }

    /**
     * Downloads an invoice
     *
     * @param int $id
     * @return Download
     */
    public function downloadInvoice($id)
    {
        $transaction = Transaction::findOrFail($id);

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
        $transaction = Transaction::findOrFail($id);

        if($info = json_decode($transaction->invoice)) {
            \Storage::delete('invoices/' . $info->store_name);
        }

        $transaction->update(['invoice' => null]);

        $this->notify('transactions.deleted_invoice');

        return redirect()->back();
    }

}
