@extends('layouts.resources.show')

@php $resourceName = 'transactions'; $showRoute = route('bookkeeper.jobs.show', [$parent->getKey(), $job->getKey()]) @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
    <a href="{{ route('bookkeeper.clients.show', $parent->getKey()) }}" class="breadcrumbs__crumb">{{ uppercase($parent->name) }}</a>
@endsection

@section('table-buttons')
    {!! transaction_buttons(['job' => $job->getKey()]) !!}
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.jobs.show', [$parent->getKey(), $job->getKey()]) }}">{{ __('transactions.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.jobs.edit', [$parent->getKey(), $job->getKey()]) }}">{{ __('jobs.self') }}</a></li>
@endsection

@section('table-head')
    @if($isSearch)
        <th>{{ __('validation.attributes.name') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.amount') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
    @else
        <th>@sortablelink('name', __('validation.attributes.name'))</th>
        <th class="is-hidden-mobile">@sortablelink('amount', __('validation.attributes.amount'))</th>
        <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
    @endif
@endsection
