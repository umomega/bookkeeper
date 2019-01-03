<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;
use Bookkeeper\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $resourceMultiple = 'clients';
    protected $resourceSingular = 'client';
    protected $resourceName = 'Client';
    protected $resourceTitleProperty = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.client', \Bookkeeper\CRM\Client::class);
    }

    /**
     * List the specified resource jobs.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $client = $this->modelPath::findOrFail($id);

        $jobs = $client->jobs();

        if(empty($request->input('q')))
        {
            $jobs = $jobs->sortable()->paginate();
            $isSearch = false;
        } else {
            $jobs = $jobs->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        $people = $client->people()->sortable()->get();

        return $this->compileView('clients.show', compact('client', 'jobs', 'people', 'isSearch'), $client->name);
    }

    /**
     * Exports the given resource
     *
     * @return download
     */
    public function export()
    {
        return Excel::download(new ClientsExport, 'companies-' . date('Y-m-d H:i:s') . '.' . request('format', 'xlsx'));
    }
}
