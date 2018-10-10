@php $currentStep = 5; @endphp

@extends('layouts.app')

@section('pageTitle', __('install.completed'))

@section('content')

    <div class="install-form">
        <p class="is-size-5">{{ __('install.install_success') }}</p>
        <p class="is-size-7">{{ __('install.enjoy_bookkeeper') }}</p>
        <br><br><br><br><br>
        <a href="{{ route('bookkeeper.auth.login') }}" class="button is-inverted is-primary">
            <span>{{ __('install.go_to_login') }}</span>
            <span class="icon">
                <i class="fas fa-sign-in-alt"></i>
            </span>
        </a>
    </div>

@endsection
