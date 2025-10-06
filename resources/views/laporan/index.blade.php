<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal
                                Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ $tanggalMulai }}">
                        </div>

                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal
                                Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ $tanggalSelesai }}">
                        </div>

                        <div>
                            <label for="kelas_id" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select name="kelas_id" id="kelas_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}" {{ $kelasId == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="jenis_id" class="block text-sm font-medium text-gray-700">Jenis
                                Pembayaran</label>
                            <select name="jenis_id" id="jenis_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Jenis</option>
                                @foreach ($jenisPembayaran as $item)
                                    <option value="{{ $item->id }}" {{ $jenisId == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Total Pemasukan</h3>
                            <p class="text-3xl font-bold text-green-600">Rp
                                {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-600">Periode: {{ date('d/m/Y', strtotime($tanggalMulai)) }} -
                                {{ date('d/m/Y', strtotime($tanggalSelesai)) }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('laporan.export-pdf', request()->query()) }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                PDF
                            </a>
                            <a href="{{ route('laporan.export-excel', request()->query()) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Siswa</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kelas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Pembayaran</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pembayaran as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->tanggal_bayar->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->siswa->nama }}<br>
                                            <span class="text-xs text-gray-500">{{ $item->siswa->nis }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->siswa->kelas->nama_kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->jenisPembayaran->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                            Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak
                                            ada data pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
