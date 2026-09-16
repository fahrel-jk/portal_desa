<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $service->name }} — Layanan Desa {{ $village->name }}</title>
    <meta name="description" content="{{ Str::limit($service->description, 160) }}">
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
        .bg-primary-hover:hover { background-color: var(--primary-hover); }
        .bg-accent { background-color: var(--accent); }
        .bg-accent-hover:hover { background-color: var(--accent-hover); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-deep { background-color: var(--deep); }
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-accent-foreground { color: var(--accent-foreground); }
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
                    <span class="mt-1 block text-[10px] uppercase tracking-[0.14em] text-muted-foreground">Detail Layanan</span>
                </span>
            </a>
            <a href="{{ route('village.services', $village->slug) }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-accent transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Semua Layanan
            </a>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-muted-foreground mb-6">
                <a href="{{ route('village.show', $village->slug) }}" class="hover:text-accent transition-colors">Beranda</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <a href="{{ route('village.services', $village->slug) }}" class="hover:text-accent transition-colors">Layanan</a>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                <span class="text-foreground font-medium">{{ $service->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Title --}}
                    <div>
                        <h1 class="font-serif text-3xl font-bold sm:text-4xl">{{ $service->name }}</h1>
                        @if($service->description)
                            <p class="mt-4 text-base leading-7 text-muted-foreground">{{ $service->description }}</p>
                        @endif
                    </div>

                    {{-- Info Cards --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="border border-border bg-card p-5 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Estimasi Waktu</span>
                            </div>
                            <p class="font-bold text-lg">{{ $service->estimated_time ?? 'Bervariasi' }}</p>
                        </div>
                        <div class="border border-border bg-card p-5 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Biaya</span>
                            </div>
                            <p class="font-bold text-lg">{{ $service->cost ?? 'Gratis' }}</p>
                        </div>
                        <div class="border border-border bg-card p-5 rounded-lg">
                            <div class="flex items-center gap-2 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Status</span>
                            </div>
                            <p class="font-bold text-lg text-green-600">Tersedia</p>
                        </div>
                    </div>

                    {{-- Requirements --}}
                    @if($service->requirements)
                    <div class="border border-border bg-card rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary">
                            <h2 class="font-serif text-xl font-bold">Syarat & Ketentuan</h2>
                        </div>
                        <div class="p-6 space-y-3">
                            @foreach(explode("\n", $service->requirements) as $reqLine)
                                @if(trim($reqLine))
                                    <div class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center shrink-0 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-accent"><polyline points="20 6 9 17 4 12"/></svg>
                                        </div>
                                        <span class="text-sm leading-relaxed">{{ preg_replace('/^\d+\.\s*/', '', trim($reqLine)) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Process Steps --}}
                    @if($service->process_steps)
                    <div class="border border-border bg-card rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-border bg-secondary">
                            <h2 class="font-serif text-xl font-bold">Alur Proses</h2>
                        </div>
                        <div class="p-6">
                            <div class="relative">
                                @foreach(explode("\n", $service->process_steps) as $index => $step)
                                    @if(trim($step))
                                        <div class="flex gap-4 {{ !$loop->last ? 'pb-8' : '' }}">
                                            {{-- Timeline --}}
                                            <div class="flex flex-col items-center">
                                                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-primary-foreground font-bold text-sm shrink-0">
                                                    {{ $index + 1 }}
                                                </div>
                                                @if(!$loop->last)
                                                    <div class="w-0.5 flex-1 bg-border mt-2"></div>
                                                @endif
                                            </div>
                                            {{-- Content --}}
                                            <div class="flex-1 pt-2">
                                                <p class="text-sm leading-relaxed font-medium">{{ preg_replace('/^\d+\.\s*/', '', trim($step)) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- CTA Button --}}
                    <div class="border border-border bg-primary rounded-lg p-8 text-center">
                        <h3 class="font-serif text-xl font-bold text-primary-foreground mb-2">Ingin Mengajukan Layanan Ini?</h3>
                        <p class="text-primary-foreground opacity-80 text-sm mb-6">Hubungi perangkat Desa {{ $village->name }} untuk memulai proses pengajuan layanan {{ $service->name }}.</p>
                        <a href="{{ route('desa.request-akses.create', $village->slug) }}"
                           class="inline-flex items-center justify-center gap-2 bg-accent text-accent-foreground font-bold py-3 px-8 rounded-lg transition-colors shadow-lg hover:bg-accent-hover text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                            Hubungi Kami untuk Mengajukan
                        </a>
                    </div>
                </div>

                {{-- Sidebar: Other Services --}}
                <div>
                    <div class="border border-border bg-card rounded-lg overflow-hidden sticky top-[90px]">
                        <div class="px-5 py-4 border-b border-border bg-secondary">
                            <h3 class="font-serif text-base font-bold">Layanan Lainnya</h3>
                        </div>
                        @if($otherServices->count() > 0)
                            <div class="divide-y divide-border">
                                @foreach($otherServices as $other)
                                    <a href="{{ $other->slug ? route('village.service.show', [$village->slug, $other->slug]) : '#' }}"
                                       class="block px-5 py-4 hover:bg-secondary transition-colors group">
                                        <h4 class="font-bold text-sm group-hover:text-accent transition-colors">{{ $other->name }}</h4>
                                        @if($other->cost)
                                            <span class="text-xs text-muted-foreground">{{ $other->cost }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="px-5 py-6 text-center text-sm text-muted-foreground">
                                Tidak ada layanan lain.
                            </div>
                        @endif
                        <div class="p-4 border-t border-border">
                            <a href="{{ route('village.services', $village->slug) }}" class="text-xs font-semibold text-accent hover:underline">← Lihat Semua Layanan</a>
                        </div>
                    </div>
                </div>
            </div>
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
