<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Finance\Job;
use Bookkeeper\CRM\Client;
use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Illuminate\Http\Request;

class JobsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Job::class;
    protected $parentModelPath = Client::class;
    protected $resourceMultiple = 'jobs';
    protected $resourceSingular = 'job';
    protected $resourceName = 'Job';
    protected $resourceTitleProperty = 'name';

    /**
     * Returns the collection of retrieved jobs by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $jobs = Job::search($request->input('q'), null, true)
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
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $job = Job::findOrFail($id);

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

}
