@extends('village.templates.modern.layout', ['title' => 'Profil Desa — ' . $village->name])

@push('styles')
@if($village->latitude && $village->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endif
<style>
    /* ==========================================================================
       PROFIL DESA — CSS murni.
       Semua spacing/padding/gap ditulis di sini, TIDAK bergantung pada utility
       Tailwind, jadi tetap rapi walaupun class Tailwind tidak ter-compile.
       Class lama (.profil-hero, .profil-card, .info-row, .eyebrow) dipertahankan
       supaya selector animasi/tema di layout tetap kena.
       ========================================================================== */

    .pf {
        --pf-gap: 1.5rem;
        --pf-pad: 1.25rem;
        --pf-top: 6.5rem; /* jarak sticky dari atas layar; naikkan kalau navbar menutupi sidebar */
        display: flex;
        flex-direction: column;
        gap: 2rem;
        width: 100%;
    }
    @media (min-width: 640px)  { .pf { --pf-pad: 1.75rem; } }
    @media (min-width: 1024px) { .pf { --pf-pad: 2rem; --pf-gap: 2rem; gap: 2.5rem; } }

    .pf, .pf *, .pf *::before, .pf *::after { box-sizing: border-box; }

    /* reset margin bawaan dengan specificity nol, supaya class di bawah selalu menang */
    :where(.pf) :is(h1, h2, h3, h4, p, blockquote, ul, ol, figure) { margin: 0; padding: 0; }
    :where(.pf) :is(ul, ol) { list-style: none; }

    /* ---------- Kartu dasar ---------- */
    .profil-hero {
        background: linear-gradient(135deg, color-mix(in srgb, var(--primary) 12%, white), color-mix(in srgb, var(--accent) 8%, white));
        border: 1px solid var(--border);
    }
    .profil-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 1.5rem;
    }
    .pf-card { padding: var(--pf-pad); min-width: 0; }

    /* ---------- Eyebrow: hanya atur spacing, gaya font tetap dari layout ---------- */
    .pf .eyebrow { display: block; margin-bottom: .5rem; line-height: 1.3; }

    /* ---------- Judul section (ikon + judul + subjudul) ---------- */
    .pf-head {
        display: flex;
        align-items: center;
        gap: .875rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .pf-ico {
        width: 2.5rem; height: 2.5rem;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 14px;
        background: color-mix(in srgb, var(--primary) 12%, transparent);
        color: var(--primary);
    }
    .pf-ico svg { width: 1.25rem; height: 1.25rem; }
    .pf-h2 {
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: clamp(1.25rem, 2vw, 1.5rem);
        line-height: 1.2;
        letter-spacing: -0.01em;
        color: var(--fg);
    }
    .pf-sub { display: block; margin-top: .25rem; font-size: .75rem; font-weight: 500; line-height: 1.4; color: var(--muted-fg); }

    /* ---------- HERO ---------- */
    .pf-hero {
        position: relative;
        overflow: hidden;
        padding: 2rem 1.25rem;
        border-radius: 24px;
        text-align: center;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
    }
    @media (min-width: 640px)  { .pf-hero { padding: 2.5rem 2rem; } }
    @media (min-width: 1024px) { .pf-hero { padding: 3rem 2.5rem; } }
    .pf-hero-inner { position: relative; z-index: 1; max-width: 42rem; margin: 0 auto; }

    .pf-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        margin-bottom: 1rem;
        padding: .5rem 1rem;
        border-radius: 9999px;
        font-size: 11px; font-weight: 700; line-height: 1.2;
        letter-spacing: .15em; text-transform: uppercase;
        color: var(--primary);
        background: color-mix(in srgb, var(--primary) 14%, white);
        border: 1px solid color-mix(in srgb, var(--primary) 22%, transparent);
    }
    .pf-badge-dot { width: .5rem; height: .5rem; border-radius: 9999px; background: var(--primary); }

    .pf-title {
        margin-bottom: .75rem;
        font-family: 'Outfit', sans-serif;
        font-weight: 800;
        font-size: clamp(2rem, 5vw, 3.25rem);
        line-height: 1.15;
        letter-spacing: -0.01em;
        color: var(--fg);
    }
    .pf-lead {
        max-width: 40rem;
        margin: 0 auto 1.5rem;
        font-size: clamp(1rem, 1.6vw, 1.125rem);
        font-weight: 500;
        line-height: 1.75;
        color: var(--muted-fg);
    }
    .pf-chips { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: .75rem; }
    .pf-chip {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .5rem 1rem;
        border-radius: 9999px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, .8);
        -webkit-backdrop-filter: blur(4px); backdrop-filter: blur(4px);
        font-size: .8125rem; font-weight: 600; line-height: 1.3;
        color: var(--fg);
    }
    .pf-chip svg { width: 1rem; height: 1rem; flex-shrink: 0; color: var(--primary); }

    /* ---------- Grid ---------- */
    .pf-row { display: grid; grid-template-columns: minmax(0, 1fr); gap: var(--pf-gap); }
    .pf-stack { display: flex; flex-direction: column; gap: var(--pf-gap); min-width: 0; }
    @media (min-width: 1024px) {
        .pf-row--vm   { grid-template-columns: repeat(12, minmax(0, 1fr)); align-items: stretch; }
        .pf-row--main { grid-template-columns: repeat(12, minmax(0, 1fr)); align-items: start; }
        .pf-c4  { grid-column: span 4; }
        .pf-c5  { grid-column: span 5; }
        .pf-c7  { grid-column: span 7; }
        .pf-c8  { grid-column: span 8; }
        .pf-c12 { grid-column: span 12; }
    }

    /* ---------- VISI ---------- */
    .pf-visi {
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        padding-left: calc(var(--pf-pad) + .75rem);
        background: linear-gradient(145deg, color-mix(in srgb, var(--primary) 6%, white), var(--card));
    }
    /* aksen kiri: bar lurus di dalam kartu, tidak memotong isi dan tidak melengkung */
    .pf-visi::before {
        content: "";
        position: absolute;
        left: 0; top: 1.5rem; bottom: 1.5rem;
        width: 5px;
        border-radius: 0 4px 4px 0;
        background: var(--primary);
    }
    .pf-visi-body { flex: 1; }
    .pf-quote {
        font-size: clamp(1.0625rem, 1.6vw, 1.25rem);
        font-weight: 600;
        font-style: italic;
        line-height: 1.7;
        color: var(--fg);
    }
    .pf-visi-foot {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
        font-size: .75rem; font-weight: 600; line-height: 1.5;
        color: var(--muted-fg);
    }

    /* ---------- MISI ---------- */
    .pf-misi li {
        display: flex; align-items: flex-start; gap: .875rem;
        padding: .875rem 0;
        border-bottom: 1px dashed var(--border);
    }
    .pf-misi li:first-child { padding-top: 0; }
    .pf-misi li:last-child  { padding-bottom: 0; border-bottom: 0; }
    .pf-num {
        width: 2.25rem; height: 2.25rem;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px;
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: .875rem;
        background: color-mix(in srgb, var(--primary) 12%, transparent);
        color: var(--primary);
    }
    .pf-misi p {
        flex: 1; min-width: 0;
        padding-top: .3rem;
        font-size: .9375rem; font-weight: 500; line-height: 1.7;
        color: var(--fg);
        overflow-wrap: anywhere;
    }

    /* ---------- TENTANG & SEJARAH ---------- */
    .pf-sections > * + * {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed var(--border);
    }
    .pf-text { font-size: .9375rem; font-weight: 400; line-height: 1.8; color: var(--fg); overflow-wrap: anywhere; }

    /* ---------- PERANGKAT DESA ---------- */
    .pf-officials {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(11.5rem, 1fr));
        gap: 1rem;
    }
    @media (min-width: 640px) { .pf-officials { gap: 1.25rem; } }
    .pf-official {
        display: flex; flex-direction: column; align-items: center;
        min-width: 0;
        padding: 1.25rem 1rem;
        text-align: center;
        border: 1px solid var(--border);
        border-radius: 18px;
        background: color-mix(in srgb, var(--bg) 40%, white);
        transition: box-shadow .2s ease;
    }
    .pf-official:hover { box-shadow: 0 6px 18px rgba(0, 0, 0, .06); }
    .pf-avatar {
        width: 6rem; height: 6rem;
        flex-shrink: 0;
        margin-bottom: .875rem;
        padding: 4px;
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 18px;
        background: color-mix(in srgb, var(--primary) 6%, white);
    }
    .pf-avatar img, .pf-avatar-ph { width: 100%; height: 100%; border-radius: 14px; }
    .pf-avatar img { display: block; object-fit: cover; object-position: top center; }
    .pf-avatar-ph {
        display: flex; align-items: center; justify-content: center;
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.75rem;
        background: color-mix(in srgb, var(--primary) 12%, transparent);
        color: var(--primary);
    }
    .pf-name {
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1rem;
        line-height: 1.3; letter-spacing: -0.01em;
        color: var(--fg);
        overflow-wrap: anywhere;
    }
    .pf-role {
        display: inline-block; max-width: 100%;
        margin-top: .625rem;
        padding: .25rem .75rem;
        border-radius: 9999px;
        font-size: .75rem; font-weight: 600; line-height: 1.4;
        text-wrap: balance;
        background: color-mix(in srgb, var(--primary) 10%, transparent);
        color: var(--primary);
    }
    .pf-empty {
        padding: 1.5rem;
        text-align: center;
        font-size: .875rem;
        border: 1px dashed var(--border);
        border-radius: 16px;
        color: var(--muted-fg);
    }

    /* ---------- BAGAN ---------- */
    .pf-bagan { padding: .5rem; overflow: auto; border: 1px solid var(--border); border-radius: 16px; background: var(--bg); }
    .pf-bagan img { display: block; width: 100%; height: auto; border-radius: 12px; cursor: zoom-in; }
    .pf-bagan img.is-zoomed { width: auto; max-width: none; cursor: zoom-out; }
    .pf-hint { margin-top: .75rem; text-align: center; font-size: .75rem; color: var(--muted-fg); }

    /* ---------- DEMOGRAFI ---------- */
    .pf-demo {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(16rem, 1fr));
        gap: 1.25rem;
        align-items: start;
    }
    .pf-demo-panel {
        min-width: 0;
        padding: 1.25rem;
        border: 1px solid var(--border);
        border-radius: 16px;
        background: color-mix(in srgb, var(--bg) 40%, white);
    }
    .pf-demo-panel--wide { grid-column: 1 / -1; }
    .pf-demo-title {
        margin-bottom: 1rem;
        padding-bottom: .625rem;
        border-bottom: 1px solid var(--border);
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: .75rem;
        letter-spacing: .08em; text-transform: uppercase; line-height: 1.3;
        color: var(--fg);
    }
    .pf-bars { display: flex; flex-direction: column; gap: .875rem; }
    .pf-bar-top {
        display: flex; align-items: baseline; justify-content: space-between; gap: .75rem;
        margin-bottom: .375rem;
        font-size: .8125rem; font-weight: 600; line-height: 1.4;
        color: var(--fg);
    }
    .pf-bar-top .pf-pct { color: var(--muted-fg); }
    .pf-bar-top > span:last-child { white-space: nowrap; }
    .pf-track { height: .5rem; overflow: hidden; border-radius: 9999px; background: var(--muted); }
    .pf-fill { height: 100%; border-radius: 9999px; background: linear-gradient(90deg, var(--primary), var(--accent)); transition: width .5s ease; }

    /* ---------- SIDEBAR (sticky: tidak ikut ter-scroll bersama konten kiri) ---------- */
    .pf-side { display: flex; flex-direction: column; gap: 1.25rem; min-width: 0; }
    @media (min-width: 1024px) {
        .pf-side {
            position: sticky;
            top: var(--pf-top);
            height: calc(100vh - var(--pf-top) - 1.25rem);
            height: calc(100dvh - var(--pf-top) - 1.25rem);
            overflow-y: auto;              /* cadangan: kalau layar sangat pendek, sidebar scroll sendiri */
            scrollbar-width: none;
        }
        .pf-side::-webkit-scrollbar { display: none; }
        .pf-card--info { flex: none; }
        .pf-mapcard { flex: 1 1 0; height: auto; min-height: 15rem; max-height: 36rem; }
    }

    /* Kartu informasi (ringkas supaya sidebar + peta muat dalam satu layar) */
    .pf-card--info { padding: 1.25rem 1.375rem; min-width: 0; }
    .pf-side-title {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        margin-bottom: .25rem;
        padding-bottom: .875rem;
        border-bottom: 1px solid var(--border);
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.125rem;
        line-height: 1.3; letter-spacing: -0.01em;
        color: var(--fg);
    }
    .pf-dot { width: .625rem; height: .625rem; flex-shrink: 0; border-radius: 9999px; background: var(--primary); }

    .info-row {
        display: flex; align-items: center; gap: .75rem;
        padding: .625rem 0;
        border-bottom: 1px dashed var(--border);
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .pf-ico--sm { width: 2.25rem; height: 2.25rem; border-radius: 12px; }
    .pf-ico--sm svg { width: 1.125rem; height: 1.125rem; }
    .info-body { flex: 1; min-width: 0; }
    .info-pair { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .75rem; }
    .pf .info-row .eyebrow { margin-bottom: .125rem; }
    .info-val { display: block; font-size: .875rem; font-weight: 600; line-height: 1.4; color: var(--fg); overflow-wrap: anywhere; }
    .info-val--strong { font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1rem; }
    a.info-val { text-decoration: none; }
    a.info-val:hover { text-decoration: underline; }

    /* Kartu peta: peta memenuhi seluruh kartu (gaya "Peta Lokasi Desa"), tinggi mengisi sisa layar */
    .pf-mapcard {
        position: relative;
        isolation: isolate;        /* z-index internal Leaflet tidak bocor menimpa navbar */
        overflow: hidden;
        padding: 0;
        height: 20rem;             /* mobile/tablet */
        min-height: 15rem;
    }
    .pf-map { position: absolute; inset: 0; width: 100%; height: 100%; }

    .pf-map-chip {
        position: absolute; z-index: 1000;
        display: inline-flex; align-items: center; gap: .375rem;
        padding: .4375rem .875rem;
        border-radius: 9999px;
        background: rgba(255, 255, 255, .92);
        -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, .14);
        font-size: .75rem; font-weight: 700; line-height: 1.2;
        text-decoration: none;
    }
    .pf-map-chip svg { width: .875rem; height: .875rem; flex-shrink: 0; }
    .pf-map-chip--label { left: .875rem; bottom: .875rem; color: var(--fg); }
    .pf-map-chip--label svg { color: var(--primary); }
    .pf-map-chip--link  { right: .875rem; top: .875rem; color: var(--primary); }
    .pf-map-chip--link:hover { text-decoration: underline; }

    /* kontrol zoom di kiri-atas, tombol membulat seperti referensi */
    .pf-mapcard .leaflet-control-zoom { border: 0 !important; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, .16); }
    .pf-mapcard .leaflet-control-zoom a { width: 2.25rem; height: 2.25rem; line-height: 2.25rem; font-size: 1.25rem; color: var(--fg); }
    .pf-pin { background: none; border: 0; }
    .pf-pin svg { display: block; filter: drop-shadow(0 3px 4px rgba(0, 0, 0, .3)); }
