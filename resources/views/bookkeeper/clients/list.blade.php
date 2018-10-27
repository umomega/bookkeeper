@if(count($clients) == 0 && !$isSearch)
    {!! no_results_row('clients.no_clients') !!}
@else
    @foreach($clients as $client)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.clients.show', $client->getKey()) }}">{{ $client->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                <a href="mailto:{{ $client->email }}">
                    {{ $client->email }}
                </a>
            </td>
            <td class="is-hidden-mobile">
                {{ $client->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $client->getKey()) !!}
        </tr>
    @endforeach
@endif
