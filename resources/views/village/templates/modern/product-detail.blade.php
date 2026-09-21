@extends('village.templates.modern.layout', ['title' => $product->name])

@section('content')
<div style="max-width: 1120px; margin: 0 auto; padding: 2rem 1rem 5rem;">
    {{-- Breadcrumb --}}
    <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8125rem; font-weight: 600; color: var(--muted-fg); margin-bottom: 2.5rem;">
        <a href="{{ route('village.show', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">{{ $village->name }}</a>
        <span style="opacity: 0.5;">/</span>
        <a href="{{ route('village.products', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Produk</a>
        <span style="opacity: 0.5;">/</span>
        <span style="color: var(--fg); font-weight: 700; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $product->name }}</span>
    </nav>

    {{-- Product Main Section: 2 Columns (Image left, info right on desktop) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start mb-16">
        
        {{-- Product Image Container (Constrained size max 480px, clean rounded card) --}}
        <div style="width: 100%; display: flex; justify-content: center;">
            <div class="card" style="padding: 0; border-radius: 1.5rem; overflow: hidden; border: 1px solid var(--border); background-color: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.06); width: 100%; max-width: 480px; aspect-ratio: 1/1; position: relative;">
                @if($product->image_path)
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" class="hover:scale-105">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; background-color: #f8fafc;">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product Information Column --}}
        <div style="display: flex; flex-direction: column; justify-content: flex-start; padding-top: 0.5rem;">
            {{-- Category Eyebrow --}}
            <div class="eyebrow" style="margin-bottom: 0.875rem; letter-spacing: 0.15em; font-weight: 700; color: var(--primary);">
                {{ $product->category ?: 'PRODUK DESA' }}
            </div>

            {{-- Product Title --}}
            <h1 style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 800; line-height: 1.25; color: var(--fg); margin-bottom: 1.25rem;">
                {{ $product->name }}
            </h1>

            {{-- Price Tag --}}
            <div style="font-family: Outfit, sans-serif; font-size: clamp(1.75rem, 3vw, 2.25rem); font-weight: 800; color: var(--primary); margin-bottom: 2rem;">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </div>

            {{-- Divider & Description Section --}}
            <div style="border-top: 1px solid var(--border); padding-top: 2rem; margin-bottom: 2.5rem;">
                <h2 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--fg); margin-bottom: 1rem;">
                    Deskripsi Produk
                </h2>
                <div style="font-size: 1rem; line-height: 1.8; color: var(--muted-fg);">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            {{-- Action Buttons --}}
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; margin-top: 0.5rem;">
                @if($product->contact_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->contact_whatsapp) }}?text={{ urlencode('Halo, saya tertarik dengan produk ' . $product->name . ' yang ada di Portal Desa ' . $village->name . '.') }}" target="_blank" class="btn-primary" style="padding: 1rem 2rem; border-radius: 9999px; gap: 0.625rem; text-decoration: none; font-size: 1rem; font-weight: 600;">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.125-.34-.154-.913-.396-1.745-.965-1.115-.764-1.875-1.722-1.933-1.8-1.579-2.107-.156-3.238.455-3.847.114-.114.249-.142.341-.142.091 0 .182.001.261.004.093.003.218-.035.34.263.15.364.512 1.25.557 1.342.045.09.075.196.029.288-.046.091-.068.148-.114.24-.045.092-.095.197-.137.243-.047.051-.096.104-.046.191.05.086.223.368.477.596.326.294.6.381.685.426.086.046.136.042.187-.015.051-.057.218-.255.275-.342.057-.087.114-.073.193-.044.079.029.502.236.588.279.086.043.143.064.164.1.021.036.021.213-.123.618z" fill-rule="evenodd" clip-rule="evenodd"/><path d="M11.968 1.488C6.182 1.488 1.488 6.182 1.488 11.968c0 1.956.516 3.791 1.439 5.385l-1.439 5.259 5.378-1.408c1.543.882 3.315 1.378 5.102 1.378 5.786 0 10.48-4.694 10.48-10.48 0-5.786-4.694-10.48-10.48-10.48zm0 1.393c5.013 0 9.087 4.074 9.087 9.087 0 5.013-4.074 9.087-9.087 9.087-1.637 0-3.18-.432-4.502-1.196l-3.238.847.864-3.161C4.331 16.142 3.881 14.12 3.881 11.968c0-5.013 4.074-9.087 9.087-9.087z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                        Hubungi Penjual
                    </a>
                @elseif($village->contact_phone)
                    <a href="tel:{{ $village->contact_phone }}" class="btn-primary" style="padding: 1rem 2rem; border-radius: 9999px; gap: 0.625rem; text-decoration: none; font-size: 1rem; font-weight: 600;">
                        Hubungi Desa
                    </a>
                @endif

                <a href="{{ route('village.products', $village->slug) }}" class="btn-ghost" style="padding: 1rem 2rem; border-radius: 9999px; text-decoration: none; font-size: 1rem; font-weight: 600;">
                    Lihat Produk Lainnya
                </a>
            </div>
        </div>
    </div>

    {{-- Related Products Section --}}
    @if($relatedProducts->count() > 0)
    <div style="border-top: 1px solid var(--border); padding-top: 3.5rem; margin-top: 3.5rem;">
        <div class="eyebrow" style="margin-bottom: 0.5rem; letter-spacing: 0.15em;">KATALOG DESA</div>
        <h2 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 700; color: var(--fg); margin-bottom: 2rem;">
            Produk UMKM desa lainnya
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
            @foreach($relatedProducts as $related)
                <a href="{{ route('village.product.show', [$village->slug, $related->slug]) }}" class="group block no-underline" style="height: 100%;">
                    <div class="card flex flex-col overflow-hidden transition-all duration-300" style="padding: 0; border-radius: 1.25rem; border: 1px solid var(--border); background-color: #ffffff; height: 100%; box-shadow: 0 2px 10px rgba(0,0,0,0.03);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 24px rgba(0,0,0,0.08)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.03)'">
                        <div style="aspect-ratio: 4/3; width: 100%; position: relative; overflow: hidden; background-color: #f1f5f9;">
                            @if($related->image_path)
                                <img src="{{ Storage::url($related->image_path) }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" class="group-hover:scale-105">
                            @endif
                        </div>
                        <div style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; flex-grow: 1;">
                            <div>
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--primary); margin-bottom: 0.5rem;">
                                    {{ $related->category ?: 'PRODUK DESA' }}
                                </div>
                                <h3 style="font-family: Outfit, sans-serif; font-size: 1.0625rem; font-weight: 700; line-height: 1.35; color: var(--fg); margin-bottom: 0.75rem;" class="line-clamp-2 group-hover:text-[var(--primary)] transition-colors">
                                    {{ $related->name }}
                                </h3>
                            </div>
                            <div style="margin-top: 0.875rem; display: flex; align-items: center; justify-content: space-between;">
                                <span style="font-size: 0.9375rem; font-weight: 700; color: var(--primary);">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
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
    </div>
    @endif
</div>
@endsection
