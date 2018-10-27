@if(count($lists) == 0 && !$isSearch)
    {!! no_results_row('lists.no_lists') !!}
@else
    @foreach($lists as $list)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.lists.show', $list->getKey()) }}">{{ $list->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                {{ $list->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $list->getKey()) !!}
        </tr>
    @endforeach
@endif
