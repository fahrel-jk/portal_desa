<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Dokumen PPID') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Daftar Dokumen Publik</h3>
                        <a href="{{ route('desa.documents.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Dokumen</a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Judul</th>
                                    <th class="py-2 px-4 border-b text-left">Kategori</th>
                                    <th class="py-2 px-4 border-b text-center">Status</th>
                                    <th class="py-2 px-4 border-b text-center">Unduhan</th>
                                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $doc)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $doc->title }}</td>
                                        <td class="py-2 px-4 border-b">{{ $doc->category }}</td>
                                        <td class="py-2 px-4 border-b text-center">
                                            @if($doc->is_active)
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b text-center">{{ $doc->download_count }}</td>
                                        <td class="py-2 px-4 border-b text-center">
                                            <a href="{{ route('desa.documents.edit', $doc) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                            <form action="{{ route('desa.documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 px-4 border-b text-center text-gray-500">Belum ada data dokumen.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $documents->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
