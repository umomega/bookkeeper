@extends('layouts.resources.index')

@php $resourceName = 'lists' @endphp

@section('table-head')
    <th>@sortablelink('first_name', __('validation.attributes.name'))</th>
    <th class="is-hidden-mobile">@sortablelink('created_at', __('validation.attributes.created_at'))</th>
@endsection
