<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-[#f8fafc]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        
        .shadow-formal {
            box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -1px rgba(15, 23, 42, 0.03);
        }
        
        .shadow-formal-hover {
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.04);
        }

        .prose-klasik p {
            margin-bottom: 1.25em;
            line-height: 1.8;
            color: #334155;
            text-align: justify;
        }
        .prose-klasik p:last-child { margin-bottom: 0; }
        :root {
            --color-primary: {{ $village->theme_color ?? '#1e293b' }};
        }
        
        .bg-klasik-primary { background-color: var(--color-primary); }
        .text-klasik-primary { color: var(--color-primary); }
        .border-klasik-primary { border-color: var(--color-primary); }
        
        /* Using primary color for accents to keep it monochromatic and formal */
        .bg-klasik-accent { background-color: var(--color-primary); }
        .text-klasik-accent { color: var(--color-primary); }
        .border-klasik-accent { border-color: var(--color-primary); }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col" style="selection-background-color: var(--color-primary); selection-color: white;">

    {{-- ═══════════════════════════════════════
         HEADER — Structured, Formal
         ═══════════════════════════════════════ --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                {{-- Logo & Typography --}}
                <div class="flex items-center gap-4">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-12 h-12 object-contain drop-shadow-sm">
                    @else
                        <div class="w-12 h-12 rounded-lg bg-klasik-primary text-white flex items-center justify-center font-bold text-xl shadow-inner">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-slate-900 tracking-tight leading-tight uppercase">Pemerintah Desa {{ $village->name }}</span>
                        <span class="text-sm text-slate-500 font-medium">Kecamatan {{ $village->kecamatan }}, Kab. {{ $village->kabupaten }}</span>
                    </div>
                </div>

                {{-- Desktop Menu --}}
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="#profil" class="text-sm font-semibold text-slate-600 hover:text-klasik-accent uppercase tracking-wide transition">Profil</a>
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" class="text-sm font-semibold text-slate-600 hover:text-klasik-accent uppercase tracking-wide transition">Perangkat</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" class="text-sm font-semibold text-slate-600 hover:text-klasik-accent uppercase tracking-wide transition">Berita</a>
                    @endif
                    @if($village->services->count() > 0)
                        <a href="#layanan" class="text-sm font-semibold text-slate-600 hover:text-klasik-accent uppercase tracking-wide transition">Layanan</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" class="text-sm font-semibold text-slate-600 hover:text-klasik-accent uppercase tracking-wide transition">Galeri</a>
                    @endif
                </nav>

                {{-- Mobile Menu Button --}}
                <button class="lg:hidden p-2 text-slate-600 bg-slate-100 rounded hover:bg-slate-200 transition" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            
            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-100 py-4">
                <div class="flex flex-col gap-2">
                    <a href="#profil" class="px-4 py-2 bg-slate-50 text-slate-700 font-medium rounded">Profil</a>
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" class="px-4 py-2 bg-slate-50 text-slate-700 font-medium rounded">Perangkat</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" class="px-4 py-2 bg-slate-50 text-slate-700 font-medium rounded">Berita</a>
                    @endif
                    @if($village->services->count() > 0)
                        <a href="#layanan" class="px-4 py-2 bg-slate-50 text-slate-700 font-medium rounded">Layanan</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" class="px-4 py-2 bg-slate-50 text-slate-700 font-medium rounded">Galeri</a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════
         HERO SECTION — Formal, Strong
         ═══════════════════════════════════════ --}}
    <section class="relative bg-klasik-primary overflow-hidden">
        @if($village->hero_image_path)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgc3Ryb2tlPSIjM2IzZDRjIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PHBhdGggZD0iTTAgNjBMMjAgNDBoNDBMMzAgMTAwaDQwbDIwLTIwIi8+PC9nPjwvc3ZnPg==')] opacity-10"></div>
        @endif
        
        <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white/90 text-sm font-medium mb-6">
                <svg class="w-4 h-4" style="color: var(--color-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Portal Resmi Pemerintahan
            </div>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight drop-shadow-lg">
                Desa {{ $village->name }}
            </h1>
            
            <p class="text-lg text-slate-300 font-medium max-w-2xl mx-auto mb-10 leading-relaxed">
                Mewujudkan pelayanan prima, transparan, dan akuntabel demi kesejahteraan masyarakat Kecamatan {{ $village->kecamatan }}.
            </p>
        </div>
        
        {{-- Floating Contact Strip --}}
        <div class="absolute bottom-0 w-full bg-klasik-accent/90 backdrop-blur">
            <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex flex-wrap justify-center sm:justify-between items-center gap-x-8 gap-y-3 text-sm text-white font-medium">
                    @if($village->address)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ Str::limit($village->address, 50) }}
                        </div>
                    @endif
                    <div class="flex items-center gap-6">
                        @if($village->contact_phone)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $village->contact_phone }}
                            </div>
                        @endif
                        @if($village->contact_email)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $village->contact_email }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════ --}}
    <main class="flex-grow pt-16 pb-24">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- ─── Main Column (8 cols) ─── --}}
                <div class="lg:col-span-8 space-y-16">
                    
                    {{-- Profil / Selayang Pandang --}}
                    @if($village->description)
                        <section id="profil" class="scroll-mt-28">
                            <div class="border-l-4 border-klasik-accent pl-4 mb-6">
                                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Selayang Pandang</h2>
                                <p class="text-sm text-slate-500 mt-1">Profil singkat dan sejarah Desa {{ $village->name }}</p>
                            </div>
                            <div class="bg-white p-8 rounded-xl shadow-formal border border-slate-100 prose-klasik text-[15px]">
                                {!! nl2br(e($village->description)) !!}
                            </div>
                        </section>
                    @endif

                    {{-- Layanan Desa --}}
                    @if($village->services->count() > 0)
                        <section id="layanan" class="scroll-mt-28">
                            <div class="border-l-4 border-klasik-accent pl-4 mb-6">
                                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Layanan Administrasi</h2>
                                <p class="text-sm text-slate-500 mt-1">Informasi pelayanan publik untuk masyarakat</p>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($village->services as $service)
                                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 hover:shadow-formal-hover transition-shadow flex flex-col sm:flex-row gap-6">
                                        <div class="flex-grow">
                                            <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $service->name }}</h4>
                                            @if($service->description)
                                                <p class="text-sm text-slate-600 mb-4">{{ $service->description }}</p>
                                            @endif
                                            @if($service->requirements)
                                                <div class="bg-slate-50 p-4 rounded border border-slate-100">
                                                    <span class="block text-xs font-bold text-slate-800 uppercase tracking-wide mb-2">Syarat Ketentuan:</span>
                                                    <p class="text-sm text-slate-600 whitespace-pre-line">{{ $service->requirements }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Berita Terkini --}}
                    @if($village->news->count() > 0)
                        <section id="berita" class="scroll-mt-28">
                            <div class="flex items-end justify-between border-b-2 border-slate-200 pb-4 mb-6">
                                <div class="border-l-4 border-klasik-accent pl-4">
                                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Berita Terkini</h2>
                                    <p class="text-sm text-slate-500 mt-1">Informasi terbaru seputar desa</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @foreach($village->news as $news)
                                    <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-formal transition-all duration-300">
                                        @if($news->cover_image_path)
                                            <div class="aspect-[16/9] overflow-hidden bg-slate-100 relative">
                                                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}"
                                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                                <div class="absolute top-4 left-4 bg-klasik-accent text-white text-xs font-bold px-3 py-1.5 rounded shadow">
                                                    {{ $news->published_at->format('d M Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="p-6">
                                            @if(!$news->cover_image_path)
                                                <div class="text-xs font-bold text-klasik-accent mb-3">
                                                    {{ $news->published_at->format('d M Y') }}
                                                </div>
                                            @endif
                                            <h3 class="text-lg font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-klasik-accent transition-colors">
                                                {{ $news->title }}
                                            </h3>
                                            <p class="text-sm text-slate-600 line-clamp-3 mb-4">
                                                {{ Str::limit(strip_tags($news->content), 120) }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Galeri Foto --}}
                    @if($village->galleries->count() > 0)
                        <section id="galeri" class="scroll-mt-28">
                            <div class="border-l-4 border-klasik-accent pl-4 mb-6">
                                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Galeri Desa</h2>
                                <p class="text-sm text-slate-500 mt-1">Koleksi foto kegiatan dan potensi desa</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($village->galleries as $gallery)
                                    <div class="relative bg-white p-1 rounded-lg shadow-sm border border-slate-200 group">
                                        <div class="aspect-square overflow-hidden rounded relative">
                                            <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                            @if($gallery->caption)
                                                <div class="absolute inset-x-0 bottom-0 bg-slate-900/80 p-3 opacity-0 group-hover:opacity-100 transition duration-300">
                                                    <p class="text-white text-xs font-medium text-center line-clamp-2">{{ $gallery->caption }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                {{-- ─── Sidebar (4 cols) ─── --}}
                <aside class="lg:col-span-4 space-y-8">
                    
                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-white rounded-xl shadow-formal border border-slate-100 overflow-hidden" id="perangkat">
                            <div class="bg-klasik-primary px-6 py-4 border-b border-klasik-primary">
                                <h3 class="font-bold text-white text-lg flex items-center gap-2">
                                    <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Struktur Pemerintahan
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="space-y-5">
                                    @foreach($village->officials as $official)
                                        <div class="flex items-center gap-4">
                                            @if($official->photo_path)
                                                <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}"
                                                     class="w-12 h-12 rounded-full object-cover border border-slate-200 p-0.5">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center font-bold text-base">
                                                    {{ strtoupper(mb_substr($official->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="font-bold text-slate-900 text-sm truncate">{{ $official->name }}</div>
                                                <div class="text-xs font-semibold text-klasik-accent uppercase tracking-wide mt-0.5">{{ $official->position }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Informasi Jam Kerja & Kontak --}}
                    <div class="bg-white rounded-xl shadow-formal border border-slate-100 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
                            <h3 class="font-bold text-slate-900 text-lg">Pusat Bantuan</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            @if($village->office_hours)
                                <div>
                                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Jam Operasional</span>
                                    <p class="text-sm font-medium text-slate-900 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-klasik-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $village->office_hours }}
                                    </p>
                                </div>
                            @endif
                            @if($village->address)
                                <div class="pt-4 border-t border-slate-100">
                                    <span class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Alamat Balai Desa</span>
                                    <p class="text-sm font-medium text-slate-900 flex items-start gap-2">
                                        <svg class="w-4 h-4 text-klasik-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="leading-relaxed">{{ $village->address }}</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </main>

    {{-- ═══════════════════════════════════════
         FOOTER — Formal, Authoritative
         ═══════════════════════════════════════ --}}
    <footer class="bg-klasik-primary text-white border-t-4 border-klasik-accent mt-auto">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" class="h-10 w-auto bg-white rounded p-1">
                    @endif
                    <div>
                        <div class="font-bold text-base uppercase tracking-wide">Pemerintah Desa {{ $village->name }}</div>
                        <div class="text-slate-400 text-xs mt-0.5">Kec. {{ $village->kecamatan }}, Kab. {{ $village->kabupaten }}</div>
                    </div>
                </div>
                <div class="text-slate-400 text-sm text-center md:text-right">
                    Hak Cipta &copy; {{ date('Y') }}. <br class="hidden sm:block">
                    Diberdayakan oleh <a href="{{ url('/') }}" class="text-white font-medium hover:text-klasik-accent transition-colors">Portal Desa</a> Provinsi Jawa Timur.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
