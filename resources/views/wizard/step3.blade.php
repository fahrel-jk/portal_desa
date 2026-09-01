<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Pendaftaran Desa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                <x-portal.step-indicator :current="3" :total="4" />

                <h3 class="text-lg font-semibold text-ivory-text mb-1">Identitas Visual</h3>
                <p class="text-sm text-ash-text mb-6">Upload logo dan foto utama desa Anda. File bersifat opsional.</p>

                <form method="POST" action="{{ route('wizard.store-step3') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Logo Desa -->
                    <div class="mb-6">
                        <x-input-label for="logo" value="Logo Desa" />
                        <div class="mt-2 flex items-center gap-4">
                            <div class="w-20 h-20 rounded-lg border-2 border-dashed border-slate-border flex items-center justify-center bg-obsidian-button/30 overflow-hidden"
                                id="logo-preview-container">
                                @if(!empty($data['logo_path']))
                                    <span class="text-xs text-green-600 text-center px-2">{{ $data['logo_name'] ?? 'Tersimpan' }}</span>
                                @else
                                    <svg class="w-8 h-8 text-ash-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp"
                                    class="block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-indigo-100 cursor-pointer" />
                                <p class="mt-1 text-xs text-ash-text">JPG, PNG, atau WebP. Maks 2 MB.</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <!-- Hero Image -->
                    <div class="mb-6">
                        <x-input-label for="hero_image" value="Foto Utama / Hero Image" />
                        <div class="mt-2">
                            <div class="w-full aspect-video rounded-lg border-2 border-dashed border-slate-border flex items-center justify-center bg-obsidian-button/30 overflow-hidden"
                                id="hero-preview-container">
                                @if(!empty($data['hero_image_path']))
                                    <span class="text-sm text-green-600">{{ $data['hero_image_name'] ?? 'Foto tersimpan' }}</span>
                                @else
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-ash-text mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-ash-text">Upload foto utama desa</p>
                                    </div>
                                @endif
                            </div>
                            <input type="file" id="hero_image" name="hero_image" accept="image/jpeg,image/png,image/webp"
                                class="mt-2 block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-indigo-100 cursor-pointer" />
                            <p class="mt-1 text-xs text-ash-text">JPG, PNG, atau WebP. Maks 4 MB. Rekomendasi: 1200x600px.</p>
                        </div>
                        <x-input-error :messages="$errors->get('hero_image')" class="mt-2" />
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('wizard.step2') }}"
                            class="inline-flex items-center px-4 py-2 bg-graphite-card border border-slate-border rounded-md font-semibold text-xs text-ivory-text uppercase tracking-widest shadow-sm hover:bg-obsidian-button/30 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <x-primary-button>
                            Lanjut ke Langkah 4
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
