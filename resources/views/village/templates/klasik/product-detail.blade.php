<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} — Produk UMKM {{ $village->name }}</title>
    <meta name="description" content="{{ Str::limit($product->description ?? 'Produk UMKM dari Desa ' . $village->name, 160) }}">
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
        .text-accent-foreground { color: var(--accent-foreground); }
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
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 md:py-14">
            {{-- Breadcrumb --}}
            <nav class="mb-8 flex items-center gap-2 text-xs text-muted-foreground">
                <a href="{{ route('village.show', $village->slug) }}" class="hover:text-accent transition-colors">{{ $village->name }}</a>
                <span>/</span>
                <a href="{{ route('village.products', $village->slug) }}" class="hover:text-accent transition-colors">Produk</a>
                <span>/</span>
                <span class="text-foreground font-medium truncate max-w-[200px]">{{ $product->name }}</span>
            </nav>

            {{-- Product Detail --}}
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:items-start">
                {{-- Product Image --}}
                <div class="overflow-hidden rounded-md border border-border bg-card">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full aspect-square object-cover">
                    @else
                        <div class="w-full aspect-square bg-muted flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/30"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div>
                    @if($product->category)
                        <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.14em] text-muted-foreground mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                            {{ $product->category }}
                        </p>
                    @endif

                    <h1 class="font-serif text-3xl font-bold leading-tight sm:text-4xl mb-4">{{ $product->name }}</h1>

                    @if($product->price)
                        <p class="text-3xl font-bold text-accent mb-6">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    @endif

                    @if($product->description)
                        <div class="mb-8 pt-6 border-t border-border">
                            <h2 class="font-serif text-lg font-bold mb-3">Deskripsi Produk</h2>
                            <div class="text-sm leading-7 text-muted-foreground">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    {{-- Contact Button --}}
                    <div class="flex flex-wrap gap-3">
                        @if($product->contact_whatsapp)
                            <a href="https://wa.me/{{ $product->contact_whatsapp }}?text={{ urlencode('Halo, saya tertarik dengan produk "' . $product->name . '" dari Desa ' . $village->name) }}" 
                               target="_blank"
                               class="inline-flex min-h-12 items-center justify-center gap-2.5 rounded-md text-sm font-semibold transition-colors bg-primary text-primary-foreground hover:bg-primary-hover px-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Hubungi Penjual
                            </a>
                        @elseif($village->contact_phone)
                            <a href="tel:{{ $village->contact_phone }}"
                               class="inline-flex min-h-12 items-center justify-center gap-2.5 rounded-md text-sm font-semibold transition-colors bg-primary text-primary-foreground hover:bg-primary-hover px-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg>
                                Hubungi Desa
                            </a>
                        @endif
                        <a href="{{ route('village.products', $village->slug) }}"
                           class="inline-flex min-h-12 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted px-6">
                            Lihat Produk Lainnya
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($relatedProducts->count() > 0)
        <section class="border-t border-border bg-secondary py-14">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-3"><span class="h-px w-7 bg-accent"></span>Produk Lainnya</p>
                <h2 class="font-serif text-2xl font-bold mb-6">Produk UMKM desa lainnya</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('village.product.show', [$village->slug, $related->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                            @if($related->image_path)
                                <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->name }}" class="aspect-[4/3] w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="aspect-[4/3] w-full bg-muted flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/40"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-serif text-base font-bold text-primary group-hover:text-accent transition-colors line-clamp-1">{{ $related->name }}</h3>
                                @if($related->price)
                                    <p class="mt-2 font-bold text-accent">Rp{{ number_format($related->price, 0, ',', '.') }}</p>
                                @endif
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
