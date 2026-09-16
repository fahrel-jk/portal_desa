<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transparansi Anggaran (APBDes) — {{ $village->name }}</title>
    <meta name="description" content="Transparansi Anggaran Pendapatan dan Belanja Desa (APBDes) {{ $village->name }}, Kecamatan {{ $village->kecamatan }}, Kabupaten {{ $village->kabupaten }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @php
            $themeColor = $village->theme_color ?? 'default';
            $themeMap = [
                'default' => ['--background'=>'#FAF7F0','--foreground'=>'#1A1A1A','--deep'=>'#313F33','--primary'=>'#313F33','--primary-hover'=>'#263328','--primary-foreground'=>'#FFFFFF','--accent'=>'#BA704F','--accent-hover'=>'#A05B3D','--accent-foreground'=>'#FFFFFF','--surface'=>'#FFFFFF','--muted'=>'#E8E5DA','--muted-foreground'=>'#6B7280','--border'=>'#E5E2D5','--card'=>'#FFFFFF','--secondary'=>'#F3F0E6'],
            ];
            $vars = $themeMap[$themeColor] ?? $themeMap['default'];
            
            $theme = $village->theme_color ?? 'sumberan-sage';
            $primary = '#c4654a'; // default sumberan-sage
            if ($theme === 'laut-senja') $primary = '#0f766e';
            elseif ($theme === 'kopi-susu') $primary = '#8c5a45';
            elseif ($theme === 'monokrom-elegan') $primary = '#334155';
            elseif (str_starts_with($theme, '#')) $primary = $theme;
        @endphp

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        :root {
            --color-primary: {{ $primary }};
            @foreach($vars as $k => $v) {{ $k }}: {{ $v }}; @endforeach
        }
        .bg-primary { background-color: var(--color-primary); }
        .text-primary { color: var(--color-primary); }
        .border-primary { border-color: var(--color-primary); }
        
        /* Klasik Navbar Classes */
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-surface { background-color: var(--surface); }
        .bg-accent { background-color: var(--accent); }
        .text-accent { color: var(--accent); }
        .text-accent-foreground { color: var(--accent-foreground); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .text-foreground { color: var(--foreground); }
        .border-border { border-color: var(--border); }
        .hover\:bg-muted:hover { background-color: var(--muted); }
        .hover\:bg-accent-hover:hover { background-color: var(--accent-hover); }
        .hover\:text-accent:hover { color: var(--accent); }
        .hover\:text-foreground:hover { color: var(--foreground); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col bg-slate-50">

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
                <a href="{{ route('village.apbdes', $village->slug) }}" class="transition-colors text-accent font-semibold border-b-2 border-accent pb-0.5">APBDes</a>
                {{-- Lainnya Dropdown --}}
                <div class="relative" @click.outside="lainnyaOpen = false">
                    <button @click="lainnyaOpen = !lainnyaOpen" class="inline-flex items-center gap-1 transition-colors hover:text-accent">
                        Lainnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="lainnyaOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="lainnyaOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="absolute right-0 mt-2 w-44 bg-surface border border-border rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('village.ppid', $village->slug) }}" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">PPID</a>
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
                    <a @click="mobileMenuOpen = false" href="{{ route('village.apbdes', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-accent bg-accent/5 rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        APBDes
                    </a>
                    {{-- Lainnya collapsible --}}
                    <div>
                        <button @click="mobileLainnya = !mobileLainnya" class="flex items-center justify-between w-full gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                            <span class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                Lainnya
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="mobileLainnya" x-collapse x-cloak class="ml-6 pl-3 border-l border-border mt-1">
                            <a @click="mobileMenuOpen = false" href="{{ route('village.ppid', $village->slug) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
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

    {{-- Hero Banner --}}
    <section class="bg-primary text-white">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-white/90 text-sm font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Anggaran Pendapatan dan Belanja Desa
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">APBDes — Desa {{ $village->name }}</h1>
            <p class="text-slate-300 max-w-xl mx-auto">
                Wujud transparansi pengelolaan keuangan desa untuk masyarakat
            </p>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="flex-grow py-10">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">

            @if($years->count() > 0)
                {{-- Year Selector + Download --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-3">
                        <label for="tahun-select" class="text-sm font-semibold text-slate-700">Tahun Anggaran:</label>
                        <select id="tahun-select"
                            onchange="window.location.href='{{ route('village.apbdes', $village->slug) }}?tahun=' + this.value"
                            class="rounded-lg border-slate-300 bg-white text-slate-800 text-sm px-4 py-2 shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('village.apbdes.pdf', ['slug' => $village->slug, 'tahun' => $selectedYear]) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg shadow hover:opacity-90 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh PDF
                    </a>
                </div>

                {{-- Summary Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
                    {{-- Total Pendapatan --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-[100%] -mr-4 -mt-4"></div>
                        <div class="relative">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Pendapatan</span>
                            </div>
                            <p class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($totals['pendapatan']['anggaran'], 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                Realisasi: <span class="font-semibold text-emerald-600">Rp {{ number_format($totals['pendapatan']['realisasi'], 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Total Belanja --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-[100%] -mr-4 -mt-4"></div>
                        <div class="relative">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Belanja</span>
                            </div>
                            <p class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($totals['belanja']['anggaran'], 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-1">
                                Realisasi: <span class="font-semibold text-red-600">Rp {{ number_format($totals['belanja']['realisasi'], 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Selisih (SiLPA) --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-[100%] -mr-4 -mt-4"></div>
                        <div class="relative">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Selisih (SiLPA)</span>
                            </div>
                            <p class="text-2xl font-extrabold {{ $selisih >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $selisih >= 0 ? '' : '-' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-500 mt-1">
                                {{ $selisih >= 0 ? 'Surplus — sisa anggaran' : 'Defisit — belanja melebihi pendapatan' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Chart Section --}}
                @if(count($chartData) > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-10">
                        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Grafik Anggaran vs Realisasi Belanja per Bidang
                        </h2>
                        <div class="relative" style="max-height: 400px;">
                            <canvas id="apbdesChart"></canvas>
                        </div>
                    </div>
                @endif

                {{-- Detail Table --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900">
                            Rincian APBDes Tahun {{ $selectedYear }}
                        </h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Uraian</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Bidang</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">Anggaran (Rp)</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">Realisasi (Rp)</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-600 uppercase tracking-wider">Capaian (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php $currentKategori = ''; $no = 1; @endphp
                                @foreach($anggarans as $item)
                                    @if($currentKategori !== $item->kategori)
                                        @php $currentKategori = $item->kategori; @endphp
                                        <tr class="bg-slate-50">
                                            <td colspan="6" class="px-6 py-3">
                                                <span class="text-sm font-bold uppercase tracking-wide
                                                    {{ $item->kategori === 'pendapatan' ? 'text-emerald-700' : '' }}
                                                    {{ $item->kategori === 'belanja' ? 'text-red-700' : '' }}
                                                    {{ $item->kategori === 'pembiayaan' ? 'text-blue-700' : '' }}
                                                ">
                                                    {{ ucfirst($item->kategori) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $pct = $item->jumlah_anggaran > 0
                                            ? round(($item->jumlah_realisasi / $item->jumlah_anggaran) * 100, 1)
                                            : 0;
                                    @endphp
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-3 text-sm text-slate-500">{{ $no++ }}</td>
                                        <td class="px-6 py-3">
                                            <div class="text-sm font-medium text-slate-900">{{ $item->uraian }}</div>
                                            @if($item->keterangan)
                                                <div class="text-xs text-slate-500 mt-0.5">{{ $item->keterangan }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-600">{{ $item->bidang ?? '-' }}</td>
                                        <td class="px-6 py-3 text-sm text-slate-900 text-right font-mono tabular-nums">
                                            {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-3 text-sm text-slate-900 text-right font-mono tabular-nums">
                                            {{ number_format($item->jumlah_realisasi, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold
                                                {{ $pct >= 80 ? 'bg-emerald-100 text-emerald-800' : '' }}
                                                {{ $pct >= 50 && $pct < 80 ? 'bg-amber-100 text-amber-800' : '' }}
                                                {{ $pct < 50 ? 'bg-red-100 text-red-800' : '' }}
                                            ">
                                                {{ $pct }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Totals Row --}}
                                <tr class="bg-slate-100 font-bold border-t-2 border-slate-300">
                                    <td colspan="3" class="px-6 py-4 text-sm text-slate-900 uppercase tracking-wide">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-sm text-slate-900 text-right font-mono tabular-nums">
                                        {{ number_format($totals['pendapatan']['anggaran'] + $totals['belanja']['anggaran'] + $totals['pembiayaan']['anggaran'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-900 text-right font-mono tabular-nums">
                                        {{ number_format($totals['pendapatan']['realisasi'] + $totals['belanja']['realisasi'] + $totals['pembiayaan']['realisasi'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- No Data --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-16 text-center">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-slate-700 mb-2">Belum Ada Data Anggaran</h3>
                    <p class="text-slate-500">Data transparansi anggaran desa ini belum tersedia.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-primary text-white mt-auto border-t-4 border-primary">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" class="h-8 w-auto bg-white rounded p-0.5">
                    @endif
                    <div>
                        <div class="font-bold text-sm uppercase tracking-wide">Desa {{ $village->name }}</div>
                        <div class="text-slate-400 text-xs">Kec. {{ $village->kecamatan }}, Kab. {{ $village->kabupaten }}</div>
                    </div>
                </div>
                <div class="text-slate-400 text-xs text-center md:text-right">
                    &copy; {{ date('Y') }} — Diberdayakan oleh
                    <a href="{{ url('/') }}" class="text-white font-medium hover:underline">Portal Desa</a>
                    Provinsi Jawa Timur.
                </div>
            </div>
        </div>
    </footer>

    {{-- Chart.js Script --}}
    @if(count($chartData) > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('apbdesChart').getContext('2d');

            const chartData = @json($chartData);
            const labels = chartData.map(d => d.label);
            const anggaranData = chartData.map(d => d.anggaran);
            const realisasiData = chartData.map(d => d.realisasi);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Anggaran',
                            data: anggaranData,
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            barPercentage: 0.6,
                        },
                        {
                            label: 'Realisasi',
                            data: realisasiData,
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            borderRadius: 6,
                            barPercentage: 0.6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { family: "'Inter', sans-serif", size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    return context.dataset.label + ': Rp ' +
                                        new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                    return 'Rp ' + value;
                                },
                                font: { family: "'Inter', sans-serif", size: 11 }
                            },
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                maxRotation: 45,
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
    @endif
</body>
</html>
