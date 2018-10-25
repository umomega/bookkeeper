@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.users.update', $user->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.users.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('users.title')) }}</a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.users.edit', $user->getKey()) }}">{{ __('users.self') }}</a></li>
    <li><a href="{{ route('bookkeeper.users.password', $user->getKey()) }}">{{ __('validation.attributes.password') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'users.edit', $user); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('users.edit', 'save') !!}
@endsection
