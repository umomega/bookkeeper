@extends('layouts.resources.index')

@php $resourceName = 'transactions' @endphp

@section('table-buttons')
    {!! transaction_buttons() !!}
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
