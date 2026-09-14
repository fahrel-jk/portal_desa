<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
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
        .bg-primary { background-color: var(--primary); }
        .bg-primary-hover:hover { background-color: var(--primary-hover); }
        .bg-accent { background-color: var(--accent); }
        .bg-accent-hover:hover { background-color: var(--accent-hover); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-accent-foreground { color: var(--accent-foreground); }
        .text-muted-foreground { color: var(--muted-foreground); }
        
        .border-border { border-color: var(--border); }
        .hover\:border-primary:hover { border-color: var(--primary); }
        
        details > summary::-webkit-details-marker {
            display: none;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

<div class="min-h-screen bg-background text-foreground flex flex-col">
    {{-- Header --}}
    <header class="bg-surface relative z-40 border-b border-border sticky top-0 shadow-sm" x-data="{ mobileMenuOpen: false }">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-4 sm:px-6">
            <a href="#beranda" class="flex items-center gap-3">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain drop-shadow-sm rounded">
                @else
                    <span class="rounded-sm border border-primary/30 bg-primary/10 text-primary grid size-10 place-items-center font-serif text-sm font-bold uppercase">
                        {{ substr($village->name, 0, 2) }}
                    </span>
                @endif
                <span>
                    <span class="block font-serif text-[15px] font-bold leading-none">{{ $village->name }}</span>
                    <span class="mt-1 block text-[10px] uppercase tracking-[0.14em] text-muted-foreground">Kecamatan {{ $village->kecamatan }}</span>
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-7 text-sm text-muted-foreground lg:flex">
                <a href="#profil" class="transition-colors hover:text-accent">Profil</a>
                <a href="#layanan" class="transition-colors hover:text-accent">Layanan</a>
                <a href="#berita" class="transition-colors hover:text-accent">Berita</a>
                @if($village->galleries->count() > 0)
                <a href="#galeri" class="transition-colors hover:text-accent">Galeri</a>
                @endif
                @if($village->latitude && $village->longitude)
                <a href="#lokasi" class="transition-colors hover:text-accent">Lokasi</a>
                @endif
                <a href="{{ route('village.apbdes', $village->slug) }}" class="transition-colors hover:text-accent">APBDes</a>
                <a href="#kontak" class="transition-colors hover:text-accent">Kontak</a>
            </nav>


            <div class="flex items-center gap-2">
                {{-- Desktop action buttons --}}
                <div class="hidden items-center gap-2 lg:flex">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs">Login Admin</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-9 px-3 text-xs">Hubungi Kami</a>
                </div>

                {{-- Mobile hamburger button --}}
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden inline-flex items-center justify-center size-10 rounded border border-border text-foreground hover:bg-muted transition-colors"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Buka menu navigasi"
                >
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
                    <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Panel --}}
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            class="lg:hidden border-t border-border bg-surface"
        >
            <nav class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
                <div class="flex flex-col gap-1">
                    <a @click="mobileMenuOpen = false" href="#profil" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Profil
                    </a>
                    <a @click="mobileMenuOpen = false" href="#layanan" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8l6 6v12a2 2 0 0 1-2 2z"></path><path d="M14 2v6h6"></path></svg>
                        Layanan
                    </a>
                    <a @click="mobileMenuOpen = false" href="#berita" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2m0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8z"></path></svg>
                        Berita
                    </a>
                    @if($village->galleries->count() > 0)
                    <a @click="mobileMenuOpen = false" href="#galeri" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                        Galeri
                    </a>
                    @endif
                    @if($village->latitude && $village->longitude)
                    <a @click="mobileMenuOpen = false" href="#lokasi" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Lokasi
                    </a>
                    @endif
                    <a href="{{ route('village.apbdes', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        APBDes
                    </a>
                    <a @click="mobileMenuOpen = false" href="#kontak" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg>
                        Kontak
                    </a>
                </div>

                {{-- Mobile action buttons --}}
                <div class="mt-3 pt-3 border-t border-border flex flex-col gap-2">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs border border-border">Login Admin</a>
                    <a @click="mobileMenuOpen = false" href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-10 px-3 text-sm">Hubungi Kami</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        {{-- Hero --}}
        <section id="beranda" class="bg-background">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-12 sm:px-6 md:py-16 lg:grid-cols-12 lg:items-center lg:gap-14">
                <div class="lg:col-span-7">
                    <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent">
                        <span class="h-px w-7 bg-accent"></span>Portal Resmi Pemerintahan Desa
                    </p>
                    <h1 class="mt-4 max-w-[18ch] font-serif text-4xl font-bold leading-[1.16] sm:text-5xl">Pelayanan desa yang dekat, jelas, dan terpercaya.</h1>
                    <p class="mt-5 max-w-xl text-base leading-7 text-muted-foreground">
                        @if($village->description)
                            {{ $village->description }}
                        @else
                            Urus surat, periksa data keluarga, dan ikuti agenda balai desa dalam satu tempat yang rapi dan mudah dijangkau.
                        @endif
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors bg-primary text-primary-foreground hover:bg-primary-hover h-12 px-5">
                            Hubungi Kami
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                        </a>
                        <a href="#layanan" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-12 px-5">Lihat Layanan</a>
                    </div>
                    <div class="mt-10 flex max-w-lg flex-wrap gap-x-8 gap-y-3 border-t border-border pt-5 text-xs text-muted-foreground">
                        @if($village->address)
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> 
                            {{ $village->address }}
                        </span>
                        @endif
                        @if($village->contact_phone)
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> 
                            {{ $village->contact_phone }}
                        </span>
                        @endif
                        @if($village->office_hours)
                        <span class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            {{ $village->office_hours }}
                        </span>
                        @endif
                    </div>
                </div>
                <figure class="lg:col-span-5">
                    <div class="overflow-hidden rounded-md bg-muted">
                        @if($village->hero_image_path)
                            <img src="{{ Storage::url($village->hero_image_path) }}" alt="Pemandangan Desa {{ $village->name }}" class="aspect-[5/4] w-full object-cover"/>
                        @else
                            <img src="https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=1280" alt="Pemandangan desa" class="aspect-[5/4] w-full object-cover"/>
                        @endif
                    </div>
                    <figcaption class="mt-2 text-xs text-muted-foreground">Pemandangan Desa {{ $village->name }}</figcaption>
                </figure>
            </div>
        </section>

        {{-- Layanan --}}
        @if($village->services->count() > 0)
        <section id="layanan" class="border-y border-border bg-secondary py-14 md:py-20 scroll-mt-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="mb-7 flex items-end justify-between gap-4">
                    <div>
                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Layanan Utama</p>
                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Urusan warga dalam satu tempat</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 items-start">
                    @foreach($village->services as $service)
                        <article class="group flex flex-col border border-border bg-card p-5 transition-colors hover:border-primary/45 sm:p-6 h-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent mb-4"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                            <h3 class="font-serif text-lg font-bold">{{ $service->name }}</h3>
                            @if($service->description)
                                <p class="mt-2 text-sm leading-6 text-muted-foreground">{{ $service->description }}</p>
                            @endif
                            
                            @if($service->requirements)
                            <div class="mt-5 pt-4 border-t border-border mt-auto">
                                <details class="group/details">
                                    <summary class="cursor-pointer font-semibold inline-flex items-center justify-between w-full py-1 text-xs uppercase tracking-wider text-primary select-none">
                                        <span>Syarat & Ketentuan</span>
                                        <svg class="w-4 h-4 transition-transform duration-300 group-open/details:rotate-180 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                    </summary>
                                    <div class="mt-4 p-4 border border-border bg-secondary space-y-2 text-[13px] leading-relaxed text-foreground">
                                        @foreach(explode("\n", $service->requirements) as $reqLine)
                                            @if(trim($reqLine))
                                                <div class="flex items-start gap-2.5">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full mt-1.5 shrink-0 bg-accent"></span>
                                                    <span>{{ preg_replace('/^\d+\.\s*/', '', trim($reqLine)) }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Berita --}}
        @if($village->news->count() > 0)
        <section id="berita" class="bg-background py-14 md:py-20 scroll-mt-20">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 sm:px-6 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <div class="mb-5 flex items-end justify-between">
                        <div>
                            <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Kabar Desa</p>
                            <h2 class="mt-3 font-serif text-2xl font-bold">Yang sedang berlangsung</h2>
                        </div>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach($village->news->take(4) as $news)
                            <article class="group border border-border bg-card overflow-hidden">
                                @if($news->cover_image_path)
                                    <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="aspect-[16/10] w-full object-cover"/>
                                @else
                                    <div class="aspect-[16/10] w-full bg-muted flex items-center justify-center">
                                        <span class="text-muted-foreground font-serif text-sm">Tidak ada gambar</span>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <p class="text-[10px] font-medium uppercase tracking-[0.14em] text-muted-foreground">{{ $news->published_at ? $news->published_at->format('d F Y') : $news->created_at->format('d F Y') }}</p>
                                    <h3 class="mt-2 font-serif text-lg font-bold leading-7 text-primary">{{ $news->title }}</h3>
                                    <p class="mt-2 text-sm text-muted-foreground line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
                
                {{-- Aparatur & Statistik (Dummy data for template purposes) --}}
                <div class="lg:col-span-4">
                    <div class="border border-border bg-card p-5 mb-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">Profil Desa</p>
                        <h3 class="font-serif text-lg font-bold text-primary mb-3">Tentang Kami</h3>
                        <p class="text-sm text-muted-foreground leading-relaxed">{{ Str::limit($village->description ?? 'Portal desa ini dibangun untuk memudahkan pelayanan masyarakat dalam mendapatkan informasi dan mengurus administrasi di tingkat desa secara mandiri, transparan, dan efisien.', 250) }}</p>
                    </div>
                    
                    @if($village->officials->count() > 0)
                    <div class="border border-border bg-card p-5">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">Aparatur Desa</p>
                        <div class="space-y-4">
                            @foreach($village->officials as $official)
                            <div class="flex items-center gap-3">
                                @if($official->photo_path)
                                    <img src="{{ Storage::url($official->photo_path) }}" class="w-12 h-12 rounded bg-muted object-cover">
                                @else
                                    <div class="w-12 h-12 rounded bg-secondary flex items-center justify-center text-primary font-bold font-serif">
                                        {{ substr($official->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-sm text-primary">{{ $official->name }}</h4>
                                    <p class="text-xs text-muted-foreground">{{ $official->position }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif
        {{-- Galeri --}}
        @if($village->galleries->count() > 0)
        <section id="galeri" class="border-y border-border bg-secondary py-14 md:py-20 scroll-mt-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="mb-7 flex items-end justify-between">
                    <div>
                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Dokumentasi</p>
                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Galeri Desa</h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($village->galleries as $gallery)
                    <div class="overflow-hidden rounded-md border border-border bg-card group relative aspect-square">
                        <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Galeri' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        @if($gallery->caption)
                            <div class="absolute bottom-0 left-0 w-full bg-deep/80 p-3 text-xs text-primary-foreground backdrop-blur-sm translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                {{ $gallery->caption }}
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        {{-- Lokasi / Peta Desa --}}
        @if($village->latitude && $village->longitude)
        <section id="lokasi" class="bg-background py-14 md:py-20 scroll-mt-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                <div class="mb-7 flex items-end justify-between">
                    <div>
                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Peta & Lokasi Penting</p>
                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Jelajahi {{ $village->name }}</h2>
                    </div>
                    <a href="https://maps.google.com/?q={{ $village->latitude }},{{ $village->longitude }}" target="_blank" class="hidden sm:inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-10 px-4">
                        Buka di Google Maps
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    </a>
                </div>
                
                <div class="rounded-lg border border-border bg-card overflow-hidden shadow-sm relative z-0">
                    <div id="village-map" class="w-full h-[400px] md:h-[500px]"></div>
                </div>
                <div class="mt-4 flex flex-wrap gap-4 text-xs font-medium">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-primary inline-block shadow-sm"></span> Balai Desa / Pemerintahan</div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-accent inline-block shadow-sm"></span> Pendidikan</div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-secondary border border-border inline-block shadow-sm"></span> Kesehatan</div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-muted-foreground inline-block shadow-sm"></span> Lainnya</div>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var map = L.map('village-map', {
                    zoomControl: false,
                    attributionControl: true
                }).setView([{{ $village->latitude }}, {{ $village->longitude }}], 15);
                
                L.control.zoom({ position: 'bottomright' }).addTo(map);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap',
                    maxZoom: 19
                }).addTo(map);
                
                // Colors from theme
                var colorPrimary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#313F33';
                var colorAccent = getComputedStyle(document.documentElement).getPropertyValue('--accent').trim() || '#BA704F';
                var colorSecondary = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim() || '#F3F0E6';
                var colorDefault = getComputedStyle(document.documentElement).getPropertyValue('--muted-foreground').trim() || '#6B7280';

                // Balai Desa (Main point)
                L.circleMarker([{{ $village->latitude }}, {{ $village->longitude }}], {
                    radius: 9, fillColor: colorPrimary, color: '#fff', weight: 2, opacity: 1, fillOpacity: 1
                }).addTo(map).bindPopup('<div class="font-serif font-bold text-sm">Balai Desa {{ $village->name }}</div>');

                // Titik Lokasi Points
                var titikLokasis = @json($village->titikLokasis ?? []);
                if (titikLokasis && titikLokasis.length > 0) {
                    titikLokasis.forEach(function (titik) {
                        var mc = colorDefault;
                        if (titik.kategori === 'kesehatan') mc = colorSecondary;
                        if (titik.kategori === 'pendidikan') mc = colorAccent;
                        if (titik.kategori === 'pemerintahan') mc = colorPrimary;

                        var popupContent = '<div class="font-sans text-xs">';
                        if (titik.foto) {
                            var imgUrl = '{{ Storage::url("") }}' + titik.foto;
                            popupContent += '<img src="' + imgUrl + '" class="w-full h-24 object-cover rounded mb-2 shadow-sm" alt="' + titik.nama_lokasi + '">';
                        }
                        popupContent += '<strong>' + titik.nama_lokasi + '</strong><br><span class="text-muted-foreground uppercase tracking-wider" style="font-size: 10px;">' + titik.kategori + '</span></div>';

                        L.circleMarker([titik.latitude, titik.longitude], {
                            radius: 7, fillColor: mc, color: '#fff', weight: 2, opacity: 1, fillOpacity: 0.9
                        }).addTo(map).bindPopup(popupContent, { minWidth: 150 });
                    });
                }
                
                // GeoJSON Batas Wilayah
                @if($village->geojson_batas_wilayah)
                    try {
                        L.geoJSON(@json($village->geojson_batas_wilayah), {
                            style: { color: colorPrimary, weight: 2, opacity: 0.5, fillOpacity: 0.05 }
                        }).addTo(map);
                    } catch (e) { console.warn('GeoJSON error:', e); }
                @endif
                
                // Fix map size issues in some browsers
                setTimeout(() => map.invalidateSize(), 400);
            });
        </script>
        @endif
    </main>

    {{-- Footer --}}
    <footer id="kontak" class="bg-deep text-primary-foreground">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3">
            <div>
                <p class="font-serif text-lg font-bold">Desa {{ $village->name }}</p>
                <p class="mt-3 max-w-sm text-sm leading-6 text-primary-foreground/75">Portal resmi pelayanan dan informasi Pemerintah Desa {{ $village->name }}.</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Kantor Desa</p>
                @if($village->address)
                <p class="mt-3 flex gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> 
                    {{ $village->address }}
                </p>
                @endif
                @if($village->office_hours)
                <p class="mt-2 flex gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    {{ $village->office_hours }}
                </p>
                @endif
            </div>
            <div>
                <p class="text-sm font-semibold">Hubungi Kami</p>
                @if($village->contact_phone)
                <p class="mt-3 flex items-center gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> 
                    {{ $village->contact_phone }}
                </p>
                @endif
                @if($village->contact_email)
                <p class="mt-2 flex items-center gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg> 
                    {{ $village->contact_email }}
                </p>
                @endif
            </div>
        </div>
        <div class="border-t border-primary-foreground/20">
            <div class="mx-auto max-w-7xl px-4 py-4 text-xs text-primary-foreground/60 sm:px-6">© {{ date('Y') }} Pemerintah Desa {{ $village->name }}. All rights reserved.</div>
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

</body>
</html>
