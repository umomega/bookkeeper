<?php


namespace Bookkeeper\Http\Controllers;


use Bookkeeper\Http\Controllers\Traits\BasicResource;
use Bookkeeper\Support\Currencies\Cruncher;
use Illuminate\Http\Request;
use Bookkeeper\Exports\TransactionsWithTagExport;
use Maatwebsite\Excel\Facades\Excel;

class TagsController extends BookkeeperController {

    use BasicResource;

    /**
     * Self model path required for ModifiesPermissions
     *
     * @var string
     */
    protected $modelPath = '';
    protected $resourceMultiple = 'tags';
    protected $resourceSingular = 'tag';
    protected $resourceName = 'Tag';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modelPath = config('models.tag', \Bookkeeper\Finance\Tag::class);
    }

    /**
     * Shows transactions for the tag.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function transactions(Request $request, $id)
    {
        $tag = $this->modelPath::findOrFail($id);

        $transactions = $tag->transactions();

        if(empty($request->input('q')))
        {
            $transactions = $transactions->sortable(['created_at' => 'desc'])->paginate();
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
    public function show($id)
    {
        $tag = $this->modelPath::findOrFail($id);

        $statistics = (new Cruncher())->compileStatisticsFor(['filter' => 'tag', 'id' => (int)$tag->getKey()]);

        return $this->compileView('tags.show', compact('tag', 'statistics'), $tag->name);
    }

    /**
     * Returns the collection of retrieved tags by json response
     *
     * @param Request $request
     * @return Response
     */
    public function searchJson(Request $request)
    {
        $tags = $this->modelPath::search($request->input('q'), null, true)
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
        $tag = $this->modelPath::findOrFail($id);

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
        $tag = $this->modelPath::findOrFail($id);

        $tag->retractTransactionById($transaction);

        return ['success' => true];
    }

    /**
     * Exports the given resource
     *
     * @param int $id
     * @return download
     */
    public function export($id)
    {
        $export = new TransactionsWithTagExport;
        $export->id = $id;

        return Excel::download($export, 'tag-' . date('Y-m-d H:i:s') . '.' . request('format', 'xlsx'));
    }

}
