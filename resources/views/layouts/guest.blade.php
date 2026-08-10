<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SmartSip') }}</title>
        <link rel="icon" href="{{ asset('images/smartsip_favicon.png') }}" type="image/png">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-dark-navy antialiased bg-secondary">
        <div class="min-h-screen flex items-center justify-center py-6 px-4">
            <div class="w-full max-w-md bg-white border border-slate-100 rounded-[28px] shadow-premium p-8 relative overflow-hidden">
                <!-- Background soft decor -->
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-teal-500/5 rounded-full blur-3xl pointer-events-none"></div>
                
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
