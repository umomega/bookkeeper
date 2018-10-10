@php $currentStep = 3; @endphp

@extends('layouts.app')

@section('pageTitle', __('install.user_information'))

@section('content')

    <form action="{{ route('install-user-post') }}" method="post" class="install-form">
        {!! csrf_field() !!}

        <p class="is-size-5">{{ __('install.enter_user_information') }}</p>

        <div class="install-form__inner has-text-left">
            @if($errors->count() > 0)
                <div class="notification is-danger">
                    <button class="delete"></button>
                    {{ __('install.check_user_information') }}
                </div>
            @endif

            @foreach([
                'first_name',
                'last_name',
                'email'
            ] as $field)

                <div class="field">
                    {!! html()->label(__('validation.attributes.' . $field), $field)->class('label') !!}
                    <div class="control">
                        {!! html()->text($field, '')->class('input') !!}
                    </div>
                </div>

            @endforeach

            <div class="field">
                {!! html()->label(__('validation.attributes.password'), 'password')->class('label') !!}
                <div class="control">
                    {!! html()->password('password')->class('input') !!}
                </div>
            </div>

            <div class="field">
                {!! html()->label(__('validation.attributes.password_confirmation'), 'password_confirmation')->class('label') !!}
                <div class="control">
                    {!! html()->password('password_confirmation')->class('input') !!}
                </div>
            </div>

            <hr>

            <div class="field has-text-right">
                <a href="{{ route('install-database') }}" class="button is-primary is-inverted is-outlined is-pulled-left">
                    <span class="icon">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    <span>{{ __('general.back') }}</span>
                </a>

                <button class="button is-inverted is-primary">
                    <span>{{ __('install.bookkeeper_settings') }}</span>
                    <span class="icon">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </button>
            </div>

        </div>
    </form>

@endsection
