<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsForJobExport implements FromCollection
{

    /** @var int */
    public $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $modelName = config('models.job', \Bookkeeper\Finance\Job::class);
        $tag = $modelName::findOrFail($this->id);

        $q = request('q', null);

        if(empty($q)) return $tag->transactions()->sortable()->get();

        return $tag->transactions()->search($q, null, true)->groupBy('id')->get();
    }
}
