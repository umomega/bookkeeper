<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\CRM\Client;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class ClientsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Client::class;
    protected $resourceMultiple = 'clients';
    protected $resourceSingular = 'client';
    protected $resourceName = 'Client';
    protected $resourceTitleProperty = 'name';

    /**
     * List the specified resource jobs.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $list = PeopleList::findOrFail($id);

        $people = $list->people();

        if(empty($request->input('q')))
        {
            $people = $people->sortable()->paginate();
            $isSearch = false;
        } else {
            $people = $people->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        return $this->compileView('lists.show', compact('list', 'people', 'isSearch'), $list->name);
    }

}
