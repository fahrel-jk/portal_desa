<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Desa — {{ $village->name }}</title>
    <meta name="description" content="Profil resmi Desa {{ $village->name }}: Visi, Misi, Sejarah, dan Struktur Organisasi.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --background: #FAF7F0;
            --foreground: #1A1A1A;
            --deep: #313F33;
            --primary: #313F33;
            --primary-hover: #263328;
            --primary-foreground: #FFFFFF;
            --accent: #BA704F;
            --accent-hover: #A05B3D;
            --accent-foreground: #FFFFFF;
            --surface: #FFFFFF;
            --muted: #E8E5DA;
            --muted-foreground: #6B7280;
            --border: #E5E2D5;
            --card: #FFFFFF;
            --secondary: #F3F0E6;
        }
        body { 
            font-family: 'IBM Plex Sans', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
        }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        
        .bg-background { background-color: var(--background); }
        .text-foreground { color: var(--foreground); }
        .bg-deep { background-color: var(--deep); }
        .bg-surface { background-color: var(--surface); }
        .bg-muted { background-color: var(--muted); }
        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-accent-foreground { color: var(--accent-foreground); }
        .text-muted-foreground { color: var(--muted-foreground); }
        
        .border-border { border-color: var(--border); }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

<div class="min-h-screen bg-background text-foreground flex flex-col">
    @include('village.templates.klasik.header')

    <main class="flex-grow">

        {{-- SECTION 1: Hero Profil (Background HIJAU/PRIMARY) --}}
        <section class="bg-deep py-16 md:py-24 text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-foreground opacity-80 mb-4">
                    <span class="h-px w-7 bg-primary-foreground opacity-40"></span>Profil Desa<span class="h-px w-7 bg-primary-foreground opacity-40"></span>
                </p>
                <h1 class="font-serif text-4xl md:text-5xl font-bold text-primary-foreground mb-4">Desa {{ $village->name }}</h1>
                <p class="text-primary-foreground opacity-80 text-lg md:text-xl max-w-2xl mx-auto">Mengenal lebih dekat Visi, Misi, Sejarah, dan Struktur Organisasi Pemerintahan Desa.</p>
            </div>
        </section>

        {{-- SECTION 2: Visi & Misi (Background BEIGE/BACKGROUND) --}}
        @if($village->visi || $village->misi)
        <section class="bg-background py-16 md:py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                
                {{-- Visi --}}
                @if($village->visi)
                <div class="text-center mb-16">
                    <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">
                        <span class="h-px w-7 bg-accent"></span>Visi Desa<span class="h-px w-7 bg-accent"></span>
                    </p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary mb-8">Visi</h2>
                    <div class="bg-surface border border-border rounded-2xl p-8 md:p-12 shadow-sm max-w-3xl mx-auto">
                        <p class="text-xl md:text-2xl font-serif italic leading-relaxed text-foreground">
                            "{{ $village->visi }}"
                        </p>
                    </div>
                </div>
                @endif

                {{-- Misi --}}
                @if($village->misi)
                <div class="text-center">
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary mb-8">Misi</h2>
                    <div class="bg-surface border border-border rounded-2xl p-8 md:p-12 shadow-sm max-w-3xl mx-auto text-left">
                        <ol class="list-decimal list-outside ml-6 text-base md:text-lg text-foreground space-y-4 leading-relaxed">
                            @foreach(explode("\n", str_replace("\r", "", $village->misi)) as $misiItem)
                                @if(trim($misiItem) !== '')
                                    <li class="pl-2">{{ trim($misiItem) }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
                @endif

            </div>
        </section>
        @endif

        {{-- SECTION 3: Bagan Struktur (Background HIJAU/DEEP) --}}
        @if($village->bagan_struktur_path)
        <section class="bg-deep py-16 md:py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center">
                <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-primary-foreground opacity-80 mb-4">
                    <span class="h-px w-7 bg-primary-foreground opacity-40"></span>Struktur Organisasi<span class="h-px w-7 bg-primary-foreground opacity-40"></span>
                </p>
                <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary-foreground mb-10">Bagan Struktur Pemerintahan Desa</h2>
                
                <div class="bg-white rounded-2xl p-3 md:p-6 shadow-lg overflow-hidden">
                    <img 
                        src="{{ Storage::url($village->bagan_struktur_path) }}" 
                        alt="Bagan Struktur Organisasi Desa {{ $village->name }}" 
                        class="w-full h-auto rounded-lg cursor-zoom-in"
                        onclick="this.classList.toggle('max-w-none'); this.classList.toggle('scale-100');"
                    >
                </div>
                <p class="text-primary-foreground opacity-60 text-sm mt-4">Klik gambar untuk memperbesar</p>
            </div>
        </section>
        @endif

        {{-- SECTION 4: Sejarah Desa (Background SURFACE/WHITE) --}}
        @if($village->history || $village->description)
        <section class="bg-surface py-16 md:py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6">
                <div class="text-center mb-10">
                    <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">
                        <span class="h-px w-7 bg-accent"></span>Sejarah<span class="h-px w-7 bg-accent"></span>
                    </p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary">Sejarah Desa {{ $village->name }}</h2>
                </div>
                <div class="bg-background border border-border rounded-2xl p-8 md:p-12 shadow-sm">
                    <div class="prose prose-lg max-w-none text-foreground font-medium leading-relaxed">
                        {!! nl2br(e($village->history ?: $village->description)) !!}
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- SECTION 5: Peta Lokasi Desa (Background BEIGE/BACKGROUND) --}}
        @if($village->latitude && $village->longitude)
        <section class="bg-background py-16 md:py-20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="text-center mb-10">
                    <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">
                        <span class="h-px w-7 bg-accent"></span>Lokasi<span class="h-px w-7 bg-accent"></span>
                    </p>
                    <h2 class="font-serif text-3xl md:text-4xl font-bold text-primary">Peta Lokasi Desa</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-stretch">
                    {{-- Info Sidebar --}}
                    <div class="md:col-span-2 bg-surface rounded-2xl p-6 md:p-8 shadow-sm border border-border">
                        @if($village->address)
                        <div class="mb-6">
                            <h3 class="font-serif font-bold text-lg text-foreground mb-2">Alamat Kantor Desa</h3>
                            <p class="text-muted-foreground text-sm leading-relaxed">{{ $village->address }}</p>
                        </div>
                        @endif

                        <div class="mb-6">
                            <h3 class="font-serif font-bold text-lg text-foreground mb-2">Wilayah Administratif</h3>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="text-muted-foreground block text-xs uppercase tracking-wider mb-1">Kecamatan</span>
                                    <span class="text-foreground font-medium">{{ $village->kecamatan }}</span>
                                </div>
                                <div>
                                    <span class="text-muted-foreground block text-xs uppercase tracking-wider mb-1">Kabupaten</span>
                                    <span class="text-foreground font-medium">{{ $village->kabupaten }}</span>
                                </div>
                            </div>
                        </div>

                        @if($village->contact_phone || $village->contact_email)
                        <div class="pt-6 border-t border-border">
                            <h3 class="font-serif font-bold text-lg text-foreground mb-3">Kontak</h3>
                            @if($village->contact_phone)
                            <p class="flex items-center gap-2 text-sm text-muted-foreground mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                {{ $village->contact_phone }}
                            </p>
                            @endif
                            @if($village->contact_email)
                            <p class="flex items-center gap-2 text-sm text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                {{ $village->contact_email }}
                            </p>
                            @endif
                        </div>
                        @endif

                        @if($village->office_hours)
                        <div class="pt-6 mt-6 border-t border-border">
                            <h3 class="font-serif font-bold text-lg text-foreground mb-2">Jam Layanan</h3>
                            <p class="text-sm text-muted-foreground">{{ $village->office_hours }}</p>
                        </div>
                        @endif
                    </div>

                    {{-- Map --}}
                    <div class="md:col-span-3 bg-surface rounded-2xl overflow-hidden shadow-sm border border-border" style="min-height: 400px;">
                        <div id="profil-map" class="w-full h-full" style="min-height: 400px;"></div>
                    </div>
                </div>
            </div>
        </section>
        @endif

    </main>

    {{-- Footer (SAME as landing page) --}}
    <footer id="kontak" class="bg-deep text-primary-foreground">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3">
            <div>
                <p class="font-serif text-lg font-bold">Desa {{ $village->name }}</p>
                <p class="mt-3 max-w-sm text-sm leading-6 text-primary-foreground opacity-75">Portal resmi pelayanan dan informasi Pemerintah Desa {{ $village->name }}.</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Kantor Desa</p>
                @if($village->address)
                <p class="mt-3 flex gap-2 text-sm text-primary-foreground opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> 
                    {{ $village->address }}
                </p>
                @endif
                @if($village->office_hours)
                <p class="mt-2 flex gap-2 text-sm text-primary-foreground opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    {{ $village->office_hours }}
                </p>
                @endif
            </div>
            <div>
                <p class="text-sm font-semibold">Hubungi Kami</p>
                @if($village->contact_phone)
                <p class="mt-3 flex items-center gap-2 text-sm text-primary-foreground opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> 
                    {{ $village->contact_phone }}
                </p>
                @endif
                @if($village->contact_email)
                <p class="mt-2 flex items-center gap-2 text-sm text-primary-foreground opacity-75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg> 
                    {{ $village->contact_email }}
                </p>
                @endif
            </div>
        </div>
        <div class="border-t border-primary-foreground opacity-80">
            <div class="mx-auto max-w-7xl px-4 py-4 text-xs text-primary-foreground opacity-60 sm:px-6">© {{ date('Y') }} Pemerintah Desa {{ $village->name }}. All rights reserved.</div>
        </div>
    </footer>
</div>

{{-- Back to Top Button --}}
<div 
    x-data="{ showBackToTop: false }" 
    x-init="window.addEventListener('scroll', () => { showBackToTop = window.scrollY > 400 })"
>
    <button
        x-show="showBackToTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 inline-flex items-center justify-center size-11 rounded border border-border bg-surface text-primary shadow-lg hover:bg-muted transition-colors"
        aria-label="Kembali ke atas"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>
</div>

{{-- Leaflet Map Script --}}
@if($village->latitude && $village->longitude)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $village->latitude }};
        const lng = {{ $village->longitude }};

        const map = L.map('profil-map').setView([lat, lng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup('<strong>Kantor Desa {{ $village->name }}</strong><br>Kecamatan {{ $village->kecamatan }}').openPopup();

        // Fix map rendering in tabs/hidden containers
        setTimeout(() => map.invalidateSize(), 400);
    });
</script>
@endif

</body>
</html>
