<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class JobsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $parentModelPath = '';
    protected $resourceMultiple = 'jobs';
    protected $resourceSingular = 'job';
    protected $resourceName = 'Job';
    protected $resourceTitleProperty = 'name';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.job', \Bookkeeper\Finance\Job::class);
        $this->parentModelPath = config('models.client', \Bookkeeper\CRM\Client::class);
    }

    /**
     * Returns the collection of retrieved jobs by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $jobs = $this->modelPath::search($request->input('q'), null, true)
            ->groupBy('id')->limit(10)->get();

        $results = [];

        foreach($jobs as $job)
        {
            $results[$job->getKey()] = [
                'id' => $job->getKey(),
                'name' => $job->name,
            ];
        }

        return $results;
    }

    /**
     * List the specified resource transactions.
     *
     * @param Request $request
     * @param int $parent
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $parent, $id)
    {
        $job = $this->modelPath::findOrFail($id);

        $transactions = $job->transactions();
        $parent = $job->client;

        if(empty($request->input('q')))
        {
            $transactions = $transactions->sortable()->paginate();
            $isSearch = false;
        } else {
            $transactions = $transactions->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        return $this->compileView('jobs.show', compact('job', 'transactions', 'isSearch', 'parent'), $job->name);
    }

    /**
     * Downloads an offer
     *
     * @param int $id
     * @return Download
     */
    public function downloadOffer($id)
    {
        $job = $this->modelPath::findOrFail($id);

        $info = json_decode($job->offer);

        return \Storage::download('offers/' . $info->store_name, $info->name);
    }

    /**
     * Deletes an offer
     *
     * @param int $id
     * @return response
     */
    public function deleteOffer($id)
    {
        $job = $this->modelPath::findOrFail($id);

        if($info = json_decode($job->offer)) {
            \Storage::delete('offers/' . $info->store_name);
        }

        $job->update(['offer' => null]);

        $this->notify('jobs.deleted_offer');

        return redirect()->back();
    }

}
