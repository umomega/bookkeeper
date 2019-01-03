<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $q = request('q', null);
        $modelName = config('models.client', \Bookkeeper\CRM\Client::class);

        if(empty($q)) return $modelName::sortable()->get();

        return $modelName::search($q, null, true)->groupBy('id')->get();
    }
}
