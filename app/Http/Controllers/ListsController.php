<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\CRM\PeopleList;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class ListsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = PeopleList::class;
    protected $resourceMultiple = 'lists';
    protected $resourceSingular = 'list';
    protected $resourceName = 'List';
    protected $resourceTitleProperty = 'name';

    /**
     * List the specified resource people.
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
