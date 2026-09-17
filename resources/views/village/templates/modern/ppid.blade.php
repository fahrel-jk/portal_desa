@extends('village.templates.modern.layout', ['title' => 'PPID - Informasi Publik'])

@section('content')
<div class="page-header" style="margin-bottom: 2.5rem;">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Keterbukaan Informasi</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">PPID Desa</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Pejabat Pengelola Informasi dan Dokumentasi (PPID) Pemerintah Desa {{ $village->name }}.</p>
    
    <div style="margin-top: 2rem;">
        <a href="{{ route('village.ppid.request', $village->slug) }}" class="btn-primary" style="font-size: 1rem; padding: 0.875rem 2rem;">
            Buat Permohonan Informasi
        </a>
    </div>
</div>

<div class="card" style="padding: 1.5rem; margin-bottom: 4rem;">
    {{-- Filter --}}
    @if($categories->count() > 0)
        <div style="margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 0.5rem; align-items: center; border-bottom: 1px solid var(--border); padding-bottom: 1.5rem;">
            <span style="font-size: 0.875rem; font-weight: 700; color: var(--fg); margin-right: 0.5rem;">Filter Kategori:</span>
            <a href="{{ route('village.ppid', $village->slug) }}" class="btn-ghost" style="padding: 0.4rem 1rem; font-size: 0.8125rem; {{ !request('category') ? 'background-color: var(--primary); color: #fff; border-color: var(--primary);' : '' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('village.ppid', [$village->slug, 'category' => $cat]) }}" class="btn-ghost" style="padding: 0.4rem 1rem; font-size: 0.8125rem; {{ request('category') == $cat ? 'background-color: var(--primary); color: #fff; border-color: var(--primary);' : '' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- Documents List --}}
    @if($documents->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($documents as $doc)
                <div style="display: flex; flex-direction: column; md:flex-row; justify-content: space-between; align-items: flex-start; padding: 1.25rem; border-radius: 0.75rem; background-color: var(--muted); border: 1px solid transparent; transition: border-color 0.2s;" onmouseover="this.style.borderColor='var(--border)'" onmouseout="this.style.borderColor='transparent'">
                    <div style="margin-bottom: 1rem; md:margin-bottom: 0;">
                        <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                            <span style="font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; padding: 0.25rem 0.6rem; border-radius: 9999px; background-color: color-mix(in srgb, var(--primary) 15%, transparent); color: var(--primary);">
                                {{ $doc->category }}
                            </span>
                        </div>
                        <h3 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); margin-bottom: 0.25rem;">
                            {{ $doc->title }}
                        </h3>
                        @if($doc->description)
                            <p style="font-size: 0.875rem; color: var(--muted-fg);">{{ $doc->description }}</p>
                        @endif
                        <div style="font-size: 0.75rem; color: var(--muted-fg); margin-top: 0.5rem;">
                            Diperbarui: {{ $doc->updated_at->translatedFormat('d M Y') }}
                        </div>
                    </div>
                    
                    <a href="{{ route('village.ppid.download', [$village->slug, $doc->id]) }}" class="btn-ghost shrink-0" style="padding: 0.5rem 1rem; font-size: 0.875rem; gap: 0.5rem;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh
                    </a>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $documents->withQueryString()->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 3rem 1rem;">
            <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
            <p style="color: var(--muted-fg);">Belum ada dokumen publik yang tersedia.</p>
        </div>
    @endif
</div>
@endsection
