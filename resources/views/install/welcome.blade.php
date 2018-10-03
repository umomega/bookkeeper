@extends('layouts.app')

@section('pageTitle', __('install.install_bookkeeper'))

@section('content')

    @if(empty($missing))
        <p class="is-size-5">{{ __('install.welcome_to_bookkeeper') }}</p>
        <p class="is-size-7">{{ __('install.bookkeeper_will_be_configured') }}</p>

        <form action="{{ route('install-welcome-post') }}" method="post" class="install-form">
            {!! csrf_field() !!}

            <p class="is-size-5">{{ __('install.choose_language_and_timezone') }}</p>

            {{--
            {!! field_wrapper_open([], 'language', $errors, 'form-group--inverted') !!}
                {!! field_label(true, [], 'language', $errors) !!}

                <div class="form-group__select">
                    {!! Form::select('language', Bookkeeper\Support\Install\InstallHelper::$locales, env('REACTOR_LOCALE', 'en')) !!}
                    <i class="icon-arrow-down"></i>
                </div>
            </div>

            {!! field_wrapper_open([], 'language', $errors, 'form-group--inverted') !!}
                {!! field_label(true, [], 'timezone', $errors) !!}

                <div class="form-group__select">
                    {!! Form::select('timezone', Bookkeeper\Support\Install\InstallHelper::$timezones, env('APP_TIMEZONE', 'Europe/Istanbul')) !!}
                    <i class="icon-arrow-down"></i>
                </div>
            </div>

            <div class="modal-buttons">
                {!! submit_button('icon-arrow-right', __('install.database')) !!}
            </div>
            --}}
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
