<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Produk UMKM
            </h2>
            <a href="{{ route('desa.products.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Produk</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">

                <form action="{{ route('desa.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Nama Produk <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                               placeholder="Contoh: Kue Kacang Gula">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-ash-text mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0"
                                   class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                                   placeholder="Contoh: 15000">
                            @error('price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ash-text mb-2">Kategori</label>
                            <input type="text" name="category" value="{{ old('category') }}"
                                   class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                                   placeholder="Contoh: Makanan & Minuman">
                            @error('category') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                                  placeholder="Jelaskan produk Anda secara detail...">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Foto Produk</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt-hover bg-obsidian-button/30 border border-slate-border/15 rounded-md p-2">
                        <p class="mt-1 text-xs text-ash-text">Format: JPG, PNG, WebP. Maks 4MB.</p>
                        @error('image') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-medium text-ash-text mb-2">Nomor WhatsApp Penjual (Opsional)</label>
                        <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp') }}"
                               class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                               placeholder="Contoh: 6281234567890">
                        <p class="mt-1 text-xs text-ash-text">Format: kode negara tanpa + (contoh: 6281234567890). Digunakan untuk tombol "Hubungi Penjual".</p>
                        @error('contact_whatsapp') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('desa.products.index') }}" class="px-5 py-2.5 bg-obsidian-button hover:bg-slate-border/15 text-ivory-text rounded-lg text-sm font-medium transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-cobalt hover:bg-cobalt-hover text-white rounded-lg text-sm font-medium shadow-md shadow-cobalt/20 transition">Simpan Produk</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
