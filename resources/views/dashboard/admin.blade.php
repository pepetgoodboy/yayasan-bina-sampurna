<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Hero Section --}}
            <div class="hidden md:flex w-full h-72 bg-[#23146A] bg-blend-overlay rounded-lg items-center justify-center shadow-md bg-cover bg-center"
                style="background-image: url('{{ asset('assets/foto_sekolah.png') }}'); background-size: cover; background-position: center;">
                <div class="text-center text-white">
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-lg">Di Sistem Informasi Pembayaran Yayasan Bina Sampurna Sutisna</p>
                </div>
            </div>

            <!-- Statistik Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-6">
                <div class="bg-blue-100 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 text-white">
                            <x-heroicon-o-users class="h-8 w-8" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-700">Total Siswa</h3>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalSiswa }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-100 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-500 text-white">
                            <x-heroicon-o-building-office class="h-8 w-8" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-700">Total Kelas</h3>
                            <p class="text-2xl font-bold text-purple-600">{{ $totalKelas }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-100 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-500 text-white">
                            <x-heroicon-o-user-group class="h-8 w-8" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-700">Total Orang Tua</h3>
                            <p class="text-2xl font-bold text-indigo-600">{{ $totalOrtu }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-green-100 p-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 text-white">
                            <x-heroicon-o-currency-dollar class="h-8 w-8" />
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-700">Total Pemasukan</h3>
                            <p class="text-xl font-bold text-green-600">Rp
                                {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemasukan Periode -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Hari Ini</h3>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($pemasukanHariIni, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Bulan Ini</h3>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($pemasukanBulanIni, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tahun Ini</h3>
                    <p class="text-2xl font-bold text-purple-600">Rp
                        {{ number_format($pemasukanTahunIni, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pembayaran per Jenis -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Pembayaran Bulan Ini per Jenis</h3>
                    @if ($pembayaranPerJenis->count() > 0)
                        <div class="space-y-3">
                            @foreach ($pembayaranPerJenis as $item)
                                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                    <span class="font-medium">{{ $item->jenisPembayaran->nama }}</span>
                                    <span class="font-bold text-green-600">Rp
                                        {{ number_format($item->total, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada pembayaran bulan ini</p>
                    @endif
                </div>

                <!-- Siswa per Kelas -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Siswa per Kelas</h3>
                    <div class="space-y-3">
                        @foreach ($siswaPerKelas as $item)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                <span class="font-medium">{{ $item->kelas->nama_kelas }}</span>
                                <span class="font-bold text-blue-600">{{ $item->total }} siswa</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pembayaran Terbaru -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Pembayaran Terbaru</h3>
                    @if ($pembayaranTerbaru->count() > 0)
                        <div class="space-y-3">
                            @foreach ($pembayaranTerbaru as $item)
                                <div
                                    class="flex justify-between items-center p-3 border-l-4 border-green-500 bg-gray-50">
                                    <div>
                                        <p class="font-medium">{{ $item->siswa->nama }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->jenisPembayaran->nama }} -
                                            {{ $item->tanggal_bayar->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="font-bold text-green-600">Rp
                                        {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada pembayaran</p>
                    @endif
                </div>

                <!-- Tunggakan SPP -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Tunggakan SPP Bulan Ini</h3>
                    @if ($tunggakan && $tunggakan->count() > 0)
                        <div class="space-y-3">
                            @foreach ($tunggakan as $item)
                                <div class="flex justify-between items-center p-3 border-l-4 border-red-500 bg-red-50">
                                    <div>
                                        <p class="font-medium">{{ $item->nama }}</p>
                                        <p class="text-sm text-gray-600">{{ $item->kelas->nama_kelas }} -
                                            {{ $item->ortu->name ?? '' }}</p>
                                    </div>
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Belum Bayar</span>
                                </div>
                            @endforeach
                        </div>
                        @if ($tunggakan->count() >= 5)
                            <p class="text-sm text-gray-500 mt-3">Menampilkan 5 dari total tunggakan</p>
                        @endif
                    @else
                        <p class="text-gray-500">Semua siswa sudah membayar SPP bulan ini</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
