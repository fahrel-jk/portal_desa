<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }} — Portal Desa</title>
    <meta name="description" content="{{ Str::limit($village->description, 160) }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --background: #FAF7F0;
            --foreground: #1A1A1A;
            --deep: #313F33;
            --primary: #313F33;
            --primary-hover: #263328;
            --primary-foreground: #FFFFFF;
            --accent: #BA704F;
            --accent-hover: #A05B3D;
            --accent-foreground: #FFFFFF;
            --surface: #FFFFFF;
            --muted: #E8E5DA;
            --muted-foreground: #6B7280;
            --border: #E5E2D5;
            --card: #FFFFFF;
            --secondary: #F3F0E6;
        }
        body { 
            font-family: 'IBM Plex Sans', sans-serif;
            background-color: var(--background);
            color: var(--foreground);
        }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        
        .bg-background { background-color: var(--background); }
        .text-foreground { color: var(--foreground); }
        .bg-deep { background-color: var(--deep); }
        .bg-surface { background-color: var(--surface); }
        .bg-primary { background-color: var(--primary); }
        .bg-primary-hover:hover { background-color: var(--primary-hover); }
        .bg-accent { background-color: var(--accent); }
        .bg-accent-hover:hover { background-color: var(--accent-hover); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-accent-foreground { color: var(--accent-foreground); }
        .text-muted-foreground { color: var(--muted-foreground); }
        
        .border-border { border-color: var(--border); }
        .hover\:border-primary:hover { border-color: var(--primary); }
        
        details > summary::-webkit-details-marker {
            display: none;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

<div class="min-h-screen bg-background text-foreground flex flex-col">
    @include('village.templates.klasik.header')

    <main class="flex-grow">
        @foreach($village->getOrderedLayoutSections() as $section)
            @if(!empty($section['enabled']))
                @php $customTitle = $section['title'] ?? null; @endphp
                @switch($section['id'])
                    @case('hero')
                        {{-- Hero --}}
                        <section id="beranda" class="bg-background">
                            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-12 sm:px-6 md:py-16 lg:grid-cols-12 lg:items-center lg:gap-14">
                                <div class="lg:col-span-7">
                                    <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent">
                                        <span class="h-px w-7 bg-accent"></span>Portal Resmi Pemerintahan Desa
                                    </p>
                                    <h1 class="mt-4 max-w-[18ch] font-serif text-4xl font-bold leading-[1.16] sm:text-5xl">Pelayanan desa yang dekat, jelas, dan terpercaya.</h1>
                                    <p class="mt-5 max-w-xl text-base leading-7 text-muted-foreground">
                                        @if($village->description)
                                            {{ $village->description }}
                                        @else
                                            Urus surat, periksa data keluarga, dan ikuti agenda balai desa dalam satu tempat yang rapi dan mudah dijangkau.
                                        @endif
                                    </p>
                                    <div class="mt-7 flex flex-wrap gap-3">
                                        <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors bg-primary text-primary-foreground hover:bg-primary-hover h-12 px-5">
                                            Hubungi Kami
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                        </a>
                                        <a href="#layanan" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-12 px-5">Lihat Layanan</a>
                                    </div>
                                    <div class="mt-10 flex max-w-lg flex-wrap gap-x-8 gap-y-3 border-t border-border pt-5 text-xs text-muted-foreground">
                                        @if($village->address)
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> 
                                            {{ $village->address }}
                                        </span>
                                        @endif
                                        @if($village->contact_phone)
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> 
                                            {{ $village->contact_phone }}
                                        </span>
                                        @endif
                                        @if($village->office_hours)
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-accent"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                            {{ $village->office_hours }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <figure class="lg:col-span-5">
                                    <div class="overflow-hidden rounded-md bg-muted">
                                        @if($village->hero_image_path)
                                            <img src="{{ Storage::url($village->hero_image_path) }}" alt="Pemandangan Desa {{ $village->name }}" class="aspect-[5/4] w-full object-cover"/>
                                        @else
                                            <img src="https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&q=80&w=1280" alt="Pemandangan desa" class="aspect-[5/4] w-full object-cover"/>
                                        @endif
                                    </div>
                                    <figcaption class="mt-2 text-xs text-muted-foreground">Pemandangan Desa {{ $village->name }}</figcaption>
                                </figure>
                            </div>
                        </section>
                        @break

                    @case('services')
                        {{-- Layanan --}}
                        @if($village->services->count() > 0)
                        <section id="layanan" class="border-y border-border bg-secondary py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Layanan Utama' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Urusan warga dalam satu tempat</h2>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 items-start">
                                    @foreach($village->services->take(6) as $service)
                                        <a href="{{ $service->slug ? route('village.service.show', [$village->slug, $service->slug]) : route('village.services', $village->slug) }}" class="group flex flex-col border border-border bg-card p-5 transition-all hover:border-primary/45 hover:shadow-md sm:p-6 h-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-accent mb-4"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"></path><path d="M14 2v5a1 1 0 0 0 1 1h5"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                                            <h3 class="font-serif text-lg font-bold group-hover:text-accent transition-colors">{{ $service->name }}</h3>
                                            @if($service->description)
                                                <p class="mt-2 text-sm leading-6 text-muted-foreground line-clamp-2">{{ $service->description }}</p>
                                            @endif
                                            <div class="mt-auto pt-4 border-t border-border">
                                                <span class="text-xs font-semibold text-accent group-hover:underline">Lihat Detail →</span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                @if($village->services->count() > 6)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('village.services', $village->slug) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-accent hover:underline">
                                        Lihat Semua Layanan ({{ $village->services->count() }})
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </section>
                        @endif
                        @break

                    @case('news')
                        {{-- Berita --}}
                        @if($village->news->count() > 0)
                        <section id="berita" class="bg-background py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-5 flex items-end justify-between">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Kabar Desa' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold">Yang sedang berlangsung</h2>
                                    </div>
                                    @if($village->news->count() > 4)
                                    <div>
                                        <a href="{{ route('village.news', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-10 px-5">
                                            Lihat Semua Berita
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                    @foreach($village->news->take(4) as $news)
                                        <a href="{{ route('village.news.show', [$village->slug, $news->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                                            @if($news->cover_image_path)
                                                <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="aspect-[16/10] w-full object-cover"/>
                                            @else
                                                <div class="aspect-[16/10] w-full bg-muted flex items-center justify-center">
                                                    <span class="text-muted-foreground font-serif text-sm">Tidak ada gambar</span>
                                                </div>
                                            @endif
                                            <div class="p-5">
                                                <p class="text-[10px] font-medium uppercase tracking-[0.14em] text-muted-foreground">{{ $news->published_at ? $news->published_at->format('d F Y') : $news->created_at->format('d F Y') }}</p>
                                                <h3 class="mt-2 font-serif text-lg font-bold leading-7 text-primary group-hover:text-accent transition-colors">{{ $news->title }}</h3>
                                                <p class="mt-2 text-sm text-muted-foreground line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                        @break

                    @case('profile')
                        {{-- Profil & Aparatur --}}
                        <section id="profil" class="bg-background py-14 md:py-20 border-t border-border scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                                    <div class="lg:col-span-6 border border-border bg-card p-6 rounded-lg">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">{{ $customTitle ?? 'Profil Desa' }}</p>
                                        <h3 class="font-serif text-xl font-bold text-primary mb-3">Tentang Kami</h3>
                                        <p class="text-sm text-muted-foreground leading-relaxed">{{ Str::limit($village->description ?? 'Portal desa ini dibangun untuk memudahkan pelayanan masyarakat dalam mendapatkan informasi dan mengurus administrasi di tingkat desa secara mandiri, transparan, dan efisien.', 350) }}</p>
                                    </div>
                                    
                                    <div class="lg:col-span-6">
                                        @if($village->officials->count() > 0)
                                        <div class="border border-border bg-card p-6 rounded-lg h-full">
                                            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-4">Aparatur Desa</p>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                @foreach($village->officials as $official)
                                                <div class="flex items-center gap-3">
                                                    @if($official->photo_path)
                                                        <img src="{{ Storage::url($official->photo_path) }}" class="w-12 h-12 rounded bg-muted object-cover">
                                                    @else
                                                        <div class="w-12 h-12 rounded bg-secondary flex items-center justify-center text-primary font-bold font-serif">
                                                            {{ substr($official->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h4 class="font-bold text-sm text-primary">{{ $official->name }}</h4>
                                                        <p class="text-xs text-muted-foreground">{{ $official->position }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                        @break

                    @case('statistics')
                        {{-- Statistik Demografi --}}
                        @php
                            $demographics = $village->demographics()->get()->groupBy('type');
                        @endphp
                        @if($demographics->count() > 0)
                        <section id="statistik" class="bg-secondary py-14 md:py-20 border-t border-border scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-accent mb-2">{{ $customTitle ?? 'Statistik Penduduk' }}</p>
                                    <h2 class="font-serif text-2xl font-bold sm:text-3xl">Demografi Desa {{ $village->name }}</h2>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($demographics as $type => $items)
                                        <div class="border border-border bg-card p-5 rounded-lg">
                                            <h4 class="font-serif text-sm font-bold text-primary mb-3 border-b border-border pb-2 capitalize">{{ $type == 'gender' ? 'Jenis Kelamin' : ($type == 'age' ? 'Kelompok Usia' : ($type == 'religion' ? 'Agama' : $type)) }}</h4>
                                            <div class="space-y-3">
                                                @php $total = $items->sum('count'); @endphp
                                                @foreach($items as $item)
                                                    @php $percentage = $total > 0 ? round(($item->count / $total) * 100) : 0; @endphp
                                                    <div>
                                                        <div class="flex justify-between text-xs mb-1">
                                                            <span class="font-medium text-text-dark">{{ $item->label }}</span>
                                                            <span class="text-muted-foreground">{{ number_format($item->count, 0, ',', '.') }} ({{ $percentage }}%)</span>
                                                        </div>
                                                        <div class="w-full bg-secondary h-2.5 rounded-full overflow-hidden">
                                                            <div class="bg-accent h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                        @break

                    @case('agenda')
                        {{-- Agenda / Kalender --}}
                        <section id="agenda" class="border-y border-border bg-secondary py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Kalender Kegiatan' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Agenda Desa</h2>
                                    </div>
                                    <a href="{{ route('village.agenda', $village->slug) }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-accent hover:underline">
                                        Lihat Semua
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                                    {{-- Mini Calendar --}}
                                    <div class="lg:col-span-3 border border-border bg-card rounded-lg overflow-hidden">
                                        @php
                                            $calYear = now()->year;
                                            $calMonth = now()->month;
                                            $daysInMonth = now()->daysInMonth;
                                            $firstDayOfWeek = now()->startOfMonth()->dayOfWeek;
                                            $monthAgendas = $village->agendas->filter(fn($a) => $a->event_date->year == $calYear && $a->event_date->month == $calMonth);
                                            $agendaDays = $monthAgendas->groupBy(fn($a) => $a->event_date->day);
                                            $monthNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                        @endphp
                                        <div class="flex items-center justify-between px-5 py-3 border-b border-border bg-card">
                                            <h3 class="font-serif text-base font-bold">{{ $monthNames[$calMonth] }} {{ $calYear }}</h3>
                                            <a href="{{ route('village.agenda', $village->slug) }}" class="text-xs text-accent hover:underline">Buka Kalender →</a>
                                        </div>
                                        <div class="grid grid-cols-7 border-b border-border">
                                            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $dayName)
                                                <div class="py-2 text-center text-[10px] font-semibold uppercase tracking-wider text-muted-foreground">{{ $dayName }}</div>
                                            @endforeach
                                        </div>
                                        <div class="grid grid-cols-7">
                                            @for($i = 0; $i < $firstDayOfWeek; $i++)
                                                <div class="min-h-[48px] border-b border-r border-border bg-secondary/50"></div>
                                            @endfor
                                            @for($d = 1; $d <= $daysInMonth; $d++)
                                                @php $isToday = ($d == now()->day && $calMonth == now()->month && $calYear == now()->year); @endphp
                                                <div class="min-h-[48px] border-b border-r border-border p-1 {{ $isToday ? 'bg-accent/5' : 'bg-card' }}">
                                                    <span class="text-xs font-medium {{ $isToday ? 'bg-accent text-white rounded-full w-6 h-6 inline-flex items-center justify-center' : '' }}">{{ $d }}</span>
                                                    @if(isset($agendaDays[$d]))
                                                        <div class="flex flex-wrap gap-0.5 mt-0.5">
                                                            @foreach($agendaDays[$d]->take(3) as $dayAgenda)
                                                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $dayAgenda->category_color }}" title="{{ $dayAgenda->title }}"></span>
                                                            @endforeach
                                                            @if($agendaDays[$d]->count() > 3)
                                                                <span class="text-[9px] text-muted-foreground">+{{ $agendaDays[$d]->count() - 3 }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            @endfor
                                            @php $totalCells = $firstDayOfWeek + $daysInMonth; $remaining = (7 - ($totalCells % 7)) % 7; @endphp
                                            @for($i = 0; $i < $remaining; $i++)
                                                <div class="min-h-[48px] border-b border-r border-border bg-secondary/50"></div>
                                            @endfor
                                        </div>
                                    </div>

                                    {{-- Upcoming Agenda List --}}
                                    <div class="lg:col-span-2 border border-border bg-card rounded-lg overflow-hidden h-fit">
                                        <div class="px-5 py-3 border-b border-border">
                                            <h3 class="font-serif text-base font-bold">Agenda Mendatang</h3>
                                        </div>
                                        @php $upcomingAgendas = $village->agendas->where('event_date', '>=', now()->startOfDay())->sortBy('event_date')->take(3); @endphp
                                        @if($upcomingAgendas->count() > 0)
                                            <div class="divide-y divide-border">
                                                @foreach($upcomingAgendas as $ua)
                                                    <div class="px-5 py-4">
                                                        <div class="flex items-start gap-3">
                                                            <div class="text-center shrink-0 w-12">
                                                                <div class="text-2xl font-bold leading-none">{{ $ua->event_date->format('d') }}</div>
                                                                <div class="text-[10px] uppercase tracking-wider text-muted-foreground mt-1">{{ $ua->event_date->translatedFormat('M') }}</div>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <h4 class="font-bold text-sm truncate">{{ $ua->title }}</h4>
                                                                <div class="flex items-center gap-2 mt-1">
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-medium" style="background-color: {{ $ua->category_color }}18; color: {{ $ua->category_color }}">
                                                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $ua->category_color }}"></span>
                                                                        {{ $ua->category_label }}
                                                                    </span>
                                                                    @if($ua->start_time)
                                                                        <span class="text-[11px] text-muted-foreground">{{ substr($ua->start_time, 0, 5) }}</span>
                                                                    @endif
                                                                </div>
                                                                @if($ua->location)
                                                                    <p class="text-[11px] text-muted-foreground mt-1 flex items-center gap-1">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                                                        {{ $ua->location }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="px-5 py-8 text-center text-sm text-muted-foreground">
                                                Belum ada agenda mendatang.
                                            </div>
                                        @endif
                                        <div class="p-4 border-t border-border text-center">
                                            <a href="{{ route('village.agenda', $village->slug) }}" class="text-xs font-semibold text-accent hover:underline">Lihat Semua Agenda →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @break

                    @case('galleries')
                        {{-- Galeri --}}
                        @if($village->galleries->count() > 0)
                        <section id="galeri" class="border-y border-border bg-background py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7 flex items-end justify-between">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Dokumentasi' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Galeri Desa</h2>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    @foreach($village->galleries as $gallery)
                                    <div class="overflow-hidden rounded-md border border-border bg-card group relative aspect-square">
                                        <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Galeri' }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                        @if($gallery->caption)
                                            <div class="absolute bottom-0 left-0 w-full bg-deep/80 p-3 text-xs text-primary-foreground backdrop-blur-sm translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                                {{ $gallery->caption }}
                                            </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                        @break

                    @case('products')
                        {{-- Produk UMKM Desa --}}
                        @php $activeProducts = $village->products->where('is_active', true); @endphp
                        @if($activeProducts->count() > 0)
                        <section id="produk" class="border-y border-border bg-secondary py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Beli Dari Desa' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Produk unggulan UMKM desa</h2>
                                        <p class="mt-2 text-sm text-muted-foreground max-w-xl">Layanan yang disediakan untuk promosi produk UMKM desa sehingga mampu meningkatkan perekonomian masyarakat desa.</p>
                                    </div>
                                    @if($activeProducts->count() > 6)
                                    <a href="{{ route('village.products', $village->slug) }}" class="hidden sm:inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-10 px-4">
                                        Lihat Semua
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                                    </a>
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach($activeProducts->take(6) as $product)
                                        <a href="{{ route('village.product.show', [$village->slug, $product->slug]) }}" class="group border border-border bg-card overflow-hidden block transition-colors hover:border-primary/45">
                                            @if($product->image_path)
                                                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                                            @else
                                                <div class="aspect-[4/3] w-full bg-muted flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/40"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif
                                            <div class="p-5">
                                                <h3 class="font-serif text-lg font-bold text-primary group-hover:text-accent transition-colors">{{ $product->name }}</h3>
                                                @if($product->category)
                                                    <p class="mt-1 text-xs text-muted-foreground">{{ $product->category }}</p>
                                                @endif
                                                @if($product->price)
                                                    <p class="mt-3 font-bold text-accent text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                        @break

                    @case('complaint_banner')
                        {{-- Lapor Desa Banner --}}
                        <section class="border-b border-border bg-card py-10">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="bg-primary rounded-2xl overflow-hidden flex flex-col md:flex-row items-center justify-between p-8 md:p-12 relative">
                                    <div class="absolute top-0 right-0 -mt-16 -mr-16 opacity-10">
                                        <svg width="200" height="200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </div>
                                    <div class="relative z-10 md:max-w-2xl text-center md:text-left mb-6 md:mb-0">
                                        <h2 class="font-serif text-2xl md:text-3xl font-bold text-white mb-2">{{ $customTitle ?? 'Layanan Pengaduan & Aspirasi Warga' }}</h2>
                                        <p class="text-white/80 text-sm md:text-base">Laporkan masalah infrastruktur, layanan, atau sampaikan aspirasi Anda langsung kepada perangkat Desa {{ $village->name }}.</p>
                                    </div>
                                    <div class="relative z-10 shrink-0">
                                        <a href="{{ route('village.complaint.create', $village->slug) }}" class="inline-flex items-center justify-center gap-2 bg-accent hover:bg-accent/90 text-white font-bold py-3 px-8 rounded-lg transition-colors shadow-lg shadow-accent/20">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                            Buat Laporan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                        @break

                    @case('map')
                        {{-- Lokasi / Peta Desa --}}
                        @if($village->latitude && $village->longitude)
                        <section id="lokasi" class="bg-secondary py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6">
                                <div class="mb-7 flex items-end justify-between">
                                    <div>
                                        <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'Peta & Lokasi Penting' }}</p>
                                        <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Jelajahi {{ $village->name }}</h2>
                                    </div>
                                    <a href="https://maps.google.com/?q={{ $village->latitude }},{{ $village->longitude }}" target="_blank" class="hidden sm:inline-flex min-h-10 items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors border border-border bg-surface text-foreground hover:bg-muted h-10 px-4">
                                        Buka di Google Maps
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    </a>
                                </div>
                                
                                <div class="rounded-lg border border-border bg-card overflow-hidden shadow-sm relative z-0">
                                    <div id="village-map" class="w-full h-[400px] md:h-[500px]"></div>
                                </div>
                                <div class="mt-4 flex flex-wrap gap-4 text-xs font-medium">
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-primary inline-block shadow-sm"></span> Balai Desa / Pemerintahan</div>
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-accent inline-block shadow-sm"></span> Pendidikan</div>
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-secondary border border-border inline-block shadow-sm"></span> Kesehatan</div>
                                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-muted-foreground inline-block shadow-sm"></span> Lainnya</div>
                                </div>
                            </div>
                        </section>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var map = L.map('village-map', {
                                    zoomControl: false,
                                    attributionControl: true
                                }).setView([{{ $village->latitude }}, {{ $village->longitude }}], 15);
                                
                                L.control.zoom({ position: 'bottomright' }).addTo(map);

                                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                                    attribution: '&copy; OpenStreetMap',
                                    maxZoom: 19
                                }).addTo(map);
                                
                                var colorPrimary = getComputedStyle(document.documentElement).getPropertyValue('--primary').trim() || '#313F33';
                                var colorAccent = getComputedStyle(document.documentElement).getPropertyValue('--accent').trim() || '#BA704F';
                                var colorSecondary = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim() || '#F3F0E6';
                                var colorDefault = getComputedStyle(document.documentElement).getPropertyValue('--muted-foreground').trim() || '#6B7280';

                                L.circleMarker([{{ $village->latitude }}, {{ $village->longitude }}], {
                                    radius: 9, fillColor: colorPrimary, color: '#fff', weight: 2, opacity: 1, fillOpacity: 1
                                }).addTo(map).bindPopup('<div class="font-serif font-bold text-sm">Balai Desa {{ $village->name }}</div>');

                                var titikLokasis = @json($village->titikLokasis ?? []);
                                if (titikLokasis && titikLokasis.length > 0) {
                                    titikLokasis.forEach(function (titik) {
                                        var mc = colorDefault;
                                        if (titik.kategori === 'kesehatan') mc = colorSecondary;
                                        if (titik.kategori === 'pendidikan') mc = colorAccent;
                                        if (titik.kategori === 'pemerintahan') mc = colorPrimary;

                                        var popupContent = '<div class="font-sans text-xs">';
                                        if (titik.foto) {
                                            var imgUrl = '{{ Storage::url("") }}' + titik.foto;
                                            popupContent += '<img src="' + imgUrl + '" class="w-full h-24 object-cover rounded mb-2 shadow-sm" alt="' + titik.nama_lokasi + '">';
                                        }
                                        popupContent += '<strong>' + titik.nama_lokasi + '</strong><br><span class="text-muted-foreground uppercase tracking-wider" style="font-size: 10px;">' + titik.kategori + '</span></div>';

                                        L.circleMarker([titik.latitude, titik.longitude], {
                                            radius: 7, fillColor: mc, color: '#fff', weight: 2, opacity: 1, fillOpacity: 0.9
                                        }).addTo(map).bindPopup(popupContent, { minWidth: 150 });
                                    });
                                }
                                
                                @if($village->geojson_batas_wilayah)
                                    try {
                                        L.geoJSON(@json($village->geojson_batas_wilayah), {
                                            style: { color: colorPrimary, weight: 2, opacity: 0.5, fillOpacity: 0.05 }
                                        }).addTo(map);
                                    } catch (e) { console.warn('GeoJSON error:', e); }
                                @endif
                                
                                setTimeout(() => map.invalidateSize(), 400);
                            });
                        </script>
                        @endif
                        @break

                    @case('faq')
                        {{-- FAQ / Tanya Jawab --}}
                        @if($village->faqs->count() > 0)
                        <section id="faq" class="border-y border-border bg-background py-14 md:py-20 scroll-mt-20">
                            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                                <div class="text-center mb-10">
                                    <p class="flex items-center justify-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>{{ $customTitle ?? 'FAQ' }}</p>
                                    <h2 class="mt-3 font-serif text-2xl font-bold sm:text-3xl">Tanya Jawab Seputar Desa</h2>
                                    <p class="mt-3 text-sm text-muted-foreground">Pertanyaan umum yang sering diajukan warga</p>
                                </div>
                                
                                <div class="space-y-4" x-data="{ active: null }">
                                    @foreach($village->faqs as $index => $faq)
                                        <div class="border border-border bg-card rounded-lg overflow-hidden transition-colors hover:border-accent/40">
                                            <button 
                                                @click="active === {{ $index }} ? active = null : active = {{ $index }}"
                                                class="flex items-center justify-between w-full px-5 py-4 text-left font-semibold focus:outline-none"
                                                :class="active === {{ $index }} ? 'text-accent' : 'text-foreground'"
                                            >
                                                <span>{{ $faq->question }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 transition-transform duration-200" :class="active === {{ $index }} ? 'rotate-180 text-accent' : 'text-muted-foreground'"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>
                                            <div 
                                                x-show="active === {{ $index }}" 
                                                x-collapse
                                                x-cloak
                                                class="px-5 pb-5 pt-0 text-sm leading-relaxed text-muted-foreground border-t border-border/50"
                                            >
                                                <div class="pt-3">
                                                    {!! nl2br(e($faq->answer)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        @endif
                        @break
                @endswitch
            @endif
        @endforeach
    </main>
    </main>
    {{-- Footer --}}
    <footer id="kontak" class="bg-deep text-primary-foreground">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3">
            <div>
                <p class="font-serif text-lg font-bold">Desa {{ $village->name }}</p>
                <p class="mt-3 max-w-sm text-sm leading-6 text-primary-foreground/75">Portal resmi pelayanan dan informasi Pemerintah Desa {{ $village->name }}.</p>
            </div>
            <div>
                <p class="text-sm font-semibold">Kantor Desa</p>
                @if($village->address)
                <p class="mt-3 flex gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg> 
                    {{ $village->address }}
                </p>
                @endif
                @if($village->office_hours)
                <p class="mt-2 flex gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5 size-4 shrink-0"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    {{ $village->office_hours }}
                </p>
                @endif
            </div>
            <div>
                <p class="text-sm font-semibold">Hubungi Kami</p>
                @if($village->contact_phone)
                <p class="mt-3 flex items-center gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"></path></svg> 
                    {{ $village->contact_phone }}
                </p>
                @endif
                @if($village->contact_email)
                <p class="mt-2 flex items-center gap-2 text-sm text-primary-foreground/75">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path><rect x="2" y="4" width="20" height="16" rx="2"></rect></svg> 
                    {{ $village->contact_email }}
                </p>
                @endif
            </div>
        </div>
        <div class="border-t border-primary-foreground/20">
            <div class="mx-auto max-w-7xl px-4 py-4 text-xs text-primary-foreground/60 sm:px-6">© {{ date('Y') }} Pemerintah Desa {{ $village->name }}. All rights reserved.</div>
        </div>
    </footer>
</div>

{{-- Back to Top Button --}}
<div 
    x-data="{ showBackToTop: false }" 
    x-init="window.addEventListener('scroll', () => { showBackToTop = window.scrollY > 400 })"
>
    <button
        x-show="showBackToTop"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        x-cloak
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 inline-flex items-center justify-center size-11 rounded border border-border bg-surface text-primary shadow-lg hover:bg-muted transition-colors"
        aria-label="Kembali ke atas"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>
</div>

</body>
</html>
