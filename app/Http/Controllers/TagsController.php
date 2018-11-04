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
     * Returns the collection of retrieved tags by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $tags = Tag::search($request->input('q'), null, true)
            ->groupBy('id')->limit(10)->get();

        $transactionId = json_decode($request->input('additional'))->transaction_id;

        $results = [];

        foreach($tags as $tag)
        {
            $results[$tag->getKey()] = [
                'id' => $tag->getKey(),
                'name' => $tag->name,
                'associate_route' => route('bookkeeper.tags.transactions.associate', [$tag->getKey(), $transactionId])
            ];
        }

        return $results;
    }

    /**
     * Associate a transaction to the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @param int $transaction
     * @return Response
     */
    public function associateTransaction(Request $request, $id, $transaction)
    {
        $tag = Tag::findOrFail($id);

        $tag->assignTransactionById($transaction);

        return [
            'id' => $tag->getKey(),
            'name' => $tag->name,
            'show_route' => route('bookkeeper.tags.show', $tag->getKey()),
            'dissociate_route' => route('bookkeeper.tags.transactions.dissociate', [$tag->getKey(), $transaction])
        ];
    }

    /**
     * Dissociate a transaction from the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @param int $transaction
     * @return Response
     */
    public function dissociateTransaction(Request $request, $id, $transaction)
    {
        $tag = Tag::findOrFail($id);

        $tag->retractTransactionById($transaction);

        return ['success' => true];
    }

}
