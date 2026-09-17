@extends('village.templates.modern.layout', ['title' => 'Agenda Desa'])

@section('content')
<div class="page-header" style="padding-bottom: 2rem;">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Kegiatan Desa</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">Kalender Agenda</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Jadwal kegiatan, musyawarah, dan acara penting lainnya di Desa {{ $village->name }}.</p>
</div>

<div x-data="calendarApp()" style="margin-bottom: 4rem;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;" class="lg:grid-cols-3">
        
        {{-- Calendar Section --}}
        <div class="card lg:col-span-2" style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0;">
                    <span x-text="monthNames[currentMonth - 1]"></span> <span x-text="currentYear"></span>
                </h2>
                <div style="display: flex; gap: 0.5rem;">
                    <button @click="prevMonth()" class="btn-ghost" style="padding: 0.5rem; border-radius: 0.5rem;" :disabled="loading">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="nextMonth()" class="btn-ghost" style="padding: 0.5rem; border-radius: 0.5rem;" :disabled="loading">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div style="position: relative; min-height: 300px;">
                <div x-show="loading" style="position: absolute; inset: 0; background: rgba(255,255,255,0.5); backdrop-filter: blur(2px); z-index: 10; display: flex; align-items: center; justify-content: center;">
                    <svg class="animate-spin w-8 h-8" style="color: var(--primary);" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>

                {{-- Days Header --}}
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); text-align: center; margin-bottom: 0.5rem;">
                    <template x-for="day in dayNames">
                        <div x-text="day.substring(0,3)" style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg); padding: 0.5rem 0;"></div>
                    </template>
                </div>

                {{-- Calendar Grid --}}
                <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 0.25rem;">
                    <template x-for="(cell, index) in calendarCells" :key="index">
                        <div style="aspect-ratio: 1/1;">
                            <template x-if="cell.currentMonth">
                                <button @click="selectDate(cell.dateStr, cell.day)" 
                                        style="width: 100%; height: 100%; border-radius: 0.5rem; display: flex; flex-direction: column; align-items: center; padding: 0.25rem; border: 1px solid transparent; transition: all 0.2s;"
                                        :style="selectedDate === cell.dateStr ? 'background-color: var(--primary); color: #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1);' : (isToday(cell.dateStr) ? 'background-color: var(--muted); border-color: var(--border); color: var(--fg);' : 'background-color: transparent; color: var(--fg);')"
                                        x-bind:class="selectedDate !== cell.dateStr ? 'hover:bg-gray-100' : ''">
                                    <span style="font-weight: 600; font-size: 0.875rem;" x-text="cell.day"></span>
                                    <div style="display: flex; gap: 2px; margin-top: auto; flex-wrap: wrap; justify-content: center; height: 6px;">
                                        <template x-for="ev in getEventsForDay(cell.day).slice(0,3)">
                                            <span style="width: 4px; height: 4px; border-radius: 50%;" :style="selectedDate === cell.dateStr ? 'background-color: #fff;' : 'background-color: ' + ev.category_color"></span>
                                        </template>
                                    </div>
                                </button>
                            </template>
                            <template x-if="!cell.currentMonth">
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem; color: var(--muted-fg); opacity: 0.5;" x-text="cell.day"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Selected Date Events & Upcoming --}}
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            {{-- Selected Date --}}
            <div x-show="selectedDate" x-cloak class="card" style="padding: 1.5rem; border-color: var(--primary);">
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1rem; color: var(--fg);" x-text="selectedDateLabel"></h3>
                
                <template x-if="selectedEvents.length > 0">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <template x-for="ev in selectedEvents">
                            <div style="padding: 1rem; border-radius: 0.75rem; background-color: var(--muted); border-left: 4px solid;" :style="'border-left-color: ' + ev.category_color">
                                <h4 style="font-size: 0.9375rem; font-weight: 700; margin-bottom: 0.5rem;" x-text="ev.title"></h4>
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.8125rem; color: var(--muted-fg);">
                                    <div x-show="ev.start_time" style="display: flex; align-items: center; gap: 0.5rem;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span x-text="ev.start_time + (ev.end_time ? ' - ' + ev.end_time : ' WIB')"></span>
                                    </div>
                                    <div x-show="ev.location" style="display: flex; align-items: flex-start; gap: 0.5rem;">
                                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                        <span x-text="ev.location"></span>
                                    </div>
                                </div>
                                <div x-show="ev.description" style="margin-top: 0.75rem; font-size: 0.8125rem; color: var(--fg);" x-text="ev.description"></div>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="selectedEvents.length === 0">
                    <p style="font-size: 0.875rem; color: var(--muted-fg);">Tidak ada agenda di tanggal ini.</p>
                </template>
            </div>

            {{-- Upcoming Agenda --}}
            <div class="card" style="padding: 1.5rem; background-color: var(--muted);">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--primary);"></div>
                    <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--fg); margin: 0;">Agenda Mendatang</h3>
                </div>
                
                @if($upcomingAgendas->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($upcomingAgendas as $ua)
                            <div style="background-color: var(--card); padding: 1rem; border-radius: 0.75rem; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                <div style="display: flex; gap: 1rem;">
                                    <div style="flex-shrink: 0; text-align: center;">
                                        <div style="font-family: Outfit, sans-serif; font-size: 1.5rem; font-weight: 800; line-height: 1; color: var(--fg);">{{ $ua->event_date->format('d') }}</div>
                                        <div style="font-size: 0.6875rem; font-weight: 700; text-transform: uppercase; color: var(--primary); margin-top: 0.25rem;">{{ $ua->event_date->translatedFormat('M') }}</div>
                                    </div>
                                    <div style="min-width: 0;">
                                        <h4 style="font-size: 0.9375rem; font-weight: 700; margin-bottom: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--fg);">{{ $ua->title }}</h4>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="display: inline-flex; items-center: center; gap: 0.25rem; font-size: 0.625rem; font-weight: 700; text-transform: uppercase; padding: 0.125rem 0.375rem; border-radius: 9999px; background-color: {{ $ua->category_color }}18; color: {{ $ua->category_color }};">
                                                <span style="width: 4px; height: 4px; border-radius: 50%; background-color: {{ $ua->category_color }};"></span>
                                                {{ $ua->category_label }}
                                            </span>
                                            @if($ua->start_time)
                                                <span style="font-size: 0.6875rem; color: var(--muted-fg);">{{ substr($ua->start_time, 0, 5) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="font-size: 0.875rem; color: var(--muted-fg);">Belum ada agenda mendatang.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
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

                for (let i = firstDay - 1; i >= 0; i--) {
                    let d = prevMonthDays - i;
                    cells.push({ day: d, currentMonth: false, dateStr: '' });
                }
                for (let d = 1; d <= daysInMonth; d++) {
                    let dateStr = this.currentYear + '-' + String(this.currentMonth).padStart(2,'0') + '-' + String(d).padStart(2,'0');
                    cells.push({ day: d, currentMonth: true, dateStr: dateStr });
                }
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
@endpush
@endsection
