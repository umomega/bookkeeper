@extends('layouts.resources.show')

@php $resourceName = 'transactions'; $showRoute = route('bookkeeper.accounts.transactions', $account->getKey()) @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.accounts.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('filters')
    @include('transactions.filter')
@endsection

@section('table-buttons')
    {!! transaction_buttons(['account' => $account->getKey()]) !!}
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.accounts.show', $account->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li><a href="{{ route('bookkeeper.accounts.edit', $account->getKey()) }}">{{ __('accounts.self') }}</a></li>
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
