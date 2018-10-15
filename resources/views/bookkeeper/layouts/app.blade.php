<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">

    <title>{{ $pageTitle }} &mdash; Bookkeeper</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    @yield('styles')

</head>
<body class="body">
    <div id="app" class="app container">
        @php
            $currentUser = auth()->user();
            $currentSection = isset($currentSection) ? $currentSection : null;
        @endphp

        @include('partials.navigation')

        <div class="main-content">
            <div class="main-content__head">
                <div class="breadcrumbs">
                    <a href="{{ route('bookkeeper.overview') }}" class="breadcrumbs__crumb">BOOKKEEPER</a>
                    @yield('breadcrumbs')
                </div>
                <h1 class="main-content__heading">{{ $pageTitle }}</h1>
            </div>
            @yield('content')
        </div>

        @include('partials.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>
