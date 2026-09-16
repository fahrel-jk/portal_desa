<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda Desa {{ $village->name }} — Portal Desa</title>
    <meta name="description" content="Agenda kegiatan dan kalender Desa {{ $village->name }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $themeColor = $village->theme_color ?? 'default';
        $themeMap = [
            'default' => ['--background'=>'#FAF7F0','--foreground'=>'#1A1A1A','--deep'=>'#313F33','--primary'=>'#313F33','--primary-hover'=>'#263328','--primary-foreground'=>'#FFFFFF','--accent'=>'#BA704F','--accent-hover'=>'#A05B3D','--accent-foreground'=>'#FFFFFF','--surface'=>'#FFFFFF','--muted'=>'#E8E5DA','--muted-foreground'=>'#6B7280','--border'=>'#E5E2D5','--card'=>'#FFFFFF','--secondary'=>'#F3F0E6'],
        ];
        $vars = $themeMap[$themeColor] ?? $themeMap['default'];
    @endphp
    <style>
        :root { @foreach($vars as $k => $v) {{ $k }}: {{ $v }}; @endforeach }
        body { font-family: 'IBM Plex Sans', sans-serif; background-color: var(--background); color: var(--foreground); }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-background { background-color: var(--background); }
        .bg-surface { background-color: var(--surface); }
        .bg-primary { background-color: var(--primary); }
        .bg-accent { background-color: var(--accent); }
        .bg-muted { background-color: var(--muted); }
        .bg-card { background-color: var(--card); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-deep { background-color: var(--deep); }
        .text-primary { color: var(--primary); }
        .text-primary-foreground { color: var(--primary-foreground); }
        .text-accent { color: var(--accent); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .border-border { border-color: var(--border); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col" x-data="calendarApp()">

    @include('village.templates.klasik.header')

    <main class="flex-grow py-10 md:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="mb-8">
                <p class="flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.16em] text-accent"><span class="h-px w-7 bg-accent"></span>Kalender Kegiatan</p>
                <h1 class="mt-3 font-serif text-3xl font-bold sm:text-4xl">Agenda Desa {{ $village->name }}</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Calendar --}}
                <div class="lg:col-span-2">
                    <div class="border border-border bg-card rounded-lg overflow-hidden">
                        {{-- Calendar Header --}}
                        <div class="flex items-center justify-between px-6 py-4 border-b border-border bg-secondary">
                            <button @click="prevMonth()" class="p-2 rounded-lg hover:bg-muted transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            </button>
                            <h2 class="font-serif text-lg font-bold" x-text="monthNames[currentMonth - 1] + ' ' + currentYear"></h2>
                            <button @click="nextMonth()" class="p-2 rounded-lg hover:bg-muted transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>

                        {{-- Day Headers --}}
                        <div class="grid grid-cols-7 border-b border-border">
                            <template x-for="day in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="day">
                                <div class="py-3 text-center text-xs font-semibold uppercase tracking-wider text-muted-foreground" x-text="day"></div>
                            </template>
                        </div>

                        {{-- Calendar Grid --}}
                        <div class="grid grid-cols-7" x-show="!loading">
                            <template x-for="(cell, index) in calendarCells" :key="index">
                                <div
                                    class="min-h-[80px] sm:min-h-[100px] border-b border-r border-border p-1.5 sm:p-2 cursor-pointer transition-colors relative"
                                    :class="{
                                        'bg-card hover:bg-secondary': cell.currentMonth,
                                        'bg-secondary/50': !cell.currentMonth,
                                        'ring-2 ring-inset ring-accent': selectedDate === cell.dateStr && cell.currentMonth,
                                        'bg-accent/5': isToday(cell.dateStr)
                                    }"
                                    @click="cell.currentMonth && selectDate(cell.dateStr, cell.day)"
                                >
                                    <div class="flex items-start justify-between">
                                        <span
                                            class="text-sm font-medium leading-none"
                                            :class="{
                                                'text-foreground': cell.currentMonth,
                                                'text-muted-foreground/40': !cell.currentMonth,
                                                'bg-accent text-white rounded-full w-7 h-7 flex items-center justify-center': isToday(cell.dateStr) && cell.currentMonth
                                            }"
                                            x-text="cell.day"
                                        ></span>
                                    </div>
                                    {{-- Event Dots --}}
                                    <div class="mt-1 flex flex-wrap gap-0.5" x-show="cell.currentMonth && getEventsForDay(cell.day).length > 0">
                                        <template x-for="evt in getEventsForDay(cell.day).slice(0, 3)" :key="evt.id">
                                            <span class="block w-full text-[10px] leading-tight px-1 py-0.5 rounded truncate hidden sm:block" :style="'background-color:' + evt.category_color + '18; color:' + evt.category_color" x-text="evt.title"></span>
                                        </template>
                                        <template x-for="evt in getEventsForDay(cell.day).slice(0, 3)" :key="'dot-'+evt.id">
                                            <span class="w-2 h-2 rounded-full sm:hidden" :style="'background-color:' + evt.category_color"></span>
                                        </template>
                                        <span class="text-[10px] text-muted-foreground" x-show="getEventsForDay(cell.day).length > 3" x-text="'+' + (getEventsForDay(cell.day).length - 3)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Loading State --}}
                        <div class="p-12 text-center text-muted-foreground" x-show="loading" x-cloak>
                            <svg class="animate-spin h-6 w-6 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            Memuat kalender...
                        </div>

                        {{-- Category Legend --}}
                        <div class="px-6 py-3 border-t border-border bg-secondary flex flex-wrap gap-3 text-xs">
                            @foreach(\App\Models\VillageAgenda::CATEGORY_OPTIONS as $key => $label)
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ \App\Models\VillageAgenda::CATEGORY_COLORS[$key] }}"></span>
                                    <span class="text-muted-foreground">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar: Selected Date Detail + Upcoming --}}
                <div class="space-y-6">
                    {{-- Selected Date Detail --}}
                    <div class="border border-border bg-card rounded-lg overflow-hidden" x-show="selectedDate" x-cloak>
                        <div class="px-5 py-4 border-b border-border bg-secondary">
                            <h3 class="font-serif text-base font-bold" x-text="selectedDateLabel"></h3>
                        </div>
                        <div class="divide-y divide-border" x-show="selectedEvents.length > 0">
                            <template x-for="evt in selectedEvents" :key="evt.id">
                                <div class="px-5 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-1 h-full min-h-[40px] rounded-full shrink-0" :style="'background-color:' + evt.category_color"></div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium" :style="'background-color:' + evt.category_color + '18; color:' + evt.category_color" x-text="evt.category_label"></span>
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse" x-show="evt.is_important" title="Penting"></span>
                                            </div>
                                            <h4 class="font-bold text-sm" x-text="evt.title"></h4>
                                            <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-muted-foreground">
                                                <span x-show="evt.start_time" class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                                    <span x-text="evt.start_time + (evt.end_time ? ' - ' + evt.end_time : '')"></span>
                                                </span>
                                                <span x-show="evt.location" class="flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                                    <span x-text="evt.location"></span>
                                                </span>
                                            </div>
                                            <p class="mt-2 text-xs text-muted-foreground leading-relaxed" x-show="evt.description" x-text="evt.description"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="px-5 py-6 text-center text-sm text-muted-foreground" x-show="selectedEvents.length === 0">
                            Tidak ada agenda di tanggal ini.
                        </div>
                    </div>

                    {{-- Upcoming Agenda --}}
                    <div class="border border-border bg-card rounded-lg overflow-hidden">
                        <div class="px-5 py-4 border-b border-border bg-secondary">
                            <h3 class="font-serif text-base font-bold">Agenda Mendatang</h3>
                        </div>
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
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="px-5 py-6 text-center text-sm text-muted-foreground">
                                Belum ada agenda mendatang.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-deep text-primary-foreground mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 text-center text-sm opacity-70">
            &copy; {{ date('Y') }} Desa {{ $village->name }}. Dibuat dengan Portal Desa.
        </div>
    </footer>

    @php
        $agendaData = $agendas->map(fn($a) => [
            'id' => $a->id,
            'title' => $a->title,
            'description' => $a->description,
            'event_date' => $a->event_date->format('Y-m-d'),
            'day' => $a->event_date->day,
            'start_time' => $a->start_time ? substr($a->start_time, 0, 5) : null,
            'end_time' => $a->end_time ? substr($a->end_time, 0, 5) : null,
            'location' => $a->location,
            'category' => $a->category,
            'category_label' => $a->category_label,
            'category_color' => $a->category_color,
            'is_important' => $a->is_important
        ])->values()->all();
    @endphp
    <script>
        function calendarApp() {
            return {
                currentYear: {{ $year }},
                currentMonth: {{ $month }},
                agendas: @json($agendaData),
                selectedDate: null,
                selectedEvents: [],
                selectedDateLabel: '',
                loading: false,
                monthNames: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                dayNames: ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],

                get calendarCells() {
                    let cells = [];
                    let firstDay = new Date(this.currentYear, this.currentMonth - 1, 1).getDay();
                    let daysInMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
                    let prevMonthDays = new Date(this.currentYear, this.currentMonth - 1, 0).getDate();

                    // Previous month fill
                    for (let i = firstDay - 1; i >= 0; i--) {
                        let d = prevMonthDays - i;
                        cells.push({ day: d, currentMonth: false, dateStr: '' });
                    }
                    // Current month
                    for (let d = 1; d <= daysInMonth; d++) {
                        let dateStr = this.currentYear + '-' + String(this.currentMonth).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                        cells.push({ day: d, currentMonth: true, dateStr: dateStr });
                    }
                    // Next month fill
                    let remaining = 42 - cells.length;
                    for (let d = 1; d <= remaining; d++) {
                        cells.push({ day: d, currentMonth: false, dateStr: '' });
                    }
                    return cells;
                },

                isToday(dateStr) {
                    return dateStr === new Date().toISOString().split('T')[0];
                },

                getEventsForDay(day) {
                    return this.agendas.filter(a => a.day === day);
                },

                selectDate(dateStr, day) {
                    this.selectedDate = dateStr;
                    this.selectedEvents = this.getEventsForDay(day);
                    let d = new Date(dateStr);
                    this.selectedDateLabel = this.dayNames[d.getDay()] + ', ' + day + ' ' + this.monthNames[this.currentMonth - 1] + ' ' + this.currentYear;
                },

                async prevMonth() {
                    this.currentMonth--;
                    if (this.currentMonth < 1) { this.currentMonth = 12; this.currentYear--; }
                    await this.fetchAgendas();
                },

                async nextMonth() {
                    this.currentMonth++;
                    if (this.currentMonth > 12) { this.currentMonth = 1; this.currentYear++; }
                    await this.fetchAgendas();
                },

                async fetchAgendas() {
                    this.loading = true;
                    this.selectedDate = null;
                    this.selectedEvents = [];
                    try {
                        let res = await fetch('{{ route("village.agenda.api", $village->slug) }}?year=' + this.currentYear + '&month=' + this.currentMonth);
                        let data = await res.json();
                        this.agendas = data.agendas;
                    } catch(e) {
                        console.error('Failed to fetch agendas:', e);
                    }
                    this.loading = false;
                }
            }
        }
    </script>
</body>
</html>
