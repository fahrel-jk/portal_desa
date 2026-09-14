<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Titik Lokasi
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

                <form action="{{ route('desa.titik-lokasi.update', $titikLokasi) }}" method="POST" enctype="multipart/form-data" id="form-titik-lokasi">
                    @csrf
                    @method('PATCH')

                    {{-- Nama Lokasi --}}
                    <div class="mb-6">
                        <label for="nama_lokasi" class="block text-sm font-medium text-ash-text mb-2">Nama Lokasi <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_lokasi" id="nama_lokasi" value="{{ old('nama_lokasi', $titikLokasi->nama_lokasi) }}" required
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
                            @foreach(['pemerintahan', 'kesehatan', 'pendidikan', 'ibadah', 'lainnya'] as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $titikLokasi->kategori) === $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                            @endforeach
                        </select>
                        @error('kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Peta Interaktif --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-ash-text mb-2">Lokasi di Peta <span class="text-red-400">*</span></label>
                        <p class="text-xs text-ash-text/70 mb-3">Klik pada peta untuk mengubah lokasi. Marker akan berpindah ke titik baru.</p>
                        <div id="map-picker" class="border border-slate-border/15"></div>
                        <div id="koordinat-info" class="mt-2 text-xs text-ash-text font-mono bg-obsidian-button/30 rounded-md px-3 py-2 border border-slate-border/10">
                            Koordinat: <span id="lat-display">{{ $titikLokasi->latitude }}</span>, <span id="lng-display">{{ $titikLokasi->longitude }}</span>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $titikLokasi->latitude) }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $titikLokasi->longitude) }}">
                        @error('latitude') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        @error('longitude') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-6">
                        <label for="deskripsi" class="block text-sm font-medium text-ash-text mb-2">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  class="w-full bg-obsidian-button/30 border-slate-border/15 text-ivory-text rounded-md shadow-sm focus:border-cobalt focus:ring focus:ring-cobalt/20"
                                  placeholder="Keterangan singkat tentang lokasi ini...">{{ old('deskripsi', $titikLokasi->deskripsi) }}</textarea>
                        @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-ash-text mb-2">Foto (Opsional)</label>
                        @if($titikLokasi->foto)
                            <div class="mb-3 flex items-center gap-3">
                                <img src="{{ Storage::url($titikLokasi->foto) }}" alt="{{ $titikLokasi->nama_lokasi }}" class="w-20 h-20 rounded-lg object-cover border border-slate-border/15">
                                <span class="text-xs text-ash-text">Foto saat ini. Upload foto baru untuk mengganti.</span>
                            </div>
                        @endif
                        <input type="file" name="foto" accept="image/*"
                               class="w-full text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt-hover bg-obsidian-button/30 border border-slate-border/15 rounded-md p-2">
                        <p class="mt-1 text-xs text-ash-text">Format: JPG, PNG, WebP. Maks 4MB.</p>
                        @error('foto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('desa.titik-lokasi.index') }}" class="px-5 py-2.5 bg-obsidian-button hover:bg-slate-border/15 text-ivory-text rounded-lg text-sm font-medium transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-cobalt hover:bg-cobalt-hover text-white rounded-lg text-sm font-medium shadow-md shadow-cobalt/20 transition">Perbarui Titik Lokasi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const existingLat = {{ $titikLokasi->latitude }};
                const existingLng = {{ $titikLokasi->longitude }};

                const map = L.map('map-picker').setView([existingLat, existingLng], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    maxZoom: 19
                }).addTo(map);

                let marker = L.marker([existingLat, existingLng]).addTo(map);

                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;
                    marker.setLatLng(e.latlng);

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
