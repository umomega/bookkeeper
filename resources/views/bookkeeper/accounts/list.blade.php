@if(count($accounts) == 0 && !$isSearch)
    {!! no_results_row('accounts.no_accounts') !!}
@else
    @foreach($accounts as $account)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}">{{ $account->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                {{ currency_string_for($account->balance, $account) }}
            </td>
            <td class="is-hidden-mobile">
                {{ $account->currency }}
            </td>
            <td class="is-hidden-mobile">
                {{ $account->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $account->getKey()) !!}
        </tr>
    @endforeach
@endif
