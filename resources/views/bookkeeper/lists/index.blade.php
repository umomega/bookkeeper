@extends('layouts.resources.index')

@php $resourceName = 'lists' @endphp

@section('table-buttons')
    <a class="button is-primary is-action" href="{{ route('bookkeeper.lists.create') }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('lists.create') }}</span></a>
@endsection

@section('table-head')
    <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
    <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
@endsection
