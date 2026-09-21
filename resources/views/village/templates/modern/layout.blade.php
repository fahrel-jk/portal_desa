<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <x-seo-meta 
        title="{{ $title ?? $village->name }} - Portal Desa" 
        description="{{ Str::limit($village->description ?: 'Portal resmi Desa ' . $village->name, 160) }}" 
        image="{{ $village->logo_path ? Storage::url($village->logo_path) : asset('images/logo.png') }}" 
    />
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            --bg: {{ $bg }}; --fg: {{ $fg }}; --card: {{ $card }}; --card-fg: {{ $card_fg }};
            --primary: {{ $primary }}; --primary-fg: {{ $primary_fg }}; --secondary: {{ $secondary }};
            --secondary-fg: {{ $secondary_fg }}; --muted: {{ $muted }}; --muted-fg: {{ $muted_fg }};
            --accent: {{ $accent }}; --accent-fg: {{ $accent_fg }}; --border: {{ $border }};
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Figtree', system-ui, sans-serif;
            background-color: var(--bg); color: var(--fg);
            line-height: 1.65; -webkit-font-smoothing: antialiased;
        }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; color: var(--fg); letter-spacing: -0.025em; line-height: 1.15; }
        
        .eyebrow {
            font-family: 'Figtree', sans-serif;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--primary);
        }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; background-color: var(--primary);
            color: var(--primary-fg); font-weight: 600; border-radius: 0.75rem; padding: 0.75rem 1.75rem;
            font-size: 0.9375rem; transition: all 0.2s; text-decoration: none; border: none;
        }
        .btn-primary:hover { filter: brightness(1.08); box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 30%, transparent); }
        .btn-ghost {
            display: inline-flex; align-items: center; justify-content: center; background-color: transparent;
            color: var(--fg); font-weight: 600; border-radius: 0.75rem; padding: 0.75rem 1.75rem;
            font-size: 0.9375rem; border: 1px solid var(--border); transition: all 0.2s; text-decoration: none;
        }
        .btn-ghost:hover { background-color: color-mix(in srgb, var(--muted) 40%, transparent); }
        
        .card { background-color: var(--card); border: 1px solid var(--border); border-radius: 1.25rem; }
        .navbar-pill {
            background: rgba(255, 255, 255, 0.78);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.85);
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 1.5rem;
            box-shadow: 0 16px 40px -12px rgba(24, 33, 27, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .page-header {
            text-align: center;
            padding: 3rem 1rem 4rem;
            margin-bottom: 2rem;
            border-radius: 1.5rem;
            background: linear-gradient(to bottom, color-mix(in srgb, var(--primary) 10%, transparent), transparent);
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen">
    @include('village.templates.modern.header')
    
    <main class="flex-grow pb-12">
        <div style="max-width: 1120px; margin: 0 auto; padding: 0 1rem;">
            @yield('content')
        </div>
    </main>

    @include('village.templates.modern.footer')
    
    @stack('scripts')
</body>
</html>