</style>
@endpush

@section('content')

@php
    $misiItems = $village->misi
        ? array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $village->misi)))))
        : [];
    $demographics = $village->demographics->groupBy('type');
@endphp

<div class="pf">

    {{-- ═════════════ HERO ═════════════ --}}
    <div class="profil-hero pf-hero">
        <div class="pf-hero-inner">
            <div class="pf-badge">
                <span class="pf-badge-dot"></span>
                Profil &amp; Sejarah Desa
            </div>

            <h1 class="pf-title">Desa {{ ucwords($village->name) }}</h1>

            <p class="pf-lead">
                Mengenal lebih dekat visi, misi, sejarah perkembangan, serta tata kelola pemerintahan Desa {{ ucwords($village->name) }}.
            </p>

            <div class="pf-chips">
                <div class="pf-chip">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    <span>Kecamatan {{ ucwords($village->kecamatan) }}</span>
                </div>
                <div class="pf-chip">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    <span>Kabupaten {{ ucwords($village->kabupaten) }}</span>
                </div>
                @if($village->officials->count() > 0)
                <div class="pf-chip">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    <span>{{ $village->officials->count() }} Perangkat Desa</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ═════════════ VISI & MISI ═════════════ --}}
    @if($village->visi || count($misiItems))
    <div class="pf-row pf-row--vm">

        @if($village->visi)
        <div class="profil-card pf-card pf-visi {{ count($misiItems) ? 'pf-c5' : 'pf-c12' }}">
            <div class="pf-visi-body">
                <div class="eyebrow">VISI DESA</div>
                <h2 class="pf-h2" style="margin-bottom: 1rem;">Cita-Cita &amp; Tujuan</h2>
                <blockquote class="pf-quote">“{{ $village->visi }}”</blockquote>
            </div>
            <div class="pf-visi-foot">
                Landasan Utama Pembangunan Desa {{ ucwords($village->name) }}
            </div>
        </div>
        @endif

        @if(count($misiItems))
        <div class="profil-card pf-card {{ $village->visi ? 'pf-c7' : 'pf-c12' }}">
            <div class="eyebrow">ARAH PEMBANGUNAN</div>
            <h2 class="pf-h2" style="margin-bottom: 1.25rem;">Misi Desa</h2>
            <ol class="pf-misi">
                @foreach($misiItems as $misiItem)
                    <li>
                        <div class="pf-num">{{ sprintf('%02d', $loop->iteration) }}</div>
                        <p>{{ $misiItem }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
        @endif

    </div>
    @endif

    {{-- ═════════════ KONTEN UTAMA + SIDEBAR ═════════════ --}}
    <div class="pf-row pf-row--main">

        {{-- ---------- KONTEN UTAMA ---------- --}}
        <div class="pf-stack pf-c8">

            {{-- Tentang & Sejarah --}}
            @if($village->description || $village->history)
            <div class="profil-card pf-card">
                <div class="pf-head">
                    <div class="pf-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-h2">Tentang &amp; Sejarah Desa</h2>
                        <span class="pf-sub">Gambaran umum dan kilas balik historis</span>
                    </div>
                </div>

                <div class="pf-sections">
                    @if($village->description)
                        <div>
                            <h3 class="eyebrow">GAMBARAN UMUM</h3>
                            <p class="pf-text">{!! nl2br(e($village->description)) !!}</p>
                        </div>
                    @endif

                    @if($village->history && trim($village->history) !== trim($village->description))
                        <div>
                            <h3 class="eyebrow">SEJARAH PERKEMBANGAN</h3>
                            <p class="pf-text">{!! nl2br(e($village->history)) !!}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Struktur Perangkat Desa --}}
            <div class="profil-card pf-card">
                <div class="pf-head">
                    <div class="pf-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-h2">Struktur Perangkat Desa</h2>
                        <span class="pf-sub">Pengelola tata kelola pelayanan publik</span>
                    </div>
                </div>

                @if($village->officials->count() > 0)
                    <div class="pf-officials">
                        @foreach($village->officials as $official)
                            <div class="pf-official">
                                <div class="pf-avatar">
                                    @if($official->photo_path)
                                        <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}" loading="lazy">
                                    @else
                                        <div class="pf-avatar-ph">{{ strtoupper(mb_substr($official->name, 0, 1)) }}</div>
                                    @endif
                                </div>
                                <h4 class="pf-name">{{ ucwords($official->name) }}</h4>
                                <span class="pf-role">{{ ucwords($official->position) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="pf-empty">Belum ada data perangkat desa yang terdaftar.</div>
                @endif
            </div>

            {{-- Bagan Organisasi --}}
            @if($village->bagan_struktur_path)
            <div class="profil-card pf-card">
                <div class="pf-head">
                    <div class="pf-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6z"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-h2">Bagan Organisasi</h2>
                        <span class="pf-sub">Skema struktur hirarki pemerintahan</span>
                    </div>
                </div>
                <div class="pf-bagan">
                    <img src="{{ Storage::url($village->bagan_struktur_path) }}"
                         alt="Bagan Struktur Organisasi Desa {{ $village->name }}"
                         onclick="this.classList.toggle('is-zoomed');">
                </div>
                <p class="pf-hint">Klik gambar untuk memperbesar tampilan bagan</p>
            </div>
            @endif

            {{-- Demografi Penduduk --}}
            @if($demographics->count() > 0)
            <div class="profil-card pf-card">
                <div class="pf-head">
                    <div class="pf-ico">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
                    </div>
                    <div>
                        <h2 class="pf-h2">Demografi Penduduk</h2>
                        <span class="pf-sub">Statistik komposisi kependudukan</span>
                    </div>
                </div>

                <div class="pf-demo">
                    @foreach($demographics as $type => $items)
                        @php $total = $items->sum('count'); @endphp
                        <div class="pf-demo-panel {{ $loop->last && $loop->count % 2 !== 0 ? 'pf-demo-panel--wide' : '' }}">
                            <h4 class="pf-demo-title">
                                {{ $type == 'gender' ? 'JENIS KELAMIN' : ($type == 'age' ? 'KELOMPOK USIA' : ($type == 'religion' ? 'AGAMA' : strtoupper($type))) }}
                            </h4>
                            <div class="pf-bars">
                                @foreach($items as $item)
                                    @php $pct = $total > 0 ? round(($item->count / $total) * 100) : 0; @endphp
                                    <div>
                                        <div class="pf-bar-top">
                                            <span>{{ $item->label }}</span>
                                            <span>{{ number_format($item->count, 0, ',', '.') }} <span class="pf-pct">({{ $pct }}%)</span></span>
                                        </div>
                                        <div class="pf-track">
                                            <div class="pf-fill" style="width: {{ $pct }}%;"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- ---------- SIDEBAR (sticky) ---------- --}}
        <aside class="pf-side pf-c4">

            {{-- Informasi & Kontak --}}
            <div class="profil-card pf-card--info">
                <h3 class="pf-side-title">
                    <span>Informasi &amp; Kontak Desa</span>
                    <span class="pf-dot"></span>
                </h3>

                <div>
                    <div class="info-row">
                        <div class="pf-ico pf-ico--sm">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545a.75.75 0 00-.472-.698l-7.5-2.812a.75.75 0 00-.556 0l-7.5 2.812A.75.75 0 003 3.545V21h4.5"/></svg>
                        </div>
                        <div class="info-body">
                            <span class="eyebrow">ALAMAT KANTOR</span>
                            <span class="info-val">{{ $village->address ? ucwords($village->address) : 'Belum diisi' }}</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="pf-ico pf-ico--sm">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21"/></svg>
                        </div>
                        <div class="info-body info-pair">
                            <div>
                                <span class="eyebrow">KECAMATAN</span>
                                <span class="info-val info-val--strong">{{ ucwords($village->kecamatan) }}</span>
                            </div>
                            <div>
                                <span class="eyebrow">KABUPATEN / KOTA</span>
                                <span class="info-val info-val--strong">{{ ucwords($village->kabupaten) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="pf-ico pf-ico--sm">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="info-body">
                            <span class="eyebrow">JAM OPERASIONAL</span>
                            <span class="info-val">{{ $village->office_hours ?: 'Senin - Jumat (08:00 - 15:00 WIB)' }}</span>
                        </div>
                    </div>

                    @if($village->contact_email)
                    <div class="info-row">
                        <div class="pf-ico pf-ico--sm">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div class="info-body">
                            <span class="eyebrow">EMAIL RESMI</span>
                            <a href="mailto:{{ $village->contact_email }}" class="info-val">{{ $village->contact_email }}</a>
                        </div>
                    </div>
                    @endif

                    @if($village->contact_phone)
                    <div class="info-row">
                        <div class="pf-ico pf-ico--sm">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div class="info-body">
                            <span class="eyebrow">TELEPON / WHATSAPP</span>
                            <a href="tel:{{ $village->contact_phone }}" class="info-val">{{ $village->contact_phone }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Peta Kantor Desa: peta memenuhi kartu --}}
            @if($village->latitude && $village->longitude)
            <div class="profil-card pf-mapcard">
                <div id="profil-map" class="pf-map"></div>

                <span class="pf-map-chip pf-map-chip--label">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                    Peta Kantor Desa
                </span>
                <a class="pf-map-chip pf-map-chip--link" href="https://maps.google.com/?q={{ $village->latitude }},{{ $village->longitude }}" target="_blank" rel="noopener">
                    Buka Maps &rarr;
                </a>
            </div>
            @endif

        </aside>
    </div>

</div>

@endsection

@push('scripts')
@if($village->latitude && $village->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $village->latitude }};
        const lng = {{ $village->longitude }};
        const el  = document.getElementById('profil-map');

        // scroll-wheel dimatikan supaya scroll halaman tidak "tersangkut" di peta (sidebar sticky);
        // aktif setelah peta diklik. Di layar sentuh, geser 1 jari tetap men-scroll halaman.
        const map = L.map(el, {
            zoomControl: false,
            scrollWheelZoom: false,
            dragging: !L.Browser.mobile,
            tap: false
        }).setView([lat, lng], 15);

        L.control.zoom({ position: 'topleft' }).addTo(map);
        map.on('click', function () { map.scrollWheelZoom.enable(); });
        map.on('mouseout', function () { map.scrollWheelZoom.disable(); });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap',
            maxZoom: 19
        }).addTo(map);

        const color = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#c4654a';
        const pinSvg = '<svg viewBox="0 0 32 42" width="32" height="42" xmlns="http://www.w3.org/2000/svg">'
            + '<path d="M16 0C7.2 0 0 7 0 15.7 0 27.3 16 42 16 42s16-14.7 16-26.3C32 7 24.8 0 16 0z" fill="' + color + '"/>'
            + '<circle cx="16" cy="15.5" r="6" fill="#ffffff"/></svg>';

        const pin = L.divIcon({
            className: 'pf-pin',
            html: pinSvg,
            iconSize: [32, 42],
            iconAnchor: [16, 41],
            popupAnchor: [0, -38]
        });

        L.marker([lat, lng], { icon: pin }).addTo(map).bindPopup(
            '<div style="font-family:Outfit,sans-serif;font-weight:700;font-size:13px">Kantor Desa {{ e(ucwords($village->name)) }}</div>'
            + '<div style="font-size:11px;color:#888">Kec. {{ e(ucwords($village->kecamatan)) }}</div>'
        );

        // tinggi peta mengikuti sisa layar, jadi ukur ulang setiap ukurannya berubah
        if (window.ResizeObserver) {
            new ResizeObserver(function () { map.invalidateSize(); }).observe(el);
        }
        setTimeout(function () { map.invalidateSize(); }, 400);
    });
</script>
@endif
@endpush