{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Guest')</title>

    {{-- Favicon Links --}}
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="tw-font-sans tw-text-gray-900 tw-antialiased">
    <div
        class="tw-min-h-screen tw-flex tw-flex-col sm:tw-justify-center tw-items-center tw-pt-6 sm:tw-pt-0 tw-bg-gray-100 dark:tw-bg-gray-900">
        <div>
            <a href="/">
                {{-- Ganti x-application-logo dengan img tag untuk logo Anda --}}
                <img src="{{ asset('images/logo-ayotemukan.png') }}" alt="AyoTemukan Logo"
                    class="tw-w-60 tw-h-auto sm:tw-w-60">
                {{-- Sesuaikan kelas Tailwind 'tw-w-24' atau 'sm:tw-w-32' untuk ukuran logo yang diinginkan --}}
            </a>
        </div>

        <div
            class="tw-w-full sm:tw-max-w-md tw-mt-6 tw-px-6 tw-py-8 tw-bg-white dark:tw-bg-gray-800 tw-shadow-md tw-overflow-hidden sm:tw-rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
