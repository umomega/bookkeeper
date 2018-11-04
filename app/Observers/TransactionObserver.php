<?php

namespace Bookkeeper\Observers;

use Bookkeeper\Finance\Transaction;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \Bookkeeper\Finance\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $tagIds = json_decode(request()->tags);

        $transaction->tags()->sync($tagIds);
    }

    /**
     * Handle the transaction "saving" event.
     *
     * @param  \Bookkeeper\Finance\Transaction  $transaction
     * @return void
     */
    public function saving(Transaction $transaction)
    {
        $transaction->vat_amount = ((int)$transaction->vat_percentage * (int)$transaction->amount / 100);
        $transaction->total_amount = (int)$transaction->amount + (int)$transaction->vat_amount;
    }

    /**
     * Handle the transaction "saved" event.
     *
     * @param  \Bookkeeper\Finance\Transaction  $transaction
     * @return void
     */
    public function saved(Transaction $transaction)
    {
        // This is for account balance calculation
        if($transaction->getOriginal('type') != $transaction->type) {
            $differance = ((int)$transaction->getOriginal('total_amount') + (int)$transaction->total_amount) * ($transaction->type == 'income' ? 1 : -1);
        } else {
            $differance = ((int)$transaction->getOriginal('total_amount') - (int)$transaction->total_amount) * ($transaction->type == 'income' ? -1 : 1);
        }

        $account = $transaction->account;
        $account->update(['balance' => (int)$account->balance + $differance]);

        // We do this here to be able to store for both creation and updating
        if(!is_null($uploadedInvoice = request()->file('invoice')))
        {
            $info = [
                'name' => $uploadedInvoice->getClientOriginalName(),
                'store_name' => 'invoice-' . $transaction->getKey() . '.' . $uploadedInvoice->extension()
            ];

            $uploadedInvoice->storeAs('invoices', $info['store_name']);

            // This is to prevent firing model events again
            Transaction::flushEventListeners();
            $transaction->update(['invoice' => json_encode($info)]);
        }
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  \Bookkeeper\Finance\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        $differance = $transaction->total_amount * ($transaction->type == 'income' ? -1 : 1);

        $account = $transaction->account;
        $account->update(['balance' => (int)$account->balance + $differance]);
    }

}
