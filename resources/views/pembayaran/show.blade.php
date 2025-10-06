<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pembayaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="mb-2"><strong>Siswa:</strong> {{ $pembayaran->siswa->nama }}</p>
                            <p class="mb-2"><strong>NIS:</strong> {{ $pembayaran->siswa->nis }}</p>
                            <p class="mb-2"><strong>Kelas:</strong> {{ $pembayaran->siswa->kelas->nama_kelas }}</p>
                        </div>
                        <div>
                            <p class="mb-2"><strong>Jenis Pembayaran:</strong>
                                {{ $pembayaran->jenisPembayaran->nama }}</p>
                            <p class="mb-2"><strong>Tanggal Bayar:</strong>
                                {{ $pembayaran->tanggal_bayar->format('d/m/Y') }}</p>
                            <p class="mb-2"><strong>Jumlah Bayar:</strong> <span
                                    class="text-green-600 font-semibold">Rp
                                    {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span></p>
                        </div>
                    </div>

                    @if ($pembayaran->keterangan)
                        <div class="mt-4">
                            <p><strong>Keterangan:</strong></p>
                            <p class="text-gray-700">{{ $pembayaran->keterangan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('pembayaran.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
