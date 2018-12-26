<?php

namespace Bookkeeper\Observers;

use Bookkeeper\Finance\Account;
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
        $originalReceived = is_null($transaction->getOriginal('received')) ? $transaction->received : $transaction->getOriginal('received');
        $originalAccount = is_null($transaction->getOriginal('account_id')) ? $transaction->account_id : $transaction->getOriginal('account_id');

        /**
         * We first check if the account has been changed,
         * if so, we first deduct the original amount from the original account if it was received
         * than we add the new amount to the new account if it is received
         */
        if($originalAccount != $transaction->account_id)
        {
            if($originalReceived) {
                $originalDifference = $transaction->getOriginal('total_amount') * ($transaction->type == 'income' ? -1 : 1);
                $a = Account::findOrFail($originalAccount);
                $a->update(['balance' => (int)$a->balance + $originalDifference]);
            }

            if($transaction->received) {
                $difference = $transaction->total_amount * ($transaction->type == 'income' ? 1 : -1);
                $transaction->account->update(['balance' => (int)$transaction->account->balance + $difference]);
            }
        } else {
            // This is for account balance calculation
            if($originalReceived != $transaction->received)
            {
                $difference = $transaction->total_amount * ($transaction->type == 'income' ? 1 : -1) * ($transaction->received ? 1 : -1);
            } else {
                if($transaction->received) {
                    if($transaction->getOriginal('type') != $transaction->type) {
                        $difference = ((int)$transaction->getOriginal('total_amount') + (int)$transaction->total_amount) * ($transaction->type == 'income' ? 1 : -1);
                    } else {
                        $difference = ((int)$transaction->getOriginal('total_amount') - (int)$transaction->total_amount) * ($transaction->type == 'income' ? -1 : 1);
                    }
                } else {
                    $difference = 0;
                }
            }

            $account = $transaction->account;
            $account->update(['balance' => (int)$account->balance + $difference]);
        }

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
        $difference = $transaction->received ? ($transaction->total_amount * ($transaction->type == 'income' ? -1 : 1)) : 0;

        $account = $transaction->account;
        $account->update(['balance' => (int)$account->balance + $difference]);

        if($info = json_decode($transaction->invoice)) {
            \Storage::delete('invoices/' . $info->store_name);
        }
    }

}
