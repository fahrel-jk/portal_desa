<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PPID - Dokumen Publik Desa {{ $village->name }}</title>
    <meta name="description" content="Pusat unduhan dokumen publik, regulasi, dan transparansi Desa {{ $village->name }}">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php
        $themeColor = $village->theme_color ?? 'default';
        $themeMap = [
            'default' => ['--background'=>'#FAF7F0','--foreground'=>'#1A1A1A','--deep'=>'#313F33','--primary'=>'#313F33','--primary-hover'=>'#263328','--primary-foreground'=>'#FFFFFF','--accent'=>'#BA704F','--accent-hover'=>'#A05B3D','--accent-foreground'=>'#FFFFFF','--surface'=>'#FFFFFF','--muted'=>'#E8E5DA','--muted-foreground'=>'#6B7280','--border'=>'#E5E2D5','--card'=>'#FFFFFF','--secondary'=>'#F3F0E6'],
        ];
        $vars = $themeMap[$themeColor] ?? $themeMap['default'];
    @endphp
    
    <style>
        :root {
            @foreach($vars as $k => $v) {{ $k }}: {{ $v }}; @endforeach
        }
        body { font-family: 'IBM Plex Sans', sans-serif; background-color: var(--background); color: var(--foreground); }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-surface { background-color: var(--surface); }
        .bg-primary { background-color: var(--primary); }
        .bg-deep { background-color: var(--deep); }
        .bg-accent { background-color: var(--accent); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-card { background-color: var(--card); }
        .text-accent { color: var(--accent); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .border-border { border-color: var(--border); }
        .hover\:bg-accent:hover { background-color: var(--accent); color: var(--accent-foreground); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-surface relative z-40 border-b border-border sticky top-0 shadow-sm" x-data="{ mobileMenuOpen: false, lainnyaOpen: false, mobileLainnya: false }">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3">
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
                <a href="{{ route('village.show', $village->slug) }}" class="transition-colors hover:text-accent">Home</a>
                <a href="{{ route('village.profile', $village->slug) }}" class="transition-colors hover:text-accent">Profil</a>
                <a href="{{ route('village.services', $village->slug) }}" class="transition-colors hover:text-accent">Layanan</a>
                <a href="{{ route('village.show', $village->slug) }}#berita" class="transition-colors hover:text-accent">Berita</a>
                <a href="{{ route('village.agenda', $village->slug) }}" class="transition-colors hover:text-accent">Agenda</a>
                <a href="{{ route('village.apbdes', $village->slug) }}" class="transition-colors hover:text-accent">APBDes</a>
                {{-- Lainnya Dropdown --}}
                <div class="relative" @click.outside="lainnyaOpen = false">
                    <button @click="lainnyaOpen = !lainnyaOpen" class="inline-flex items-center gap-1 transition-colors text-accent font-semibold border-b-2 border-accent pb-0.5">
                        Lainnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="lainnyaOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="lainnyaOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="absolute right-0 mt-2 w-44 bg-surface border border-border rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('village.ppid', $village->slug) }}" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-accent bg-accent/5 transition-colors">PPID</a>
                        @if($village->galleries->count() > 0)
                        <a href="{{ route('village.show', $village->slug) }}#galeri" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Galeri</a>
                        @endif
                        @if($village->products->where('is_active', true)->count() > 0)
                        <a href="{{ route('village.show', $village->slug) }}#produk" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Produk UMKM</a>
                        @endif
                        @if($village->latitude && $village->longitude)
                        <a href="{{ route('village.show', $village->slug) }}#lokasi" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Lokasi</a>
                        @endif
                        <a href="{{ route('village.show', $village->slug) }}#kontak" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Kontak</a>
                    </div>
                </div>
            </nav>

            <div class="flex items-center gap-2">
                {{-- Desktop action buttons --}}
                <div class="hidden items-center gap-2 lg:flex">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs">Login</a>
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
                    <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Home
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.profile', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Profil
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.services', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8l6 6v12a2 2 0 0 1-2 2z"></path><path d="M14 2v6h6"></path></svg>
                        Layanan
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#berita" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2m0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8z"></path></svg>
                        Berita
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.agenda', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                        Agenda
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.apbdes', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        APBDes
                    </a>
                    {{-- Lainnya collapsible --}}
                    <div>
                        <button @click="mobileLainnya = !mobileLainnya" class="flex items-center justify-between w-full gap-3 px-3 py-2.5 text-sm font-semibold text-accent bg-accent/5 rounded-md transition-colors">
                            <span class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                Lainnya
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="mobileLainnya" x-collapse x-cloak class="ml-6 pl-3 border-l border-border mt-1">
                            <a @click="mobileMenuOpen = false" href="{{ route('village.ppid', $village->slug) }}" class="flex items-center gap-3 px-3 py-2 text-sm font-semibold text-accent bg-accent/5 rounded-md transition-colors">
                                PPID
                            </a>
                            @if($village->galleries->count() > 0)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#galeri" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Galeri
                            </a>
                            @endif
                            @if($village->products->where('is_active', true)->count() > 0)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#produk" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Produk UMKM
                            </a>
                            @endif
                            @if($village->latitude && $village->longitude)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#lokasi" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Lokasi
                            </a>
                            @endif
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#kontak" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Kontak
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Mobile action buttons --}}
                <div class="mt-3 pt-3 border-t border-border flex flex-col gap-2">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs border border-border">Login Admin</a>
                    <a @click="mobileMenuOpen = false" href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-10 px-3 text-sm">Hubungi Kami</a>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6">
            
            <div class="text-center mb-12">
                <h1 class="font-serif text-4xl font-bold tracking-tight sm:text-5xl mb-4 text-primary">PPID</h1>
                <p class="text-lg text-muted-foreground max-w-2xl mx-auto">
                    Pejabat Pengelola Informasi dan Dokumentasi (PPID) adalah pusat layanan informasi publik. Di sini Anda dapat melihat dan mengunduh peraturan desa, laporan keuangan, formulir, dan dokumen lainnya.
                </p>
            </div>

            {{-- Filter Kategori --}}
            <div class="mb-8 flex flex-wrap gap-2 justify-center">
                <a href="{{ route('village.ppid', $village->slug) }}" class="px-4 py-2 rounded-full text-sm font-medium border border-border transition-colors {{ !request('category') ? 'bg-primary text-white' : 'bg-surface hover:bg-secondary text-foreground' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('village.ppid', ['slug' => $village->slug, 'category' => $cat]) }}" class="px-4 py-2 rounded-full text-sm font-medium border border-border transition-colors {{ request('category') == $cat ? 'bg-primary text-white' : 'bg-surface hover:bg-secondary text-foreground' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            {{-- Daftar Dokumen --}}
            <div class="bg-card border border-border rounded-xl shadow-sm overflow-hidden">
                @if($documents->count() > 0)
                    <div class="divide-y divide-border">
                        @foreach($documents as $doc)
                            <div class="p-5 sm:p-6 flex flex-col sm:flex-row gap-5 items-start sm:items-center hover:bg-secondary/30 transition-colors">
                                <div class="shrink-0 bg-secondary w-14 h-14 rounded-lg flex items-center justify-center text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                                </div>
                                
                                <div class="flex-grow min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-accent/10 text-accent uppercase tracking-wider">
                                            {{ $doc->category }}
                                        </span>
                                        <span class="text-xs text-muted-foreground flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                            {{ $doc->created_at->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-lg leading-tight mb-1">{{ $doc->title }}</h3>
                                    @if($doc->description)
                                        <p class="text-sm text-muted-foreground line-clamp-2">{{ $doc->description }}</p>
                                    @endif
                                </div>

                                <div class="shrink-0 flex flex-col sm:items-end gap-2 w-full sm:w-auto mt-2 sm:mt-0">
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-semibold border border-border rounded-lg bg-surface hover:bg-secondary transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                        Lihat Berkas
                                    </a>
                                    <a href="{{ route('village.ppid.download', ['slug' => $village->slug, 'id' => $doc->id]) }}" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 text-sm font-semibold border border-transparent rounded-lg bg-primary text-white hover:bg-primary-hover transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                        Unduh <span class="font-normal opacity-80">({{ $doc->download_count }}x)</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center text-muted-foreground">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-secondary mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary opacity-50"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="12" x2="12" y1="18" y2="12"/><line x1="9" x2="15" y1="15" y2="15"/></svg>
                        </div>
                        <h3 class="font-bold text-lg mb-1">Tidak ada dokumen</h3>
                        <p class="text-sm">Belum ada dokumen publik yang tersedia di kategori ini.</p>
                    </div>
                @endif
            </div>

            <div class="mt-8">
                {{ $documents->links() }}
            </div>

            {{-- Banner Permohonan Informasi --}}
            <div class="mt-16 bg-deep rounded-2xl overflow-hidden relative shadow-lg">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(var(--accent) 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="relative z-10 px-6 py-10 sm:px-10 sm:py-14 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-left max-w-xl">
                        <h2 class="font-serif text-2xl sm:text-3xl font-bold text-white mb-3">Butuh Informasi Spesifik?</h2>
                        <p class="text-white/80 text-sm sm:text-base">Ajukan permohonan informasi publik secara online jika dokumen yang Anda butuhkan belum tersedia di halaman ini.</p>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('layanan.ppid.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-accent text-accent-foreground font-semibold hover:bg-accent-hover transition-colors shadow-xl shadow-accent/20 hover:scale-105 transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-4Z"/><path d="M12 11h.01"/></svg>
                            Ajukan Permohonan
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="bg-primary text-white border-t border-border mt-auto py-8 text-center text-sm opacity-90">
        &copy; {{ date('Y') }} PPID Desa {{ $village->name }}. Dibuat dengan Portal Desa.
    </footer>

</body>
</html>
