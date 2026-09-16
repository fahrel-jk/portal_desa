<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Profil Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                
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

                    <!-- Deskripsi Singkat -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Deskripsi Singkat Desa (Untuk Landing Page)" />
                        <textarea id="description" name="description" rows="3"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Ceritakan gambaran umum desa Anda dalam satu paragraf pendek...">{{ old('description', $village->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Sejarah Desa -->
                    <div class="mb-6 pb-6 border-b border-slate-border/15">
                        <x-input-label for="history" value="Sejarah Lengkap Desa (Untuk Halaman Profil)" />
                        <textarea id="history" name="history" rows="6"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Ceritakan sejarah asal mula, pendiri, atau peristiwa penting desa Anda...">{{ old('history', $village->history) }}</textarea>
                        <x-input-error :messages="$errors->get('history')" class="mt-2" />
                    </div>

                    <!-- Visi -->
                    <div class="mb-6 border-t border-slate-border/15 pt-6">
                        <x-input-label for="visi" value="Visi Desa" />
                        <textarea id="visi" name="visi" rows="3"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Contoh: Terwujudnya Desa yang Aman, Sehat, Cerdas, dan Berbudaya">{{ old('visi', $village->visi) }}</textarea>
                        <x-input-error :messages="$errors->get('visi')" class="mt-2" />
                    </div>

                    <!-- Misi -->
                    <div class="mb-6">
                        <x-input-label for="misi" value="Misi Desa" />
                        <p class="text-xs text-slate-500 mb-2">Tuliskan setiap poin misi di baris baru. Sistem otomatis akan membuatkan nomor berurutan.</p>
                        <textarea id="misi" name="misi" rows="6"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Meningkatkan kualitas pelayanan publik.&#10;Membangun infrastruktur desa yang memadai.&#10;Memberdayakan ekonomi kerakyatan.">{{ old('misi', $village->misi) }}</textarea>
                        <x-input-error :messages="$errors->get('misi')" class="mt-2" />
                    </div>

                    <!-- Gambar Bagan Struktur Desa -->
                    <div class="mb-6 pb-6 border-b border-slate-border/15">
                        <x-input-label for="bagan_struktur" value="Gambar Bagan Struktur Organisasi Desa" />
                        <div class="mt-2">
                            @if($village->bagan_struktur_path)
                                <div class="relative group h-auto w-full mb-3 rounded-lg overflow-hidden border border-slate-border max-w-md">
                                    <img src="{{ Storage::url($village->bagan_struktur_path) }}" alt="Bagan Struktur" class="w-full object-contain bg-slate-100">
                                    <label class="absolute inset-0 bg-red-500/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" title="Hapus Gambar Bagan">
                                        <input type="checkbox" name="remove_bagan" value="1" class="sr-only">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </label>
                                </div>
                            @endif
                            <input type="file" id="bagan_struktur" name="bagan_struktur" class="block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt/90 cursor-pointer">
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP (Maks 4MB). Disarankan format landscape (mendatar).</p>
                        <x-input-error :messages="$errors->get('bagan_struktur')" class="mt-2" />
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

                    {{-- Koordinat Kantor Desa (Peta Interaktif) --}}
                    <div class="mb-8 pt-6 border-t border-slate-border/15">
                        <h3 class="text-lg font-semibold text-ivory-text mb-1">Koordinat Kantor Desa</h3>
                        <p class="text-sm text-ash-text mb-4">Tentukan lokasi kantor desa di peta. Klik pada peta untuk memindahkan marker. Titik ini akan menjadi pusat peta di halaman publik desa.</p>

                        <div id="map-profil" class="w-full rounded-xl border border-slate-border/15 overflow-hidden mb-3" style="height: 340px; z-index: 1; cursor: crosshair;"></div>

                        <div class="flex items-center gap-4">
                            <div class="flex-1 text-xs text-ash-text font-mono bg-obsidian-button/30 rounded-md px-3 py-2 border border-slate-border/10">
                                Koordinat: <span id="lat-display">{{ $village->latitude ? number_format($village->latitude, 7) : 'belum ditentukan' }}</span>, <span id="lng-display">{{ $village->longitude ? number_format($village->longitude, 7) : 'belum ditentukan' }}</span>
                            </div>
                            @if($village->latitude && $village->longitude)
                                <button type="button" onclick="clearKoordinat()" class="text-xs text-red-400 hover:text-red-300 font-medium transition">Hapus Koordinat</button>
                            @endif
                        </div>

                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $village->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $village->longitude) }}">
                        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                    </div>

                    {{-- Theme Color Selection --}}
                    <div class="mb-8 pt-6 border-t border-slate-border/15">
                        <h3 class="text-lg font-semibold text-ivory-text mb-1">Pilih Tema Warna (Tampilan Publik)</h3>
                        <p class="text-sm text-ash-text mb-4">Pilih nuansa warna yang paling cocok dengan karakter desa Anda.</p>

                        @php
                            $themes = [
                                // Tema Klasik
                                [
                                    'id' => 'sawah-terakota',
                                    'name' => 'Sawah & Terakota (Klasik)',
                                    'desc' => 'Hijau natural & merah bata',
                                    'color_primary' => 'oklch(0.53 0.074 139)',
                                    'color_accent' => 'oklch(0.65 0.095 42)'
                                ],
                                [
                                    'id' => 'laut-pasir',
                                    'name' => 'Laut & Pasir (Klasik)',
                                    'desc' => 'Biru klasik & emas pesisir',
                                    'color_primary' => 'oklch(0.45 0.08 250)',
                                    'color_accent' => 'oklch(0.65 0.07 50)'
                                ],
                                [
                                    'id' => 'kopi-senja',
                                    'name' => 'Kopi & Senja (Klasik)',
                                    'desc' => 'Coklat tanah & jingga senja',
                                    'color_primary' => 'oklch(0.40 0.05 50)',
                                    'color_accent' => 'oklch(0.60 0.12 35)'
                                ],
                                [
                                    'id' => 'batu-pinus',
                                    'name' => 'Batu & Pinus (Klasik)',
                                    'desc' => 'Abu-abu batu & hijau pinus',
                                    'color_primary' => 'oklch(0.40 0.02 200)',
                                    'color_accent' => 'oklch(0.45 0.08 140)'
                                ],
                                // Tema Modern
                                [
                                    'id' => 'sumberan-sage',
                                    'name' => 'Sumberan Sage (Modern)',
                                    'desc' => 'Sage green & terracotta',
                                    'color_primary' => '#c4654a',
                                    'color_accent' => '#87a878'
                                ],
                                [
                                    'id' => 'laut-senja',
                                    'name' => 'Laut Senja (Modern)',
                                    'desc' => 'Teal laut & amber hangat',
                                    'color_primary' => '#0f766e',
                                    'color_accent' => '#3b82f6'
                                ],
                                [
                                    'id' => 'kopi-susu',
                                    'name' => 'Kopi Susu (Modern)',
                                    'desc' => 'Coklat kopi & krem latte',
                                    'color_primary' => '#8c5a45',
                                    'color_accent' => '#bfa38f'
                                ],
                                [
                                    'id' => 'monokrom-elegan',
                                    'name' => 'Monokrom (Modern)',
                                    'desc' => 'Slate abu-abu elegan',
                                    'color_primary' => '#334155',
                                    'color_accent' => '#94a3b8'
                                ]
                            ];
                            // Default back to sawah-terakota if it's an old hex color
                            $selectedColor = old('theme_color', $village->theme_color ?? 'sumberan-sage');
                            if (str_starts_with($selectedColor, '#')) {
                                $selectedColor = 'sawah-terakota';
                            }
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-2">
                            @foreach($themes as $theme)
                                <label for="theme-{{ $theme['id'] }}"
                                    class="relative flex items-center gap-4 p-4 cursor-pointer rounded-xl border-2 transition-all duration-200
                                    {{ $selectedColor == $theme['id'] ? 'border-portal-primary bg-cobalt/10' : 'border-slate-border/15 bg-graphite-card hover:border-slate-border' }}"
                                    onclick="selectColor(this)">
                                    
                                    <input type="radio" id="theme-{{ $theme['id'] }}" name="theme_color"
                                        value="{{ $theme['id'] }}" class="sr-only"
                                        {{ $selectedColor == $theme['id'] ? 'checked' : '' }}>
                                    
                                    <div class="flex flex-shrink-0 -space-x-2">
                                        <div class="w-8 h-8 rounded-full shadow-sm border-2 border-white relative z-10" style="background-color: {{ $theme['color_primary'] }}"></div>
                                        <div class="w-8 h-8 rounded-full shadow-sm border-2 border-white relative z-0" style="background-color: {{ $theme['color_accent'] }}"></div>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-ivory-text">{{ $theme['name'] }}</div>
                                        <div class="text-xs text-ash-text mt-0.5">{{ $theme['desc'] }}</div>
                                    </div>
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

        function clearKoordinat() {
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
            document.getElementById('lat-display').textContent = 'belum ditentukan';
            document.getElementById('lng-display').textContent = 'belum ditentukan';
            if (window._profilMarker) {
                window._profilMap.removeLayer(window._profilMarker);
                window._profilMarker = null;
            }
        }
    </script>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const existingLat = {{ $village->latitude ?? 'null' }};
                const existingLng = {{ $village->longitude ?? 'null' }};

                // Default center: existing village coords or Surabaya
                const centerLat = existingLat || -7.2575;
                const centerLng = existingLng || 112.7521;
                const defaultZoom = existingLat ? 16 : 10;

                const map = L.map('map-profil').setView([centerLat, centerLng], defaultZoom);
                window._profilMap = map;

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19
                }).addTo(map);

                let marker = null;
                window._profilMarker = null;

                // Show existing marker
                if (existingLat && existingLng) {
                    marker = L.marker([existingLat, existingLng]).addTo(map);
                    window._profilMarker = marker;
                }

                // Restore from old() if validation failed
                const oldLat = document.getElementById('latitude').value;
                const oldLng = document.getElementById('longitude').value;
                if (oldLat && oldLng && (!existingLat || oldLat != existingLat)) {
                    if (marker) map.removeLayer(marker);
                    marker = L.marker([parseFloat(oldLat), parseFloat(oldLng)]).addTo(map);
                    window._profilMarker = marker;
                    map.setView([parseFloat(oldLat), parseFloat(oldLng)], 16);
                }

                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }
                    window._profilMarker = marker;

                    document.getElementById('latitude').value = lat.toFixed(7);
                    document.getElementById('longitude').value = lng.toFixed(7);
                    document.getElementById('lat-display').textContent = lat.toFixed(7);
                    document.getElementById('lng-display').textContent = lng.toFixed(7);
                });

                setTimeout(() => map.invalidateSize(), 200);
            });
        </script>
    @endpush
</x-app-layout>
