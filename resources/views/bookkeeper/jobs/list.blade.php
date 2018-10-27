@if(count($jobs) == 0 && !$isSearch)
    {!! no_results_row('jobs.no_jobs') !!}
@else
    @foreach($jobs as $job)
        <tr>
            <td>
                <a href="{{ route('bookkeeper.jobs.show', [$client->getKey(), $job->getKey()]) }}">{{ $job->name }}</a>
            </td>
            <td class="is-hidden-mobile">
                {{ $job->created_at->formatLocalized('%b %e, %Y') }}
            </td>
            {!! resource_options_menu($resourceName, $job->getKey(), $client->getKey()) !!}
        </tr>
    @endforeach
@endif
