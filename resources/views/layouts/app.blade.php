<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />

        <meta name="application-name" content="{{ config('app.name') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name') }}</title>

        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('scripts')
    </head>

    <body class="font-sans antialiased bg-gray-100 body-margin-bottom">

        <div class="flex flex-col h-screen">

{{--        <header class="bg-primary shadow">--}}
{{--            @include('layouts.navigation')--}}
{{--        </header>--}}

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto xl:px-28 px-3 lg:py-5 py-2">
                {{ $slot }}
            </main>

        </div>

    </body>
</html>
