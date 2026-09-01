<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Berita
            </h2>
            <a href="{{ route('desa.news.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                
                <form method="POST" action="{{ route('desa.news.update', $news) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="mb-5">
                        <x-input-label for="title" value="Judul Berita" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            :value="old('title', $news->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    
                    <div class="mb-5">
                        <x-input-label for="cover_image" value="Foto Sampul Baru (Kosongkan jika tidak ingin mengubah)" />
                        <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp"
                            class="mt-1 block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-indigo-100 cursor-pointer" />
                        @if($news->cover_image_path)
                            <p class="mt-2 text-sm text-green-600">Sudah ada foto sampul tersimpan.</p>
                        @endif
                        <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="content" value="Isi Berita" />
                        <textarea id="content" name="content" rows="10"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            required>{{ old('content', $news->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
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
