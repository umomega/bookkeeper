@extends('layouts.resources.tab')

@php $overrideTab = true; @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.accounts.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.accounts.show', $account->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li><a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.accounts.edit', $account->getKey()) }}">{{ __('accounts.self') }}</a></li>
@endsection

@section('tab')
    @include('overview.chart', ['transactionButtonsOptions' => ['account' => $account->getKey()]])
@endsection
