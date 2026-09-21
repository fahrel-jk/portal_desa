@extends('village.templates.modern.layout', ['title' => 'Agenda Desa'])

@push('styles')
<style>
    /* ==========================================================================
       AGENDA DESA — CSS murni (tidak bergantung pada Tailwind).
       Daftar agenda dirender server-side sebagai timeline: tanggal | rel | isi.
       Warna kategori masuk lewat variabel --c pada tiap item.
       ========================================================================== */

    .ag-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr);
        gap: 2rem;
        align-items: start;
        margin-bottom: 4rem;
    }
    @media (min-width: 1024px) {
        .ag-layout { grid-template-columns: repeat(12, minmax(0, 1fr)); }
        .ag-cal  { grid-column: span 5; }
        .ag-main { grid-column: span 7; }
    }
    .ag-cal { display: flex; justify-content: center; min-width: 0; }
    .ag-cal > #glass-calendar-root { width: 100%; }
    .ag-main { display: flex; flex-direction: column; min-width: 0; }

    /* ---------- Header daftar ---------- */
    .ag-head {
        display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        margin-bottom: 1rem;
        padding: 0 .25rem;
    }
    .ag-head-title { display: flex; align-items: center; gap: .6rem; min-width: 0; }
    .ag-head-dot { width: 8px; height: 8px; flex-shrink: 0; border-radius: 50%; background: var(--primary); }
    .ag-head-title h3 {
        margin: 0;
        font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 800;
        letter-spacing: -0.01em; color: var(--fg);
    }
    .ag-count {
        flex-shrink: 0;
        padding: .25rem .75rem;
        border: 1px solid var(--border); border-radius: 9999px;
        background: rgba(255, 255, 255, .6);
        font-size: .8125rem; font-weight: 600; color: var(--muted-fg);
    }

    /* ---------- Panel + timeline ---------- */
    .ag-panel {
        padding: .25rem 1.25rem;
        border: 1px solid var(--border);
        border-radius: 1.5rem;
        background: var(--card);
    }
    @media (min-width: 640px) { .ag-panel { padding: .25rem 1.75rem; } }

    .ag-timeline { margin: 0; padding: 0; list-style: none; }

    .ag-item {
        --dw: 3.25rem;      /* lebar kolom tanggal */
        --rail: 1.75rem;    /* lebar kolom rel */
        --c: #3b82f6;       /* warna kategori, di-override per item */
        position: relative;
        display: grid;
        grid-template-columns: var(--dw) var(--rail) minmax(0, 1fr);
        column-gap: .5rem;
        padding: 1.25rem 0;
    }
    @media (min-width: 640px) { .ag-item { --dw: 4rem; } }

    /* garis rel */
    .ag-item::before {
        content: "";
        position: absolute;
        left: calc(var(--dw) + .5rem + var(--rail) / 2 - 1px);
        top: 0; bottom: 0;
        width: 2px;
        background: var(--border);
    }
    .ag-item:first-child::before { top: 2rem; }
    .ag-item:last-child::before  { bottom: auto; height: 2rem; }
    .ag-item:only-child::before  { display: none; }

    /* titik di rel = warna kategori */
    .ag-node {
        position: absolute; z-index: 1;
        left: calc(var(--dw) + .5rem + var(--rail) / 2 - .4375rem);
        top: 1.55rem;
        width: .875rem; height: .875rem;
        box-sizing: border-box;
        border: 3px solid var(--c);
        border-radius: 50%;
        background: var(--card);
    }
    .ag-item.is-today .ag-node { background: var(--c); box-shadow: 0 0 0 4px color-mix(in srgb, var(--c) 18%, transparent); }

    /* kolom tanggal */
    .ag-date { display: flex; flex-direction: column; align-items: center; text-align: center; }
    .ag-dow, .ag-mon { font-size: .75rem; font-weight: 600; line-height: 1.2; color: var(--muted-fg); }
    .ag-day {
        margin: .125rem 0;
        font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.75rem;
        line-height: 1.05; letter-spacing: -0.02em;
        color: var(--fg);
    }
    .ag-item.is-today .ag-day { color: var(--primary); }

    /* isi */
    .ag-body { min-width: 0; }
    .ag-title-row { display: flex; align-items: flex-start; justify-content: space-between; gap: .75rem; }
    .ag-title {
        margin: 0; min-width: 0;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        font-family: 'Outfit', sans-serif; font-weight: 700; font-size: 1.0625rem;
        line-height: 1.35; letter-spacing: -0.01em;
        color: var(--fg);
        transition: color .18s ease;
    }
    .ag-item:hover .ag-title { color: var(--primary); }

    .ag-pill {
        flex: none; max-width: 45%;
        overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        padding: .1875rem .625rem;
        border-radius: 9999px;
        font-size: .75rem; font-weight: 600; line-height: 1.4;
        color: color-mix(in srgb, var(--c) 72%, #000);
        background: color-mix(in srgb, var(--c) 12%, white);
    }

    .ag-desc {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        margin: .375rem 0 0;
        font-size: .875rem; line-height: 1.55;
        color: var(--muted-fg);
    }

    .ag-meta {
        display: flex; flex-wrap: wrap; align-items: center;
        gap: .375rem 1.25rem;
        margin-top: .625rem;
        font-size: .8125rem; line-height: 1.4;
        color: var(--muted-fg);
    }
    .ag-meta-item { display: inline-flex; align-items: center; gap: .375rem; min-width: 0; }
    .ag-meta-item svg { width: 1rem; height: 1rem; flex: none; color: var(--c); }
    .ag-meta-item span { overflow-wrap: anywhere; }
    .ag-when { margin-left: auto; font-weight: 600; color: var(--fg); }
    .ag-item.is-today .ag-when { color: var(--primary); }

    @media (max-width: 480px) {
        .ag-title-row { flex-direction: column-reverse; align-items: flex-start; gap: .375rem; }
        .ag-pill { max-width: 100%; }
        .ag-when { margin-left: 0; }
    }

    /* ---------- Kosong ---------- */
    .ag-empty {
        display: flex; flex-direction: column; align-items: center; text-align: center;
        padding: 2.5rem 1.5rem;
    }
    .ag-empty-ico {
        display: flex; align-items: center; justify-content: center;
        width: 3rem; height: 3rem; margin-bottom: 1rem;
        border-radius: 50%; background: var(--muted); color: var(--muted-fg);
    }
    .ag-empty h3 { margin: 0 0 .5rem; font-family: 'Outfit', sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); }
    .ag-empty p { margin: 0; font-size: .875rem; color: var(--muted-fg); }
