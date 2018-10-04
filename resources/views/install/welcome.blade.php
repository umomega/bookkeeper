@extends('layouts.app')

@section('pageTitle', __('install.install_bookkeeper'))

@section('content')

    @if(empty($missing))
        <p class="is-size-5">{{ __('install.welcome_to_bookkeeper') }}</p>
        <p class="is-size-7">{{ __('install.bookkeeper_will_be_configured') }}</p>

        <form action="{{ route('install-welcome-post') }}" method="post" class="install-form">
            {!! csrf_field() !!}

            <p class="is-size-5">{{ __('install.choose_language_and_timezone') }}</p>

            <div class="install-form__inner has-text-left">

                <div class="field">
                    {!! html()->label(__('validation.attributes.language'), 'language')->class('label') !!}
                    <div class="control is-expanded has-icons-left">
                        <div class="select is-fullwidth">
                            {!! html()->select('timezone', Bookkeeper\Support\Install\InstallHelper::$locales,  env('APP_LOCALE', 'en')) !!}
                        </div>
                        <div class="icon is-small is-left">
                            <i class="fas fa-language"></i>
                        </div>
                    </div>
                </div>

                <div class="field">
                    {!! html()->label(__('validation.attributes.timezone'), 'timezone')->class('label') !!}
                    <div class="control is-expanded has-icons-left">
                        <div class="select is-fullwidth">
                            {!! html()->select('timezone', Bookkeeper\Support\Install\InstallHelper::$timezones, env('APP_TIMEZONE', 'Europe/Istanbul')) !!}
                        </div>
                        <div class="icon is-small is-left">
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="field has-text-right">
                    <button class="button is-inverted is-primary">
                        <span>{{ __('install.database') }}</span>
                        <span class="icon">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </button>
                </div>

            </div>

        </form>
    @else
        <div class="install-message">
            <p>{!! __('install.requirements_not_matched') !!}</p>

            <ul class="install-missing">
            @foreach($missing as $requirement)
                <li class="is-size-7">{!! $requirement !!}</li>
            @endforeach
            </ul>
        </div>
    @endif

@endsection
