<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Siswa</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex space-x-2 mb-6">
                <a href="{{ route('siswa.export-excel', request()->query()) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('siswa.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Siswa
                </a>
            </div>

            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Cari Siswa</label>
                            <input type="text" name="search" id="search"
                                placeholder="Nama, NIS, atau nama orang tua..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ request('search') }}">
                        </div>
                        <div>
                            <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                            <select name="kelas" id="kelas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelasList as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('kelas') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                            <a href="{{ route('siswa.index') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIS</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kelas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Kelamin</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Orang Tua</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($siswa as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->nis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->kelas->nama_kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->ortu->name ?? '-' }}</td>
                                        <td
                                            class="flex gap-2 justify-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('siswa.show', $item) }}"
                                                class="bg-indigo-600 hover:bg-indigo-700 py-1.5 px-4 rounded-md text-white">Lihat</a>
                                            <a href="{{ route('siswa.edit', $item) }}"
                                                class="bg-yellow-600 hover:bg-yellow-700 py-1.5 px-4 rounded-md text-white">Edit</a>
                                            <form action="{{ route('siswa.destroy', $item) }}" method="POST"
                                                class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="bg-red-600 hover:bg-red-700 py-1.5 px-4 rounded-md text-white delete-btn">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak
                                            ada data siswa</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $siswa->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteForms = document.querySelectorAll('.delete-form');

                deleteForms.forEach(form => {
                    const deleteBtn = form.querySelector('.delete-btn');

                    deleteBtn.addEventListener('click', async function(e) {
                        e.preventDefault();

                        try {
                            const result = await Swal.fire({
                                title: 'Hapus Siswa',
                                text: 'Apakah Anda yakin ingin menghapus siswa ini?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#EF4444', // Tailwind red-500
                                cancelButtonColor: '#6B7280', // Tailwind gray-500
                                confirmButtonText: 'Ya, Hapus!',
                                cancelButtonText: 'Batal',
                                reverseButtons: true
                            });

                            if (result.isConfirmed) {
                                form.submit();
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Toast.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat memproses permintaan'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
