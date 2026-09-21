@extends('village.templates.modern.layout', ['title' => 'Produk UMKM'])

@section('content')
<div class="page-header">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Potensi Desa</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Produk Unggulan UMKM</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Jelajahi berbagai produk lokal berkualitas karya masyarakat Desa {{ $village->name }}.</p>
</div>

@if($products->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.75rem; margin-bottom: 4rem;">
        @foreach($products as $product)
            <a href="{{ route('village.product.show', [$village->slug, $product->slug]) }}" class="group block no-underline" style="height: 100%;">
                <div class="card flex flex-col overflow-hidden transition-all duration-300" style="padding: 0; border-radius: 1.25rem; border: 1px solid var(--border); background-color: #ffffff; height: 100%; box-shadow: 0 2px 10px rgba(0,0,0,0.03);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.03)'">
                    <div style="aspect-ratio: 4/3; width: 100%; position: relative; overflow: hidden; background-color: #f1f5f9;">
                        @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" class="group-hover:scale-105">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1;">
                        <div>
                            <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary); margin-bottom: 0.5rem;">
                                {{ $product->category ?: 'PRODUK DESA' }}
                            </div>
                            <h3 style="font-family: Outfit, sans-serif; font-size: 1.0625rem; font-weight: 700; line-height: 1.35; color: var(--fg); margin-bottom: 0.75rem;" class="line-clamp-2 group-hover:text-[var(--primary)] transition-colors">
                                {{ $product->name }}
                            </h3>
                        </div>
                        <div style="margin-top: 0.875rem; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.9375rem; font-weight: 700; color: var(--primary);">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span style="font-size: 0.8125rem; font-weight: 600; color: var(--fg);" class="group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Detail →
                            </span>
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
