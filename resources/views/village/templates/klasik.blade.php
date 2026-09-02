<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .prose-village p { margin-bottom: 1em; line-height: 1.75; }
        .prose-village p:last-child { margin-bottom: 0; }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">

    {{-- ═══════════════════════════════════════
         NAVIGATION — Sticky, clean, formal
         ═══════════════════════════════════════ --}}
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo + Village Name --}}
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 rounded-full object-contain bg-white border border-gray-200 shadow-sm">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-700 text-white flex items-center justify-center font-bold text-lg shadow-sm">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-gray-900 text-sm leading-tight">{{ $village->name }}</div>
                        <div class="text-xs text-gray-500">{{ $village->kecamatan }}</div>
                    </div>
                </div>

                {{-- Links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="#profil" class="text-sm font-medium text-gray-600 hover:text-blue-700 transition">Profil</a>
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" class="text-sm font-medium text-gray-600 hover:text-blue-700 transition">Perangkat Desa</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" class="text-sm font-medium text-gray-600 hover:text-blue-700 transition">Berita</a>
                    @endif
                    <a href="#kontak" class="text-sm font-medium text-gray-600 hover:text-blue-700 transition">Kontak</a>
                </div>

                {{-- Mobile menu --}}
                <div class="md:hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                         class="absolute top-16 right-4 bg-white rounded-xl shadow-xl border border-gray-200 py-2 w-48">
                        <a href="#profil" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Profil</a>
                        @if($village->officials->count() > 0)
                            <a href="#perangkat" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Perangkat Desa</a>
                        @endif
                        @if($village->news->count() > 0)
                            <a href="#berita" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Berita</a>
                        @endif
                        <a href="#kontak" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Kontak</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════
         HERO BANNER
         ═══════════════════════════════════════ --}}
    <section class="relative overflow-hidden">
        @if($village->hero_image_path)
            <div class="relative h-[340px] sm:h-[420px] lg:h-[480px]">
                <img src="{{ Storage::url($village->hero_image_path) }}" alt="Pemandangan {{ $village->name }}"
                     class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/40 to-gray-900/20"></div>
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-14 w-full">
                        <div class="max-w-2xl">
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight mb-3">
                                {{ $village->name }}
                            </h1>
                            <p class="text-base sm:text-lg text-white/80 font-medium">
                                {{ $village->kecamatan }}, {{ $village->kabupaten }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="relative h-[280px] sm:h-[340px] bg-gradient-to-br from-blue-700 via-blue-800 to-blue-900 overflow-hidden">
                {{-- Decorative pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.3"/></pattern></defs><rect width="100" height="100" fill="url(#grid)"/></svg>
                </div>
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-10 sm:pb-14 w-full">
                        <div class="flex items-center gap-5 mb-4">
                            @if($village->logo_path)
                                <img src="{{ Storage::url($village->logo_path) }}" alt="Logo" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-contain bg-white/10 p-2 border border-white/20 shadow-lg">
                            @endif
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight leading-tight mb-3">
                            {{ $village->name }}
                        </h1>
                        <p class="text-base sm:text-lg text-blue-200 font-medium">
                            {{ $village->kecamatan }}, {{ $village->kabupaten }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- ═══════════════════════════════════════
         QUICK CONTACT STRIP
         ═══════════════════════════════════════ --}}
    @if($village->contact_phone || $village->contact_email || $village->office_hours || $village->address)
        <section class="bg-white border-b border-gray-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @if($village->address)
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat</div>
                                <div class="text-sm text-gray-700 truncate">{{ $village->address }}</div>
                            </div>
                        </div>
                    @endif
                    @if($village->contact_phone)
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Telepon</div>
                                <div class="text-sm text-gray-700">{{ $village->contact_phone }}</div>
                            </div>
                        </div>
                    @endif
                    @if($village->contact_email)
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</div>
                                <div class="text-sm text-gray-700 truncate">{{ $village->contact_email }}</div>
                            </div>
                        </div>
                    @endif
                    @if($village->office_hours)
                        <div class="flex items-center gap-3 px-3 py-2">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jam Layanan</div>
                                <div class="text-sm text-gray-700">{{ $village->office_hours }}</div>
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 lg:gap-14">

                {{-- ─── Left Column (Main) ─── --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- Profil Desa --}}
                    @if($village->description)
                        <section id="profil">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-blue-700 text-white flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Profil Desa</h2>
                            </div>
                            <div class="prose-village text-gray-600 text-[15px] leading-relaxed">
                                {!! nl2br(e($village->description)) !!}
                            </div>
                        </section>
                    @endif

                    {{-- Berita --}}
                    @if($village->news->count() > 0)
                        <section id="berita">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-blue-700 text-white flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Berita & Pengumuman</h2>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                @foreach($village->news as $news)
                                    <article class="group bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg hover:shadow-gray-200/60 transition-all duration-300">
                                        @if($news->cover_image_path)
                                            <div class="aspect-video overflow-hidden bg-gray-100">
                                                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                            </div>
                                        @else
                                            <div class="aspect-video bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                                                <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                            </div>
                                        @endif
                                        <div class="p-5">
                                            <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-md mb-3">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $news->published_at->format('d M Y') }}
                                            </div>
                                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 leading-snug group-hover:text-blue-700 transition">
                                                {{ $news->title }}
                                            </h3>
                                            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                                                {{ Str::limit(strip_tags($news->content), 120) }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Layanan Administrasi --}}
                    @if($village->services->count() > 0)
                        <section>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-blue-700 text-white flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900">Layanan Administrasi</h2>
                            </div>
                            <div class="space-y-3">
                                @foreach($village->services as $service)
                                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-200 transition">
                                        <h4 class="font-semibold text-gray-900 mb-1.5">{{ $service->name }}</h4>
                                        @if($service->description)
                                            <p class="text-sm text-gray-500 mb-3">{{ $service->description }}</p>
                                        @endif
                                        @if($service->requirements)
                                            <div class="bg-blue-50 rounded-lg px-4 py-3">
                                                <p class="text-xs font-semibold text-blue-700 uppercase tracking-wider mb-1">Persyaratan</p>
                                                <p class="text-sm text-gray-600 whitespace-pre-line">{{ $service->requirements }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                {{-- ─── Right Column (Sidebar) ─── --}}
                <aside class="space-y-6" id="kontak">

                    {{-- Informasi Kontak --}}
                    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi & Kontak
                        </h3>
                        <div class="space-y-4">
                            @if($village->address)
                                <div class="flex gap-3">
                                    <svg class="w-4.5 h-4.5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-sm text-gray-600 leading-relaxed">{{ $village->address }}</span>
                                </div>
                            @endif
                            @if($village->contact_phone)
                                <div class="flex gap-3">
                                    <svg class="w-4.5 h-4.5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span class="text-sm text-gray-600">{{ $village->contact_phone }}</span>
                                </div>
                            @endif
                            @if($village->contact_email)
                                <div class="flex gap-3">
                                    <svg class="w-4.5 h-4.5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span class="text-sm text-gray-600">{{ $village->contact_email }}</span>
                                </div>
                            @endif
                            @if($village->office_hours)
                                <div class="flex gap-3">
                                    <svg class="w-4.5 h-4.5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-sm text-gray-600">{{ $village->office_hours }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm" id="perangkat">
                            <h3 class="font-bold text-gray-900 mb-5 flex items-center gap-2">
                                <svg class="w-4.5 h-4.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Perangkat Desa
                            </h3>
                            <div class="space-y-4">
                                @foreach($village->officials as $official)
                                    <div class="flex items-center gap-3.5 group">
                                        @if($official->photo_path)
                                            <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}"
                                                 class="w-11 h-11 rounded-full object-cover border-2 border-gray-100 group-hover:border-blue-300 transition shadow-sm">
                                        @else
                                            <div class="w-11 h-11 rounded-full bg-blue-700 text-white flex items-center justify-center text-sm font-bold shadow-sm">
                                                {{ strtoupper(mb_substr($official->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-semibold text-gray-900 text-sm truncate">{{ $official->name }}</div>
                                            <div class="text-xs text-blue-600 font-medium">{{ $official->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </main>

    {{-- ═══════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════ --}}
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" class="h-8 w-auto rounded opacity-70">
                    @endif
                    <span class="font-semibold text-sm">{{ $village->name }}</span>
                </div>
                <p class="text-gray-400 text-xs text-center sm:text-right">
                    &copy; {{ date('Y') }} {{ $village->name }}. Diberdayakan oleh
                    <a href="{{ url('/') }}" class="text-blue-400 hover:text-blue-300 transition">Portal Desa</a>
                    Jawa Timur.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
