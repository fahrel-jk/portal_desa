<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Layanan
            </h2>
            <a href="{{ route('desa.services.index') }}" class="text-sm text-cobalt hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-6">
                <form method="POST" action="{{ route('desa.services.update', $service) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <label for="name" class="block text-sm font-medium text-ash-text mb-1">Nama Layanan <span class="text-red-400">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                               class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">
                        @error('name') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-ash-text mb-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3"
                                  class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">{{ old('description', $service->description) }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="requirements" class="block text-sm font-medium text-ash-text mb-1">Persyaratan</label>
                        <textarea id="requirements" name="requirements" rows="4"
                                  class="block w-full rounded-lg bg-obsidian-button border-slate-border/30 text-ivory-text focus:border-cobalt focus:ring-cobalt">{{ old('requirements', $service->requirements) }}</textarea>
                        @error('requirements') <p class="mt-1 text-sm text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('desa.services.index') }}" class="px-4 py-2 text-sm text-ash-text hover:text-ivory-text transition">Batal</a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
