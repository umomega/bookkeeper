@extends('layouts.resources.tab')

@php $overrideTab = true; @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.tags.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.tags.transactions', $tag->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.tags.show', $tag->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li><a href="{{ route('bookkeeper.tags.edit', $tag->getKey()) }}">{{ __('tags.self') }}</a></li>
@endsection

@section('tab')
    @include('overview.chart', ['transactionButtonsOptions' => ['tag' => $tag->getKey()]])
@endsection
