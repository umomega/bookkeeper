@extends('layouts.resources.tab')

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.lists.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('lists.title')) }}</a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.lists.show', $list->getKey()) }}">{{ __('people.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.lists.edit', $list->getKey()) }}">{{ __('lists.self') }}</a></li>
@endsection

@section('tab')
    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
                <th class="is-hidden-mobile">@sortablelink('email', __('validation.attributes.email'))</th>
                <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @include('people.list', ['resourceName' => 'people'])
        </tbody>
    </table>
@endsection

@section('contents-footer')
@if($people->lastPage() > 1)
    <div class="contents__footer">
        {!! $people->appends(request()->except('page'))->links('partials.pagination') !!}
    </div>
@endif
@endsection
