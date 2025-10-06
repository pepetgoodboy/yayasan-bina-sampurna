<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Kelas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-6">
            <a href="{{ route('kelas.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-fit">
                Tambah Kelas
            </a>
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Kelas</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jumlah Siswa</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kelas as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->nama_kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            {{ $item->siswa_count }} siswa</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2 justify-center text-sm">
                                                <a href="{{ route('kelas.show', $item) }}"
                                                    class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded-md">Lihat</a>
                                                <a href="{{ route('kelas.edit', $item) }}"
                                                    class="bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-3 rounded-md">Edit</a>
                                                <form action="{{ route('kelas.destroy', $item) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md delete-btn">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak ada data kelas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                title: 'Hapus Kelas',
                                text: 'Apakah Anda yakin ingin menghapus kelas ini?',
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
