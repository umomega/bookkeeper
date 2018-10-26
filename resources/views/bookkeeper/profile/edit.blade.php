@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.profile.update'); $formMethod = 'put' @endphp

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.profile.edit') }}">{{ __('users.profile') }}</a></li>
    <li><a href="{{ route('bookkeeper.profile.password') }}">{{ __('validation.attributes.password') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'users.edit', $profile); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('users.update_profile', 'save') !!}
@endsection
