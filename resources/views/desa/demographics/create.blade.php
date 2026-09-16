<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('desa.demographics.index') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                {{ __('Tambah Data Statistik') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 overflow-hidden">
                <form action="{{ route('desa.demographics.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    
                    <div>
                        <x-input-label for="type" value="Kategori (Contoh: Jenis Kelamin, Usia, Agama)" />
                        <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" :value="old('type')" required autofocus placeholder="Contoh: Jenis Kelamin" />
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        <p class="mt-1 text-xs text-ash-text">Pastikan penulisan kategori konsisten agar data dapat dikelompokkan dengan benar.</p>
                    </div>

                    <div>
                        <x-input-label for="label" value="Label (Contoh: Laki-laki, 0-4 Tahun, Islam)" />
                        <x-text-input id="label" name="label" type="text" class="mt-1 block w-full" :value="old('label')" required placeholder="Contoh: Laki-laki" />
                        <x-input-error class="mt-2" :messages="$errors->get('label')" />
                    </div>

                    <div>
                        <x-input-label for="count" value="Jumlah Penduduk" />
                        <x-text-input id="count" name="count" type="number" min="0" class="mt-1 block w-full" :value="old('count')" required placeholder="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('count')" />
                    </div>

                    <div class="flex justify-end mt-8 pt-6 border-t border-slate-border/20">
                        <a href="{{ route('desa.demographics.index') }}" class="px-6 py-2.5 text-ash-text hover:text-ivory-text font-medium transition mr-4">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-cobalt hover:bg-cobalt-hover text-pure-white font-semibold rounded-lg transition shadow-lg shadow-cobalt/20">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
