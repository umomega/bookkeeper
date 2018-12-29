<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Bookkeeper\CRM\Person;

class PeopleExport implements FromCollection
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $q = request('q', null);

        if(empty($q)) return Person::sortable()->get();

        return Person::search($q, null, true)->groupBy('id')->get();
    }

}
