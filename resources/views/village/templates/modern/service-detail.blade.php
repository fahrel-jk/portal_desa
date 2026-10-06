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
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-9 h-9 object-contain">
                @else
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                @endif
            </div>
            <div>
                <div class="eyebrow" style="margin-bottom: 0.25rem;">Informasi Layanan</div>
                <h1 style="font-family: Outfit, sans-serif; font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 800; color: var(--fg); line-height: 1.2;">
                    {{ $service->name }}
                </h1>
            </div>
        </div>

        @if($service->description)
            <div style="font-size: 1.125rem; line-height: 1.8; color: var(--muted-fg); margin-bottom: 2.5rem;">
                {{ $service->description }}
            </div>
        @endif

        {{-- Info Cards --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 3rem; padding-bottom: 3rem; border-bottom: 1px dashed var(--border);">
            <div style="border: 1px solid var(--border); border-radius: 1rem; padding: 1.25rem; background-color: color-mix(in srgb, var(--bg) 50%, transparent);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg class="w-4 h-4" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted-fg);">Estimasi Waktu</span>
                </div>
                <div style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--fg);">{{ $service->estimated_time ?? 'Bervariasi' }}</div>
            </div>
            
            <div style="border: 1px solid var(--border); border-radius: 1rem; padding: 1.25rem; background-color: color-mix(in srgb, var(--bg) 50%, transparent);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg class="w-4 h-4" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted-fg);">Biaya</span>
                </div>
                <div style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--fg);">{{ $service->cost ?? 'Gratis' }}</div>
            </div>

            <div style="border: 1px solid var(--border); border-radius: 1rem; padding: 1.25rem; background-color: color-mix(in srgb, var(--bg) 50%, transparent);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg class="w-4 h-4" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted-fg);">Status</span>
                </div>
                <div style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; color: #16a34a;">Tersedia</div>
            </div>
        </div>

        @if($service->requirements)
            <div style="margin-bottom: 3rem;">
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="w-5 h-5" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Syarat & Ketentuan
                </h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach(explode("\n", $service->requirements) as $reqLine)
                        @if(trim($reqLine))
                            <div style="display: flex; align-items: flex-start; gap: 0.75rem; padding: 1rem; border: 1px solid var(--border); border-radius: 0.75rem; background-color: var(--card);">
                                <div style="width: 1.5rem; height: 1.5rem; border-radius: 50%; background-color: color-mix(in srgb, var(--primary) 15%, transparent); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 0.125rem;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                                <span style="font-size: 0.9375rem; line-height: 1.6; color: var(--fg);">{{ preg_replace('/^\d+\.\s*/', '', trim($reqLine)) }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <div style="padding: 2rem; background-color: var(--muted); border-radius: 1rem; text-align: center; color: var(--muted-fg); margin-bottom: 3rem;">
                Tidak ada informasi persyaratan khusus yang dicantumkan untuk layanan ini.
            </div>
        @endif

        {{-- Alur Proses --}}
        @if($service->process_steps)
            <div style="margin-bottom: 3rem;">
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="w-5 h-5" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Alur Proses
                </h3>
                <div style="padding: 1.5rem; border: 1px solid var(--border); border-radius: 1rem; background-color: color-mix(in srgb, var(--bg) 30%, transparent);">
                    <div style="position: relative;">
                        @foreach(explode("\n", $service->process_steps) as $index => $step)
                            @if(trim($step))
                                <div style="display: flex; gap: 1rem; {{ !$loop->last ? 'padding-bottom: 2rem;' : '' }}">
                                    <div style="display: flex; flex-direction: column; align-items: center;">
                                        <div style="width: 2.5rem; height: 2.5rem; border-radius: 50%; background-color: var(--primary); color: var(--primary-fg); display: flex; align-items: center; justify-content: center; font-weight: 700; font-family: Outfit, sans-serif; flex-shrink: 0;">
                                            {{ $index + 1 }}
                                        </div>
                                        @if(!$loop->last)
                                            <div style="width: 2px; flex-grow: 1; background-color: var(--border); margin-top: 0.5rem;"></div>
                                        @endif
                                    </div>
                                    <div style="padding-top: 0.375rem;">
                                        <p style="font-size: 0.9375rem; font-weight: 500; color: var(--fg); line-height: 1.6;">{{ preg_replace('/^\d+\.\s*/', '', trim($step)) }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        {{-- Ajukan Layanan --}}
        <div style="padding: 2.5rem; background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 90%, black), var(--primary)); border-radius: 1.25rem; text-align: center; color: var(--primary-fg); box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <h3 style="font-family: Outfit, sans-serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.75rem; color: #ffffff;">Ingin Mengajukan Layanan Ini?</h3>
            <p style="font-size: 0.9375rem; opacity: 0.9; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">Hubungi perangkat Desa {{ $village->name }} untuk memulai proses pengajuan layanan {{ $service->name }}.</p>
            <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-ghost" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-color: rgba(255,255,255,0.3); color: #fff;">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m22 2-7 20-4-9-9-4Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M22 2 11 13"/></svg>
                Hubungi Kami untuk Mengajukan
            </a>
        </div>

        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border); display: flex; justify-content: center;">
            <a href="{{ route('village.services', $village->slug) }}" class="btn-ghost">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Layanan
            </a>
        </div>
    </div>
</div>
@endsection
