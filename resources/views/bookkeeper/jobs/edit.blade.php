@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.jobs.update', [$parent->getKey(), $job->getKey()]); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
    <a href="{{ route('bookkeeper.clients.show', $parent->getKey()) }}" class="breadcrumbs__crumb">{{ uppercase($parent->name) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.jobs.show', [$parent->getKey(), $job->getKey()]) }}">{{ __('transactions.title') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.jobs.edit', [$parent->getKey(), $job->getKey()]) }}">{{ __('jobs.self') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'jobs.edit', $job); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('jobs.edit', 'save') !!}
@endsection
