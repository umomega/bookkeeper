@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.profile.password.put'); $formMethod = 'put' @endphp

@section('tabs')
    <li><a href="{{ route('bookkeeper.profile.edit') }}">{{ __('users.profile') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.profile.password') }}">{{ __('validation.attributes.password') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'users.password'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('users.change_password', 'lock') !!}
@endsection
