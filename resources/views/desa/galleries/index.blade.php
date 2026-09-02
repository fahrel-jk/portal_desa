<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Galeri Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-ivory-text">Koleksi Foto</h3>
                    <a href="{{ route('desa.galleries.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Foto
                    </a>
                </div>
                
                @if($galleries->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($galleries as $gallery)
                            <div class="group relative rounded-xl overflow-hidden bg-obsidian-button/30 border border-slate-border/15 aspect-square">
                                <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                                    @if($gallery->caption)
                                        <p class="text-white text-sm truncate mb-2">{{ $gallery->caption }}</p>
                                    @endif
                                    
                                    <form action="{{ route('desa.galleries.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded w-full transition">
                                            Hapus Foto
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center text-ash-text">
                        <svg class="w-12 h-12 mx-auto mb-4 text-ash-text/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Belum ada foto di galeri. Klik "Tambah Foto" untuk memulai.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
