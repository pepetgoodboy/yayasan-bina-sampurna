<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Yayasan Bina Sampurna Sutisna</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('logo-yayasan-bs.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/sidebar.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-80 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <!-- Logo -->
            <div class="flex items-center justify-center h-[74px] px-4 border-b border-gray-200">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('/logo-yayasan-bs.png') }}" alt="Logo" class="h-10 w-10">
                    <span class="font-bold text-xl text-gray-800">Yayasan Bina Sampurna</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-5 px-6 space-y-4">
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-c-squares-2x2 class="mr-4 h-6 w-6" />
                    Dashboard
                </a>

                @if (auth()->user()->hasRole(['admin', 'bendahara']))
                    <a href="{{ route('kelas.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('kelas.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-building-office class="mr-4 h-6 w-6" />
                        Kelas
                    </a>

                    <a href="{{ route('siswa.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('siswa.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-users class="mr-4 h-6 w-6" />
                        Siswa
                    </a>

                    <a href="{{ route('jenis-pembayaran.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('jenis-pembayaran.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-document-magnifying-glass class="mr-4 h-6 w-6" />
                        Jenis Pembayaran
                    </a>

                    <a href="{{ route('pembayaran.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('pembayaran.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-currency-dollar class="mr-4 h-6 w-6" />
                        Pembayaran
                    </a>

                    <a href="{{ route('laporan.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('laporan.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-document-chart-bar class="mr-4 h-6 w-6" />
                        Laporan
                    </a>
                @endif

                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('users.index') }}"
                        class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('users.*') ? 'bg-indigo-100 text-[#23146A]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <x-heroicon-o-user-group class="mr-4 h-6 w-6" />
                        Users
                    </a>
                @endif
            </nav>

            <!-- User Menu -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-[#23146A] flex items-center justify-center">
                            <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <div class="ml-3 flex flex-col">
                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                        <div class="flex gap-2 items-center">
                            <a href="{{ route('profile.edit') }}"
                                class="text-xs text-[#23146A]/90 hover:text-[#23146A]">Profile</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline -mt-[1px]">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75 lg:hidden"
            @click="sidebarOpen = false"></div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col lg:ml-80 min-w-0">
            <!-- Top bar -->
            <div class="bg-white shadow-sm border-b border-gray-200 lg:hidden"
                :class="sidebarOpen ? 'static' : 'sticky top-0'">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-600">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <div class="flex items-center ml-4">
                                <img src="{{ asset('/logo-yayasan-bs.png') }}" alt="Logo" class="h-8 w-8 mr-2">
                                <h1 class="text-lg font-semibold text-gray-900">Yayasan Bina Sampurna</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-1">
                @if (session('success'))
                    <div class="px-4 py-4 sm:px-6 lg:px-8">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="px-4 py-4 sm:px-6 lg:px-8">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
