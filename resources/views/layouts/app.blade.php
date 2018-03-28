<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.2/trix.css">

    <style>
        .thread-header {
            display: flex;
            justify-content: space-between;
        }

        .reply-header {
            display: flex;
            justify-content: space-between;
        }

        .show-thread-header {
            display: flex;
            justify-content: space-between;
        }

        [v-cloak] {
            display: none;
        }

        .ais-highlight em {
            background-color: #f1c40f;
            font-style: normal;
        }
    </style>
    <script>
        window.App = {!! json_encode([
            'user' => auth()->user(),
            'signedIn' => auth()->check()
        ]) !!};
    </script>
    @yield('head')
</head>
<body>
    <div id="app">
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>

        <flash message="{{ session('flash') }}"></flash>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
