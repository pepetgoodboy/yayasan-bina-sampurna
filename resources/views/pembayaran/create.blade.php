<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Input Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('pembayaran.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="siswa_search" class="block text-sm font-medium text-gray-700">Siswa</label>
                                <input type="text" id="siswa_search"
                                    placeholder="Ketik nama, NIS, atau kelas siswa..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_siswa') border-red-500 @enderror"
                                    autocomplete="off" required>
                                <input type="hidden" name="id_siswa" id="id_siswa" value="{{ old('id_siswa') }}">
                                <div id="siswa_dropdown"
                                    class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                                    @foreach ($siswa as $item)
                                        <div class="siswa-option px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                            data-id="{{ $item->id }}"
                                            data-text="{{ $item->nama }} ({{ $item->nis }}) - {{ $item->kelas->nama_kelas }}">
                                            {{ $item->nama }} ({{ $item->nis }}) - {{ $item->kelas->nama_kelas }}
                                        </div>
                                    @endforeach
                                </div>
                                @error('id_siswa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="id_jenis" class="block text-sm font-medium text-gray-700">Jenis
                                    Pembayaran</label>
                                <select name="id_jenis" id="id_jenis"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('id_jenis') border-red-500 @enderror"
                                    required disabled>
                                    <option value="">Pilih Jenis Pembayaran</option>
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
                                    value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                                @error('tanggal_bayar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700">Jumlah
                                    Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('jumlah_bayar') border-red-500 @enderror"
                                    value="{{ old('jumlah_bayar') }}" required>
                                @error('jumlah_bayar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="info-pembayaran" class="mt-2 text-sm text-gray-600"></div>
                            </div>

                            <div class="md:col-span-2">
                                <label for="keterangan"
                                    class="block text-sm font-medium text-gray-700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pembayaran.index') }}"
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
            const siswaSearchInput = document.getElementById('siswa_search');
            const siswaHiddenInput = document.getElementById('id_siswa');
            const siswaDropdown = document.getElementById('siswa_dropdown');
            const jenisSelect = document.getElementById('id_jenis');
            const jumlahInput = document.getElementById('jumlah_bayar');
            const infoDiv = document.getElementById('info-pembayaran');
            const submitBtn = document.querySelector('button[type="submit"]');
            const siswaOptions = document.querySelectorAll('.siswa-option');
            const allJenisPembayaran = @json($jenisPembayaran);

            // Search siswa functionality
            siswaSearchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasResults = false;

                siswaOptions.forEach(option => {
                    const text = option.getAttribute('data-text').toLowerCase();
                    if (text.includes(searchTerm)) {
                        option.style.display = 'block';
                        hasResults = true;
                    } else {
                        option.style.display = 'none';
                    }
                });

                if (searchTerm.length > 0 && hasResults) {
                    siswaDropdown.classList.remove('hidden');
                } else {
                    siswaDropdown.classList.add('hidden');
                }

                // Clear selection if input is cleared
                if (searchTerm.length === 0) {
                    siswaHiddenInput.value = '';
                    updateInfo();
                }
            });

            // Handle siswa selection
            siswaOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const text = this.getAttribute('data-text');
                    const siswaData = @json($siswa);
                    const selectedSiswa = siswaData.find(s => s.id == id);

                    siswaSearchInput.value = text;
                    siswaHiddenInput.value = id;
                    siswaDropdown.classList.add('hidden');

                    // Enable and filter jenis pembayaran
                    jenisSelect.disabled = false;
                    updateJenisPembayaran(selectedSiswa);
                    updateInfo();
                });
            });

            function updateJenisPembayaran(siswa) {
                // Clear existing options except the first one
                while (jenisSelect.options.length > 1) {
                    jenisSelect.remove(1);
                }

                // Fetch applicable payment types for this student
                fetch(`{{ route('pembayaran.jenis-by-siswa') }}?siswa_id=${siswa.id}`)
                    .then(response => response.json())
                    .then(jenisList => {
                        jenisList.forEach(jenis => {
                            const option = document.createElement('option');
                            option.value = jenis.id;
                            option.textContent =
                                `${jenis.nama} (${jenis.tipe.charAt(0).toUpperCase() + jenis.tipe.slice(1)}) - Rp ${Intl.NumberFormat('id-ID').format(jenis.total_tagihan)}`;
                            jenisSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching payment types:', error);
                    });
            }

            // Clear selection if input is cleared
            siswaSearchInput.addEventListener('input', function() {
                if (this.value === '') {
                    jenisSelect.disabled = true;
                    while (jenisSelect.options.length > 1) {
                        jenisSelect.remove(1);
                    }
                }
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!siswaSearchInput.contains(e.target) && !siswaDropdown.contains(e.target)) {
                    siswaDropdown.classList.add('hidden');
                }
            });

            function updateInfo() {
                const siswaId = siswaHiddenInput.value;
                const jenisId = jenisSelect.value;

                if (siswaId && jenisId) {
                    fetch(`{{ route('pembayaran.sisa-tagihan') }}?id_siswa=${siswaId}&id_jenis=${jenisId}`)
                        .then(response => response.json())
                        .then(data => {
                            let info =
                                `Total Tagihan: Rp ${Intl.NumberFormat('id-ID').format(data.total_tagihan)}<br>`;
                            info += `Sisa Tagihan: Rp ${data.sisa.toLocaleString('id-ID')}<br>`;
                            info += `Tipe: ${data.tipe.charAt(0).toUpperCase() + data.tipe.slice(1)}`;

                            // Check if already paid in full
                            if (data.sisa === 0) {
                                jumlahInput.disabled = true;
                                submitBtn.disabled = true;
                                info +=
                                    `<br><span class="text-green-600 font-bold">LUNAS - Pembayaran sudah selesai</span>`;
                            } else if (data.tipe === 'bulanan') {
                                jumlahInput.value = parseInt(data.total_tagihan);
                                jumlahInput.readOnly = true;
                                jumlahInput.disabled = false;
                                submitBtn.disabled = false;
                                info +=
                                    `<br><span class="text-red-600">Pembayaran bulanan harus dibayar penuh</span>`;
                            } else {
                                jumlahInput.readOnly = false;
                                jumlahInput.disabled = false;
                                submitBtn.disabled = false;
                                jumlahInput.max = data.sisa;
                                if (data.bisa_cicil) {
                                    info += `<br><span class="text-green-600">Bisa dicicil</span>`;
                                }
                            }

                            infoDiv.innerHTML = info;
                        });
                } else {
                    infoDiv.innerHTML = '';
                    jumlahInput.readOnly = false;
                    jumlahInput.disabled = false;
                    submitBtn.disabled = false;
                    jumlahInput.removeAttribute('max');
                }
            }

            jenisSelect.addEventListener('change', updateInfo);
        });
    </script>
</x-app-layout>
