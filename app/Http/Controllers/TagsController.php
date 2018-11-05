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
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transactions(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        $transactions = $tag->transactions();

        if(empty($request->input('q')))
        {
            $transactions = $transactions->sortable()->paginate();
            $isSearch = false;
        } else {
            $transactions = $transactions->search($request->input('q'), null, true)->get();
            $isSearch = true;
        }

        return $this->compileView('tags.transactions', compact('tag', 'transactions', 'isSearch'), $tag->name);
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

        $additional = json_decode($request->input('additional'));

        $results = [];

        if(isset($additional->passive))
        {
            foreach($tags as $tag)
            {
                $results[$tag->getKey()] = [
                    'id' => $tag->getKey(),
                    'name' => $tag->name
                ];
            }
        } else {
            $transactionId = $additional->transaction_id;

            foreach($tags as $tag)
            {
                $results[$tag->getKey()] = [
                    'id' => $tag->getKey(),
                    'name' => $tag->name,
                    'associate_route' => route('bookkeeper.tags.transactions.associate', [$tag->getKey(), $transactionId])
                ];
            }
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
