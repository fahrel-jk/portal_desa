<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Foto Galeri
            </h2>
            <a href="{{ route('desa.galleries.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Galeri</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                
                <form action="{{ route('desa.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Upload Foto (Bisa pilih lebih dari satu)</label>
                        <input type="file" name="images[]" multiple accept="image/*" required
                               class="w-full text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt-hover bg-obsidian-button/30 border border-slate-border/15 rounded-md p-2">
                        <p class="mt-1 text-xs text-ash-text">Format: JPG, PNG. Maks 4MB per file.</p>
                        @error('images') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @error('images.*') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-ash-text mb-2">Caption (Opsional)</label>
                        <input type="text" name="caption" value="{{ old('caption') }}"
                               class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                               placeholder="Tuliskan keterangan untuk foto-foto ini...">
                        <p class="mt-1 text-xs text-ash-text">Caption ini akan diterapkan ke semua foto yang diupload bersamaan.</p>
                        @error('caption') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('desa.galleries.index') }}" class="px-5 py-2.5 bg-obsidian-button hover:bg-slate-border/15 text-ivory-text rounded-lg text-sm font-medium transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-cobalt hover:bg-cobalt-hover text-white rounded-lg text-sm font-medium shadow-md shadow-cobalt/20 transition">Upload Foto</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
