<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\CRM\PeopleList;
use Bookkeeper\CRM\Person;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class PeopleController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Person::class;
    protected $resourceMultiple = 'people';
    protected $resourceSingular = 'person';
    protected $resourceName = 'Person';

    /**
     * List the specified resource lists.
     *
     * @param int $id
     * @return Response
     */
    public function lists($id)
    {
        $person = Person::with('lists')->findOrFail($id);

        $availableLists = PeopleList::all()
            ->diff($person->lists)
            ->pluck('name', 'id')
            ->toArray();

        return $this->compileView('people.lists', compact('person', 'availableLists'), trans('lists.title'));
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
        $person = Person::findOrFail($id);
        
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
        $person = Person::findOrFail($id);

        $person->retractListById($list);

        $this->notify('lists.dissociated');

        return redirect()->back();
    }

}
