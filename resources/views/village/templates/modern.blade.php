<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Inter', system-ui, sans-serif;
            background-color: #ffffff;
            color: #000000;
        }
        
        /* Subtle forensic shadow */
        .shadow-mintlify {
            box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.04);
        }
        
        .shadow-mintlify-hover {
            box-shadow: 0px 4px 12px 0px rgba(0,0,0,0.06);
        }

        .prose-modern p {
            margin-bottom: 1.5em;
            line-height: 1.75;
            color: #111827;
        }
        .prose-modern p:last-child { margin-bottom: 0; }
        
        /* Primary theme color */
        :root {
            --color-primary: {{ $village->theme_color ?? '#0c8c5e' }};
        }

        .bg-mint { background-color: var(--color-primary); }
        .text-mint { color: var(--color-primary); }
        .border-mint { border-color: var(--color-primary); }
        /* A very light version of the primary color for wash backgrounds */
        .bg-mint-wash { background-color: color-mix(in srgb, var(--color-primary) 5%, white); }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col" style="selection-background-color: var(--color-primary); selection-color: white;">

    {{-- ═══════════════════════════════════════
         FLOATING NAVIGATION
         ═══════════════════════════════════════ --}}
    <nav class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100" x-data="{ mobileOpen: false }">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}"
                             class="w-8 h-8 rounded object-contain">
                    @else
                        <div class="w-8 h-8 rounded flex items-center justify-center font-bold text-sm bg-zinc-950 text-white">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <span class="font-semibold text-sm tracking-tight text-zinc-950">
                        {{ $village->name }}
                    </span>
                </div>

                {{-- Desktop Links --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="#profil" class="text-[14px] font-medium text-zinc-600 hover:text-zinc-950 transition-colors">Profil</a>
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" class="text-[14px] font-medium text-zinc-600 hover:text-zinc-950 transition-colors">Perangkat</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" class="text-[14px] font-medium text-zinc-600 hover:text-zinc-950 transition-colors">Berita</a>
                    @endif
                    @if($village->services->count() > 0)
                        <a href="#layanan" class="text-[14px] font-medium text-zinc-600 hover:text-zinc-950 transition-colors">Layanan</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" class="text-[14px] font-medium text-zinc-600 hover:text-zinc-950 transition-colors">Galeri</a>
                    @endif
                </div>

                {{-- Mobile Toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded text-zinc-600 hover:bg-zinc-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition x-cloak class="md:hidden pb-4 border-t border-gray-100">
                <div class="flex flex-col py-2 gap-1">
                    <a href="#profil" @click="mobileOpen = false" class="px-3 py-2 rounded-md text-[14px] font-medium text-zinc-700 hover:bg-zinc-50">Profil</a>
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" @click="mobileOpen = false" class="px-3 py-2 rounded-md text-[14px] font-medium text-zinc-700 hover:bg-zinc-50">Perangkat</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" @click="mobileOpen = false" class="px-3 py-2 rounded-md text-[14px] font-medium text-zinc-700 hover:bg-zinc-50">Berita</a>
                    @endif
                    @if($village->services->count() > 0)
                        <a href="#layanan" @click="mobileOpen = false" class="px-3 py-2 rounded-md text-[14px] font-medium text-zinc-700 hover:bg-zinc-50">Layanan</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" @click="mobileOpen = false" class="px-3 py-2 rounded-md text-[14px] font-medium text-zinc-700 hover:bg-zinc-50">Galeri</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════
         HERO SECTION — Dark teal / Image
         ═══════════════════════════════════════ --}}
    <section class="relative pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden bg-zinc-900">
        @if($village->hero_image_path)
            <div class="absolute inset-0">
                <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/50"></div>
            </div>
        @else
            {{-- Abstract subtle gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-[#0a192f] via-[#0f2c4d] to-[#0a192f]"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full blur-[120px] opacity-20" style="background-color: var(--color-primary);"></div>
        @endif

        <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if($village->logo_path)
                <img src="{{ Storage::url($village->logo_path) }}" alt="Logo"
                     class="w-16 h-16 mx-auto rounded-lg object-contain bg-white/10 backdrop-blur border border-white/20 mb-8 shadow-2xl">
            @endif
            
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white tracking-tight leading-[1.1] mb-6 max-w-4xl mx-auto" style="letter-spacing: -1.14px;">
                {{ $village->name }}
            </h1>
            <p class="text-lg md:text-xl text-zinc-300 font-medium max-w-2xl mx-auto mb-10" style="letter-spacing: -0.2px;">
                Kecamatan {{ $village->kecamatan }}, Kabupaten {{ $village->kabupaten }}
            </p>
            
            @if($village->contact_phone || $village->contact_email)
                <div class="flex flex-wrap justify-center gap-4 text-sm font-medium">
                    @if($village->contact_phone)
                        <a href="tel:{{ $village->contact_phone }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-zinc-950 rounded hover:bg-zinc-100 transition-colors">
                            <svg class="w-4 h-4 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            Hubungi Kami
                        </a>
                    @endif
                    @if($village->contact_email)
                        <a href="mailto:{{ $village->contact_email }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white border border-white/20 rounded hover:bg-white/20 transition-colors backdrop-blur-sm">
                            Kirim Email
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         MAIN CONTENT
         ═══════════════════════════════════════ --}}
    <main class="flex-grow pb-24 pt-12">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                {{-- ─── Left Column (8 cols) ─── --}}
                <div class="lg:col-span-8 space-y-20">

                    {{-- Profil --}}
                    @if($village->description)
                        <section id="profil" class="scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-zinc-950 mb-6 tracking-tight">Profil Desa</h2>
                            <div class="prose-modern text-[16px] text-zinc-800 bg-white border border-zinc-100 rounded-[16px] p-6 sm:p-8 shadow-mintlify">
                                {!! nl2br(e($village->description)) !!}
                            </div>
                        </section>
                    @endif

                    {{-- Berita --}}
                    @if($village->news->count() > 0)
                        <section id="berita" class="scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-zinc-950 mb-6 tracking-tight">Berita Terbaru</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @foreach($village->news as $news)
                                    <article class="group bg-white rounded-[16px] border border-zinc-100 shadow-mintlify overflow-hidden flex flex-col hover:shadow-mintlify-hover transition-shadow duration-300">
                                        @if($news->cover_image_path)
                                            <div class="aspect-[16/9] overflow-hidden bg-zinc-50 border-b border-zinc-100">
                                                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        <div class="p-6 flex-grow flex flex-col">
                                            <div class="text-[13px] font-medium text-mint mb-3 uppercase tracking-wider" style="letter-spacing: 0.65px;">
                                                {{ $news->published_at->format('d M Y') }}
                                            </div>
                                            <h3 class="text-[18px] font-semibold text-zinc-950 mb-2 line-clamp-2 leading-snug">
                                                {{ $news->title }}
                                            </h3>
                                            <p class="text-[15px] text-zinc-600 line-clamp-3 leading-relaxed flex-grow mb-4">
                                                {{ Str::limit(strip_tags($news->content), 120) }}
                                            </p>
                                            <div class="mt-auto pt-4 border-t border-zinc-100">
                                                <span class="text-[14px] font-medium text-zinc-950 hover:text-mint transition-colors inline-flex items-center gap-1 cursor-pointer">
                                                    Baca selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Layanan --}}
                    @if($village->services->count() > 0)
                        <section id="layanan" class="scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-zinc-950 mb-6 tracking-tight">Layanan Administrasi</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                @foreach($village->services as $service)
                                    <div class="bg-mint-wash rounded-[16px] p-6 border border-zinc-50/0 hover:border-mint/20 transition-colors">
                                        <div class="text-[13px] font-medium text-mint uppercase tracking-wider mb-2" style="letter-spacing: 0.65px;">
                                            Layanan
                                        </div>
                                        <h4 class="text-[20px] font-semibold text-zinc-950 mb-3 tracking-tight">{{ $service->name }}</h4>
                                        @if($service->description)
                                            <p class="text-[15px] text-zinc-800 mb-4 leading-relaxed">{{ $service->description }}</p>
                                        @endif
                                        @if($service->requirements)
                                            <div class="pt-4 border-t border-mint/10">
                                                <p class="text-[13px] font-semibold text-zinc-950 uppercase tracking-wider mb-2" style="letter-spacing: 0.65px;">Persyaratan</p>
                                                <p class="text-[14px] text-zinc-600 whitespace-pre-line leading-relaxed">{{ $service->requirements }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    {{-- Galeri Foto --}}
                    @if($village->galleries->count() > 0)
                        <section id="galeri" class="scroll-mt-24">
                            <h2 class="text-2xl font-semibold text-zinc-950 mb-6 tracking-tight">Galeri Desa</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($village->galleries as $gallery)
                                    <div class="group relative rounded-[16px] overflow-hidden aspect-square bg-zinc-100 shadow-mintlify border border-zinc-100">
                                        <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}"
                                             class="w-full h-full object-cover">
                                        @if($gallery->caption)
                                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/40 to-transparent p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <p class="text-white text-[13px] font-medium line-clamp-2 leading-snug">{{ $gallery->caption }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                {{-- ─── Right Column (4 cols) ─── --}}
                <aside class="lg:col-span-4 space-y-10">

                    {{-- Informasi Singkat --}}
                    <div class="bg-white rounded-[16px] border border-zinc-100 shadow-mintlify p-6">
                        <h3 class="text-[13px] font-medium text-mint uppercase tracking-wider mb-5" style="letter-spacing: 0.65px;">
                            Informasi Kontak
                        </h3>
                        <div class="space-y-4">
                            @if($village->address)
                                <div>
                                    <p class="text-[13px] text-zinc-500 font-medium mb-1">Alamat Kantor</p>
                                    <p class="text-[14px] text-zinc-950 font-medium leading-relaxed">{{ $village->address }}</p>
                                </div>
                            @endif
                            @if($village->contact_phone)
                                <div class="pt-4 border-t border-zinc-100">
                                    <p class="text-[13px] text-zinc-500 font-medium mb-1">Telepon</p>
                                    <p class="text-[14px] text-zinc-950 font-medium">{{ $village->contact_phone }}</p>
                                </div>
                            @endif
                            @if($village->contact_email)
                                <div class="pt-4 border-t border-zinc-100">
                                    <p class="text-[13px] text-zinc-500 font-medium mb-1">Email</p>
                                    <p class="text-[14px] text-zinc-950 font-medium truncate">{{ $village->contact_email }}</p>
                                </div>
                            @endif
                            @if($village->office_hours)
                                <div class="pt-4 border-t border-zinc-100">
                                    <p class="text-[13px] text-zinc-500 font-medium mb-1">Jam Layanan</p>
                                    <p class="text-[14px] text-zinc-950 font-medium">{{ $village->office_hours }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-white rounded-[16px] border border-zinc-100 shadow-mintlify p-6" id="perangkat">
                            <h3 class="text-[13px] font-medium text-mint uppercase tracking-wider mb-5" style="letter-spacing: 0.65px;">
                                Perangkat Desa
                            </h3>
                            <div class="space-y-4">
                                @foreach($village->officials as $official)
                                    <div class="flex items-center gap-4">
                                        @if($official->photo_path)
                                            <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}"
                                                 class="w-10 h-10 rounded border border-zinc-200 object-cover bg-zinc-50">
                                        @else
                                            <div class="w-10 h-10 rounded bg-zinc-100 text-zinc-600 flex items-center justify-center font-semibold text-sm border border-zinc-200">
                                                {{ strtoupper(mb_substr($official->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-medium text-zinc-950 text-[14px] truncate">{{ $official->name }}</div>
                                            <div class="text-[13px] text-zinc-500 mt-0.5">{{ $official->position }}</div>
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
    <footer class="bg-white border-t border-zinc-100 mt-auto">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" class="h-6 w-auto rounded">
                    @endif
                    <span class="font-semibold text-[14px] text-zinc-950">{{ $village->name }}</span>
                </div>
                <p class="text-zinc-500 text-[13px] text-center sm:text-right font-medium">
                    &copy; {{ date('Y') }} {{ $village->name }}. Diberdayakan oleh 
                    <a href="{{ url('/') }}" class="text-zinc-950 hover:text-mint transition-colors">Portal Desa</a>.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
