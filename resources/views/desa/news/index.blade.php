<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Berita
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl">
                <div class="p-6 border-b border-slate-border/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-ivory-text">Daftar Berita</h3>
                    <a href="{{ route('desa.news.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Berita
                    </a>
                </div>
                
                @if($news->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-obsidian-button/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Dipublikasikan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($news as $item)
                                    <tr class="hover:bg-obsidian-button/30 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-ivory-text">{{ $item->title }}</div>
                                            <div class="text-xs text-ash-text font-mono">/berita/{{ $item->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                            {{ $item->published_at->format('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('desa.news.edit', $item) }}" class="text-cobalt hover:underline mr-3">Edit</a>
                                            
                                            <form action="{{ route('desa.news.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-ash-text">
                        Belum ada berita yang dipublikasikan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
