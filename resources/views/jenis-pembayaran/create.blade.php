<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Jenis Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('jenis-pembayaran.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama
                                    Pembayaran</label>
                                <input type="text" name="nama" id="nama"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 @enderror"
                                    value="{{ old('nama') }}" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenjang" class="block text-sm font-medium text-gray-700">Jenjang</label>
                                <select name="jenjang" id="jenjang"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jenjang') border-red-500 @enderror">
                                    <option value="">Pilih Jenjang</option>
                                    <option value="TK" {{ old('jenjang') == 'TK' ? 'selected' : '' }}>TK</option>
                                    <option value="SD" {{ old('jenjang') == 'SD' ? 'selected' : '' }}>SD</option>
                                </select>
                                @error('jenjang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" id="gender"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('gender') border-red-500 @enderror">
                                    <option value="ALL" {{ old('gender') == 'ALL' ? 'selected' : '' }}>Semua</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelas_min" class="block text-sm font-medium text-gray-700">Kelas Min (untuk
                                    SD)</label>
                                <input type="number" name="kelas_min" id="kelas_min" min="1" max="6"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kelas_min') border-red-500 @enderror"
                                    value="{{ old('kelas_min') }}">
                                @error('kelas_min')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kelas_max" class="block text-sm font-medium text-gray-700">Kelas Max (untuk
                                    SD)</label>
                                <input type="number" name="kelas_max" id="kelas_max" min="1" max="6"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('kelas_max') border-red-500 @enderror"
                                    value="{{ old('kelas_max') }}">
                                @error('kelas_max')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gelombang" class="block text-sm font-medium text-gray-700">Gelombang (untuk
                                    UDP SD)</label>
                                <select name="gelombang" id="gelombang"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('gelombang') border-red-500 @enderror">
                                    <option value="">Pilih Gelombang</option>
                                    <option value="1" {{ old('gelombang') == '1' ? 'selected' : '' }}>Gelombang 1
                                    </option>
                                    <option value="2" {{ old('gelombang') == '2' ? 'selected' : '' }}>Gelombang 2
                                    </option>
                                    <option value="3" {{ old('gelombang') == '3' ? 'selected' : '' }}>Gelombang 3
                                    </option>
                                    <option value="4" {{ old('gelombang') == '4' ? 'selected' : '' }}>Gelombang 4
                                    </option>
                                </select>
                                @error('gelombang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tipe" class="block text-sm font-medium text-gray-700">Tipe
                                    Pembayaran</label>
                                <select name="tipe" id="tipe"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('tipe') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="bulanan" {{ old('tipe') == 'bulanan' ? 'selected' : '' }}>Bulanan
                                    </option>
                                    <option value="tahunan" {{ old('tipe') == 'tahunan' ? 'selected' : '' }}>Tahunan
                                    </option>
                                    <option value="sekali" {{ old('tipe') == 'sekali' ? 'selected' : '' }}>Sekali Bayar
                                    </option>
                                </select>
                                @error('tipe')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="total_tagihan" class="block text-sm font-medium text-gray-700">Total
                                    Tagihan</label>
                                <input type="number" name="total_tagihan" id="total_tagihan" step="0.01"
                                    min="0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('total_tagihan') border-red-500 @enderror"
                                    value="{{ old('total_tagihan') }}" required>
                                @error('total_tagihan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bisa Dicicil?</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="bisa_cicil" id="cicil_ya" value="1"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            {{ old('bisa_cicil') == '1' ? 'checked' : '' }}>
                                        <label for="cicil_ya" class="text-sm text-gray-700">Ya</label>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="bisa_cicil" id="cicil_tidak" value="0"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            {{ old('bisa_cicil') == '0' ? 'checked' : '' }}>
                                        <label for="cicil_tidak" class="text-sm text-gray-700">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('jenis-pembayaran.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
