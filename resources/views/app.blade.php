<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#0d937a" media="(prefers-color-scheme: dark)">

        <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/js/assets/images/logos/favicon.ico') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ Vite::asset('resources/js/assets/images/logos/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ Vite::asset('resources/js/assets/images/logos/android-chrome-192x192.png') }}">

        @PwaHead

        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        <x-inertia::head>
            <title>{{ config('app.name', 'See Cure Medical Corporation') }}</title>
        </x-inertia::head>
    </head>
    <body>
        <x-inertia::app />

        @RegisterServiceWorkerScript
    </body>
</html>
