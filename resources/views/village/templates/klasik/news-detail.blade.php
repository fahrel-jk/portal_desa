<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $news->title }} — {{ $village->name }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($news->content), 160) }}">
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
        .bg-primary { background-color: var(--primary); }
        .bg-accent { background-color: var(--accent); }
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

    <main class="flex-grow">
        <article class="mx-auto max-w-4xl px-4 py-10 sm:px-6 md:py-14">
            {{-- Breadcrumb --}}
            <nav class="mb-6 flex items-center gap-2 text-xs text-muted-foreground">
                <a href="{{ route('village.show', $village->slug) }}" class="hover:text-accent transition-colors">{{ $village->name }}</a>
                <span>/</span>
                <a href="{{ route('village.news', $village->slug) }}" class="hover:text-accent transition-colors">Berita</a>
                <span>/</span>
                <span class="text-foreground font-medium truncate max-w-[200px]">{{ $news->title }}</span>
            </nav>

            {{-- Cover Image --}}
            @if($news->cover_image_path)
                <div class="mb-8 overflow-hidden rounded-md border border-border">
                    <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="w-full aspect-[21/9] object-cover">
                </div>
            @endif

            {{-- Meta --}}
            <div class="mb-4 flex flex-wrap items-center gap-4 text-xs text-muted-foreground">
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    {{ $news->published_at ? $news->published_at->format('d F Y') : $news->created_at->format('d F Y') }}
                </span>
                @if($news->author)
                <span class="flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    {{ $news->author->name }}
                </span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="font-serif text-3xl font-bold leading-tight sm:text-4xl mb-8">{{ $news->title }}</h1>

            {{-- Content --}}
            <div class="prose prose-lg max-w-none text-foreground leading-relaxed">
                {!! nl2br(e($news->content)) !!}
            </div>

            {{-- Back link --}}
            <div class="mt-12 pt-6 border-t border-border">
                <a href="{{ route('village.news', $village->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-accent hover:text-accent-hover transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Lihat Semua Berita
                </a>
            </div>
        </article>

        {{-- Related News --}}
        @if($relatedNews->count() > 0)
        <section class="border-t border-border bg-secondary py-14">
            <div class="mx-auto max-w-4xl px-4 sm:px-6">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-3"><span class="h-px w-7 bg-accent"></span>Berita Lainnya</p>
                <h2 class="font-serif text-2xl font-bold mb-6">Kabar terbaru dari desa</h2>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($relatedNews as $related)
                        <a href="{{ route('village.news.show', [$village->slug, $related->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                            @if($related->cover_image_path)
                                <img src="{{ Storage::url($related->cover_image_path) }}" alt="{{ $related->title }}" class="aspect-[16/10] w-full object-cover">
                            @else
                                <div class="aspect-[16/10] w-full bg-muted flex items-center justify-center">
                                    <span class="text-muted-foreground font-serif text-sm">Tidak ada gambar</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <p class="text-[10px] font-medium uppercase tracking-[0.14em] text-muted-foreground">{{ $related->published_at ? $related->published_at->format('d F Y') : $related->created_at->format('d F Y') }}</p>
                                <h3 class="mt-2 font-serif text-base font-bold leading-snug text-primary group-hover:text-accent transition-colors line-clamp-2">{{ $related->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
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
