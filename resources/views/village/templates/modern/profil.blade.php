@extends('village.templates.modern.layout', ['title' => 'Profil Desa'])

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 3rem;">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Profil & Sejarah</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Profil Desa {{ $village->name }}</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Mengenal lebih dekat sejarah, visi misi, dan struktur pemerintahan desa.</p>
</div>

{{-- ═══════════════════════════════════════
     VISI & MISI
     ═══════════════════════════════════════ --}}
@if($village->visi || $village->misi)
<div style="margin-bottom: 3rem;">
    @if($village->visi)
    <div class="card" style="padding: 2.5rem; margin-bottom: 1.5rem; text-align: center; background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 6%, transparent), color-mix(in srgb, var(--accent) 4%, transparent));">
        <div class="eyebrow" style="margin-bottom: 1rem;">Visi Desa</div>
        <h2 style="font-family: Outfit, sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg);">Visi</h2>
        <blockquote style="font-size: 1.25rem; line-height: 1.7; font-style: italic; color: var(--fg); max-width: 700px; margin: 0 auto; padding: 0 1rem; position: relative;">
            <span style="position: absolute; top: -0.5rem; left: 0; font-size: 3rem; color: var(--primary); opacity: 0.3; font-family: serif; line-height: 1;">"</span>
            {{ $village->visi }}
            <span style="font-size: 3rem; color: var(--primary); opacity: 0.3; font-family: serif; line-height: 1;">"</span>
        </blockquote>
    </div>
    @endif

    @if($village->misi)
    <div class="card" style="padding: 2.5rem;">
        <h2 style="font-family: Outfit, sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); text-align: center;">Misi</h2>
        <div style="max-width: 700px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem;">
            @foreach(explode("\n", str_replace("\r", "", $village->misi)) as $idx => $misiItem)
                @if(trim($misiItem) !== '')
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <div style="width: 32px; height: 32px; min-width: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--accent)); color: var(--primary-fg); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; font-family: Outfit, sans-serif; margin-top: 2px;">{{ $idx + 1 }}</div>
                    <p style="font-size: 1.0625rem; line-height: 1.7; color: var(--muted-fg); flex: 1;">{{ trim($misiItem) }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif
</div>
@endif

{{-- ═══════════════════════════════════════
     TENTANG DESA + SIDEBAR
     ═══════════════════════════════════════ --}}
<div style="display: grid; grid-template-columns: 1fr; gap: 3rem; margin-bottom: 3rem;" class="lg:grid-cols-3">
    
    {{-- Main Content --}}
    <div class="lg:col-span-2">
        <div class="card" style="padding: 2.5rem; margin-bottom: 2.5rem;">
            <h2 style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.75rem;">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                Tentang Desa
            </h2>
            <div class="prose prose-blue max-w-none" style="font-size: 1.0625rem; line-height: 1.8; color: var(--muted-fg);">
                {!! nl2br(e($village->description)) !!}
            </div>
        </div>

        <div class="card" style="padding: 2.5rem;">
            <h2 style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.75rem;">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                Struktur Perangkat Desa
            </h2>
            
            @if($village->officials->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                    @foreach($village->officials as $official)
                        <div style="text-align: center;">
                            <div style="width: 100px; height: 100px; margin: 0 auto 1rem; border-radius: 50%; overflow: hidden; background-color: var(--muted); border: 2px solid var(--border);">
                                @if($official->photo_path)
                                    <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <svg style="width: 100%; height: 100%; padding: 1.5rem; color: var(--muted-fg);" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                @endif
                            </div>
                            <h4 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); margin-bottom: 0.25rem;">{{ $official->name }}</h4>
                            <p style="font-size: 0.875rem; font-weight: 600; color: var(--primary);">{{ $official->position }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 2rem; background-color: var(--muted); border-radius: 1rem;">
                    <p style="color: var(--muted-fg);">Belum ada data perangkat desa.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar --}}
    <div>
        <div class="card" style="padding: 2rem; position: sticky; top: 6rem;">
            <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); padding-bottom: 1rem; border-bottom: 1px solid var(--border);">Informasi Wilayah</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Kecamatan</div>
                    <div style="font-size: 1.125rem; font-weight: 600; color: var(--fg);">{{ $village->kecamatan }}</div>
                </div>
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Kabupaten/Kota</div>
                    <div style="font-size: 1.125rem; font-weight: 600; color: var(--fg);">{{ $village->kabupaten }}</div>
                </div>
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Alamat Kantor</div>
                    <div style="font-size: 1rem; color: var(--muted-fg);">{{ $village->address ?: '-' }}</div>
                </div>
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Jam Operasional</div>
                    <div style="font-size: 1rem; color: var(--muted-fg);">{{ $village->office_hours ?: '-' }}</div>
                </div>
            </div>

            <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-top: 2.5rem; margin-bottom: 1.5rem; color: var(--fg); padding-bottom: 1rem; border-bottom: 1px solid var(--border);">Kontak Desa</h3>
            
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Email</div>
                    <div style="font-size: 1rem; color: var(--muted-fg);">{{ $village->contact_email ?: '-' }}</div>
                </div>
                <div>
                    <div class="eyebrow" style="margin-bottom: 0.25rem;">Telepon / WA</div>
                    <div style="font-size: 1rem; color: var(--muted-fg);">{{ $village->contact_phone ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     BAGAN STRUKTUR ORGANISASI
     ═══════════════════════════════════════ --}}
