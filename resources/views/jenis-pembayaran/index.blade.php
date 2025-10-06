<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jenis Pembayaran</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-6 mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('jenis-pembayaran.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-fit">
                Tambah Jenis Pembayaran
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenjang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gender</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kelas</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tipe</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Tagihan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Bisa Cicil</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($jenisPembayaran as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($item->jenjang)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">{{ $item->jenjang }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($item->gender && $item->gender !== 'ALL')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if ($item->gender == 'L') bg-blue-100 text-blue-800
                                                    @else bg-pink-100 text-pink-800 @endif">
                                                    {{ $item->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">Semua</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($item->kelas_min && $item->kelas_max)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $item->kelas_min }}-{{ $item->kelas_max }}
                                                </span>
                                            @elseif($item->gelombang)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Gel. {{ $item->gelombang }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if ($item->tipe == 'bulanan') bg-blue-100 text-blue-800
                                                @elseif($item->tipe == 'tahunan') bg-green-100 text-green-800
                                                @else bg-purple-100 text-purple-800 @endif">
                                                {{ ucfirst($item->tipe) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp
                                            {{ number_format($item->total_tagihan, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if ($item->bisa_cicil)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                            @endif
                                        </td>
                                        <td
                                            class="flex gap-2 justify-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('jenis-pembayaran.edit', $item) }}"
                                                class="bg-yellow-600 hover:bg-yellow-700 py-1.5 px-4 rounded-md text-white">Edit</a>
                                            <form action="{{ route('jenis-pembayaran.destroy', $item) }}"
                                                method="POST" class="inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="bg-red-600 hover:bg-red-700 py-1.5 px-4 rounded-md text-white delete-btn">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Tidak
                                            ada data jenis pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $jenisPembayaran->appends(request()->query())->links() }}
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
