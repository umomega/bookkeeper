@extends('layouts.email')

@section('pageTitle', trans('passwords.reset_password'))

@section('content')
    <h3>{{ trans('general.hello') }}!</h3>
    <p>{{ trans('passwords.reset_requested') }}</p>
    <a href="{!! route('bookkeeper.password.reset', [
        'token' => $token,
        'email' => urlencode($user->getEmailForPasswordReset())
    ]) !!}">{!! route('bookkeeper.password.reset', [
        'token' => $token,
        'email' => urlencode($user->getEmailForPasswordReset())
    ]) !!}</a>
    <p>{{ trans('passwords.ignore') }}</p>

    <p>{{ trans('general.thank_you') }}!</p>
@endsection
