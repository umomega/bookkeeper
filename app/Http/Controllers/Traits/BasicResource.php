<?php


namespace Bookkeeper\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait BasicResource {

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param int|null $parent
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $parent = null)
    {
        extract($this->getResourceNames());

        $parent = $this->getParent($parent);

        if(empty($request->input('q')))
        {
            $items = $modelPath::sortable()->paginate();
            $isSearch = false;
        } else {
            $items = $modelPath::search($request->input('q'), null, true)
                ->groupBy('id')->get();
            $isSearch = true;
        }

        return $this->compileView($resourceMultiple . '.index', [$resourceMultiple => $items, 'parent' => $parent, 'isSearch' => $isSearch]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int|null $parent
     * @return \Illuminate\Http\Response
     */
    public function create($parent = null)
    {
        extract($this->getResourceNames());

        $parent = $this->getParent($parent);

        return $this->compileView($resourceMultiple . '.create', compact('parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int|null $parent
     * @return \Illuminate\Http\Response
     */
    public function store($parent = null)
    {
        extract($this->getResourceNames());

        $validated = $this->resolveRequest('Store')->validated();

        $parent = $this->getParent($parent);

        $item = $modelPath::create($validated);

        $this->notify($resourceMultiple . '.created');

        $params = is_null($parent) ? $item->getKey() : [$parent->getKey(), $item->getKey()];

        return redirect()->route('bookkeeper.' . $resourceMultiple . '.edit', $params);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  int|null $parent
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $parent = null)
    {
        extract($this->getResourceNames());

        if(!is_null($parent))
        {
            $item = $modelPath::findOrFail($parent);
            $parent = $this->parentModelPath::findOrFail($id);
        } else {
            $item = $modelPath::findOrFail($id);
        }

        $titlePropery = $this->getTitleProperty();

        $title = is_null($titlePropery) ? null : $item->{$titlePropery};

        return $this->compileView($resourceMultiple . '.edit', [$resourceSingular => $item, 'parent' => $parent], $title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int|null $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $parent = null)
    {
        extract($this->getResourceNames());

        if(!is_null($parent))
        {
            $item = $modelPath::findOrFail($parent);
            $parent = $this->parentModelPath::findOrFail($id);
        } else {
            $item = $modelPath::findOrFail($id);
        }

        $validated = $this->resolveRequest('Update')->validated();

        $item->update($request->all());

        $this->notify($resourceMultiple . '.edited');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $parent = null)
    {
        extract($this->getResourceNames());

        if(!is_null($parent))
        {
            $item = $modelPath::findOrFail($parent);
            $parent = $this->parentModelPath::findOrFail($id);
        } else {
            $item = $modelPath::findOrFail($id);
        }

        $item->delete();

        $this->notify($resourceMultiple . '.destroyed');

        return redirect()->back();
    }

    /**
     * Returns necessary resource names
     *
     * @return array
     */
    protected function getResourceNames()
    {
        return [
            'modelPath'        => $this->modelPath,
            'resourceMultiple' => $this->resourceMultiple,
            'resourceSingular' => $this->resourceSingular
        ];
    }

    /**
     * Returns the title property name
     *
     * @return string
     */
    protected function getTitleProperty()
    {
        return isset($this->resourceTitleProperty) ? $this->resourceTitleProperty : null;
    }

    /**
     * Retriever for parent
     *
     * @param int|null $parent
     * @return Model|null
     */
    public function getParent($parent)
    {
        return is_null($parent) ? null : $this->parentModelPath::findOrFail($parent);
    }
}
