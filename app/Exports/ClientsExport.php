<?php

namespace Bookkeeper\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Bookkeeper\CRM\Client;

class ClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $q = request('q', null);

        if(empty($q)) return Client::sortable()->get();

        return Client::search($q, null, true)->groupBy('id')->get();
    }
}
