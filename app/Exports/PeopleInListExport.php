<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class PeopleInListExport implements FromCollection
{

    /** @var int */
    public $id;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $modelName = config('models.people_list', \Bookkeeper\CRM\PeopleList::class);
        $list = $modelName::findOrFail($this->id);

        $q = request('q', null);

        if(empty($q)) return $list->people()->sortable()->get();

        return $list->people()->search($q, null, true)->groupBy('id')->get();
    }

}
