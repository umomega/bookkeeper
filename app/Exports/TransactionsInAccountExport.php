<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Bookkeeper\Finance\Account;

class TransactionsInAccountExport implements FromCollection
{

    /** @var int */
    public $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $account = Account::findOrFail($this->id);

        $q = request('q', null);

        if(empty($q)) return $account->transactions()->sortable()->get();

        return $account->transactions()->search($q, null, true)->groupBy('id')->get();
    }
}
