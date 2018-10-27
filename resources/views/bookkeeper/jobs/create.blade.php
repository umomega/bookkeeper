@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.jobs.store', $parent->getKey()); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
    <a href="{{ route('bookkeeper.clients.show', $parent->getKey()) }}" class="breadcrumbs__crumb">{{ uppercase($parent->name) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'jobs.create'); @endphp

    <input type="hidden" name="client_id" value="{{ $parent->getKey() }}">
    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('jobs.create', 'plus') !!}
@endsection
