<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Titik Lokasi
            </h2>
            <a href="{{ route('desa.titik-lokasi.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Daftar</a>
        </div>
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <style>
            #map-picker { height: 360px; border-radius: 0.75rem; z-index: 1; cursor: crosshair; }
        </style>
    @endpush

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">

                <form action="{{ route('desa.titik-lokasi.store') }}" method="POST" enctype="multipart/form-data" id="form-titik-lokasi">
                    @csrf

                    {{-- Nama Lokasi --}}
                    <div class="mb-6">
                        <label for="nama_lokasi" class="block text-sm font-medium text-ash-text mb-2">Nama Lokasi <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_lokasi" id="nama_lokasi" value="{{ old('nama_lokasi') }}" required
                               class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                               placeholder="Contoh: Balai Desa, Puskesmas, SD Negeri...">
                        @error('nama_lokasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-6">
                        <label for="kategori" class="block text-sm font-medium text-ash-text mb-2">Kategori <span class="text-red-400">*</span></label>
                        <select name="kategori" id="kategori" required
                                class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20">
                            <option value="">— Pilih Kategori —</option>
                            <option value="pemerintahan" {{ old('kategori') === 'pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                            <option value="kesehatan" {{ old('kategori') === 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="pendidikan" {{ old('kategori') === 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="ibadah" {{ old('kategori') === 'ibadah' ? 'selected' : '' }}>Ibadah</option>
                            <option value="lainnya" {{ old('kategori') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Peta Interaktif --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Lokasi di Peta <span class="text-red-400">*</span></label>
                        <p class="text-xs text-ash-text/70 mb-3">Klik pada peta untuk menandai lokasi. Marker akan muncul di titik yang Anda pilih.</p>
                        <div id="map-picker" class="border border-slate-border/15"></div>
                        <div id="koordinat-info" class="mt-2 text-xs text-ash-text font-mono bg-obsidian-button/30 rounded-md px-3 py-2 border border-slate-border/10">
                            Koordinat: <span id="lat-display">belum dipilih</span>, <span id="lng-display">belum dipilih</span>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                        @error('latitude') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @error('longitude') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label for="deskripsi" class="block text-sm font-medium text-ash-text mb-2">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                                  placeholder="Keterangan singkat tentang lokasi ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-ash-text mb-2">Foto (Opsional)</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt-hover bg-obsidian-button/30 border border-slate-border/15 rounded-md p-2">
                        <p class="mt-1 text-xs text-ash-text">Format: JPG, PNG, WebP. Maks 4MB.</p>
                        @error('foto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('desa.titik-lokasi.index') }}" class="px-5 py-2.5 bg-obsidian-button hover:bg-slate-border/15 text-ivory-text rounded-lg text-sm font-medium transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-cobalt hover:bg-cobalt-hover text-white rounded-lg text-sm font-medium shadow-md shadow-cobalt/20 transition">Simpan Titik Lokasi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Center on village coordinates or fallback to Surabaya
                const villageLatitude = {{ $village->latitude ?? -7.2575 }};
                const villageLongitude = {{ $village->longitude ?? 112.7521 }};
                const defaultZoom = {{ $village->latitude ? 15 : 10 }};

                const map = L.map('map-picker').setView([villageLatitude, villageLongitude], defaultZoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19
                }).addTo(map);

                let marker = null;

                // Restore old values if validation failed
                const oldLat = document.getElementById('latitude').value;
                const oldLng = document.getElementById('longitude').value;
                if (oldLat && oldLng) {
                    marker = L.marker([parseFloat(oldLat), parseFloat(oldLng)]).addTo(map);
                    map.setView([parseFloat(oldLat), parseFloat(oldLng)], 16);
                    document.getElementById('lat-display').textContent = parseFloat(oldLat).toFixed(7);
                    document.getElementById('lng-display').textContent = parseFloat(oldLng).toFixed(7);
                }

                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }

                    document.getElementById('latitude').value = lat.toFixed(7);
                    document.getElementById('longitude').value = lng.toFixed(7);
                    document.getElementById('lat-display').textContent = lat.toFixed(7);
                    document.getElementById('lng-display').textContent = lng.toFixed(7);
                });

                // Fix tile rendering in hidden/resized containers
                setTimeout(() => map.invalidateSize(), 200);
            });
        </script>
    @endpush
</x-app-layout>
