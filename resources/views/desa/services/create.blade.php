<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Layanan Baru
            </h2>
            <a href="{{ route('desa.services.index') }}" class="text-sm text-cobalt hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                <form method="POST" action="{{ route('desa.services.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-ash-text mb-1">Nama Layanan <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-ash-text mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="requirements" class="block text-sm font-medium text-ash-text mb-1">Persyaratan</label>
                        <textarea id="requirements" name="requirements" rows="4" placeholder="Tulis satu persyaratan per baris:&#10;KTP asli&#10;Surat pengantar RT/RW&#10;Pas foto 3x4"
                                  class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">{{ old('requirements') }}</textarea>
                        <p class="mt-1 text-xs text-ash-text/60">Tulis satu persyaratan per baris.</p>
                        @error('requirements') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="process_steps" class="block text-sm font-medium text-ash-text mb-1">Alur Proses</label>
                        <textarea id="process_steps" name="process_steps" rows="4" placeholder="Tulis satu langkah per baris:&#10;Datang ke kantor desa dengan membawa persyaratan&#10;Mengisi formulir pengajuan&#10;Petugas memverifikasi data&#10;Dokumen dicetak dan ditandatangani"
                                  class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">{{ old('process_steps') }}</textarea>
                        <p class="mt-1 text-xs text-ash-text/60">Tulis satu langkah per baris. Akan ditampilkan sebagai timeline di halaman publik.</p>
                        @error('process_steps') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="estimated_time" class="block text-sm font-medium text-ash-text mb-1">Estimasi Waktu</label>
                            <input type="text" id="estimated_time" name="estimated_time" value="{{ old('estimated_time') }}" placeholder="Contoh: 3-5 Hari Kerja"
                                   class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">
                            @error('estimated_time') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="cost" class="block text-sm font-medium text-ash-text mb-1">Biaya</label>
                            <input type="text" id="cost" name="cost" value="{{ old('cost') }}" placeholder="Contoh: Gratis / Rp 50.000"
                                   class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">
                            @error('cost') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-slate-border bg-obsidian-button text-cobalt focus:ring-cobalt">
                            <span class="text-sm text-ivory-text">Aktifkan layanan ini (tampil di halaman publik)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('desa.services.index') }}" class="px-4 py-2 text-sm text-ash-text hover:text-ivory-text transition">Batal</a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                            Simpan Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
