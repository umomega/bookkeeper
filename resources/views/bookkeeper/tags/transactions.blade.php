@extends('layouts.resources.show')

@php $resourceName = 'transactions'; $showRoute = route('bookkeeper.tags.transactions', $tag->getKey()) @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.tags.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('table-buttons')
    {!! transaction_buttons(['tag' => $tag->getKey()]) !!}
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.tags.show', $tag->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.tags.transactions', $tag->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.tags.edit', $tag->getKey()) }}">{{ __('tags.self') }}</a></li>
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
