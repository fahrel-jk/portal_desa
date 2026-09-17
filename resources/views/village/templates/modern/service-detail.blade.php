@extends('village.templates.modern.layout', ['title' => $service->name])

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">
    {{-- Breadcrumb --}}
    <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--muted-fg); margin-bottom: 2rem;">
        <a href="{{ route('village.show', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Beranda</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('village.services', $village->slug) }}" style="color: var(--muted-fg); text-decoration: none;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--muted-fg)'">Layanan</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span style="color: var(--fg); font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;">{{ $service->name }}</span>
    </nav>

    <div class="card" style="padding: 2.5rem; margin-bottom: 4rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0" style="background-color: color-mix(in srgb, var(--primary) 12%, transparent); color: var(--primary);">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <div class="eyebrow" style="margin-bottom: 0.25rem;">Informasi Layanan</div>
                <h1 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 800; color: var(--fg); line-height: 1.2;">
                    {{ $service->name }}
                </h1>
            </div>
        </div>

        @if($service->description)
            <div style="font-size: 1.125rem; line-height: 1.8; color: var(--muted-fg); margin-bottom: 3rem; padding-bottom: 2.5rem; border-bottom: 1px dashed var(--border);">
                {{ $service->description }}
            </div>
        @endif

        @if($service->requirements)
            <div>
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Syarat & Ketentuan
                </h3>
                <div class="prose prose-blue max-w-none" style="color: var(--fg); line-height: 1.8;">
                    {!! nl2br(e($service->requirements)) !!}
                </div>
            </div>
        @else
            <div style="padding: 2rem; background-color: var(--muted); border-radius: 1rem; text-align: center; color: var(--muted-fg);">
                Tidak ada informasi persyaratan khusus yang dicantumkan untuk layanan ini.
            </div>
        @endif

        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border); display: flex; justify-content: center;">
            <a href="{{ route('village.services', $village->slug) }}" class="btn-ghost">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Layanan
            </a>
        </div>
    </div>
</div>
@endsection
