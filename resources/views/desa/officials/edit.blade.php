<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Perangkat Desa
            </h2>
            <a href="{{ route('desa.officials.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                
                <form method="POST" action="{{ route('desa.officials.update', $official) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $official->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="position" value="Jabatan" />
                        <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                            :value="old('position', $official->position)" required />
                        <x-input-error :messages="$errors->get('position')" class="mt-2" />
                    </div>
                    
                    <div class="mb-6">
                        <x-input-label for="photo" value="Foto Baru (Kosongkan jika tidak ingin mengubah)" />
                        <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                            class="mt-1 block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-indigo-100 cursor-pointer" />
                        
                        @if($official->photo_path)
                            <div class="mt-3 flex items-center gap-3">
                                <span class="text-sm text-ash-text">Foto saat ini:</span>
                                <img src="{{ Storage::url($official->photo_path) }}" class="w-12 h-12 rounded-full object-cover">
                            </div>
                        @endif
                        
                        <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
