<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Siswa: {{ $siswa->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Siswa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p><strong>NIS:</strong> {{ $siswa->nis }}</p>
                            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
                            <p><strong>Jenis Kelamin:</strong>
                                {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas }}</p>
                            <p><strong>Orang Tua:</strong> {{ $siswa->ortu->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Pembayaran</h3>
                    @if ($siswa->pembayaran->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jenis Pembayaran</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($siswa->pembayaran as $pembayaran)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $pembayaran->jenisPembayaran->nama }}</td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada riwayat pembayaran.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('siswa.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
