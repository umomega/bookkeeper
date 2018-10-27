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
    HERE BE ASSOCIATED PEOPLE
@endsection
