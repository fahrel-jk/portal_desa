<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Desa — {{ $village->name }}</title>
    <meta name="description" content="Berita dan pengumuman terbaru dari Desa {{ $village->name }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --background: #FAF7F0; --foreground: #1A1A1A; --deep: #313F33;
            --primary: #313F33; --primary-hover: #263328; --primary-foreground: #FFFFFF;
            --accent: #BA704F; --accent-hover: #A05B3D; --accent-foreground: #FFFFFF;
            --surface: #FFFFFF; --muted: #E8E5DA; --muted-foreground: #6B7280;
            --border: #E5E2D5; --card: #FFFFFF; --secondary: #F3F0E6;
        }
        body { font-family: 'IBM Plex Sans', sans-serif; background-color: var(--background); color: var(--foreground); }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-background { background-color: var(--background); }
        .bg-deep { background-color: var(--deep); }
        .bg-surface { background-color: var(--surface); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .border-border { border-color: var(--border); }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

<div class="min-h-screen bg-background text-foreground flex flex-col">
    {{-- Header --}}
    <header class="bg-surface relative z-40 border-b border-border sticky top-0 shadow-sm">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain drop-shadow-sm rounded">
                @else
                    <span class="rounded-sm border border-primary/30 bg-primary/10 text-primary grid size-10 place-items-center font-serif text-sm font-bold uppercase">
                        {{ substr($village->name, 0, 2) }}
                    </span>
                @endif
                <span>
                    <span class="block font-serif text-[15px] font-bold leading-none">{{ $village->name }}</span>
                    <span class="mt-1 block text-[10px] uppercase tracking-[0.14em] text-muted-foreground">Kecamatan {{ $village->kecamatan }}</span>
                </span>
            </a>
            <a href="{{ route('village.show', $village->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-muted-foreground hover:text-accent transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Portal
            </a>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            {{-- Breadcrumb --}}
            <nav class="mb-6 flex items-center gap-2 text-xs text-muted-foreground">
                <a href="{{ route('village.show', $village->slug) }}" class="hover:text-accent transition-colors">{{ $village->name }}</a>
                <span>/</span>
                <span class="text-foreground font-medium">Semua Berita</span>
            </nav>

            <div class="mb-8">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Kabar Desa</p>
                <h1 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Berita & Pengumuman</h1>
            </div>

            @if($news->count() > 0)
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($news as $item)
                        <a href="{{ route('village.news.show', [$village->slug, $item->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                            @if($item->cover_image_path)
                                <img src="{{ Storage::url($item->cover_image_path) }}" alt="{{ $item->title }}" class="aspect-[16/10] w-full object-cover">
                            @else
                                <div class="aspect-[16/10] w-full bg-muted flex items-center justify-center">
                                    <span class="text-muted-foreground font-serif text-sm">Tidak ada gambar</span>
                                </div>
                            @endif
                            <div class="p-5">
                                <p class="text-[10px] font-medium uppercase tracking-[0.14em] text-muted-foreground">{{ $item->published_at ? $item->published_at->format('d F Y') : $item->created_at->format('d F Y') }}</p>
                                <h3 class="mt-2 font-serif text-lg font-bold leading-7 text-primary group-hover:text-accent transition-colors line-clamp-2">{{ $item->title }}</h3>
                                <p class="mt-2 text-sm text-muted-foreground line-clamp-2">{{ Str::limit(strip_tags($item->content), 120) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $news->links() }}
                </div>
            @else
                <div class="py-16 text-center">
                    <p class="text-muted-foreground font-serif">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-deep text-primary-foreground">
        <div class="mx-auto max-w-7xl px-4 py-6 text-center text-xs text-primary-foreground/60 sm:px-6">
            © {{ date('Y') }} Pemerintah Desa {{ $village->name }}. All rights reserved.
        </div>
    </footer>
</div>

</body>
</html>
