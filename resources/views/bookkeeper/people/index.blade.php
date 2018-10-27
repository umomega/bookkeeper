@extends('layouts.resources.index')

@php $resourceName = 'people' @endphp

@section('table-buttons')
    <a class="button is-primary is-overlay" href="{{ route('bookkeeper.people.create') }}"><i class="fa fa-user-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('people.create') }}</span></a>
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
