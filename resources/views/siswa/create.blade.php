<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nis" class="block text-sm font-medium text-gray-700">NIS</label>
                                <input type="number" name="nis" id="nis"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nis') border-red-500 @enderror"
                                    value="{{ old('nis') }}" required>
                                @error('nis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                                <input type="text" name="nama" id="nama"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nama') border-red-500 @enderror"
                                    value="{{ old('nama') }}" required>
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
                                            {{ old('id_kelas') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kelas')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="relative">
                                <label for="ortu_search" class="block text-sm font-medium text-gray-700">Orang
                                    Tua</label>
                                <input type="text" id="ortu_search" placeholder="Ketik nama atau email orang tua..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_ortu') border-red-500 @enderror"
                                    autocomplete="off">
                                <input type="hidden" name="id_ortu" id="id_ortu" value="{{ old('id_ortu') }}">
                                <div id="ortu_dropdown"
                                    class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                                    @foreach ($ortu as $item)
                                        <div class="ortu-option px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                            data-id="{{ $item->id }}"
                                            data-text="{{ $item->name }} ({{ $item->email }})">
                                            {{ $item->name }} ({{ $item->email }})
                                        </div>
                                    @endforeach
                                </div>
                                @error('id_ortu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jenis_kelamin') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">
                                        Laki-laki</option>
                                    <option value="P">
                                        Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
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
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ortuSearchInput = document.getElementById('ortu_search');
            const ortuHiddenInput = document.getElementById('id_ortu');
            const ortuDropdown = document.getElementById('ortu_dropdown');
            const ortuOptions = document.querySelectorAll('.ortu-option');

            // Search ortu functionality
            ortuSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasResults = false;

                ortuOptions.forEach(option => {
                    const text = option.getAttribute('data-text').toLowerCase();
                    if (text.includes(searchTerm)) {
                        option.style.display = 'block';
                        hasResults = true;
                    } else {
                        option.style.display = 'none';
                    }
                });

                if (searchTerm.length > 0 && hasResults) {
                    ortuDropdown.classList.remove('hidden');
                } else {
                    ortuDropdown.classList.add('hidden');
                }

                // Clear selection if input is cleared
                if (searchTerm.length === 0) {
                    ortuHiddenInput.value = null;
                }
            });

            // Handle ortu selection
            ortuOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const text = this.getAttribute('data-text');

                    ortuSearchInput.value = text;
                    ortuHiddenInput.value = id;
                    ortuDropdown.classList.add('hidden');
                });
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!ortuSearchInput.contains(e.target) && !ortuDropdown.contains(e.target)) {
                    ortuDropdown.classList.add('hidden');
                }
            });

            // Set initial value if there's old input
            if (ortuHiddenInput.value) {
                const selectedOption = document.querySelector(`.ortu-option[data-id="${ortuHiddenInput.value}"]`);
                if (selectedOption) {
                    ortuSearchInput.value = selectedOption.getAttribute('data-text');
                }
            }
        });
    </script>
</x-app-layout>
