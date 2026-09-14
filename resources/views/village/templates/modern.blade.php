<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo-meta 
        title="{{ $village->name }} - Portal Desa {{ $village->kabupaten }}" 
        description="{{ Str::limit($village->description ?: 'Portal resmi Desa ' . $village->name . ', Kecamatan ' . $village->kecamatan . ', Kabupaten ' . $village->kabupaten, 160) }}" 
        image="{{ $village->logo_path ? Storage::url($village->logo_path) : asset('images/logo.png') }}" 
    />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @if($village->latitude && $village->longitude)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    @endif
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @php
            $theme = $village->theme_color ?? 'sumberan-sage';
            
            $bg = '#eef0ea'; $fg = '#2a2f23'; $card = '#ffffff'; $card_fg = '#2a2f23';
            $primary = '#c4654a'; $primary_fg = '#ffffff';
            $secondary = '#87a878'; $secondary_fg = '#ffffff';
            $muted = '#d7dacb'; $muted_fg = '#5c6652';
            $accent = '#e8a87c'; $accent_fg = '#3d2b1f';
            $border = 'rgba(42, 47, 35, 0.10)';

            if ($theme === 'laut-senja') {
                $bg = '#f0f2f5'; $fg = '#1e293b'; $card = '#ffffff'; $card_fg = '#1e293b';
                $primary = '#0f766e'; $primary_fg = '#ffffff';
                $secondary = '#3b82f6'; $secondary_fg = '#ffffff';
                $muted = '#e2e8f0'; $muted_fg = '#64748b';
                $accent = '#f59e0b'; $accent_fg = '#451a03';
                $border = 'rgba(30, 41, 59, 0.10)';
            } elseif ($theme === 'kopi-susu') {
                $bg = '#f5f0eb'; $fg = '#43302b'; $card = '#ffffff'; $card_fg = '#43302b';
                $primary = '#8c5a45'; $primary_fg = '#ffffff';
                $secondary = '#bfa38f'; $secondary_fg = '#ffffff';
                $muted = '#e6dfd8'; $muted_fg = '#7a645d';
                $accent = '#d97743'; $accent_fg = '#ffffff';
                $border = 'rgba(67, 48, 43, 0.10)';
            } elseif ($theme === 'monokrom-elegan') {
                $bg = '#f8fafc'; $fg = '#0f172a'; $card = '#ffffff'; $card_fg = '#0f172a';
                $primary = '#334155'; $primary_fg = '#ffffff';
                $secondary = '#94a3b8'; $secondary_fg = '#ffffff';
                $muted = '#f1f5f9'; $muted_fg = '#64748b';
                $accent = '#475569'; $accent_fg = '#ffffff';
                $border = 'rgba(15, 23, 42, 0.10)';
            }
        @endphp

        :root {
            --bg: {{ $bg }};
            --fg: {{ $fg }};
            --card: {{ $card }};
            --card-fg: {{ $card_fg }};
            --primary: {{ $primary }};
            --primary-fg: {{ $primary_fg }};
            --secondary: {{ $secondary }};
            --secondary-fg: {{ $secondary_fg }};
            --muted: {{ $muted }};
            --muted-fg: {{ $muted_fg }};
            --accent: {{ $accent }};
            --accent-fg: {{ $accent_fg }};
            --border: {{ $border }};
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        details summary::-webkit-details-marker { display: none; }
        details summary { list-style: none; }
        
        body {
            font-family: 'Figtree', system-ui, sans-serif;
            background-color: var(--bg);
            color: var(--fg);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            color: var(--fg);
            letter-spacing: -0.025em;
            line-height: 1.15;
        }

        .eyebrow {
            font-family: 'Figtree', sans-serif;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--primary);
        }

        /* Hero image container */
        .hero-container {
            border-radius: 1.25rem;
            overflow: hidden;
            position: relative;
        }

        /* Frosted glass panel — WHITE, readable */
        .hero-glass {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 1.25rem;
        }

        /* Dark info badge */
        .hero-badge {
            background: rgba(42, 47, 35, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            background-color: var(--primary);
            color: var(--primary-fg);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.75rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }
        .btn-primary:hover {
            filter: brightness(1.08);
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 30%, transparent);
        }

        .btn-ghost {
            display: inline-flex; align-items: center; justify-content: center;
            background-color: transparent;
            color: var(--fg);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.75rem;
            font-size: 0.9375rem;
            border: 1px solid var(--border);
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-ghost:hover { background-color: color-mix(in srgb, var(--muted) 40%, transparent); }

        /* Card */
        .card {
            background-color: var(--card);
            border: 1px solid var(--border);
            border-radius: 1.25rem;
        }

        /* Gallery caption pill at bottom of photo */
        .gallery-caption {
            position: absolute;
            bottom: 0.75rem;
            left: 0.75rem;
            right: 0.75rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border-radius: 0.75rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--fg);
        }

        /* Divider line for stats */
        .stat-divider {
            width: 1px;
            align-self: stretch;
            background-color: var(--border);
        }

        /* Floating Navbar Pill */
        .navbar-pill {
            background-color: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    {{-- ═══════════════════════════════════════
         NAVIGATION — Solid, above hero
         ═══════════════════════════════════════ --}}
    <div style="position: sticky; top: 0.75rem; z-index: 50; padding: 0 0.75rem; margin-bottom: 1.5rem;" class="sm:mb-8">
        <style>
            @media (min-width: 640px) {
                .navbar-sticky-wrap { top: 1.5rem !important; padding: 0 1rem !important; }
            }
        </style>
        <header class="navbar-pill" x-data="{ mobileOpen: false }" :style="mobileOpen ? 'border-radius: 1.5rem;' : 'border-radius: 9999px;'" style="border-radius: 9999px;">
            <div style="display: flex; align-items: center; justify-content: space-between; height: 4.5rem;">

                {{-- Logo & Village Name --}}
                <a href="#" class="flex items-center gap-3 no-underline">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain rounded-full" style="border: 1px solid var(--border);">
                    @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-base" style="background-color: var(--primary); color: var(--primary-fg); font-family: Outfit, sans-serif;">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-bold text-[15px]" style="color: var(--fg); font-family: Outfit, sans-serif;">Desa {{ $village->name }}</span>
                        <span class="text-[11px] font-medium" style="color: var(--muted-fg);">Portal resmi desa</span>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-7">
                    <a href="#profil" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Profil</a>
                    @if($village->services->count() > 0)
                        <a href="#layanan" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Layanan</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Berita</a>
                    @endif
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Perangkat</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Galeri</a>
                    @endif
                    @if($village->latitude && $village->longitude)
                        <a href="#lokasi" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Lokasi</a>
                    @endif
                    <a href="{{ route('village.apbdes', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">APBDes</a>

                    <div class="h-5 w-px" style="background-color: var(--border);"></div>

                    <a href="{{ route('login') }}" class="text-[13px] font-medium px-4 py-1.5 rounded-lg border no-underline transition-colors" style="color: var(--muted-fg); border-color: var(--border);" onmouseover="this.style.borderColor='var(--fg)';this.style.color='var(--fg)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted-fg)'">Login Admin</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary text-[13px] !py-2 !px-5 !rounded-full no-underline">Hubungi kami</a>
                </nav>

                {{-- Mobile Hamburger --}}
                <button aria-label="Toggle menu" class="lg:hidden p-2 rounded-lg" style="color: var(--fg);" @click="mobileOpen = !mobileOpen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-collapse x-cloak class="lg:hidden border-t py-4" style="border-color: var(--border);">
                <div class="flex flex-col gap-1">
                    <a href="#profil" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Profil</a>
                    @if($village->services->count() > 0)
                        <a href="#layanan" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Layanan</a>
                    @endif
                    @if($village->news->count() > 0)
                        <a href="#berita" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Berita</a>
                    @endif
                    @if($village->officials->count() > 0)
                        <a href="#perangkat" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Perangkat</a>
                    @endif
                    @if($village->galleries->count() > 0)
                        <a href="#galeri" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Galeri</a>
                    @endif
                    @if($village->latitude && $village->longitude)
                        <a href="#lokasi" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Lokasi</a>
                    @endif
                    <a href="{{ route('village.apbdes', $village->slug) }}" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">APBDes</a>
                    <div class="h-px my-2" style="background-color: var(--border);"></div>
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium rounded-lg border no-underline" style="color: var(--fg); border-color: var(--border);">Login Admin</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary text-sm text-center mt-1 no-underline">Hubungi kami</a>
                </div>
            </div>
        </header>
    </div>

    {{-- ═══════════════════════════════════════
         HERO — Rounded image, glass panel
         ═══════════════════════════════════════ --}}
    <section style="padding: 1.5rem 1rem 2rem;">
        <div style="max-width: 1120px; margin: 0 auto;">
            <div style="border-radius: 1.25rem; overflow: hidden; position: relative; min-height: 320px; background-color: #4a6741; background-size: cover; background-position: center; {{ $village->hero_image_path ? 'background-image: url(' . Storage::url($village->hero_image_path) . ');' : '' }}" class="sm:!min-h-[520px]">
                {{-- Gradient overlay --}}
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.35), transparent 60%);"></div>

                {{-- Content --}}
                <div style="position: relative; z-index: 10; display: flex; flex-direction: column; justify-content: flex-end; min-height: 320px; padding: 1.25rem;" class="sm:!min-h-[520px] sm:!p-8">
                    <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 1.25rem;">

                        {{-- Glass Panel --}}
                        <div style="background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.5); border-radius: 1rem; padding: 1.25rem; max-width: 500px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);" class="sm:!p-8 sm:!rounded-[1.25rem]">
                            <div class="eyebrow" style="margin-bottom: 0.75rem; color: rgba(255, 255, 255, 0.9); text-shadow: 0 1px 2px rgba(0,0,0,0.5);">Desa di {{ $village->kabupaten }}</div>
                            <h1 style="font-family: Outfit, sans-serif; font-size: clamp(1.75rem, 6vw, 4.5rem); font-weight: 800; color: #ffffff; text-shadow: 0 2px 12px rgba(0,0,0,0.4); line-height: 1.05; margin-bottom: 0.75rem; letter-spacing: -0.04em;">
                                {{ ucwords(strtolower($village->name)) }}
                            </h1>
                            <p style="font-size: 15px; line-height: 1.6; color: rgba(255, 255, 255, 0.95); text-shadow: 0 1px 4px rgba(0,0,0,0.5); margin-bottom: 1.5rem; font-weight: 500;">
                                @if($village->description && Str::length($village->description) > 10)
                                    {{ Str::limit(strip_tags($village->description), 120) }}
                                @else
                                    Ruang hidup yang tumbuh di antara kampung, persawahan, dan semangat gotong royong warganya.
                                @endif
                            </p>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                                @if($village->contact_phone)
                                    <a href="tel:{{ $village->contact_phone }}" class="btn-primary" style="text-decoration: none;">Hubungi kami</a>
                                @else
                                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary" style="text-decoration: none;">Hubungi kami</a>
                                @endif
                                @if($village->contact_email)
                                    <a href="mailto:{{ $village->contact_email }}" class="btn-ghost" style="text-decoration: none; color: white; border-color: rgba(255,255,255,0.4);">Kirim email</a>
                                @else
                                    <a href="#profil" class="btn-ghost" style="text-decoration: none; color: white; border-color: rgba(255,255,255,0.4);">Jelajahi Desa</a>
                                @endif
                            </div>
                        </div>

                        {{-- Dark Badge --}}
                        @if($village->office_hours)
                            <div style="background: rgba(42,47,35,0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.12); border-radius: 1rem; padding: 1.25rem; max-width: 220px; display: none;" class="hidden md:block" id="hero-badge-desktop">
                                <div style="font-size: 10px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 0.25rem;">Hari Pelayanan</div>
                                <div style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: white; margin-bottom: 0.25rem;">Senin—Jumat</div>
                                <div style="font-size: 13px; color: rgba(255,255,255,0.8);">{{ $village->office_hours }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @media (min-width: 768px) {
            #hero-badge-desktop { display: block !important; }
        }
        @media (max-width: 639px) {
            .stat-divider-mobile { display: none !important; }
        }
        @media (min-width: 640px) {
            #galeri-grid { grid-template-columns: repeat(2, 1fr) !important; }
            #berita-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (min-width: 1024px) {
            #profil-grid { grid-template-columns: 1fr 380px !important; }
            #galeri-grid { grid-template-columns: repeat(3, 1fr) !important; }
            #berita-grid { grid-template-columns: repeat(4, 1fr) !important; }
            #lokasi-grid { grid-template-columns: 7fr 5fr !important; }
        }
    </style>

    {{-- ═══════════════════════════════════════
         STATISTICS — 3 numbers, thin dividers
         ═══════════════════════════════════════ --}}
    <section style="padding: 2.5rem 0; border-bottom: 1px solid var(--border);">
        <div style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0;" class="flex-col sm:flex-row">
                <div style="flex: 1; min-width: 180px; padding: 0.5rem 1.5rem;">
                    <div style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: var(--primary);">1.240</div>
                    <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted-fg); margin-top: 0.25rem;">Jiwa penduduk</div>
                </div>
                <div style="width: 1px; align-self: stretch; background-color: var(--border);" class="hidden md:block"></div>
                <div style="flex: 1; min-width: 180px; padding: 0.5rem 1.5rem;">
                    <div style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: var(--primary);">4</div>
                    <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted-fg); margin-top: 0.25rem;">Dusun / RW</div>
                </div>
                <div style="width: 1px; align-self: stretch; background-color: var(--border);" class="hidden md:block"></div>
                <div style="flex: 1; min-width: 180px; padding: 0.5rem 1.5rem;">
                    <div style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: var(--primary);">1928</div>
                    <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted-fg); margin-top: 0.25rem;">Tahun berdiri</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         PROFIL + KONTAK + PERANGKAT
         ═══════════════════════════════════════ --}}
    <section id="profil" class="scroll-mt-20" style="padding: 4rem 0 5rem;">
        <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
            <div id="profil-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">

                {{-- Left Column: Profile Text --}}
                <div class="card" style="padding: 2rem 2.5rem;">
                    <div class="eyebrow" style="margin-bottom: 1rem;">Profil desa</div>
                    <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; line-height: 1.2; margin-bottom: 1.25rem; color: var(--fg);">
                        Sebuah kampung yang tumbuh bersama warganya.
                    </h2>
                    <div style="font-size: 15px; line-height: 1.75; color: var(--muted-fg);">
                        @if($village->description && Str::length($village->description) > 80)
                            {!! nl2br(e($village->description)) !!}
                        @else
                            <p>Desa {{ $village->name }} terdiri dari empat dusun dengan kehidupan warga yang bertumpu pada pertanian, usaha rumahan, dan ruang-ruang komunal. Portal ini menjadi pintu informasi yang sederhana dan dekat bagi seluruh warga.</p>
                            <p style="font-size: 13px; font-style: italic; opacity: 0.7; margin-top: 1rem;">Data pada contoh template ini dapat disesuaikan oleh setiap desa.</p>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Contact + Officials (5 cols) --}}
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">

                    {{-- Contact Card --}}
                    <div class="card" style="padding: 1.75rem;">
                        <div class="eyebrow" style="margin-bottom: 1.25rem;">Informasi kontak</div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 14.5px;">
                            @if($village->address)
                                <div style="display: flex; gap: 1rem;">
                                    <span style="font-weight: 500; width: 72px; flex-shrink: 0; color: var(--muted-fg);">Alamat</span>
                                    <span style="font-weight: 500; color: var(--fg);">{{ $village->address }}</span>
                                </div>
                            @endif
                            @if($village->contact_phone)
                                <div style="display: flex; gap: 1rem;">
                                    <span style="font-weight: 500; width: 72px; flex-shrink: 0; color: var(--muted-fg);">Telepon</span>
                                    <span style="font-weight: 500; color: var(--fg);">{{ $village->contact_phone }}</span>
                                </div>
                            @endif
                            @if($village->contact_email)
                                <div style="display: flex; gap: 1rem;">
                                    <span style="font-weight: 500; width: 72px; flex-shrink: 0; color: var(--muted-fg);">Email</span>
                                    <span style="font-weight: 500; color: var(--fg);">{{ $village->contact_email }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Perangkat Card --}}
                    @if($village->officials->count() > 0)
                        <div id="perangkat" class="card scroll-mt-20" style="padding: 1.75rem;">
                            <div class="eyebrow" style="margin-bottom: 1.25rem;">Perangkat desa</div>
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                @foreach($village->officials as $official)
                                    <div style="display: flex; align-items: center; gap: 1rem; padding: 0.5rem; margin: -0.5rem; border-radius: 0.75rem; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='var(--muted)'" onmouseout="this.style.backgroundColor='transparent'">
                                        @if($official->photo_path)
                                            <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border" style="border-color: var(--border);">
                                        @else
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-base shrink-0" style="background-color: var(--muted); color: var(--fg); font-family: Outfit, sans-serif;">
                                                {{ strtoupper(mb_substr($official->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-[15px]" style="font-family: Outfit, sans-serif; color: var(--fg);">{{ $official->name }}</div>
                                            <div class="text-[12.5px] font-medium" style="color: var(--muted-fg);">{{ $official->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════
         LAYANAN (Services)
         ═══════════════════════════════════════ --}}
    @if($village->services->count() > 0)
        <section id="layanan" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div class="eyebrow" style="margin-bottom: 0.75rem;">Layanan warga</div>
                <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; margin-bottom: 2rem; color: var(--fg);">Administrasi satu pintu</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" style="align-items: start;">
                    @foreach($village->services as $service)
                        <div class="card transition-all duration-300 group flex flex-col" style="padding: 1.5rem; align-self: start; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-5 shrink-0" style="background-color: color-mix(in srgb, var(--primary) 12%, transparent); color: var(--primary);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="font-bold text-lg mb-3" style="font-family: Outfit, sans-serif;">{{ $service->name }}</h3>
                            @if($service->description)
                                <p class="text-[14px] leading-relaxed mb-6" style="color: var(--muted-fg);">{{ $service->description }}</p>
                            @endif
                            @if($service->requirements)
                                <div class="mt-auto pt-4 border-t" style="border-color: var(--border);">
                                    <details class="group/details">
                                        <summary class="cursor-pointer font-semibold inline-flex items-center justify-between w-full py-1 text-xs uppercase tracking-wider transition-colors select-none" style="color: var(--primary);">
                                            <span>Syarat & Ketentuan</span>
                                            <svg class="w-4 h-4 transition-transform duration-300 group-open/details:rotate-180 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </summary>
                                        <div class="mt-4 p-4 rounded-xl border space-y-2 text-[13px] leading-relaxed" style="background-color: color-mix(in srgb, var(--bg) 70%, transparent); border-color: var(--border); color: var(--fg);">
                                            @foreach(explode("\n", $service->requirements) as $reqLine)
                                                @if(trim($reqLine))
                                                    <div class="flex items-start gap-2.5">
                                                        <span class="inline-block w-1.5 h-1.5 rounded-full mt-2 shrink-0" style="background-color: var(--primary);"></span>
                                                        <span>{{ preg_replace('/^\d+\.\s*/', '', trim($reqLine)) }}</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </details>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         BERITA (News)
         ═══════════════════════════════════════ --}}
    @if($village->news->count() > 0)
        <section id="berita" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div class="eyebrow" style="margin-bottom: 0.75rem;">Kabar desa</div>
                <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; margin-bottom: 2rem; color: var(--fg);">Berita & pengumuman</h2>
                <div id="berita-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                    @foreach($village->news->take(4) as $news)
                        <article class="group flex flex-col">
                            @if($news->cover_image_path)
                                <div class="overflow-hidden rounded-xl mb-3 aspect-[4/3]" style="background-color: var(--muted);">
                                    <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @endif
                            <div class="text-[11px] font-bold uppercase tracking-wider mb-1.5" style="color: var(--muted-fg);">
                                {{ $news->published_at->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="font-bold text-[15px] leading-snug mb-1.5 line-clamp-2 transition-colors" style="font-family: Outfit, sans-serif;">
                                {{ $news->title }}
                            </h3>
                            <p class="text-[13px] line-clamp-2 mt-auto" style="color: var(--muted-fg);">
                                {{ Str::limit(strip_tags($news->content), 80) }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         GALERI — Grid 3×2 with caption pills
         ═══════════════════════════════════════ --}}
    @if($village->galleries->count() > 0)
        <section id="galeri" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Galeri desa</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Wajah dan keseharian</h2>
                    </div>
                    <div style="font-size: 13px; font-weight: 500; color: var(--muted-fg);">{{ $village->galleries->count() }} dokumentasi</div>
                </div>

                <div id="galeri-grid" style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                    @foreach($village->galleries->take(6) as $gallery)
                        <div style="position: relative; border-radius: 0.75rem; overflow: hidden; aspect-ratio: 4/3; background-color: var(--muted); cursor: pointer;" class="group">
                            <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Galeri' }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            @if($gallery->caption)
                                <div class="gallery-caption">{{ $gallery->caption }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         PETA / LOKASI — Map + Legend card
         ═══════════════════════════════════════ --}}
    @if($village->latitude && $village->longitude)
        <section id="lokasi" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div class="card" style="padding: 1.25rem;">
                    <div id="lokasi-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; align-items: stretch;">
                        
                        {{-- Map --}}
                        <div id="peta-desa" style="height: 380px; border-radius: 0.75rem; overflow: hidden; z-index: 10; border: 1px solid var(--border);"></div>
                        
                        {{-- Legend --}}
                        <div style="display: flex; flex-direction: column; justify-content: center; padding: 1rem 1.5rem;">
                            <div class="eyebrow" style="margin-bottom: 0.75rem;">Lokasi</div>
                            <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.75rem); font-weight: 700; margin-bottom: 1rem; color: var(--fg);">Temukan kami</h2>
                            <p style="font-size: 14.5px; line-height: 1.6; margin-bottom: 1.5rem; color: var(--muted-fg);">
                                Balai desa berada di jalur utama kampung dan mudah dijangkau dari pusat kecamatan.
                            </p>

                            @if($village->titikLokasis->count() > 0)
                                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--primary);"></div>
                                        <span style="font-size: 13.5px; font-weight: 500;">Balai / Kantor Desa</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--secondary);"></div>
                                        <span style="font-size: 13.5px; font-weight: 500;">Fasilitas Kesehatan</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 10px; height: 10px; border-radius: 50%; background-color: var(--accent);"></div>
                                        <span style="font-size: 13.5px; font-weight: 500;">Pendidikan</span>
                                    </div>
                                </div>
                            @endif

                            <a href="https://maps.google.com/?q={{ $village->latitude }},{{ $village->longitude }}" target="_blank" class="btn-ghost" style="text-decoration: none; display: inline-flex; width: fit-content;">
                                Buka petunjuk arah
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         FOOTER
         ═══════════════════════════════════════ --}}
    <footer style="margin-top: auto; padding: 2rem 0; border-top: 1px solid var(--border); background-color: var(--bg);">
        <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1.25rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo" style="width: 36px; height: 36px; border-radius: 50%; object-fit: contain; border: 1px solid var(--border);">
                    @else
                        <div style="width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; background-color: var(--primary); color: var(--primary-fg); font-family: Outfit, sans-serif;">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div style="font-family: Outfit, sans-serif; font-weight: 700; font-size: 14px; color: var(--fg);">Desa {{ $village->name }}</div>
                        <div style="font-size: 11.5px; color: var(--muted-fg);">&copy; {{ date('Y') }} Pemerintah Desa {{ $village->name }}</div>
                    </div>
                </div>
                <div style="display: flex; gap: 1.5rem; font-size: 12.5px; font-weight: 500;">
                    <a href="#profil" style="color: var(--muted-fg); text-decoration: none;">Profil</a>
                    <a href="#galeri" style="color: var(--muted-fg); text-decoration: none;">Galeri</a>
                    <a href="#lokasi" style="color: var(--muted-fg); text-decoration: none;">Lokasi</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════
         LEAFLET MAP SCRIPT
         ═══════════════════════════════════════ --}}
    @if($village->latitude && $village->longitude)
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const villageLat = {{ $village->latitude }};
                const villageLng = {{ $village->longitude }};

                const map = L.map('peta-desa', { zoomControl: false }).setView([villageLat, villageLng], 14);
                L.control.zoom({ position: 'bottomright' }).addTo(map);

                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
                    subdomains: 'abcd',
                    maxZoom: 20
                }).addTo(map);

                const colorPrimary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();
                const colorSecondary = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim();
                const colorAccent = getComputedStyle(document.documentElement).getPropertyValue('--accent').trim();
                const colorFg = getComputedStyle(document.documentElement).getPropertyValue('--fg').trim();

                // Village center marker
                L.circleMarker([villageLat, villageLng], {
                    radius: 11, fillColor: colorPrimary, color: '#fff', weight: 3, opacity: 1, fillOpacity: 1
                }).addTo(map).bindPopup('<div style="font-family:Figtree,sans-serif;font-weight:600;font-size:13px">Balai Desa {{ e($village->name) }}</div>');

                const titikLokasis = @json($village->titikLokasis);
                titikLokasis.forEach(function (titik) {
                    let mc = colorFg;
                    if (titik.kategori === 'kesehatan') mc = colorSecondary;
                    if (titik.kategori === 'pendidikan') mc = colorAccent;
                    if (titik.kategori === 'pemerintahan') mc = colorPrimary;

                    L.circleMarker([titik.latitude, titik.longitude], {
                        radius: 7, fillColor: mc, color: '#fff', weight: 2, opacity: 1, fillOpacity: 0.9
                    }).addTo(map).bindPopup('<div style="font-family:Figtree,sans-serif;font-size:12px"><strong>' + titik.nama_lokasi + '</strong><br><span style="color:#888">' + titik.kategori + '</span></div>');
                });

                @if($village->geojson_batas_wilayah)
                    try {
                        L.geoJSON(@json($village->geojson_batas_wilayah), {
                            style: { color: colorPrimary, weight: 2, opacity: 0.4, fillOpacity: 0.04 }
                        }).addTo(map);
                    } catch (e) { console.warn('GeoJSON error:', e); }
                @endif

                setTimeout(() => map.invalidateSize(), 400);
            });
        </script>
    @endif

</body>
</html>
