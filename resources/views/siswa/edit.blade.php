<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('siswa.update', $siswa) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                                <input type="text" name="nis" id="nis"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nis') border-red-500 @enderror"
                                    value="{{ old('nis', $siswa->nis) }}" required>
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                                <input type="text" name="nama" id="nama"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 @enderror"
                                    value="{{ old('nama', $siswa->nama) }}" required>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                                <select name="id_kelas" id="id_kelas"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_kelas') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_kelas', $siswa->id_kelas) == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kelas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_ortu" class="block text-sm font-medium text-gray-700">Orang Tua</label>
                                <select name="id_ortu" id="id_ortu"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_ortu') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Orang Tua</option>
                                    @foreach ($ortu as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('id_ortu', $siswa->id_ortu) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_ortu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('siswa.index') }}"
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
