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

    <section class="hero is-primary is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="install has-text-centered">
                    {!! Theme::img('img/bookkeeper-logo-bg.svg', 'Bookkeeper Logo', 'install__logo') !!}

                    @include('partials.progress', ['currentStep' => 1])

                    <h1 class="is-size-2">@yield('pageTitle')</h1>

                    @yield('content')
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>
