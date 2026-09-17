@extends('village.templates.modern.layout', ['title' => $product->name])

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding-top: 2rem;">
    {{-- Breadcrumb --}}
    <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--muted-fg); margin-bottom: 2.5rem;">
        <a href="{{ route('village.show', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Beranda</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('village.products', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Produk</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span style="color: var(--fg); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{ $product->name }}</span>
    </nav>

    <div style="display: grid; grid-template-columns: 1fr; gap: 3rem; margin-bottom: 4rem;" class="md:grid-cols-2">
        {{-- Product Image --}}
        <div>
            <div class="card" style="padding: 0.5rem; border-radius: 1.5rem; position: sticky; top: 6rem;">
                <div style="border-radius: 1rem; overflow: hidden; aspect-ratio: 1/1; background-color: var(--muted);">
                    @if($product->image_path)
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--muted-fg);">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Product Details --}}
        <div style="display: flex; flex-direction: column;">
            <div style="margin-bottom: 2rem;">
                <div class="text-[12px] font-bold uppercase tracking-wider mb-2" style="color: var(--primary);">
                    {{ $product->category }}
                </div>
                <h1 style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; line-height: 1.15; color: var(--fg); margin-bottom: 1rem;">
                    {{ $product->name }}
                </h1>
                <div style="font-family: Outfit, sans-serif; font-size: 2rem; font-weight: 700; color: var(--primary); margin-bottom: 2rem;">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                
                @if($product->contact_whatsapp)
                    <div style="margin-bottom: 2.5rem; padding-bottom: 2.5rem; border-bottom: 1px solid var(--border);">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->contact_whatsapp) }}?text={{ urlencode('Halo, saya tertarik dengan produk ' . $product->name . ' yang ada di Portal Desa ' . $village->name . '.') }}" target="_blank" class="btn-primary" style="width: 100%; gap: 0.5rem; padding: 1rem; font-size: 1.125rem;">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.125-.34-.154-.913-.396-1.745-.965-1.115-.764-1.875-1.722-1.933-1.8-1.579-2.107-.156-3.238.455-3.847.114-.114.249-.142.341-.142.091 0 .182.001.261.004.093.003.218-.035.34.263.15.364.512 1.25.557 1.342.045.09.075.196.029.288-.046.091-.068.148-.114.24-.045.092-.095.197-.137.243-.047.051-.096.104-.046.191.05.086.223.368.477.596.326.294.6.381.685.426.086.046.136.042.187-.015.051-.057.218-.255.275-.342.057-.087.114-.073.193-.044.079.029.502.236.588.279.086.043.143.064.164.1.021.036.021.213-.123.618z" fill-rule="evenodd" clip-rule="evenodd"/><path d="M11.968 1.488C6.182 1.488 1.488 6.182 1.488 11.968c0 1.956.516 3.791 1.439 5.385l-1.439 5.259 5.378-1.408c1.543.882 3.315 1.378 5.102 1.378 5.786 0 10.48-4.694 10.48-10.48 0-5.786-4.694-10.48-10.48-10.48zm0 1.393c5.013 0 9.087 4.074 9.087 9.087 0 5.013-4.074 9.087-9.087 9.087-1.637 0-3.18-.432-4.502-1.196l-3.238.847.864-3.161C4.331 16.142 3.881 14.12 3.881 11.968c0-5.013 4.074-9.087 9.087-9.087z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                            Beli via WhatsApp
                        </a>
                    </div>
                @endif
                
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: var(--fg);">Deskripsi Produk</h3>
                <div style="font-size: 1rem; line-height: 1.8; color: var(--muted-fg);">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            
            {{-- Share / Back --}}
            <div style="margin-top: auto; padding-top: 2rem;">
                <a href="{{ route('village.products', $village->slug) }}" class="btn-ghost" style="width: 100%;">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if($relatedProducts->count() > 0)
<div style="margin-top: 6rem; padding-top: 4rem; border-top: 1px solid var(--border);">
    <div style="max-width: 1120px; margin: 0 auto;">
        <div class="eyebrow" style="margin-bottom: 0.75rem; text-align: center;">Katalog</div>
        <h2 style="font-family: Outfit, sans-serif; font-size: 2rem; font-weight: 700; margin-bottom: 2.5rem; text-align: center; color: var(--fg);">Produk Lainnya</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
            @foreach($relatedProducts as $related)
                <a href="{{ route('village.product.show', [$village->slug, $related->slug]) }}" class="group block no-underline">
                    <div class="card h-full flex flex-col overflow-hidden transition-all duration-300" style="padding: 0; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
                        <div class="aspect-square w-full relative overflow-hidden" style="background-color: var(--muted);">
                            @if($related->image_path)
                                <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                            <div class="absolute top-2 right-2 rounded-lg px-2.5 py-1 text-xs font-bold" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(8px); color: var(--fg); border: 1px solid rgba(255,255,255,0.5);">
                                Rp {{ number_format($related->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="text-[10px] font-bold uppercase tracking-wider mb-1 line-clamp-1" style="color: var(--primary);">{{ $related->category }}</div>
                                <h3 class="font-bold text-[14px] leading-snug mb-1 line-clamp-2" style="font-family: Outfit, sans-serif; color: var(--fg);">{{ $related->name }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
