@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.settings.update'); $formMethod = 'put' @endphp

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'settings.edit', $settings); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('settings.edit', 'save') !!}
@endsection
