@extends('layouts.auth')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')

    <form method="POST" action="{{ route('bookkeeper.password.email.post') }}">
        @csrf

        <input id="email" type="email" name="email" title="email" placeholder="{{ __('validation.attributes.email') }}" value="{{ old('email') }}" required autofocus>

        <button type="submit" class="button is-primary is-rounded is-fullwidth">{{ __('passwords.send_reset_link') }}</button>
    </form>

@endsection
