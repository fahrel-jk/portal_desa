@extends('village.templates.modern.layout', ['title' => 'Produk UMKM'])

@section('content')
<div class="page-header">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Potensi Desa</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Produk Unggulan UMKM</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Jelajahi berbagai produk lokal berkualitas karya masyarakat Desa {{ $village->name }}.</p>
</div>

@if($products->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        @foreach($products as $product)
            <a href="{{ route('village.product.show', [$village->slug, $product->slug]) }}" class="group block no-underline">
                <div class="card h-full flex flex-col overflow-hidden transition-all duration-300" style="padding: 0; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
                    <div class="aspect-square w-full relative overflow-hidden" style="background-color: var(--muted);">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 rounded-xl px-3 py-1.5 text-[13px] font-bold shadow-sm" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); color: var(--fg); border: 1px solid rgba(255,255,255,0.5);">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="text-[11px] font-bold uppercase tracking-wider mb-1.5 line-clamp-1" style="color: var(--primary);">{{ $product->category }}</div>
                            <h3 class="font-bold text-[16px] leading-snug mb-2 line-clamp-2" style="font-family: Outfit, sans-serif; color: var(--fg);">{{ $product->name }}</h3>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    
    <div style="display: flex; justify-content: center; margin-top: 2rem;">
        {{ $products->links() }}
    </div>
@else
    <div class="card" style="padding: 4rem 2rem; text-align: center;">
        <div style="margin-bottom: 1rem; color: var(--muted-fg);">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.999 2.999 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.999 2.999 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
        </div>
        <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--fg);">Belum ada produk</h3>
        <p style="color: var(--muted-fg);">Pemerintah desa belum menginput data produk UMKM.</p>
    </div>
@endif
@endsection
