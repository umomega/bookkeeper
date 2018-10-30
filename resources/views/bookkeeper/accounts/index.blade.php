@extends('layouts.resources.index')

@php $resourceName = 'accounts' @endphp

@section('table-head')
    @if($isSearch)
        <th>{{ __('validation.attributes.name') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.balance') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.currency') }}</th>
        <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
    @else
        <th>@sortablelink('name', __('validation.attributes.name'))</th>
        <th class="is-hidden-mobile">@sortablelink('balance', __('validation.attributes.balance'))</th>
        <th class="is-hidden-mobile">@sortablelink('currency', __('validation.attributes.currency'))</th>
        <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
    @endif
@endsection
