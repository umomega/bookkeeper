@extends('layouts.resources.index')

@php $resourceName = 'users'; $isSearch = true @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.users.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('users.title')) }}</a>
@endsection

@section('table-buttons')
    <a class="button is-primary is-action" href="{{ route('bookkeeper.users.create') }}"><i class="fa fa-user-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('users.create') }}</span></a>
@endsection

@section('table-head')
    <th>{{ __('validation.attributes.name') }}</th>
    <th class="is-hidden-mobile">{{ __('validation.attributes.email') }}</th>
    <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
@endsection
