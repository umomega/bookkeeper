@extends('layouts.resources.show')

@php $resourceName = 'people'; $showRoute = route('bookkeeper.lists.show', $list->getKey()) @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.lists.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('lists.title')) }}</a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.lists.show', $list->getKey()) }}">{{ __('people.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.lists.edit', $list->getKey()) }}">{{ __('lists.self') }}</a></li>
@endsection

@section('table-head')
    @if($isSearch)
        <th>{{ __('validation.attributes.name') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.email') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
    @else
        <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
        <th class="is-hidden-mobile">@sortablelink('email', __('validation.attributes.email'))</th>
        <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
    @endif
@endsection
