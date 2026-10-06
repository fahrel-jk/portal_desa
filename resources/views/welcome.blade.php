<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo-meta />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-serif-velorah { font-family: 'Playfair Display', serif; }
        .glass-button {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .glass-button:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="font-sans antialiased text-white min-h-screen flex flex-col selection:bg-white/30 selection:text-white">
    {{-- Fixed Cinematic Video Background --}}
    <div class="fixed inset-0 z-[-1] overflow-hidden">
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="{{ asset('video_desa.mp4') }}" type="video/mp4">
        </video>
        {{-- Overlay ringan agar teks tetap terbaca tanpa menggelapkan video --}}
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    {{-- NAVIGATION — Transparent over hero, Center aligned links --}}
    <nav class="fixed w-full top-0 z-50 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = (window.scrollY > 40)">
        <div :class="scrolled ? 'bg-black/40 backdrop-blur-xl border-b border-white/10 shadow-lg shadow-black/20' : 'bg-transparent py-2'" class="transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex justify-between h-16 items-center">
                    {{-- Left: Logo --}}
                    <div class="flex items-center gap-2.5 shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Portal Desa" class="w-8 h-8 object-contain rounded">
                        <span class="font-serif-velorah text-xl sm:text-2xl text-white tracking-tight">Portal Desa</span>
                    </div>
                    
                    {{-- Center: Links (desktop) --}}
                    <div class="hidden md:flex items-center justify-center gap-8">
                        <a href="#cara-kerja" class="velorah-link text-sm font-medium text-white/90 hover:text-white transition-colors">Cara Kerja</a>
                        <a href="#template" class="velorah-link text-sm font-medium text-white/90 hover:text-white transition-colors">Template</a>
                        <a href="#faq" class="velorah-link text-sm font-medium text-white/90 hover:text-white transition-colors">FAQ</a>
                    </div>
                    
                    {{-- Right: Actions (desktop) --}}
                    <div class="hidden md:flex items-center justify-end gap-4 shrink-0">
                        @auth
                            <a href="{{ route('dashboard') }}" class="glass-button text-sm font-medium text-white px-5 py-2 rounded-full">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-white/90 hover:text-white transition">Masuk</a>
                            <a href="{{ route('register') }}" class="glass-button text-sm font-medium text-white px-6 py-2.5 rounded-full">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>

                    {{-- Mobile Hamburger --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition" aria-label="Toggle menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu --}}
                <div x-show="mobileOpen" x-collapse x-cloak class="md:hidden border-t border-white/10 pb-4 pt-2">
                    <div class="flex flex-col gap-1">
                        <a href="#cara-kerja" @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 transition">Cara Kerja</a>
                        <a href="#template" @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 transition">Template</a>
                        <a href="#faq" @click="mobileOpen=false" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 transition">FAQ</a>
                        <div class="h-px bg-white/10 my-2"></div>
                        @auth
                            <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-white bg-white/10 text-center">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="block px-3 py-2.5 rounded-lg text-sm font-semibold text-white bg-white/10 text-center mt-1">Daftar Sekarang</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO — Dreamy Velorah Style --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        {{-- Background flows through completely from fixed body --}}

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center mt-20">
            <h1 class="animate-fade-rise font-serif-velorah text-3xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-[5.5rem] text-white tracking-normal leading-[1.1] mb-6">
                Bawa desa Anda ke<br class="hidden sm:inline">era digital.
            </h1>
            <p class="animate-fade-rise-d1 max-w-2xl mx-auto text-[15px] sm:text-base leading-relaxed text-white/80 mb-10 font-light">
                Platform termudah untuk membuat halaman resmi desa. Pilih template, isi data, dan halaman desa Anda siap diakses publik dalam hitungan menit — tanpa perlu coding.
            </p>
            <div class="animate-fade-rise-d2 flex justify-center">
                <a href="{{ route('register') }}" class="glass-button text-white font-medium px-8 py-3 rounded-full text-[15px]">
                    Mulai Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- STATS — Trust strip --}}
    <section class="relative z-10 -mt-20 pb-24">
        <div class="max-w-5xl mx-auto px-6">
            <div class="scroll-reveal bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 p-8 sm:p-10 shadow-xl shadow-black/20">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl sm:text-4xl font-serif-velorah text-white mb-1">{{ $stats['total_villages'] }}+</div>
                        <div class="text-xs sm:text-sm text-white/70 uppercase tracking-widest">Desa Tergabung</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-serif-velorah text-white mb-1">{{ $stats['total_districts'] }}</div>
                        <div class="text-xs sm:text-sm text-white/70 uppercase tracking-widest">Kecamatan</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-serif-velorah text-white mb-1">2</div>
                        <div class="text-xs sm:text-sm text-white/70 uppercase tracking-widest">Template Premium</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-serif-velorah text-white mb-1">Rp 0</div>
                        <div class="text-xs sm:text-sm text-white/70 uppercase tracking-widest">Gratis Selamanya</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CARA KERJA — 4 Steps --}}
    <section id="cara-kerja" class="py-24 bg-black/40 backdrop-blur-md border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400 mb-4 font-semibold">Cara Kerja</p>
                <h2 class="font-serif-velorah text-3xl sm:text-4xl md:text-5xl text-white tracking-normal font-medium">
                    Empat langkah.<br>Lima menit.
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $steps = [
                    ['icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'title' => 'Daftar Akun', 'desc' => 'Buat akun sebagai perwakilan desa. Hanya butuh email dan password.'],
                    ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z', 'title' => 'Pilih Template', 'desc' => 'Pilih desain yang cocok untuk desa Anda — Klasik atau Modern.'],
                    ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'title' => 'Isi Konten', 'desc' => 'Lengkapi profil desa, daftar perangkat, dan upload logo dalam wizard interaktif.'],
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Disetujui & Tayang', 'desc' => 'Admin Provinsi review data Anda. Setelah disetujui, halaman desa langsung tayang!'],
                ];
                @endphp

                @foreach($steps as $i => $step)
                    <div class="scroll-reveal bg-white/5 backdrop-blur-md rounded-xl p-8 border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all group" style="transition-delay: {{ $i * 0.1 }}s">
                        <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mb-5 group-hover:bg-white/20 transition">
                            <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}" /></svg>
                        </div>
                        <div class="text-sm font-bold text-sky-400/90 uppercase tracking-widest mb-3">Langkah {{ $i + 1 }}</div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-white/70 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TEMPLATE SHOWCASE --}}
    <section id="template" class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400 mb-4 font-semibold">Pilihan Template</p>
                <h2 class="font-serif-velorah text-3xl sm:text-4xl md:text-5xl text-white tracking-normal font-medium mb-4">
                    Desain yang sudah siap pakai.
                </h2>
                <p class="text-white/70 max-w-xl mx-auto">Pilih tampilan yang paling cocok untuk desa Anda. Kedua template didesain profesional dan responsif di semua perangkat.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- Klasik --}}
                <a href="{{ url('/desa/pujon-kidul') }}" target="_blank" class="scroll-reveal group bg-white/5 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all block">
                    <div class="aspect-[4/3] bg-slate-900 flex items-center justify-center overflow-hidden relative">
                        <iframe src="{{ url('/desa/pujon-kidul') }}" style="width: 400%; height: 400%; transform: scale(0.25); transform-origin: top left;" class="absolute top-0 left-0 border-0 pointer-events-none bg-slate-50"></iframe>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-10">
                            <span class="bg-white text-sky-600 text-sm font-bold px-4 py-2 rounded-full shadow-lg">Lihat Demo</span>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-sky-400 transition">Template Klasik</h3>
                            <p class="text-sm text-white/70 mt-1">Tata letak sederhana dan informatif</p>
                        </div>
                        <span class="text-xs font-bold text-sky-400 uppercase tracking-widest bg-sky-500/20 px-3 py-1 rounded-full">Gratis</span>
                    </div>
                </a>

                {{-- Modern --}}
                <a href="{{ url('/desa/sumberan') }}" target="_blank" class="scroll-reveal group bg-white/5 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all block" style="transition-delay: 0.1s">
                    <div class="aspect-[4/3] bg-slate-900 flex items-center justify-center overflow-hidden relative">
                        <iframe src="{{ url('/desa/sumberan') }}" style="width: 400%; height: 400%; transform: scale(0.25); transform-origin: top left;" class="absolute top-0 left-0 border-0 pointer-events-none bg-white"></iframe>
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-10">
                            <span class="bg-white text-sky-600 text-sm font-bold px-4 py-2 rounded-full shadow-lg">Lihat Demo</span>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-white group-hover:text-sky-400 transition">Template Modern</h3>
                            <p class="text-sm text-white/70 mt-1">Card grid dinamis dan hero overlay</p>
                        </div>
                        <span class="text-xs font-bold text-sky-400 uppercase tracking-widest bg-sky-500/20 px-3 py-1 rounded-full">Gratis</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- SEARCH & SHOWCASE VILLAGES --}}
    <section id="pencarian" class="py-24 bg-black/40 backdrop-blur-md border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-10">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400 mb-4 font-semibold">Portofolio & Pencarian</p>
                <h2 class="font-serif-velorah text-3xl sm:text-4xl md:text-5xl text-white tracking-normal font-medium mb-4">
                    Temukan desa Anda.
                </h2>
                <p class="text-white/70 max-w-xl mx-auto">Cari dan jelajahi halaman desa yang telah bergabung di Portal Desa.</p>
            </div>

            {{-- Search Form --}}
            <div class="scroll-reveal max-w-3xl mx-auto mb-16">
                <form action="{{ url('/') }}#pencarian" method="GET" class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-2 sm:p-3 flex flex-col sm:flex-row gap-2 sm:gap-3 shadow-xl shadow-black/20">
                    <div class="flex-grow">
                        <label for="q" class="sr-only">Cari Desa</label>
                        <input type="text" name="q" id="q" value="{{ request('q') }}" placeholder="Cari nama desa..." class="w-full h-11 bg-white/10 border border-white/20 rounded-xl px-4 text-white placeholder:text-white/50 focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 transition-colors">
                    </div>
                    
                    <div class="w-full sm:w-48 shrink-0">
                        <label for="kecamatan" class="sr-only">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="w-full h-11 bg-white/10 border border-white/20 rounded-xl px-4 text-white focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 transition-colors appearance-none">
                            <option value="" class="text-slate-800">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }} class="text-slate-800">{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-48 shrink-0">
                        <label for="kabupaten" class="sr-only">Kabupaten</label>
                        <select name="kabupaten" id="kabupaten" class="w-full h-11 bg-white/10 border border-white/20 rounded-xl px-4 text-white focus:outline-none focus:border-sky-400 focus:ring-1 focus:ring-sky-400 transition-colors appearance-none">
                            <option value="" class="text-slate-800">Semua Kabupaten</option>
                            @foreach($kabupatens as $kab)
                                <option value="{{ $kab }}" {{ request('kabupaten') == $kab ? 'selected' : '' }} class="text-slate-800">{{ $kab }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" aria-label="Cari Desa" class="h-11 px-6 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl transition-colors flex-1 sm:flex-none flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Cari</span>
                        </button>
                        @if($isSearching)
                            <a href="{{ url('/') }}#pencarian" class="h-11 w-11 bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-xl transition-colors shrink-0 flex items-center justify-center" aria-label="Reset Filter" title="Reset">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($isSearching)
                {{-- Search Results --}}
                @if($searchResults->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($searchResults as $village)
                            <a href="{{ url('/desa/' . $village->slug) }}" class="group block bg-white/5 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all hover:-translate-y-1">
                                <div class="aspect-[4/3] bg-slate-900 relative overflow-hidden">
                                    @if($village->hero_image_path)
                                        <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-sky-900/40 to-indigo-900/40 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/><path d="M14.14 11.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                                    <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur text-xs font-bold px-2.5 py-1 rounded-full text-white/90 border border-white/20">
                                        {{ $village->template->name }}
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-white mb-1 group-hover:text-sky-400 transition">{{ $village->name }}</h3>
                                    <p class="text-sm text-white/70">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    {{-- Default tailwind pagination uses SVG icons which are fine, but might need style override if broken, let's wrap it --}}
                    <div class="flex justify-center mt-10" id="pagination-container">
                        {{ $searchResults->links() }}
                    </div>
                    <style>
                        #pagination-container nav { background: transparent; }
                        #pagination-container p { color: rgba(255,255,255,0.7) !important; }
                        #pagination-container span[aria-current="page"] > span { background-color: #0ea5e9 !important; border-color: #0ea5e9 !important; color: white !important; }
                        #pagination-container a { color: white !important; background-color: rgba(255,255,255,0.1) !important; border-color: rgba(255,255,255,0.2) !important; }
                        #pagination-container a:hover { background-color: rgba(255,255,255,0.2) !important; }
                    </style>
                @else
                    <div class="text-center bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-10 max-w-2xl mx-auto">
                        <svg class="w-16 h-16 text-white/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <h3 class="text-xl font-bold text-white mb-2">Desa tidak ditemukan</h3>
                        <p class="text-white/70">Tidak ada desa yang cocok dengan kriteria pencarian Anda.</p>
                    </div>
                @endif
            @else
                {{-- Showcase --}}
                @if($showcaseVillages->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($showcaseVillages as $i => $village)
                            <a href="{{ url('/desa/' . $village->slug) }}" class="scroll-reveal group block bg-white/5 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all hover:-translate-y-1" style="transition-delay: {{ $i * 0.1 }}s">
                                <div class="aspect-[4/3] bg-slate-900 relative overflow-hidden">
                                    @if($village->hero_image_path)
                                        <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-sky-900/40 to-indigo-900/40 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white/20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/><path d="M14.14 11.86l-3 3.87L9 13.14 6 17h12l-3.86-5.14z"/></svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                                    <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur text-xs font-bold px-2.5 py-1 rounded-full text-white/90 border border-white/20">
                                        {{ $village->template->name }}
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-white mb-1 group-hover:text-sky-400 transition">{{ $village->name }}</h3>
                                    <p class="text-sm text-white/70">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- FAQ ACCORDION --}}
    <section id="faq" class="py-24">
        <div class="max-w-3xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-sm uppercase tracking-[0.3em] text-sky-400 mb-4 font-semibold">FAQ</p>
                <h2 class="font-serif-velorah text-3xl sm:text-4xl text-white tracking-normal font-medium">
                    Pertanyaan umum.
                </h2>
            </div>

            @php
            $faqs = [
                ['q' => 'Apakah Portal Desa benar-benar gratis?', 'a' => 'Ya, sepenuhnya gratis. Portal Desa adalah inisiatif Diskominfo Provinsi Jawa Timur untuk mendukung digitalisasi desa. Tidak ada biaya tersembunyi.'],
                ['q' => 'Berapa lama proses pendaftaran sampai halaman desa bisa tayang?', 'a' => 'Proses pengisian wizard memakan waktu sekitar 5-10 menit. Setelah itu, Admin Provinsi akan mereview data Anda. Proses review biasanya memakan waktu 1-3 hari kerja.'],
                ['q' => 'Apakah saya bisa mengedit konten setelah halaman desa sudah tayang?', 'a' => 'Tentu! Setelah disetujui, Anda bisa kapan saja memperbarui profil desa, menambah berita, atau mengubah kontak. Perubahan langsung tayang tanpa perlu approval lagi.'],
                ['q' => 'Bagaimana jika pendaftaran saya ditolak?', 'a' => 'Admin akan memberikan alasan penolakan yang jelas. Anda bisa memperbaiki data sesuai catatan tersebut dan mengirim ulang pendaftaran melalui dashboard Anda.'],
                ['q' => 'Apakah data desa saya aman?', 'a' => 'Data Anda disimpan di server yang dikelola oleh Diskominfo Provinsi Jawa Timur dengan standar keamanan yang baik. Hanya Anda dan Admin Provinsi yang bisa mengakses data pengelolaan.'],
            ];
            @endphp

            <div class="space-y-3">
                @foreach($faqs as $i => $faq)
                    <div class="scroll-reveal" style="transition-delay: {{ $i * 0.05 }}s"
                         x-data="{ open: false }">
                        <button @click="open = !open" class="w-full flex items-center justify-between bg-white/5 backdrop-blur-md rounded-xl px-6 py-5 text-left border border-white/10 hover:bg-white/10 transition group">
                            <span class="text-sm sm:text-base font-medium text-white pr-4">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-white/70 shrink-0 transition-transform duration-300" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="px-6 pb-5 pt-2 text-sm text-white/70 leading-relaxed bg-white/5 backdrop-blur-md rounded-b-xl -mt-2 border-x border-b border-white/10">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="relative py-32 overflow-hidden bg-black/40 backdrop-blur-md border-y border-white/5">
        {{-- Background flows through completely from fixed body --}}

        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
            <div class="scroll-reveal">
                <p class="text-xs uppercase tracking-[0.3em] text-white/70 mb-6">Siap Memulai?</p>
                <h2 class="font-serif-velorah text-4xl sm:text-5xl md:text-6xl text-white tracking-normal leading-[1.05] mb-6">
                    Hadirkan desa Anda<br>secara digital.
                </h2>
                <p class="text-white/80 text-base sm:text-lg max-w-xl mx-auto mb-10 font-light">
                    Hanya butuh 5 menit untuk mendaftar dan mempublikasikan halaman resmi desa Anda. Gratis, selamanya.
                </p>
                <div class="flex justify-center">
                    <a href="{{ route('register') }}" class="glass-button text-white font-medium px-8 py-3 rounded-full text-[15px]">
                        Daftarkan Desa Anda
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT FOOTER --}}
    <footer class="relative pb-10 pt-20 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="scroll-reveal bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 p-8 sm:p-12 mb-10 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Left Side: Info --}}
                    <div>
                        <h2 class="font-serif-velorah text-4xl sm:text-5xl text-white font-medium mb-4">Get in touch</h2>
                        <p class="text-white/80 text-sm sm:text-base leading-relaxed mb-10">
                            Punya pertanyaan tentang layanan kami atau butuh bantuan? Silakan isi form berikut. Kami akan berusaha merespons dalam 1 hari kerja.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold mb-0.5">Email</div>
                                    <div class="text-white/70 text-sm">contact@portaldesa.jatimprov.go.id</div>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold mb-0.5">Telepon</div>
                                    <div class="text-white/70 text-sm">(031) 8294608</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <div class="text-white font-semibold mb-0.5">Alamat</div>
                                    <div class="text-white/70 text-sm">Jl. Ahmad Yani No.242-244, Surabaya, Jawa Timur</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Form --}}
                    <div>
                        @if(session('success'))
                            <div class="bg-green-500/20 border border-green-500/50 rounded-lg p-4 mb-6">
                                <p class="text-green-200 text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-white mb-1.5">Nama</label>
                                <input type="text" id="contact_name" name="name" value="{{ old('name') }}" required class="flex h-10 w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md">
                                @error('name') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-white mb-1.5">Email</label>
                                <input type="email" id="contact_email" name="email" value="{{ old('email') }}" required class="flex h-10 w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md">
                                @error('email') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-white mb-1.5">Telepon (Opsional)</label>
                                <input type="text" id="contact_phone" name="phone" value="{{ old('phone') }}" class="flex h-10 w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md">
                                @error('phone') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="contact_message" class="block text-sm font-medium text-white mb-1.5">Pesan</label>
                                <textarea id="contact_message" name="message" rows="4" required class="flex w-full rounded-md border border-white/20 bg-white/10 px-3 py-2 text-sm text-white placeholder:text-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all backdrop-blur-md resize-none">{{ old('message') }}</textarea>
                                @error('message') <p class="mt-1 text-xs text-red-300">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-black text-white hover:bg-black/80 transition-colors shadow-lg mt-2">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Portal Desa" class="w-6 h-6 object-contain rounded">
                    <span class="font-bold text-white text-sm tracking-tight">Portal Desa</span>
                </div>
                <p class="text-white/60 text-xs">
                    &copy; {{ date('Y') }} Portal Desa — Diskominfo Provinsi Jawa Timur. Proyek Magang Akademik.
                </p>
            </div>
        </div>
    </footer>

    {{-- Scroll Reveal Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
