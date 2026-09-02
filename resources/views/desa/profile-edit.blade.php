<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Profil Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('desa.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <!-- Logo Desa -->
                    <div class="mb-6 pb-6 border-b border-slate-border/15">
                        <x-input-label for="logo" value="Logo Desa" />
                        <div class="mt-2 flex items-center gap-4">
                            @if($village->logo_path)
                                <div class="relative group h-16 w-16">
                                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo" class="h-16 w-16 object-cover rounded-md border border-slate-border">
                                    <label class="absolute inset-0 bg-red-500/80 rounded-md opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" title="Hapus Logo">
                                        <input type="checkbox" name="remove_logo" value="1" class="sr-only">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </label>
                                </div>
                            @endif
                            <input type="file" id="logo" name="logo" class="block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt/90 cursor-pointer">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP (Maks 2MB). Centang ikon tong sampah untuk menghapus.</p>
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <!-- Gambar Hero (Background Landing Page) -->
                    <div class="mb-6 pb-6 border-b border-slate-border/15">
                        <x-input-label for="hero_image" value="Gambar Latar Landing Page (Hero)" />
                        <div class="mt-2">
                            @if($village->hero_image_path)
                                <div class="relative group h-32 w-full mb-3 rounded-lg overflow-hidden border border-slate-border">
                                    <img src="{{ Storage::url($village->hero_image_path) }}" alt="Hero" class="h-full w-full object-cover">
                                    <label class="absolute inset-0 bg-red-500/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" title="Hapus Gambar Latar">
                                        <input type="checkbox" name="remove_hero" value="1" class="sr-only">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </label>
                                </div>
                            @endif
                            <input type="file" id="hero_image" name="hero_image" class="block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt/90 cursor-pointer">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP (Maks 4MB). Centang ikon tong sampah untuk menghapus.</p>
                        <x-input-error :messages="$errors->get('hero_image')" class="mt-2" />
                    </div>

                    <!-- Deskripsi / Sejarah -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Deskripsi / Sejarah Singkat Desa" />
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Ceritakan sejarah singkat dan keunggulan desa Anda...">{{ old('description', $village->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Kontak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="contact_phone" value="Telepon Kantor" />
                            <x-text-input id="contact_phone" name="contact_phone" type="text" class="mt-1 block w-full"
                                :value="old('contact_phone', $village->contact_phone)"
                                placeholder="0343-123456" />
                            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact_email" value="Email Desa" />
                            <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full"
                                :value="old('contact_email', $village->contact_email)"
                                placeholder="desa@example.com" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="office_hours" value="Jam Layanan" />
                        <x-text-input id="office_hours" name="office_hours" type="text" class="mt-1 block w-full"
                            :value="old('office_hours', $village->office_hours)"
                            placeholder="Senin - Jumat, 08:00 - 15:00 WIB" />
                        <x-input-error :messages="$errors->get('office_hours')" class="mt-2" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="address" value="Alamat Kantor Desa" />
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Alamat lengkap kantor desa">{{ old('address', $village->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    {{-- Theme Color Selection --}}
                    <div class="mb-8 pt-6 border-t border-slate-border/15">
                        <h3 class="text-lg font-semibold text-ivory-text mb-1">Pilih Warna Tema</h3>
                        <p class="text-sm text-ash-text mb-4">Ubah warna utama yang merepresentasikan desa Anda pada halaman publik.</p>

                        @php
                            $colors = [
                                ['hex' => '#0c8c5e', 'name' => 'Hijau Mint'],
                                ['hex' => '#1e40af', 'name' => 'Biru Tua'],
                                ['hex' => '#991b1b', 'name' => 'Merah Marun'],
                                ['hex' => '#5b21b6', 'name' => 'Ungu Gelap'],
                                ['hex' => '#047857', 'name' => 'Zamrud'],
                                ['hex' => '#0f172a', 'name' => 'Hitam Elegan']
                            ];
                            $selectedColor = old('theme_color', $village->theme_color ?? '#0c8c5e');
                        @endphp

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-2">
                            @foreach($colors as $color)
                                <label for="color-{{ Str::slug($color['name']) }}"
                                    class="relative flex items-center gap-3 p-3 cursor-pointer rounded-xl border-2 transition-all duration-200
                                    {{ $selectedColor == $color['hex'] ? 'border-portal-primary bg-cobalt/10' : 'border-slate-border/15 bg-graphite-card hover:border-slate-border' }}"
                                    onclick="selectColor(this)">
                                    
                                    <input type="radio" id="color-{{ Str::slug($color['name']) }}" name="theme_color"
                                        value="{{ $color['hex'] }}" class="sr-only"
                                        {{ $selectedColor == $color['hex'] ? 'checked' : '' }}>
                                    
                                    <div class="w-6 h-6 rounded-full shadow-sm flex-shrink-0" style="background-color: {{ $color['hex'] }}"></div>
                                    <span class="text-sm font-medium text-ivory-text">{{ $color['name'] }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('theme_color')" class="mt-2" />
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

    <script>
        function selectColor(label) {
            // Remove selection from all
            document.querySelectorAll('input[name="theme_color"]').forEach(radio => {
                const parent = radio.closest('label');
                parent.classList.remove('border-portal-primary', 'bg-cobalt/10');
                parent.classList.add('border-slate-border/15', 'bg-graphite-card');
            });

            // Add selection to clicked
            label.classList.add('border-portal-primary', 'bg-cobalt/10');
            label.classList.remove('border-slate-border/15', 'bg-graphite-card');
        }
    </script>
</x-app-layout>