</style>
@endpush

@section('content')
<div style="text-align: center; padding: 2.5rem 1rem 3rem; margin-bottom: 1.5rem; background: transparent;">
    <div class="eyebrow" style="margin-bottom: 0.5rem; color: var(--primary); letter-spacing: 0.15em; font-size: 11px; font-weight: 700; text-transform: uppercase;">AGENDA WARGA</div>
    <h1 style="font-family: 'Outfit', sans-serif; font-size: clamp(2rem, 4.5vw, 3rem); font-weight: 800; color: var(--fg); margin-bottom: 0.75rem; letter-spacing: -0.03em; line-height: 1.1;">Kalender Agenda</h1>
    <p style="font-family: 'Figtree', sans-serif; color: var(--muted-fg); max-width: 580px; margin: 0 auto; font-size: 1.05rem; font-weight: 500; line-height: 1.6;">Pantau kegiatan sosial, pembangunan, dan budaya di lingkungan Desa {{ $village->name }}.</p>
</div>

@php
    $calendarEventsData = $agendas->map(function($agenda) {
        return [
            'id' => $agenda->id,
            'title' => $agenda->title,
            'description' => $agenda->description,
            'event_date' => \Carbon\Carbon::parse($agenda->event_date)->format('Y-m-d'),
            'start_time' => $agenda->start_time,
            'end_time' => $agenda->end_time,
            'location' => $agenda->location,
            'category_label' => $agenda->category_label ?: ($agenda->category ?: 'Kegiatan'),
            'category_color' => $agenda->category_color ?: '#c4654a',
        ];
    })->values()->toJson();

    $upcomingAgendasData = $upcomingAgendas->map(function($agenda) {
        return [
            'id' => $agenda->id,
            'title' => $agenda->title,
            'event_date' => \Carbon\Carbon::parse($agenda->event_date)->format('Y-m-d'),
            'month_name' => $agenda->event_date->translatedFormat('M'),
            'day_number' => $agenda->event_date->format('d'),
            'start_time' => $agenda->start_time ? \Carbon\Carbon::parse($agenda->start_time)->format('H:i') : null,
            'end_time' => $agenda->end_time ? \Carbon\Carbon::parse($agenda->end_time)->format('H:i') : null,
            'location' => $agenda->location,
            'description' => $agenda->description,
            'category_label' => $agenda->category_label ?: ($agenda->category ?: 'KEGIATAN'),
            'category_color' => $agenda->category_color ?: '#3b82f6',
        ];
    })->values()->toJson();

    $today = \Carbon\Carbon::today();
