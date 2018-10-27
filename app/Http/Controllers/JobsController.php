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
     * List the specified resource jobs.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $jobs = $job->jobs();

        if(empty($request->input('q')))
        {
            $jobs = $jobs->sortable()->paginate();
            $isSearch = false;
        } else {
            $jobs = $jobs->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        $people = $job->people()->sortable()->get();

        return $this->compileView('jobs.show', compact('job', 'jobs', 'people', 'isSearch'), $job->name);
    }

}