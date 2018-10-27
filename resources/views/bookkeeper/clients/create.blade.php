@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.clients.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.clients.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('clients.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'clients.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('clients.create', 'plus') !!}
@endsection
