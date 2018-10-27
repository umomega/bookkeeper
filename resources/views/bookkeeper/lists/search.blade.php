@extends('layouts.resources.index')

@php $resourceName = 'lists'; $isSearch = true @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.lists.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('lists.title')) }}</a>
@endsection

@section('table-buttons')
    <a class="button is-primary is-overlay" href="{{ route('bookkeeper.lists.create') }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('lists.create') }}</span></a>
@endsection

@section('table-head')
    <th>{{ __('validation.attributes.name') }}</th>
    <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
@endsection
