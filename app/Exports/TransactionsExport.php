<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Bookkeeper\Finance\Transaction;

class TransactionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $q = request('q', null);

        if(empty($q)) return Transaction::sortable()->get();

        return Transaction::search($q, null, true)->groupBy('id')->get();
    }
}
