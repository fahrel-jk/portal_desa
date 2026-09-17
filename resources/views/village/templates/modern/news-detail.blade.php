@extends('village.templates.modern.layout', ['title' => $news->title])

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">
    {{-- Breadcrumb --}}
    <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--muted-fg); margin-bottom: 2rem;">
        <a href="{{ route('village.show', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Beranda</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('village.news', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Berita</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span style="color: var(--fg); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{ $news->title }}</span>
    </nav>

    {{-- Title & Meta --}}
    <div style="margin-bottom: 2.5rem; text-align: center;">
        <div style="display: inline-flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; font-size: 0.875rem; font-weight: 600; color: var(--muted-fg); text-transform: uppercase; letter-spacing: 0.05em;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg class="w-4 h-4" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $news->published_at ? $news->published_at->translatedFormat('d F Y') : $news->created_at->translatedFormat('d F Y') }}
            </div>
            @if($news->author)
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="w-4 h-4" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $news->author->name }}
                </div>
            @endif
        </div>
        <h1 style="font-family: Outfit, sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; line-height: 1.1; color: var(--fg);">
            {{ $news->title }}
        </h1>
    </div>

    {{-- Cover Image --}}
    @if($news->cover_image_path)
        <div class="card" style="padding: 0.5rem; border-radius: 1.5rem; margin-bottom: 3rem;">
            <div style="border-radius: 1rem; overflow: hidden; aspect-ratio: 21/9; background-color: var(--muted);">
                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
        </div>
    @endif

    {{-- Content --}}
    <div style="font-size: 1.125rem; line-height: 1.8; color: var(--fg); margin-bottom: 4rem;">
        {!! nl2br(e($news->content)) !!}
    </div>

    {{-- Share / Back --}}
    <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 2rem; border-top: 1px solid var(--border);">
        <a href="{{ route('village.news', $village->slug) }}" class="btn-ghost">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Indeks
        </a>
    </div>
</div>

{{-- Related News --}}
@if($relatedNews->count() > 0)
<div style="margin-top: 6rem; padding-top: 4rem; border-top: 1px solid var(--border);">
    <div style="max-width: 1120px; margin: 0 auto;">
        <div class="eyebrow" style="margin-bottom: 0.75rem; text-align: center;">Kabar Lainnya</div>
        <h2 style="font-family: Outfit, sans-serif; font-size: 2rem; font-weight: 700; margin-bottom: 2.5rem; text-align: center; color: var(--fg);">Berita Terkait</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($relatedNews as $related)
                <a href="{{ route('village.news.show', [$village->slug, $related->slug]) }}" class="group flex flex-col no-underline">
                    <div class="card flex flex-col h-full overflow-hidden transition-all duration-300" style="padding: 0; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='var(--border)'; this.style.transform='translateY(0)'">
                        @if($related->cover_image_path)
                            <div class="aspect-[16/9] w-full overflow-hidden" style="background-color: var(--muted);">
                                <img src="{{ Storage::url($related->cover_image_path) }}" alt="{{ $related->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @endif
                        <div class="p-5 flex-grow flex flex-col">
                            <div class="text-[11px] font-bold uppercase tracking-wider mb-2" style="color: var(--muted-fg);">
                                {{ $related->published_at ? $related->published_at->translatedFormat('d M Y') : $related->created_at->translatedFormat('d M Y') }}
                            </div>
                            <h3 class="font-bold text-[15px] leading-snug line-clamp-2" style="font-family: Outfit, sans-serif; color: var(--fg);">
                                {{ $related->title }}
                            </h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
