<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Desa — Buat Halaman Desa dalam 5 Menit</title>
    <meta name="description" content="Platform termudah untuk membuat halaman resmi desa. Pilih template, isi data, dan halaman desa Anda siap diakses publik dalam hitungan menit.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Mini Mockup Styles (Template & Village Previews) ── */
        .mini-mockup {
            background: #f9fafb;
            border-radius: 6px;
            overflow: hidden;
            font-size: 0;
            position: relative;
        }
        .mini-mockup .mm-header {
            height: 18%;
            display: flex;
            align-items: center;
            padding: 0 8%;
            gap: 6%;
        }
        .mini-mockup .mm-logo {
            width: 8%;
            aspect-ratio: 1;
            border-radius: 2px;
            background: rgba(255,255,255,0.5);
        }
        .mini-mockup .mm-nav {
            display: flex;
            gap: 4%;
            flex: 1;
            justify-content: flex-end;
        }
        .mini-mockup .mm-nav span {
            width: 12%;
            height: 3px;
            border-radius: 2px;
            background: rgba(255,255,255,0.35);
        }
        .mini-mockup .mm-hero {
            height: 38%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 12%;
        }
        .mini-mockup .mm-hero .mm-title {
            width: 55%;
            height: 5px;
            border-radius: 2px;
        }
        .mini-mockup .mm-hero .mm-subtitle {
            width: 40%;
            height: 3px;
            border-radius: 2px;
        }
        .mini-mockup .mm-hero .mm-btn {
            width: 22%;
            height: 8px;
            border-radius: 4px;
            margin-top: 4px;
        }
        .mini-mockup .mm-content {
            padding: 6% 8%;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .mini-mockup .mm-content .mm-line {
            height: 3px;
            border-radius: 2px;
            background: #e5e7eb;
        }
        .mini-mockup .mm-content .mm-line.short { width: 60%; }
        .mini-mockup .mm-content .mm-line.medium { width: 80%; }
        .mini-mockup .mm-content .mm-line.full { width: 100%; }

        /* ── Klasik variant ── */
        .mini-mockup.variant-klasik .mm-header { background: #1D4ED8; }
        .mini-mockup.variant-klasik .mm-hero { background: #EFF6FF; }
        .mini-mockup.variant-klasik .mm-hero .mm-title { background: #1E40AF; }
        .mini-mockup.variant-klasik .mm-hero .mm-subtitle { background: #93C5FD; }
        .mini-mockup.variant-klasik .mm-hero .mm-btn { background: #1D4ED8; }

        /* ── Modern variant ── */
        .mini-mockup.variant-modern .mm-header { background: #111827; }
        .mini-mockup.variant-modern .mm-hero {
            background: linear-gradient(135deg, #312e81 0%, #4338ca 100%);
        }
        .mini-mockup.variant-modern .mm-hero .mm-title { background: #fff; }
        .mini-mockup.variant-modern .mm-hero .mm-subtitle { background: rgba(255,255,255,0.5); }
        .mini-mockup.variant-modern .mm-hero .mm-btn { background: #6366f1; }
        .mini-mockup.variant-modern .mm-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
        }
        .mini-mockup.variant-modern .mm-content .mm-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            height: 28px;
        }

        /* ── Fallback village mockup ── */
        .mini-mockup.variant-village .mm-header { background: #1D4ED8; }
        .mini-mockup.variant-village .mm-hero {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
        }
        .mini-mockup.variant-village .mm-hero .mm-title { background: #1E3A5F; }
        .mini-mockup.variant-village .mm-hero .mm-subtitle { background: #93C5FD; }
        .mini-mockup.variant-village .mm-hero .mm-btn { background: #2563EB; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 min-h-screen flex flex-col selection:bg-indigo-100 selection:text-indigo-900">

    {{-- ═══════════════════════════════════════
         NAVIGATION — Transparent → White on scroll
         Text color switches simultaneously with background
         ═══════════════════════════════════════ --}}
    <nav class="fixed w-full top-0 z-50 transition-all duration-300"
         x-data="{ scrolled: false }"
         @scroll.window="scrolled = (window.scrollY > 40)">
        <div :class="scrolled
                ? 'bg-white/95 backdrop-blur-xl border-b border-gray-200 shadow-sm'
                : 'bg-transparent py-2'"
             class="transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="flex justify-between h-16 items-center">
                    {{-- Left: Logo --}}
                    <div class="flex items-center gap-2.5 w-1/4">
                        <span class="text-2xl font-bold tracking-tight transition-colors duration-300"
                              :class="scrolled ? 'text-gray-900' : 'text-white'">Portal Desa</span>
                    </div>

                    {{-- Center: Links --}}
                    <div class="hidden md:flex items-center justify-center gap-8 w-2/4">
                        <a href="#cara-kerja"
                           class="text-[13px] font-medium transition-colors duration-300"
                           :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/90 hover:text-white'">Cara Kerja</a>
                        <a href="#template"
                           class="text-[13px] font-medium transition-colors duration-300"
                           :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/90 hover:text-white'">Template</a>
                        <a href="#faq"
                           class="text-[13px] font-medium transition-colors duration-300"
                           :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/90 hover:text-white'">FAQ</a>
                    </div>

                    {{-- Right: Actions --}}
                    <div class="flex items-center justify-end gap-4 w-1/4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                               class="text-[13px] font-medium px-5 py-2 rounded-full transition-all duration-300"
                               :class="scrolled
                                   ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                                   : 'bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20'">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="hidden sm:block text-[13px] font-medium transition-colors duration-300"
                               :class="scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/90 hover:text-white'">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                               class="text-[13px] font-medium px-6 py-2.5 rounded-full transition-all duration-300"
                               :class="scrolled
                                   ? 'bg-indigo-600 text-white hover:bg-indigo-700'
                                   : 'bg-white/10 backdrop-blur-md text-white border border-white/20 hover:bg-white/20'">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════
         HERO — Video background ONLY here
         ═══════════════════════════════════════ --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        {{-- Video Background — scoped to this section only --}}
        <div class="absolute inset-0 z-0">
            <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover">
                <source src="{{ asset('video_desa.mp4') }}" type="video/mp4">
            </video>
            {{-- Dark gradient overlay for text readability --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/70"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-6 text-center mt-20">
            <h1 class="animate-fade-rise text-5xl sm:text-6xl md:text-7xl lg:text-[5.5rem] text-white tracking-tight leading-[1.1] mb-6 font-bold">
                Bawa desa Anda ke<br>era digital.
            </h1>
            <p class="animate-fade-rise-d1 max-w-2xl mx-auto text-[15px] sm:text-base leading-relaxed text-white/85 mb-10 font-light">
                Platform termudah untuk membuat halaman resmi desa. Pilih template, isi data, dan halaman desa Anda siap diakses publik dalam hitungan menit — tanpa perlu coding.
            </p>
            <div class="animate-fade-rise-d2 flex justify-center">
                <a href="{{ route('register') }}"
                   class="bg-indigo-600 text-white font-semibold px-8 py-3.5 rounded-full text-[15px] shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:scale-[1.03] transition-all duration-150">
                    Mulai Gratis Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         STATS — Trust strip (overlaps bottom of hero)
         ═══════════════════════════════════════ --}}
    <section class="relative z-10 -mt-20 pb-24">
        <div class="max-w-5xl mx-auto px-6">
            <div class="scroll-reveal bg-white rounded-2xl border border-gray-200 p-8 sm:p-10 shadow-xl">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-1">{{ $stats['total_villages'] }}+</div>
                        <div class="text-xs sm:text-sm text-gray-500 uppercase tracking-widest">Desa Tergabung</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-1">{{ $stats['total_districts'] }}</div>
                        <div class="text-xs sm:text-sm text-gray-500 uppercase tracking-widest">Kecamatan</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-1">2</div>
                        <div class="text-xs sm:text-sm text-gray-500 uppercase tracking-widest">Template Premium</div>
                    </div>
                    <div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-1">Rp 0</div>
                        <div class="text-xs sm:text-sm text-gray-500 uppercase tracking-widest">Gratis Selamanya</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         CARA KERJA — 4 Steps (bg-gray-50)
         ═══════════════════════════════════════ --}}
    <section id="cara-kerja" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-600 font-semibold mb-4">Cara Kerja</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl text-gray-900 tracking-tight font-semibold">
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
                    <div class="scroll-reveal bg-white rounded-xl p-8 border border-gray-200 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 group" style="transition-delay: {{ $i * 0.1 }}s">
                        <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center mb-5 group-hover:bg-indigo-100 transition">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}" /></svg>
                        </div>
                        <div class="text-xs font-bold text-indigo-600/60 uppercase tracking-widest mb-3">Langkah {{ $i + 1 }}</div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         TEMPLATE SHOWCASE (bg-white)
         ═══════════════════════════════════════ --}}
    <section id="template" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-600 font-semibold mb-4">Pilihan Template</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl text-gray-900 tracking-tight font-semibold mb-4">
                    Desain yang sudah siap pakai.
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto">Pilih tampilan yang paling cocok untuk desa Anda. Kedua template didesain profesional dan responsif di semua perangkat.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                {{-- Klasik --}}
                <div class="scroll-reveal group bg-white rounded-2xl overflow-hidden border border-gray-200 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-xl transition-all duration-300">
                    <div class="aspect-[4/3] p-4 bg-gray-50 flex items-center justify-center">
                        {{-- CSS Mini Mockup: Klasik layout --}}
                        <div class="mini-mockup variant-klasik w-full h-full rounded-lg shadow-sm border border-gray-200">
                            <div class="mm-header"></div>
                            <div class="mm-hero">
                                <div class="mm-title"></div>
                                <div class="mm-subtitle"></div>
                                <div class="mm-btn"></div>
                            </div>
                            <div class="mm-content">
                                <div class="mm-line full"></div>
                                <div class="mm-line medium"></div>
                                <div class="mm-line short"></div>
                                <div class="mm-line full"></div>
                                <div class="mm-line medium"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Template Klasik</h3>
                            <p class="text-sm text-gray-500 mt-1">Tata letak sederhana dan informatif</p>
                        </div>
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Gratis</span>
                    </div>
                </div>

                {{-- Modern --}}
                <div class="scroll-reveal group bg-white rounded-2xl overflow-hidden border border-gray-200 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-xl transition-all duration-300" style="transition-delay: 0.1s">
                    <div class="aspect-[4/3] p-4 bg-gray-50 flex items-center justify-center">
                        {{-- CSS Mini Mockup: Modern layout --}}
                        <div class="mini-mockup variant-modern w-full h-full rounded-lg shadow-sm border border-gray-200">
                            <div class="mm-header"></div>
                            <div class="mm-hero">
                                <div class="mm-title"></div>
                                <div class="mm-subtitle"></div>
                                <div class="mm-btn"></div>
                            </div>
                            <div class="mm-content">
                                <div class="mm-card"></div>
                                <div class="mm-card"></div>
                                <div class="mm-card"></div>
                                <div class="mm-card"></div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Template Modern</h3>
                            <p class="text-sm text-gray-500 mt-1">Card grid dinamis dan hero overlay</p>
                        </div>
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full">Gratis</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         SHOWCASE VILLAGES (bg-gray-50)
         ═══════════════════════════════════════ --}}
    @if($showcaseVillages->count() > 0)
        <section class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="scroll-reveal text-center mb-16">
                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-600 font-semibold mb-4">Portofolio</p>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl text-gray-900 tracking-tight font-semibold mb-4">
                        Desa yang telah bergabung.
                    </h2>
                    <p class="text-gray-500 max-w-xl mx-auto">Lihat bagaimana desa-desa lain memanfaatkan Portal Desa untuk hadir secara digital.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($showcaseVillages as $i => $village)
                        <a href="{{ url('/desa/' . $village->slug) }}"
                           class="scroll-reveal group block bg-white rounded-2xl overflow-hidden border border-gray-200 hover:-translate-y-1 hover:border-indigo-300 hover:shadow-xl transition-all duration-300"
                           style="transition-delay: {{ $i * 0.1 }}s">
                            <div class="aspect-[4/3] relative overflow-hidden bg-gray-100">
                                @if($village->hero_image_path)
                                    <img src="{{ Storage::url($village->hero_image_path) }}" alt="{{ $village->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    {{-- Fallback: CSS mini mockup instead of broken image icon --}}
                                    <div class="w-full h-full p-4 flex items-center justify-center">
                                        <div class="mini-mockup variant-village w-full h-full rounded-lg shadow-sm border border-gray-200">
                                            <div class="mm-header"></div>
                                            <div class="mm-hero">
                                                <div class="mm-title"></div>
                                                <div class="mm-subtitle"></div>
                                                <div class="mm-btn"></div>
                                            </div>
                                            <div class="mm-content">
                                                <div class="mm-line full"></div>
                                                <div class="mm-line medium"></div>
                                                <div class="mm-line short"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                                <div class="absolute bottom-3 right-3 bg-white text-xs font-bold px-2.5 py-1 rounded-full text-gray-700 border border-gray-200 shadow-sm">
                                    {{ $village->template->name }}
                                </div>
                            </div>
                            <div class="p-5">
                                <h3 class="text-base font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition">{{ $village->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         FAQ ACCORDION (bg-white)
         ═══════════════════════════════════════ --}}
    <section id="faq" class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-6">
            <div class="scroll-reveal text-center mb-16">
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-600 font-semibold mb-4">FAQ</p>
                <h2 class="text-3xl sm:text-4xl text-gray-900 tracking-tight font-semibold">
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
                        <button @click="open = !open" class="w-full flex items-center justify-between bg-white rounded-xl px-6 py-5 text-left border border-gray-200 hover:border-indigo-300 transition group">
                            <span class="text-sm sm:text-base font-medium text-gray-900 pr-4">{{ $faq['q'] }}</span>
                            <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </button>
                        <div x-show="open" x-collapse x-cloak class="px-6 pb-5 pt-2 text-sm text-gray-600 leading-relaxed bg-gray-50 rounded-b-xl -mt-2 border-x border-b border-gray-200">
                            {{ $faq['a'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         CTA FINAL (indigo band)
         ═══════════════════════════════════════ --}}
    <section class="relative py-32 overflow-hidden bg-indigo-600">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 80% 50%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
            <div class="scroll-reveal">
                <p class="text-xs uppercase tracking-[0.3em] text-indigo-200 mb-6">Siap Memulai?</p>
                <h2 class="text-4xl sm:text-5xl md:text-6xl text-white tracking-tight leading-[1.05] mb-6 font-bold">
                    Hadirkan desa Anda<br>secara digital.
                </h2>
                <p class="text-white/85 text-base sm:text-lg max-w-xl mx-auto mb-10 font-light">
                    Hanya butuh 5 menit untuk mendaftar dan mempublikasikan halaman resmi desa Anda. Gratis, selamanya.
                </p>
                <div class="flex justify-center">
                    <a href="{{ route('register') }}"
                       class="bg-white text-indigo-600 font-semibold px-8 py-3.5 rounded-full text-[15px] shadow-lg hover:bg-indigo-50 hover:scale-[1.03] transition-all duration-150">
                        Daftarkan Desa Anda
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         CONTACT FOOTER (bg-gray-50)
         ═══════════════════════════════════════ --}}
    <footer class="relative pb-10 pt-20 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="scroll-reveal bg-white rounded-2xl border border-gray-200 p-8 sm:p-12 mb-10 shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Left Side: Info --}}
                    <div>
                        <h2 class="text-4xl sm:text-5xl text-gray-900 font-bold mb-4">Hubungi Kami</h2>
                        <p class="text-gray-500 text-sm sm:text-base leading-relaxed mb-10">
                            Punya pertanyaan tentang layanan kami atau butuh bantuan? Silakan isi form berikut. Kami akan berusaha merespons dalam 1 hari kerja.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <div class="text-gray-900 font-semibold mb-0.5">Email</div>
                                    <div class="text-gray-500 text-sm">contact@portaldesa.jatimprov.go.id</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <div class="text-gray-900 font-semibold mb-0.5">Telepon</div>
                                    <div class="text-gray-500 text-sm">(031) 8294608</div>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <div class="text-gray-900 font-semibold mb-0.5">Alamat</div>
                                    <div class="text-gray-500 text-sm">Jl. Ahmad Yani No.242-244, Surabaya, Jawa Timur</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Form --}}
                    <div>
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                                <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama</label>
                                <input type="text" id="contact_name" name="name" value="{{ old('name') }}" required
                                       class="flex h-10 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all">
                                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                                <input type="email" id="contact_email" name="email" value="{{ old('email') }}" required
                                       class="flex h-10 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1.5">Telepon (Opsional)</label>
                                <input type="text" id="contact_phone" name="phone" value="{{ old('phone') }}"
                                       class="flex h-10 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all">
                                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="contact_message" class="block text-sm font-medium text-gray-700 mb-1.5">Pesan</label>
                                <textarea id="contact_message" name="message" rows="4" required
                                          class="flex w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all resize-none">{{ old('message') }}</textarea>
                                @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-lg text-sm font-semibold h-10 px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 hover:scale-[1.03] transition-all duration-150 shadow-md mt-2">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pt-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 bg-indigo-600 rounded-md flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    </div>
                    <span class="font-bold text-gray-900 text-sm tracking-tight">Portal Desa</span>
                </div>
                <p class="text-gray-400 text-xs">
                    &copy; {{ date('Y') }} Portal Desa — Diskominfo Provinsi Jawa Timur. Proyek Magang Akademik.
                </p>
            </div>
        </div>
    </footer>

    {{-- Scroll Reveal Script (fade-in-up via IntersectionObserver) --}}
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
