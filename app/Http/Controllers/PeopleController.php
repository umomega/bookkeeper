<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;
use Bookkeeper\Exports\PeopleExport;
use Maatwebsite\Excel\Facades\Excel;

class PeopleController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $resourceMultiple = 'people';
    protected $resourceSingular = 'person';
    protected $resourceName = 'Person';
    protected $resourceTitleProperty = 'full_name';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.person', \Bookkeeper\CRM\Person::class);
    }

    /**
     * List the specified resource lists.
     *
     * @param int $id
     * @return Response
     */
    public function lists($id)
    {
        $person = $this->modelPath::with('lists')->findOrFail($id);

        $availableLists = config('models.people_list', \Bookkeeper\CRM\PeopleList::class)::all()
            ->diff($person->lists)
            ->pluck('name', 'id')
            ->toArray();

        return $this->compileView('people.lists', compact('person', 'availableLists'), $person->full_name);
    }

    /**
     * Associate a list to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function associateList(Request $request, $id)
    {
        $person = $this->modelPath::findOrFail($id);

        $validated = $request->validate([
            'list' => 'required'
        ]);

        $person->assignListById($request->input('list'));

        $this->notify('lists.associated');

        return redirect()->back();
    }

    /**
     * Dissociate a list from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @param int $list
     * @return Response
     */
    public function dissociateList(Request $request, $id, $list)
    {
        $person = $this->modelPath::findOrFail($id);

        $person->retractListById($list);

        $this->notify('lists.dissociated');

        return redirect()->back();
    }

    /**
     * Returns the collection of retrieved nodes by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $people = $this->modelPath::search($request->input('q'), null, true)
            ->groupBy('id')->limit(10)->get();

        $clientId = json_decode($request->input('additional'))->client_id;

        $results = [];

        foreach($people as $person)
        {
            $results[$person->getKey()] = [
                'id' => $person->getKey(),
                'name' => $person->full_name,
                'associate_route' => route('bookkeeper.people.clients.associate', [$person->getKey(), $clientId])
            ];
        }

        return $results;
    }

    /**
     * Associate a client to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @param int $client
     * @return Response
     */
    public function associateClient(Request $request, $id, $client)
    {
        $person = $this->modelPath::findOrFail($id);

        $person->assignClientById($client);

        return [
            'id' => $person->getKey(),
            'name' => $person->full_name,
            'edit_route' => route('bookkeeper.people.edit', $person->getKey()),
            'dissociate_route' => route('bookkeeper.people.clients.dissociate', [$person->getKey(), $client]),
            'dissociate_message' => __('people.confirm_dissociate')
        ];
    }

    /**
     * Dissociate a client from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @param int $client
     * @return Response
     */
    public function dissociateClient(Request $request, $id, $client)
    {
        $person = $this->modelPath::findOrFail($id);

        $person->retractClientById($client);

        $this->notify('people.dissociated');

        return redirect()->back();
    }

    /**
     * Exports the given resource
     *
     * @return download
     */
    public function export()
    {
        return Excel::download(new PeopleExport, 'people-' . date('Y-m-d H:i:s') . '.' . request('format', 'xlsx'));
    }

}
