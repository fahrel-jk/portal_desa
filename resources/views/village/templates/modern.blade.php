<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .prose-modern p { margin-bottom: 1em; line-height: 1.8; }
        .prose-modern p:last-child { margin-bottom: 0; }
    </style>
</head>
<body class="antialiased bg-white text-gray-900 min-h-screen flex flex-col">

    {{-- ═══════════════════════════════════════
         FLOATING NAVIGATION — transparent → white on scroll
         ═══════════════════════════════════════ --}}
    <nav class="fixed w-full top-0 z-50" x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = (window.scrollY > 60)">
        <div class="transition-all duration-300"
             :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg shadow-gray-900/5 border-b border-gray-100' : 'bg-transparent'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-18">
                    {{-- Logo --}}
                    <div class="flex items-center gap-3">
                        @if($village->logo_path)
                            <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}"
                                 class="w-9 h-9 rounded-xl object-contain shadow-sm transition-all"
                                 :class="scrolled ? 'border border-gray-200 bg-white' : 'border border-white/20 bg-white/10'">
                        @else
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm transition-all"
                                 :class="scrolled ? 'bg-indigo-600 text-white' : 'bg-white/15 text-white border border-white/20'">
                                {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="font-bold text-sm tracking-tight transition-colors"
                              :class="scrolled ? 'text-gray-900' : 'text-white'">
                            {{ $village->name }}
                        </span>
                    </div>

                    {{-- Desktop Links --}}
                    <div class="hidden md:flex items-center gap-7">
                        <a href="#profil" class="text-[13px] font-medium transition-colors"
                           :class="scrolled ? 'text-gray-600 hover:text-indigo-600' : 'text-white/80 hover:text-white'">Profil</a>
                        @if($village->officials->count() > 0)
                            <a href="#perangkat" class="text-[13px] font-medium transition-colors"
                               :class="scrolled ? 'text-gray-600 hover:text-indigo-600' : 'text-white/80 hover:text-white'">Perangkat</a>
                        @endif
                        @if($village->news->count() > 0)
                            <a href="#berita" class="text-[13px] font-medium transition-colors"
                               :class="scrolled ? 'text-gray-600 hover:text-indigo-600' : 'text-white/80 hover:text-white'">Berita</a>
                        @endif
                        @if($village->services->count() > 0)
                            <a href="#layanan" class="text-[13px] font-medium transition-colors"
                               :class="scrolled ? 'text-gray-600 hover:text-indigo-600' : 'text-white/80 hover:text-white'">Layanan</a>
                        @endif
                    </div>

                    {{-- Mobile Toggle --}}
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg transition"
                            :class="scrolled ? 'text-gray-600 hover:bg-gray-100' : 'text-white/80 hover:bg-white/10'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>

                {{-- Mobile Menu --}}
                <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition x-cloak
                     class="md:hidden pb-4 border-t"
                     :class="scrolled ? 'border-gray-100' : 'border-white/10'">
                    <div class="flex flex-col py-2 gap-1">
                        <a href="#profil" @click="mobileOpen = false" class="px-3 py-2.5 rounded-lg text-sm font-medium"
                           :class="scrolled ? 'text-gray-700 hover:bg-gray-50' : 'text-white/90 hover:bg-white/10'">Profil</a>
                        @if($village->officials->count() > 0)
                            <a href="#perangkat" @click="mobileOpen = false" class="px-3 py-2.5 rounded-lg text-sm font-medium"
                               :class="scrolled ? 'text-gray-700 hover:bg-gray-50' : 'text-white/90 hover:bg-white/10'">Perangkat</a>
                        @endif
                        @if($village->news->count() > 0)
                            <a href="#berita" @click="mobileOpen = false" class="px-3 py-2.5 rounded-lg text-sm font-medium"
                               :class="scrolled ? 'text-gray-700 hover:bg-gray-50' : 'text-white/90 hover:bg-white/10'">Berita</a>
                        @endif
                        @if($village->services->count() > 0)
                            <a href="#layanan" @click="mobileOpen = false" class="px-3 py-2.5 rounded-lg text-sm font-medium"
                               :class="scrolled ? 'text-gray-700 hover:bg-gray-50' : 'text-white/90 hover:bg-white/10'">Layanan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════
         HERO — Full-viewport, cinematic
         ═══════════════════════════════════════ --}}
    <section class="relative min-h-[70vh] lg:min-h-[75vh] flex items-end overflow-hidden">
        @if($village->hero_image_path)
            <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/85 via-gray-900/40 to-gray-900/30"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-gray-900 to-gray-900"></div>
            {{-- Abstract decoration --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-600/15 rounded-full blur-3xl"></div>
        @endif

        <div class="relative z-10 w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-14 sm:pb-20 pt-28">
                <div class="max-w-3xl">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo"
                             class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-contain bg-white/10 backdrop-blur-md p-2 border border-white/20 shadow-2xl mb-6">
                    @endif
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[1.1] mb-4">
                        {{ $village->name }}
                    </h1>
                    <p class="text-lg sm:text-xl text-gray-300 font-medium mb-2">
                        {{ $village->kecamatan }}, {{ $village->kabupaten }}
                    </p>
                    @if($village->description)
                        <p class="text-sm sm:text-base text-gray-400 max-w-xl leading-relaxed mt-4">
                            {{ Str::limit($village->description, 180) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         CONTACT CARDS — Overlapping hero/content
         ═══════════════════════════════════════ --}}
    @if($village->contact_phone || $village->contact_email || $village->office_hours)
        <section class="relative z-20 -mt-10 mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($village->contact_phone)
                        <div class="bg-white rounded-2xl p-5 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-4 hover:shadow-2xl hover:shadow-gray-200/60 transition duration-300">
                            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Telepon</div>
                                <div class="font-bold text-gray-900 text-sm">{{ $village->contact_phone }}</div>
                            </div>
                        </div>
                    @endif
                    @if($village->contact_email)
                        <div class="bg-white rounded-2xl p-5 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-4 hover:shadow-2xl hover:shadow-gray-200/60 transition duration-300">
                            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Email</div>
                                <div class="font-bold text-gray-900 text-sm truncate">{{ $village->contact_email }}</div>
                            </div>
                        </div>
                    @endif
                    @if($village->office_hours)
                        <div class="bg-white rounded-2xl p-5 shadow-xl shadow-gray-200/50 border border-gray-100 flex items-center gap-4 hover:shadow-2xl hover:shadow-gray-200/60 transition duration-300">
                            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Jam Layanan</div>
                                <div class="font-bold text-gray-900 text-sm">{{ $village->office_hours }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════ --}}
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">

                {{-- ─── Left Column (8 cols) ─── --}}
                <div class="lg:col-span-8 space-y-16">

                    {{-- Profil --}}
                    @if($village->description)
                        <section id="profil">
                            <div class="bg-white rounded-3xl border border-gray-100 p-8 sm:p-10 shadow-sm">
                                <div class="flex items-center gap-3 mb-6">
                                    <span class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/25">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Profil Desa</h2>
                                </div>
                                <div class="prose-modern text-gray-600 text-[15px] max-w-none">
                                    {!! nl2br(e($village->description)) !!}
                                </div>
                            </div>
                        </section>
                    @endif

                    {{-- Berita Grid --}}
                    @if($village->news->count() > 0)
                        <section id="berita">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/25">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </span>
                                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Berita & Pengumuman</h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                @foreach($village->news as $news)
                                    <article class="group bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 flex flex-col">
                                        @if($news->cover_image_path)
                                            <div class="aspect-video overflow-hidden bg-gray-100">
                                                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            </div>
                                        @else
                                            <div class="aspect-video bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 flex items-center justify-center">
                                                <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                            </div>
                                        @endif
                                        <div class="p-5 sm:p-6 flex-grow flex flex-col">
                                            <div class="text-xs font-bold text-indigo-600 mb-3 tracking-wide">
                                                {{ $news->published_at->format('d M Y') }}
                                            </div>
                                            <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 leading-snug group-hover:text-indigo-600 transition">
                                                {{ $news->title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed flex-grow">
                                                {{ Str::limit(strip_tags($news->content), 120) }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Layanan --}}
                    @if($village->services->count() > 0)
                        <section id="layanan">
                            <div class="flex items-center gap-3 mb-8">
                                <span class="w-9 h-9 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg shadow-indigo-600/25">
                                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                </span>
                                <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">Layanan Administrasi</h2>
                            </div>
                            <div class="space-y-4">
                                @foreach($village->services as $service)
                                    <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-indigo-200 hover:shadow-md transition duration-300">
                                        <h4 class="font-bold text-gray-900 mb-2">{{ $service->name }}</h4>
                                        @if($service->description)
                                            <p class="text-sm text-gray-500 mb-4 leading-relaxed">{{ $service->description }}</p>
                                        @endif
                                        @if($service->requirements)
                                            <div class="bg-indigo-50 rounded-xl p-4">
                                                <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-1.5">Persyaratan</p>
                                                <p class="text-sm text-gray-600 whitespace-pre-line leading-relaxed">{{ $service->requirements }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                {{-- ─── Right Column (4 cols) ─── --}}
                <aside class="lg:col-span-4 space-y-6">

                    {{-- Alamat Card (dark) --}}
                    @if($village->address)
                        <div class="bg-gray-900 rounded-2xl p-7 text-white relative overflow-hidden shadow-xl">
                            <div class="absolute -top-4 -right-4 opacity-[0.06]">
                                <svg class="w-36 h-36" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                            </div>
                            <h3 class="font-bold text-base mb-3 relative z-10">Alamat Kantor</h3>
                            <p class="text-gray-300 text-sm leading-relaxed relative z-10">{{ $village->address }}</p>
                        </div>
                    @endif

                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-white rounded-2xl border border-gray-100 p-7 shadow-sm" id="perangkat">
                            <h3 class="font-extrabold text-gray-900 mb-6 text-base">Perangkat Desa</h3>
                            <div class="space-y-5">
                                @foreach($village->officials as $official)
                                    <div class="flex items-center gap-4 group">
                                        @if($official->photo_path)
                                            <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}"
                                                 class="w-12 h-12 rounded-xl object-cover border-2 border-transparent group-hover:border-indigo-300 transition duration-300 shadow-sm">
                                        @else
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-base shadow-md group-hover:shadow-lg transition duration-300">
                                                {{ strtoupper(mb_substr($official->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-gray-900 text-sm truncate">{{ $official->name }}</div>
                                            <div class="text-xs text-indigo-600 font-semibold">{{ $official->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Informasi Tambahan --}}
                    <div class="bg-white rounded-2xl border border-gray-100 p-7 shadow-sm">
                        <h3 class="font-extrabold text-gray-900 mb-5 text-base">Informasi</h3>
                        <div class="space-y-4">
                            @if($village->contact_phone)
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span class="text-sm text-gray-600">{{ $village->contact_phone }}</span>
                                </div>
                            @endif
                            @if($village->contact_email)
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="text-sm text-gray-600 truncate">{{ $village->contact_email }}</span>
                                </div>
                            @endif
                            @if($village->office_hours)
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-sm text-gray-600">{{ $village->office_hours }}</span>
                                </div>
                            @endif
                            <div class="pt-3 mt-3 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span class="text-xs text-gray-400 font-medium">Terverifikasi oleh Diskominfo Jatim</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    {{-- ═══════════════════════════════════════
         FOOTER — Clean, light
         ═══════════════════════════════════════ --}}
    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" class="h-7 w-auto rounded-lg opacity-60">
                    @endif
                    <span class="font-bold text-sm text-gray-900">{{ $village->name }}</span>
                </div>
                <p class="text-gray-400 text-xs text-center sm:text-right">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi. Diberdayakan oleh
                    <a href="{{ url('/') }}" class="text-indigo-500 hover:text-indigo-600 transition">Portal Desa</a>
                    Jawa Timur.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
