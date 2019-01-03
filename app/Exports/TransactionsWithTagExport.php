<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsWithTagExport implements FromCollection
{

    /** @var int */
    public $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $modelName = config('models.tag', \Bookkeeper\Finance\Tag::class);
        $tag = $modelName::findOrFail($this->id);

        $q = request('q', null);

        if(empty($q)) return $tag->transactions()->sortable()->get();

        return $tag->transactions()->search($q, null, true)->groupBy('id')->get();
    }
}
