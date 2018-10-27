<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\CRM\PeopleList;
use Bookkeeper\Http\Controllers\Traits\BasicResource;

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
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $list = PeopleList::findOrFail($id);

        $people = $list->people()
            ->sortable()
            ->paginate();

        return $this->compileView('lists.show', compact('list', 'people'), $list->name);
    }

}
