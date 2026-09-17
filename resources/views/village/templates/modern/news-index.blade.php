@extends('village.templates.modern.layout', ['title' => 'Berita Desa'])

@section('content')
<div class="page-header">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Kabar Desa</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Berita & Pengumuman</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Ikuti perkembangan terbaru dan informasi resmi dari Pemerintah Desa {{ $village->name }}.</p>
</div>

@if($news->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        @foreach($news as $item)
            <a href="{{ route('village.news.show', [$village->slug, $item->slug]) }}" class="group flex flex-col no-underline">
                <div class="card flex flex-col h-full overflow-hidden transition-all duration-300" style="padding: 0; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
                    @if($item->cover_image_path)
                        <div class="aspect-[4/3] w-full overflow-hidden" style="background-color: var(--muted);">
                            <img src="{{ Storage::url($item->cover_image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-[4/3] w-full flex items-center justify-center text-gray-400" style="background-color: var(--muted);">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                        </div>
                    @endif
                    <div class="p-5 flex-grow flex flex-col">
                        <div class="text-[11px] font-bold uppercase tracking-wider mb-2" style="color: var(--muted-fg);">
                            {{ $item->published_at->translatedFormat('d M Y') }}
                        </div>
                        <h3 class="font-bold text-[16px] leading-snug mb-2 line-clamp-2" style="font-family: Outfit, sans-serif; color: var(--fg);">
                            {{ $item->title }}
                        </h3>
                        <p class="text-[13.5px] line-clamp-3 mt-auto" style="color: var(--muted-fg);">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    
    <div style="display: flex; justify-content: center; margin-top: 2rem;">
        {{ $news->links() }}
    </div>
@else
    <div class="card" style="padding: 4rem 2rem; text-align: center;">
        <div style="margin-bottom: 1rem; color: var(--muted-fg);">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
        <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--fg);">Belum ada berita</h3>
        <p style="color: var(--muted-fg);">Pemerintah desa belum mempublikasikan berita apapun.</p>
    </div>
@endif
@endsection
