<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produk UMKM — {{ $village->name }}</title>
    <meta name="description" content="Produk UMKM unggulan dari Desa {{ $village->name }}">
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
                <span class="text-foreground font-medium">Semua Produk UMKM</span>
            </nav>

            <div class="mb-8">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Beli Dari Desa</p>
                <h1 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Produk UMKM Desa</h1>
                <p class="mt-2 text-sm text-muted-foreground max-w-xl">Layanan yang disediakan untuk promosi produk UMKM desa sehingga mampu meningkatkan perekonomian masyarakat desa.</p>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($products as $product)
                        <a href="{{ route('village.product.show', [$village->slug, $product->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                            @if($product->image_path)
                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="aspect-[4/3] w-full bg-muted flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/40"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                            @endif
                            <div class="p-5">
                                <h3 class="font-serif text-lg font-bold text-primary group-hover:text-accent transition-colors">{{ $product->name }}</h3>
                                @if($product->category)
                                    <p class="mt-1 text-xs text-muted-foreground">{{ $product->category }}</p>
                                @endif
                                @if($product->price)
                                    <p class="mt-3 font-bold text-accent text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="py-16 text-center">
                    <p class="text-muted-foreground font-serif">Belum ada produk UMKM yang tersedia.</p>
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
