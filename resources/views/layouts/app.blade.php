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

    <body class="font-mono antialiased bg-slate-100 body-margin-bottom">

        <main class="container mx-auto p-1">

            <x-header />

            <div class="bg-white mt-2 rounded-sm lg:rounded py-2 px-1 lg:px-2">
                <x-menu />

                {{ $slot }}
            </div>

        </main>

    </body>
</html>
