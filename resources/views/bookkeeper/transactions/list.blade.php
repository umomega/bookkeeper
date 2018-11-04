@if(count($transactions) == 0 && !$isSearch)
    {!! no_results_row('transactions.no_transactions') !!}
@else
    @foreach($transactions as $transaction)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.transactions.edit', $transaction->getKey()) }}">{{ $transaction->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                {{ $transaction->presentAmount() }}
            </td>
            <td class="is-hidden-mobile">
                {{ $transaction->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $transaction->getKey()) !!}
        </tr>
    @endforeach
@endif
