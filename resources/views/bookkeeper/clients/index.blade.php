@extends('layouts.resources.index')

@php $resourceName = 'clients' @endphp

@section('options')
    @include('partials.export', ['baseURL' =>
        route('bookkeeper.clients.export') .
        '?q=' . request('q', '') . '&sort=' . request('sort', '') .  '&direction=' . request('direction')])
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
