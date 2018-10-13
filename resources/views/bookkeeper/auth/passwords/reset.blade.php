@extends('layouts.auth')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')

    <form method="POST" action="{{ route('bookkeeper.password.reset.post') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <input id="email" type="email" name="email" title="email" placeholder="{{ __('validation.attributes.email') }}" value="{{ urldecode($email) ?: old('email') }}" required autofocus>
        <input id="password" type="password" name="password" title="password" placeholder="{{ __('validation.attributes.password') }}" required>
        <input id="password_confirmation" type="password" name="password_confirmation" title="password_confirmation" placeholder="{{ __('validation.attributes.password_confirmation') }}" required>

        <button type="submit" class="button is-primary is-rounded is-fullwidth">{{ __('passwords.reset_password') }}</button>
    </form>

@endsection
