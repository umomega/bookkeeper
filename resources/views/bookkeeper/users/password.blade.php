@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.users.password.put', $user->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.users.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('users.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.users.edit', $user->getKey()) }}">{{ __('users.self') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.users.password', $user->getKey()) }}">{{ __('validation.attributes.password') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'users.password'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('users.change_password', 'lock') !!}
@endsection
