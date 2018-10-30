<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Finance\Tag;
use Bookkeeper\Support\Currencies\Cruncher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TagsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = Tag::class;
    protected $resourceMultiple = 'tags';
    protected $resourceSingular = 'tag';
    protected $resourceName = 'Tag';

    /**
     * Shows transactions for the tag.
     *
     * @param int $id
     * @return Response
     */
    public function transactions($id)
    {
        $tag = Tag::findOrFail($id);

        $transactions = $tag->transactions()
            ->sortable()->paginate();

        return $this->compileView('tags.transactions', compact('tag', 'transactions'), trans('transactions.title'));
    }

    /**
     * Shows transactions for the tag.
     *
     * @param int $id
     * @return Response
     */
    public function overview($id)
    {
        $tag = Tag::findOrFail($id);

        $start = Carbon::now()->endOfMonth()->subYear()->addSecond();
        $end = Carbon::now()->endOfMonth();

        $transactions = $tag->transactions()
            ->whereExclude(0)
            ->whereReceived(1)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $statistics = (new Cruncher())
            ->compileStatisticsFor($transactions, $start, $end);

        return $this->compileView('tags.overview', compact('tag', 'statistics'), trans('overview.index'));
    }

    /**
     * Returns the collection of retrieved nodes by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        return Tag::search($request->input('q'), null, true)
            ->groupBy('id')->limit(10)->get()
            ->pluck('name', 'id')->toArray();
    }

}
