@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.clients.update', $client->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.clients.show', $client->getKey()) }}">{{ __('jobs.title') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.clients.edit', $client->getKey()) }}">{{ __('clients.self') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'clients.create', $client); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('clients.edit', 'save') !!}
@endsection
