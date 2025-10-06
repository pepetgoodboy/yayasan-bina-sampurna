<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pembayaran.update', $pembayaran) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="id_siswa" class="block text-sm font-medium text-gray-700">Siswa</label>
                                <select name="id_siswa" id="id_siswa"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_siswa') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_siswa', $pembayaran->id_siswa) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }} ({{ $item->nis }}) - {{ $item->kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_siswa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_jenis" class="block text-sm font-medium text-gray-700">Jenis
                                    Pembayaran</label>
                                <select name="id_jenis" id="id_jenis"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_jenis') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    @foreach ($jenisPembayaran as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_jenis', $pembayaran->id_jenis) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }} ({{ ucfirst($item->tipe) }}) - Rp
                                            {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jenis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700">Tanggal
                                    Bayar</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tanggal_bayar') border-red-500 @enderror"
                                    value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar->format('Y-m-d')) }}"
                                    required>
                                @error('tanggal_bayar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700">Jumlah
                                    Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" step="0.01"
                                    min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jumlah_bayar') border-red-500 @enderror"
                                    value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}" required>
                                @error('jumlah_bayar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $pembayaran->keterangan) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pembayaran.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
