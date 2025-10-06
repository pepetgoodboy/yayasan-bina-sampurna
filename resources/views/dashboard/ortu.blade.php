<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Hero Section --}}
            <div class="hidden md:flex w-full h-72 bg-[#23146A] bg-blend-overlay rounded-lg items-center justify-center shadow-md bg-cover bg-center mb-6"
                style="background-image: url('{{ asset('assets/foto_sekolah.png') }}'); background-size: cover; background-position: center;">
                <div class="text-center text-white">
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-lg">Di Sistem Informasi Pembayaran Yayasan Bina Sampurna Sutisna</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mb-4">
                <form method="GET" class="flex items-center space-x-2">
                    <select name="bulan"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="tahun"
                        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for ($i = 2020; $i <= now()->year + 1; $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                </form>
                <a href="{{ route('dashboard.download-pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download PDF
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-4 bg-blue-50">
                    <p class="text-sm text-blue-800">
                        <strong>Periode:</strong> {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        {{ $tahun }}
                    </p>
                </div>
            </div>

            @if ($siswa->count() > 0)
                @foreach ($siswa as $anak)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $anak->nama }}</h3>
                                    <p class="text-sm text-gray-600">NIS: {{ $anak->nis }} | Kelas:
                                        {{ $anak->kelas->nama_kelas }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Status Pembayaran -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-3">Status Pembayaran</h4>
                                    @php
                                        $jenisPembayaran = \App\Models\JenisPembayaran::all()->filter(function (
                                            $jenis,
                                        ) use ($anak) {
                                            return $jenis->isApplicableForSiswa($anak);
                                        });
                                    @endphp

                                    @foreach ($jenisPembayaran as $jenis)
                                        @php
                                            // Logic berbeda untuk bulanan vs tahunan/sekali
                                            if ($jenis->tipe == 'bulanan') {
                                                // SPP: cek pembayaran bulan ini
                                                $totalBayar = $anak
                                                    ->pembayaran()
                                                    ->where('id_jenis', $jenis->id)
                                                    ->whereMonth('tanggal_bayar', $bulan)
                                                    ->whereYear('tanggal_bayar', $tahun)
                                                    ->sum('jumlah_bayar');
                                            } else {
                                                // Tahunan/Sekali: cek pembayaran tahun ini
                                                $totalBayar = $anak
                                                    ->pembayaran()
                                                    ->where('id_jenis', $jenis->id)
                                                    ->whereYear('tanggal_bayar', $tahun)
                                                    ->sum('jumlah_bayar');
                                            }

                                            $persentase =
                                                $jenis->total_tagihan > 0
                                                    ? ($totalBayar / $jenis->total_tagihan) * 100
                                                    : 0;
                                            $sisa = $jenis->total_tagihan - $totalBayar;
                                        @endphp

                                        <div class="mb-4 p-3 border rounded-lg">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="font-medium">{{ $jenis->nama }}</span>
                                                <span
                                                    class="text-sm text-gray-600">{{ number_format($persentase, 1) }}%</span>
                                            </div>

                                            @if ($jenis->tipe == 'bulanan')
                                                <p class="text-xs text-blue-600 mb-2">Periode:
                                                    {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                                    {{ $tahun }}</p>
                                            @else
                                                <p class="text-xs text-purple-600 mb-2">Tahun: {{ $tahun }}</p>
                                            @endif

                                            <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                                <div class="bg-blue-600 h-2 rounded-full"
                                                    style="width: {{ min($persentase, 100) }}%"></div>
                                            </div>

                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>Dibayar: Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                                                <span>Sisa: Rp {{ number_format(max($sisa, 0), 0, ',', '.') }}</span>
                                            </div>

                                            @if ($persentase >= 100)
                                                <span
                                                    class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Lunas</span>
                                            @elseif($totalBayar > 0)
                                                <span
                                                    class="inline-block mt-2 px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Cicilan</span>
                                            @else
                                                <span
                                                    class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">Belum
                                                    Bayar</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Riwayat Pembayaran Periode Ini -->
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-3">Riwayat Pembayaran Periode Ini</h4>
                                    @php
                                        $riwayatPeriode = $anak
                                            ->pembayaran()
                                            ->with('jenisPembayaran')
                                            ->where(function ($query) use ($bulan, $tahun) {
                                                $query
                                                    ->whereMonth('tanggal_bayar', $bulan)
                                                    ->whereYear('tanggal_bayar', $tahun);
                                            })
                                            ->orderBy('tanggal_bayar', 'desc')
                                            ->get();
                                    @endphp

                                    @if ($riwayatPeriode->count() > 0)
                                        <div class="space-y-3">
                                            @foreach ($riwayatPeriode as $pembayaran)
                                                <div
                                                    class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                                    <div>
                                                        <p class="font-medium text-sm">
                                                            {{ $pembayaran->jenisPembayaran->nama }}</p>
                                                        <p class="text-xs text-gray-600">
                                                            {{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="font-medium text-green-600">Rp
                                                            {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-gray-500 text-sm">Tidak ada pembayaran di periode ini</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500">Tidak ada data siswa yang terdaftar untuk akun ini.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
