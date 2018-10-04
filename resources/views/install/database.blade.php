@php $currentStep = 2; @endphp

@extends('layouts.app')

@section('pageTitle', trans('install.database'))

@section('content')

    <form action="{{ route('install-database-post') }}" method="post" class="install-form">
        {!! csrf_field() !!}

        <p class="is-size-5">{{ trans('install.set_database_configuration') }}</p>

        <div class="install-form__inner has-text-left">
            @foreach([
                'host' => 'localhost',
                'port' => '3306',
                'database' => 'bookkeeper',
                'username' => 'root',
                'password' => ''
            ] as $field => $default)

                <div class="field">
                    {!! html()->label(__('install.' . $field), $field)->class('label') !!}
                    <div class="control">
                        {!! html()->text($field, $default)->class('input') !!}
                    </div>
                </div>

            @endforeach

            <hr>

            <div class="field has-text-right">
                <a href="{{ route('install-welcome') }}" class="button is-primary is-inverted is-outlined is-pulled-left">
                    <span class="icon">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                    <span>{{ __('general.back') }}</span>
                </a>

                <button class="button is-inverted is-primary">
                    <span>{{ __('install.user_information') }}</span>
                    <span class="icon">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </button>
            </div>
            
        </div>
    </form>

@endsection
