<?php


namespace Bookkeeper\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait BasicResource {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        extract($this->getResourceNames());

        $items = $modelPath::sortable()->paginate();

        return $this->compileView($resourceMultiple . '.index', [$resourceMultiple => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        extract($this->getResourceNames());

        return $this->compileView($resourceMultiple . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        extract($this->getResourceNames());

        $validated = $this->resolveRequest('Store')->validated();

        $item = $modelPath::create($validated);

        $this->notify($resourceMultiple . '.created');

        return redirect()->route('bookkeeper.' . $resourceMultiple . '.edit', $item->getKey());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        extract($this->getResourceNames());

        $item = $modelPath::findOrFail($id);

        $titlePropery = $this->getTitleProperty();

        $title = is_null($titlePropery) ? null : $item->{$titlePropery};

        return $this->compileView($resourceMultiple . '.edit', [$resourceSingular => $item], $title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        extract($this->getResourceNames());

        $item = $modelPath::findOrFail($id);

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
    public function destroy($id)
    {
        extract($this->getResourceNames());

        $item = $modelPath::findOrFail($id);

        $item->delete();

        $this->notify($resourceMultiple . '.destroyed');

        return redirect()->back();
    }

    /**
     * Display results of searching the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        extract($this->getResourceNames());

        $results = $modelPath::search($request->input('q'), null, true)
            ->groupBy('id')->get();

        return $this->compileView($resourceMultiple . '.search', [$resourceMultiple => $results]);
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

}
