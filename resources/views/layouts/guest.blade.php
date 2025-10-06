<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Yayasan Bina Sampurna Sutisna - {{ $title ?? 'Login' }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('logo-yayasan-bs.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex flex-col gap-2 mb-4">
                <div class="flex flex-col items-center pt-4">
                    <h1 class="font-semibold text-2xl text-center">Yayasan Bina Sampurna</h1>
                    <h2 class="font-semibold text-2xl text-center">Sutisna Sejahtera</h2>
                    <p class="mt-4 text-center text-[#22146a] font-medium">Sistem Informasi Pembayaran Sekolah</p>
                </div>
                <a href="/" class="flex justify-center mb-4">
                    <x-application-logo class="w-32 h-32" />
                </a>
                <p class="text-center text-[#22146a] font-medium -mt-4">{{ $title ?? 'Login' }} untuk mengakses Sistem
                </p>
                @if (session('success'))
                    <div class="w-full">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="w-full">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
            </div>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
