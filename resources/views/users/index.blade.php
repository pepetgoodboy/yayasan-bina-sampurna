<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Users</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="flex flex-col gap-6 mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('users.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-fit">
                Tambah User
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
                                        Email</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pertanyaan</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @foreach ($user->roles as $role)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if ($role->name == 'admin') bg-red-100 text-red-800
                                                    @elseif($role->name == 'bendahara') bg-blue-100 text-blue-800
                                                    @else bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $user->pertanyaanKeamanan->pertanyaan }}</td>
                                        <td
                                            class="flex gap-2 justify-center px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('users.show', $user) }}"
                                                class="bg-indigo-600 hover:bg-indigo-700 py-1.5 px-4 rounded-md text-white">Lihat</a>
                                            <a href="{{ route('users.edit', $user) }}"
                                                class="bg-yellow-600 hover:bg-yellow-700 py-1.5 px-4 rounded-md text-white">Edit</a>
                                            @if ($user->id != auth()->id())
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-600 hover:bg-red-700 py-1.5 px-4 rounded-md text-white"
                                                        onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak
                                            ada data user</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
