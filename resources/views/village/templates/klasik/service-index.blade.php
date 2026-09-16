<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan Desa {{ $village->name }} — Portal Desa</title>
    <meta name="description" content="Daftar layanan administrasi Desa {{ $village->name }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $themeColor = $village->theme_color ?? 'default';
        $themeMap = [
            'default' => ['--background'=>'#FAF7F0','--foreground'=>'#1A1A1A','--deep'=>'#313F33','--primary'=>'#313F33','--primary-hover'=>'#263328','--primary-foreground'=>'#FFFFFF','--accent'=>'#BA704F','--accent-hover'=>'#A05B3D','--accent-foreground'=>'#FFFFFF','--surface'=>'#FFFFFF','--muted'=>'#E8E5DA','--muted-foreground'=>'#6B7280','--border'=>'#E5E2D5','--card'=>'#FFFFFF','--secondary'=>'#F3F0E6'],
        ];
        $vars = $themeMap[$themeColor] ?? $themeMap['default'];
    @endphp
    <style>
        :root { @foreach($vars as $k => $v) {{ $k }}: {{ $v }}; @endforeach }
        body { font-family: 'IBM Plex Sans', sans-serif; background-color: var(--background); color: var(--foreground); }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-background { background-color: var(--background); }
        .bg-surface { background-color: var(--surface); }
        .bg-primary { background-color: var(--primary); }
        .bg-accent { background-color: var(--accent); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-deep { background-color: var(--deep); }
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .border-border { border-color: var(--border); }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-surface border-b border-border sticky top-0 z-40 shadow-sm">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain drop-shadow-sm rounded">
                @else
                    <span class="rounded-sm border border-border bg-secondary text-primary grid size-10 place-items-center font-serif text-sm font-bold uppercase">{{ substr($village->name, 0, 2) }}</span>
                @endif
                <span>
                    <span class="block font-serif text-[15px] font-bold leading-none">{{ $village->name }}</span>
                    <span class="mt-1 block text-[10px] uppercase tracking-[0.14em] text-muted-foreground">Layanan Administrasi</span>
                </span>
            </a>
            <a href="{{ route('village.show', $village->slug) }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-accent transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mb-8">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Layanan Administrasi</p>
                <h1 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Layanan Desa {{ $village->name }}</h1>
                <p class="mt-3 text-base text-muted-foreground max-w-2xl">Daftar layanan administrasi yang tersedia di Desa {{ $village->name }}. Klik salah satu layanan untuk melihat persyaratan, alur, dan biaya.</p>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($services as $service)
                        <a href="{{ $service->slug ? route('village.service.show', [$village->slug, $service->slug]) : '#' }}"
                           class="group flex flex-col border border-border bg-card p-6 transition-all hover:border-primary/45 hover:shadow-md">
                            <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center mb-4 group-hover:bg-accent/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path>
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5"></path>
                                </svg>
                            </div>
                            <h3 class="font-serif text-lg font-bold group-hover:text-accent transition-colors">{{ $service->name }}</h3>
                            @if($service->description)
                                <p class="mt-2 text-sm leading-6 text-muted-foreground line-clamp-2">{{ $service->description }}</p>
                            @endif
                            <div class="mt-auto pt-4 flex flex-wrap gap-3 text-xs text-muted-foreground">
                                @if($service->estimated_time)
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $service->estimated_time }}
                                    </span>
                                @endif
                                @if($service->cost)
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                        {{ $service->cost }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-4 pt-3 border-t border-border">
                                <span class="text-xs font-semibold text-accent group-hover:underline">Lihat Detail →</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="border border-border bg-card rounded-lg p-12 text-center">
                    <p class="text-muted-foreground">Belum ada layanan yang tersedia.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-deep text-primary-foreground mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 text-center text-sm opacity-70">
            &copy; {{ date('Y') }} Desa {{ $village->name }}. Dibuat dengan Portal Desa.
        </div>
    </footer>
</body>
</html>
