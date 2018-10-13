@php $currentStep = 4; @endphp

@extends('layouts.app')

@section('pageTitle', __('install.bookkeeper_settings'))

@section('content')

    <form action="{{ route('install-settings-post') }}" method="post" class="install-form">
        @csrf

        <p class="is-size-5">{{ trans('install.enter_bookkeeper_settings') }}</p>

        <div class="install-form__inner has-text-left">
            @if($errors->count() > 0)
                <div class="notification is-danger">
                    <button class="delete"></button>
                    {{ __('install.check_bookkeeper_settings') }}
                </div>
            @endif

            <div class="field">
                {!! html()->label(__('install.bookkeeper_base_url'), 'base_url')->class('label') !!}
                <div class="control">
                    {!! html()->text('base_url', env('base_url', 'http://bookkeeper.test'))->class('input') !!}
                </div>
            </div>

            <div class="field">
                {!! html()->label(__('currencies.default_currency'), 'default_currency')->class('label') !!}
                <div class="control is-expanded has-icons-left">
                    <div class="select is-fullwidth">
                        {!! html()->select('default_currency', Bookkeeper\Support\Currencies\CurrencyHelper::getCurrencies(),  env('DEFAULT_CURRENCY', 'EUR')) !!}
                    </div>
                    <div class="icon is-small is-left">
                        <i class="fas fa-coins"></i>
                    </div>
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
                    <span>{{ __('install.complete') }}</span>
                    <span class="icon">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </button>
            </div>

        </div>
    </form>

@endsection
