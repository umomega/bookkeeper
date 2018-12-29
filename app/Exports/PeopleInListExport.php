<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Bookkeeper\CRM\PeopleList;

class PeopleInListExport implements FromCollection
{

    /** @var int */
    public $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $list = PeopleList::findOrFail($this->id);

        $q = request('q', null);

        if(empty($q)) return $list->people()->sortable()->get();

        return $list->people()->search($q, null, true)->groupBy('id')->get();
    }

}