@endphp

<div class="ag-layout">

    {{-- Kalender (React) --}}
    <div class="ag-cal">
        <div id="glass-calendar-root" data-events="{{ $calendarEventsData }}"></div>
    </div>

    {{-- Daftar agenda mendatang --}}
    <div class="ag-main">
        <div class="ag-head">
            <div class="ag-head-title">
                <span class="ag-head-dot"></span>
                <h3>Daftar Agenda Mendatang</h3>
            </div>
            <span class="ag-count">{{ $upcomingAgendas->count() }} Kegiatan</span>
        </div>

        <div class="ag-panel">
            @if($upcomingAgendas->count() > 0)
                <ol class="ag-timeline">
                    @foreach($upcomingAgendas as $ua)
                        @php
                            $d = \Carbon\Carbon::parse($ua->event_date)->locale('id');

                            $c = $ua->category_color ?: '#3b82f6';
                            $c = preg_match('/^#[0-9a-fA-F]{3,8}$/', $c) ? $c : '#3b82f6';

                            $label = $ua->category_label ?: ($ua->category ?: 'Kegiatan');
                            $label = mb_convert_case(mb_strtolower($label, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');

                            $diff = (int) $today->diffInDays($d->copy()->startOfDay(), false);
                            $isToday = $diff === 0;
                            $when = $diff < 0 ? null : ($diff === 0 ? 'Hari ini' : ($diff === 1 ? 'Besok' : $diff . ' hari lagi'));

                            $start = $ua->start_time ? \Carbon\Carbon::parse($ua->start_time)->format('H:i') : null;
                            $end   = $ua->end_time ? \Carbon\Carbon::parse($ua->end_time)->format('H:i') : null;
                            $time  = $start ? ($end ? $start . ' – ' . $end . ' WIB' : $start . ' WIB') : null;
                        @endphp

                        <li class="ag-item {{ $isToday ? 'is-today' : '' }}" style="--c: {{ $c }};">
                            <span class="ag-node" aria-hidden="true"></span>

                            <div class="ag-date">
                                <span class="ag-dow">{{ $d->translatedFormat('D') }}</span>
                                <span class="ag-day">{{ $d->format('d') }}</span>
                                <span class="ag-mon">{{ $d->translatedFormat('M') }}</span>
                            </div>

                            <div></div>{{-- kolom rel --}}

                            <div class="ag-body">
                                <div class="ag-title-row">
                                    <h4 class="ag-title" title="{{ $ua->title }}">{{ $ua->title }}</h4>
                                    <span class="ag-pill">{{ $label }}</span>
                                </div>

                                @if($ua->description)
                                    <p class="ag-desc">{{ $ua->description }}</p>
                                @endif

                                <div class="ag-meta">
                                    @if($time)
                                        <span class="ag-meta-item">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ $time }}</span>
                                        </span>
                                    @endif
                                    @if($ua->location)
                                        <span class="ag-meta-item">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                            <span>{{ $ua->location }}</span>
                                        </span>
                                    @endif
                                    @if($when)
                                        <span class="ag-when">{{ $when }}</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            @else
                <div class="ag-empty">
                    <div class="ag-empty-ico">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                    </div>
                    <h3>Tidak ada agenda mendatang</h3>
                    <p>Belum ada jadwal kegiatan dalam waktu dekat.</p>
                </div>
            @endif
        </div>

        {{-- Root lama untuk komponen React kartu agenda: dipertahankan (disembunyikan) supaya
             calendar-mount.tsx tidak error saat mencari elemen ini. Daftar tampil dari markup di atas. --}}
        <div id="animated-agenda-cards-root" data-agendas="{{ $upcomingAgendasData }}" hidden></div>
    </div>
</div>

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/calendar-mount.tsx'])
@endpush
@endsection