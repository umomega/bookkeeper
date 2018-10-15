@extends('layouts.auth')

@section('pageTitle', trans('auth.login'))

@section('content')

    <form method="POST" action="{{ route('bookkeeper.auth.login.post') }}">
        @csrf

        <input id="email" type="email" name="email" title="email" placeholder="{{ __('validation.attributes.email') }}" value="{{ old('email') }}" required autofocus>
        <input id="password" type="password" name="password" title="password" placeholder="{{ __('validation.attributes.password') }}" required>

        <div class="level auth__options">
            <div class="auth__checkbox level-left">
                <input type="checkbox" name="remember" id="remember" value="true" class="regular-checkbox">
                <label for="remember"></label>
                <span>{{ __('auth.remember') }}</span>
            </div>

            <a class="level-right" href="{{ route('bookkeeper.password.email') }}">{{ __('auth.forgot') }}</a>
        </div>

        <button type="submit" class="button is-primary is-rounded is-fullwidth">{{ __('auth.login') }}</button>
    </form>

@endsection
