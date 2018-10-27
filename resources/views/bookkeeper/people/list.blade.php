@if(count($people) == 0 && !$isSearch)
    {!! no_results_row('people.no_people') !!}
@else
    @foreach($people as $person)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.people.edit', $person->getKey()) }}">{{ $person->full_name }}</a>
            </td>
            <td class="is-hidden-mobile">
                <a href="mailto:{{ $person->email }}">
                    {{ $person->email }}
                </a>
            </td>
            <td class="is-hidden-mobile">
                {{ $person->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $person->getKey()) !!}
        </tr>
    @endforeach
@endif
