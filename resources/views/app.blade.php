<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/js/assets/images/logos/favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/js/assets/images/logos/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ Vite::asset('resources/js/assets/images/logos/android-chrome-192x192.png') }}">
        <link rel="manifest" href="{{ Vite::asset('resources/js/assets/images/logos/site.webmanifest') }}">

        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        <x-inertia::head>
            <title>{{ config('app.name', 'Laravel') }}</title>
        </x-inertia::head>
    </head>
    <body>
        <x-inertia::app />
    </body>
</html>
