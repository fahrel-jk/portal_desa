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
    
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/carousel-mount.tsx', 'resources/js/faq-mount.tsx'])
    
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
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    @include('village.templates.modern.header')

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
         STATISTIK DEMOGRAFI
         ═══════════════════════════════════════ --}}
    @php
        $demographics = $village->demographics()->get()->groupBy('type');
    @endphp
    @if($demographics->count() > 0)
        <section id="statistik" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Data Kependudukan</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Statistik Penduduk Desa</h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($demographics as $type => $items)
                        <div class="card" style="padding: 1.75rem; border-color: var(--border);">
                            <h3 style="font-family: Outfit, sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 1.25rem; color: var(--fg); padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
                                {{ $type == 'gender' ? 'Jenis Kelamin' : ($type == 'age' ? 'Kelompok Usia' : ($type == 'religion' ? 'Agama' : ucfirst($type))) }}
                            </h3>
                            @php $total = $items->sum('count'); @endphp
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                @foreach($items as $item)
                                    @php $pct = $total > 0 ? round(($item->count / $total) * 100) : 0; @endphp
                                    <div>
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.375rem; font-size: 13.5px;">
                                            <span style="font-weight: 600; color: var(--fg);">{{ $item->label }}</span>
                                            <span style="font-weight: 500; color: var(--muted-fg);">{{ number_format($item->count, 0, ',', '.') }} <span style="opacity: 0.7;">({{ $pct }}%)</span></span>
                                        </div>
                                        <div style="width: 100%; height: 8px; background-color: var(--muted); border-radius: 9999px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ $pct }}%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 9999px; transition: width 0.6s ease;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid var(--border); text-align: right;">
                                <span style="font-size: 12px; font-weight: 600; color: var(--muted-fg);">Total: {{ number_format($total, 0, ',', '.') }} jiwa</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         LAPOR DESA (Pengaduan)
         ═══════════════════════════════════════ --}}
    <section id="lapor-desa" style="padding-bottom: 4rem;">
        <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
            <div style="background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 90%, black), var(--primary)); border-radius: 1.25rem; overflow: hidden; position: relative; padding: 2.5rem; display: flex; flex-direction: column; align-items: center; text-align: center; color: var(--primary-fg); box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                {{-- Decorative circles --}}
                <div style="position: absolute; top: -50%; left: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(40px);"></div>
                <div style="position: absolute; bottom: -50%; right: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.15); border-radius: 50%; filter: blur(40px);"></div>
                
                <div style="position: relative; z-index: 10;">
                    <div class="eyebrow" style="margin-bottom: 1rem; color: rgba(255,255,255,0.8); text-shadow: none;">Layanan Aspirasi</div>
                    <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.75rem, 4vw, 2.5rem); font-weight: 700; margin-bottom: 1rem; color: #ffffff;">Suara Anda Membangun Desa</h2>
                    <p style="font-size: 15px; line-height: 1.6; color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto 2rem;">Sampaikan pengaduan, kritik, saran, atau permohonan informasi kepada perangkat desa secara langsung dan transparan.</p>
                    <a href="{{ route('village.complaint.create', $village->slug) }}" class="btn-ghost" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-color: rgba(255,255,255,0.3); color: #fff;">
                        Buat Pengaduan
                    </a>
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
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Layanan warga</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Administrasi satu pintu</h2>
                    </div>
                    <a href="{{ route('village.services', $village->slug) }}" class="text-[13.5px] font-bold no-underline transition-colors flex items-center gap-1" style="color: var(--primary);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--primary)'">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" style="align-items: start;">
                    @foreach($village->services->take(6) as $service)
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
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Kabar desa</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Berita & pengumuman</h2>
                    </div>
                    <a href="{{ route('village.news', $village->slug) }}" class="text-[13.5px] font-bold no-underline transition-colors flex items-center gap-1" style="color: var(--primary);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--primary)'">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
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
         AGENDA (Events) & MINI KALENDER
         ═══════════════════════════════════════ --}}
    @php
        $upcomingAgendas = $village->agendas->where('event_date', '>=', now()->toDateString())->sortBy('event_date')->take(3);
        
        // Mini Calendar Logic (Current Month)
        $today = now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $startDayOfWeek = $startOfMonth->dayOfWeekIso; // 1 (Mon) - 7 (Sun)
        $daysInMonth = $endOfMonth->daysInMonth;
        
        // Get events for current month to show dots
        $monthEvents = $village->agendas->whereBetween('event_date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])->groupBy(function($event) {
            return \Carbon\Carbon::parse($event->event_date)->format('Y-m-d');
        });
    @endphp
    @if($upcomingAgendas->count() > 0 || $monthEvents->count() > 0)
        <section id="agenda" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Kegiatan</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Agenda Desa Terdekat</h2>
                    </div>
                    <a href="{{ route('village.agenda', $village->slug) }}" class="text-[13.5px] font-bold no-underline transition-colors flex items-center gap-1" style="color: var(--primary);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--primary)'">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                    
                    {{-- Left Column: Mini Calendar --}}
                    <div class="lg:col-span-5 xl:col-span-4 card" style="padding: 1.75rem; border-color: var(--border);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                            <h3 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg);">{{ $today->translatedFormat('F Y') }}</h3>
                            <a href="{{ route('village.agenda', $village->slug) }}" class="p-2 rounded-full hover:bg-muted text-muted-foreground transition-colors" title="Buka Kalender Penuh">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="m9 16 2 2 4-4"/></svg>
                            </a>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.25rem; text-align: center; margin-bottom: 0.75rem;">
                            @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                                <div style="font-size: 0.75rem; font-weight: 700; color: var(--muted-fg); text-transform: uppercase;">{{ $day }}</div>
                            @endforeach
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.25rem;">
                            {{-- Empty slots for start of month --}}
                            @for ($i = 1; $i < $startDayOfWeek; $i++)
                                <div style="aspect-ratio: 1; padding: 0.25rem;"></div>
                            @endfor
                            
                            {{-- Days --}}
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $dateStr = $today->format('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $isToday = $day === $today->day;
                                    $dayEvents = $monthEvents->get($dateStr, collect());
                                    $hasEvents = $dayEvents->count() > 0;
                                @endphp
                                <div style="aspect-ratio: 1; padding: 0.25rem; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; border-radius: 0.5rem; {{ $isToday ? 'background-color: var(--primary); color: var(--primary-fg); box-shadow: 0 4px 10px rgba(0,0,0,0.1);' : 'background-color: transparent; color: var(--fg);' }}">
                                    <span style="font-size: 0.875rem; font-weight: {{ $isToday ? '700' : '500' }};">{{ $day }}</span>
                                    
                                    {{-- Event Dots --}}
                                    @if($hasEvents && !$isToday)
                                        <div style="display: flex; gap: 2px; position: absolute; bottom: 4px;">
                                            @foreach($dayEvents->take(3) as $evt)
                                                <div style="width: 4px; height: 4px; border-radius: 50%; background-color: {{ $evt->category_color }};"></div>
                                            @endforeach
                                        </div>
                                    @elseif($hasEvents && $isToday)
                                        <div style="display: flex; gap: 2px; position: absolute; bottom: 4px;">
                                            @foreach($dayEvents->take(3) as $evt)
                                                <div style="width: 4px; height: 4px; border-radius: 50%; background-color: var(--primary-fg); opacity: 0.8;"></div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Right Column: Upcoming Agenda List --}}
                    <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-4">
                        @if($upcomingAgendas->count() > 0)
                            @foreach($upcomingAgendas as $agenda)
                                <div class="card p-4 sm:p-5 flex items-start gap-4 transition-all duration-300" style="border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateX(4px)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateX(0)'">
                                    <div class="flex-shrink-0 w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex flex-col items-center justify-center overflow-hidden border" style="background: rgba(255,255,255,0.5); border-color: var(--border); box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                        <div class="w-full text-center text-[9px] sm:text-[10px] font-bold uppercase py-0.5" style="background-color: {{ $agenda->category_color }}; color: #fff;">
                                            {{ $agenda->event_date->translatedFormat('M') }}
                                        </div>
                                        <div class="flex-grow flex items-center justify-center font-bold text-lg sm:text-xl" style="font-family: Outfit, sans-serif; color: var(--fg);">
                                            {{ $agenda->event_date->format('d') }}
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-block w-2 h-2 rounded-full" style="background-color: {{ $agenda->category_color }};"></span>
                                            <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider" style="color: var(--muted-fg);">{{ $agenda->category_label }}</span>
                                        </div>
                                        <h3 class="font-bold text-[14px] sm:text-[15px] leading-snug mb-2 line-clamp-1" style="font-family: Outfit, sans-serif; color: var(--fg);">{{ $agenda->title }}</h3>
                                        <div class="flex flex-col gap-1 text-[12px] sm:text-[13px]" style="color: var(--muted-fg);">
                                            @if($agenda->start_time)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    {{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} {{ $agenda->end_time ? '- ' . \Carbon\Carbon::parse($agenda->end_time)->format('H:i') : 'WIB' }}
                                                </div>
                                            @endif
                                            @if($agenda->location)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                                    <span class="line-clamp-1">{{ $agenda->location }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card p-8 flex flex-col items-center justify-center text-center border-dashed" style="border-color: var(--border); height: 100%;">
                                <div style="width: 48px; height: 48px; border-radius: 50%; background: var(--muted); display: flex; items-center; justify-content: center; margin-bottom: 1rem; color: var(--muted-fg);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                </div>
                                <h3 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); margin-bottom: 0.5rem;">Tidak Ada Agenda Mendatang</h3>
                                <p style="font-size: 0.875rem; color: var(--muted-fg);">Belum ada jadwal kegiatan dalam waktu dekat.</p>
                            </div>
                        @endif
                    </div>
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

                {{-- 3D Carousel Container (React) --}}
                <div 
                    id="react-gallery-root" 
                    data-cards="{{ json_encode($village->galleries->take(12)->map(function($g) {
                        return [
                            'image_path' => Storage::url($g->image_path),
                            'caption' => $g->caption
                        ];
                    })->toArray()) }}"
                ></div>
            </div>
        </section>
    @endif

    {{-- ═══════════════════════════════════════
         PRODUK UMKM
         ═══════════════════════════════════════ --}}
    @if($village->products->where('is_active', true)->count() > 0)
        <section id="produk" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
                <div style="display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 0.75rem; margin-bottom: 2rem;">
                    <div>
                        <div class="eyebrow" style="margin-bottom: 0.75rem;">Potensi Desa</div>
                        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Produk Unggulan UMKM</h2>
                    </div>
                    <a href="{{ route('village.products', $village->slug) }}" class="text-[13.5px] font-bold no-underline transition-colors flex items-center gap-1" style="color: var(--primary);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--primary)'">
                        Lihat Semua
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-5">
                    @foreach($village->products->where('is_active', true)->take(6) as $product)
                        <a href="{{ route('village.product.show', [$village->slug, $product->slug]) }}" 
                           class="group relative block overflow-hidden rounded-[24px] h-64 sm:h-72 lg:h-80 {{ ($loop->iteration == 1 || $loop->iteration == 6) ? 'md:col-span-2' : 'md:col-span-1' }}">
                            
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                </div>
                            @endif
                            
                            {{-- Liquid Glass Pill --}}
                            <div class="absolute bottom-3 left-3 right-3 sm:bottom-4 sm:left-4 sm:right-4">
                                <div class="rounded-[16px] px-6 py-4 bg-white/70 backdrop-blur-md border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.12)] flex items-center justify-between gap-4 transition-colors duration-300 group-hover:bg-white/85">
                                    <div class="truncate">
                                        <h3 class="font-normal text-gray-900 text-[14.5px] sm:text-[15px] truncate" style="font-family: Outfit, sans-serif;">{{ $product->name }}</h3>
                                    </div>
                                    <div class="shrink-0 text-[13.5px] sm:text-[14.5px] font-semibold" style="color: var(--primary);">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </a>
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
         FAQ / TANYA JAWAB
         ═══════════════════════════════════════ --}}
    @if($village->faqs->count() > 0)
        <section id="faq" class="scroll-mt-20" style="padding-bottom: 4rem;">
            <div style="max-width: 800px; margin: 0 auto; padding: 0 1rem;">
                <div style="text-align: center; margin-bottom: 2.5rem;">
                    <div class="eyebrow" style="margin-bottom: 0.75rem;">FAQ</div>
                    <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 1.875rem); font-weight: 700; color: var(--fg);">Tanya Jawab Seputar Desa</h2>
                    <p style="color: var(--muted-fg); margin-top: 0.5rem; font-size: 15px;">Pertanyaan umum yang sering diajukan warga</p>
                </div>
                <div id="faq-react-root" data-faqs="{{ json_encode($village->faqs) }}"></div>
            </div>
        </section>
    @endif

    @include('village.templates.modern.footer')

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

    {{-- ═══════════════════════════════════════
         BACK TO TOP — Floating glass pill
         ═══════════════════════════════════════ --}}
    <div
        x-data="{ showTop: false }"
        x-init="window.addEventListener('scroll', () => { showTop = window.scrollY > 400 })"
    >
        <button
            x-show="showTop"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            x-cloak
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 50; width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; background: rgba(255,255,255,0.8); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.6); box-shadow: 0 4px 20px rgba(0,0,0,0.08); color: var(--fg); cursor: pointer; transition: all 0.2s;"
            onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='var(--primary-fg)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.12)'"
            onmouseout="this.style.backgroundColor='rgba(255,255,255,0.8)'; this.style.color='var(--fg)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'"
            aria-label="Kembali ke atas"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
        </button>
    </div>

</body>
</html>
