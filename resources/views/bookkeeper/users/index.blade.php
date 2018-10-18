@extends('layouts.resources.index')

@php $resourceName = 'users' @endphp

@section('table-buttons')
    <a class="button is-primary is-action" href="{{ route('bookkeeper.users.create') }}"><i class="fa fa-user-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('users.create') }}</span></a>
@endsection

@section('table-head')
    <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
    <th class="is-hidden-mobile">@sortablelink('email', __('validation.attributes.email'))</th>
    <th class="is-hidden-mobile">@sortablelink('email', __('validation.attributes.created_at'))</th>
@endsection
