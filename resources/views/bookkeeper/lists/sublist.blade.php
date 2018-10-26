@if(count($lists) == 0 && !(isset($isSearch) && !$isSearch))
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
            {!! options_menu_open($list->getKey()) . delete_option(route('bookkeeper.people.lists.dissociate', [$person->getKey(), $list->getKey()]), 'lists.dissociate', 'minus', 'lists.confirm_dissociate') . options_menu_close() !!}
        </tr>
    @endforeach
@endif
