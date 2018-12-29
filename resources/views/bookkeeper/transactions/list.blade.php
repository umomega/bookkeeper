@if(count($transactions) == 0 && !$isSearch)
    {!! no_results_row('transactions.no_transactions') !!}
@else
    @foreach($transactions as $transaction)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.transactions.edit', $transaction->getKey()) }}"><span class="transaction-dot transaction-dot--{{ $transaction->type }} {{ $transaction->received ? 'transaction-dot--received' : '' }}"></span>{{ $transaction->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                {{ $transaction->presentAmount() }}
            </td>
            <td class="is-hidden-mobile">
                {{ $transaction->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! options_menu_open($transaction->getKey()) .
                '<a class="dropdown-item" href="' . route('bookkeeper.transactions.edit', $transaction->getKey()) . '">
                    <i class="icon fa fa-edit" aria-hidden="true"></i>' . __('transactions.edit') . '</a>' .
                '<a class="dropdown-item" href="' . route('bookkeeper.transactions.repeat', $transaction->getKey()) . '">
                    <i class="icon fa fa-redo" aria-hidden="true"></i>' . __('transactions.repeat') . '</a>' .
                    delete_option(route('bookkeeper.transactions.destroy', $transaction->getKey()), 'transactions.destroy') .
                options_menu_close();!!}
        </tr>
    @endforeach
@endif