@if($village->bagan_struktur_path)
<div style="margin-bottom: 3rem;">
    <div class="card" style="padding: 2.5rem; text-align: center;">
        <div class="eyebrow" style="margin-bottom: 0.75rem;">Organisasi</div>
        <h2 style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: 2rem; color: var(--fg);">Bagan Struktur Pemerintahan Desa</h2>
        <div style="background: var(--muted); border-radius: 1rem; padding: 1rem; overflow: hidden;">
            <img 
                src="{{ Storage::url($village->bagan_struktur_path) }}" 
                alt="Bagan Struktur Organisasi Desa {{ $village->name }}" 
                style="width: 100%; height: auto; border-radius: 0.5rem; cursor: zoom-in;"
                onclick="this.classList.toggle('max-w-none'); this.parentElement.style.overflow = this.parentElement.style.overflow === 'auto' ? 'hidden' : 'auto';"
            >
        </div>
        <p style="color: var(--muted-fg); font-size: 13px; margin-top: 1rem;">Klik gambar untuk memperbesar</p>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════
     SEJARAH DESA
     ═══════════════════════════════════════ --}}
@if($village->history || $village->description)
<div style="margin-bottom: 3rem;">
    <div class="card" style="padding: 2.5rem;">
        <h2 style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.75rem;">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            Sejarah Desa {{ $village->name }}
        </h2>
        <div class="prose prose-blue max-w-none" style="font-size: 1.0625rem; line-height: 1.9; color: var(--muted-fg);">
            {!! nl2br(e($village->history ?: $village->description)) !!}
        </div>
    </div>
</div>
@endif

{{-- ═══════════════════════════════════════
     PETA LOKASI DESA
     ═══════════════════════════════════════ --}}
@if($village->latitude && $village->longitude)
<div style="margin-bottom: 3rem;">
    <div class="card" style="padding: 1.25rem;">
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="lg:grid-cols-5">
            {{-- Map --}}
            <div class="lg:col-span-3" style="min-height: 380px;">
                <div id="profil-map" style="height: 100%; min-height: 380px; border-radius: 0.75rem; overflow: hidden; z-index: 10; border: 1px solid var(--border);"></div>
            </div>
            
            {{-- Info --}}
            <div class="lg:col-span-2" style="display: flex; flex-direction: column; justify-content: center; padding: 1rem 1.5rem;">
                <div class="eyebrow" style="margin-bottom: 0.75rem;">Lokasi</div>
                <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.75rem); font-weight: 700; margin-bottom: 1rem; color: var(--fg);">Temukan Kami</h2>
                
                @if($village->address)
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 1rem;">
                    <svg style="width: 18px; height: 18px; margin-top: 2px; color: var(--primary); flex-shrink: 0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span style="font-size: 14.5px; line-height: 1.6; color: var(--muted-fg);">{{ $village->address }}</span>
                </div>
                @endif

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.25rem;">Kecamatan</div>
                        <div style="font-size: 14.5px; font-weight: 600; color: var(--fg);">{{ $village->kecamatan }}</div>
                    </div>
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.25rem;">Kabupaten</div>
                        <div style="font-size: 14.5px; font-weight: 600; color: var(--fg);">{{ $village->kabupaten }}</div>
                    </div>
                </div>

                <a href="https://maps.google.com/?q={{ $village->latitude }},{{ $village->longitude }}" target="_blank" class="btn-ghost" style="text-decoration: none; display: inline-flex; width: fit-content;">
                    Buka petunjuk arah
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if($village->latitude && $village->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $village->latitude }};
        const lng = {{ $village->longitude }};

        const map = L.map('profil-map', { zoomControl: false }).setView([lat, lng], 14);
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        const colorPrimary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();

        L.circleMarker([lat, lng], {
            radius: 11, fillColor: colorPrimary, color: '#fff', weight: 3, opacity: 1, fillOpacity: 1
        }).addTo(map).bindPopup('<div style="font-family:Outfit,sans-serif;font-weight:600;font-size:13px">Kantor Desa {{ e($village->name) }}</div><div style="font-size:11px;color:#888">Kecamatan {{ e($village->kecamatan) }}</div>');

        setTimeout(() => map.invalidateSize(), 400);
    });
</script>
@endif
@endpush
