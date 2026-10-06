@extends('village.templates.modern.layout', ['title' => 'Layanan Warga'])

@section('content')
<div class="page-header">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Administrasi & Layanan</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Layanan Desa Terpadu</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Informasi lengkap seputar persyaratan dan prosedur layanan administrasi kependudukan di Desa {{ $village->name }}.</p>
</div>

@if($services->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; margin-bottom: 4rem;">
        @foreach($services as $service)
            <div class="card transition-all duration-300 group flex flex-col h-full" style="padding: 1.5rem; border-color: var(--border);" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background-color: color-mix(in srgb, var(--primary) 12%, transparent); color: var(--primary);">
                        @if($village->logo_path)
                            <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-8 h-8 object-contain">
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                    </div>
                    <h3 class="font-bold text-lg leading-tight" style="font-family: Outfit, sans-serif; color: var(--fg);">{{ $service->name }}</h3>
                </div>
                
                @if($service->description)
                    <p class="text-[14.5px] leading-relaxed mb-6" style="color: var(--muted-fg);">{{ $service->description }}</p>
                @endif
                
                <div class="mt-auto pt-4 border-t" style="border-color: var(--border);">
                    @if($service->slug)
                    <a href="{{ route('village.service.show', [$village->slug, $service->slug]) }}" class="inline-flex items-center gap-2 font-bold text-[13.5px] transition-colors no-underline" style="color: var(--primary);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--primary)'">
                        Lihat Persyaratan Lengkap
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @else
                    <span class="inline-flex items-center gap-2 font-bold text-[13.5px]" style="color: var(--muted-fg);">
                        Layanan di Balai Desa
                    </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card" style="padding: 4rem 2rem; text-align: center; margin-bottom: 4rem;">
        <div style="margin-bottom: 1rem; color: var(--muted-fg);">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        </div>
        <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--fg);">Belum ada informasi layanan</h3>
        <p style="color: var(--muted-fg);">Pemerintah desa belum menginput informasi layanan administrasi.</p>
    </div>
@endif

@endsection
