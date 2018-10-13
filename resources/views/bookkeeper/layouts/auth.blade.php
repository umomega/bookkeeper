<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">

    <title>@yield('pageTitle') &mdash; Bookkeeper</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('styles')

</head>
<body>
    <div class="auth-outer">

        <div class="auth">

            <div class="auth__logo-outer">
                {!! Theme::img('img/bookkeeper-logo.svg', 'Bookkeeper Logo', 'auth__logo') !!}
            </div>

            <div class="auth__inner">
                <div class="auth__head">
                    <h1>@yield('pageTitle')</h1>
                </div>

                <div class="auth__content">
                    @if(count($errors) > 0)
                    <p class="auth__message is-size-7 has-text-danger">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </p>
                    @endif

                    @if(session('status'))
                        <p class="auth__message is-size-7 has-text-success">{{ session('status') }}</p>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>
