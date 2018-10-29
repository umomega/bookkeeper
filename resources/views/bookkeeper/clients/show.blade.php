@extends('layouts.resources.show')

@php $resourceName = 'jobs'; $showRoute = route('bookkeeper.clients.show', $client->getKey()) @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
@endsection

@section('table-buttons')
    <a class="button is-primary is-overlay" href="{{ route('bookkeeper.jobs.create', $client->getKey()) }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('jobs.create') }}</span></a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.clients.show', $client->getKey()) }}">{{ __('jobs.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.clients.edit', $client->getKey()) }}">{{ __('clients.self') }}</a></li>
@endsection

@section('table-head')
    @if($isSearch)
        <th>{{ __('validation.attributes.name') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
    @else
        <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
        <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
    @endif
@endsection

@section('sidebar')
    <div class="contents-sidebar__spacer"></div>
    <h3 class="contents-sidebar__heading">{{ __('people.title') }}</h3>
    <div class="contents contents--sidebar">
        <div class="contents__body">
            <div class="subcontents" id="subcontents">
                @if(count($people) > 0)
                    @foreach($people as $person)
                        <div class="subcontents__item">
                            <a href="{{ route('bookkeeper.people.edit', $person->getKey()) }}">{{ $person->full_name }}</a>
                            <a class="delete delete-option" href="{{ route('bookkeeper.people.clients.dissociate', [$person->getKey(), $client->getKey()]) }}" data-message="{{ __('people.confirm_dissociate') }}"></a>
                        </div>
                    @endforeach
                @else
                    <div class="subcontents__item subcontents__item--padded">
                        {{ __('people.no_people') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="contents__footer contents__footer--inverted">
            <h4 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted">{{ uppercase(__('people.add_person')) }}</h4>
            <div id="clientSearch" class="searcher"
                data-searchurl="{{ route('bookkeeper.people.search.json') }}">
                <input type="hidden" name="_exclude" value="{{ json_encode($people->pluck('id')) }}">
                <input type="hidden" name="_additional" value="{{ json_encode(['client_id' => $client->getKey()]) }}">
                <input type="text" name="_searcher" autocomplete="off" placeholder="{{ __('general.search') }}" class="searcher__input">
                <p class="searcher__hint">{{ __('people.type_to_search_and_add') }}</p>

                <ul class="searcher__results">

                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    var searcher = new Searcher($('#clientSearch'), $('#subcontents'));
</script>
@endpush
