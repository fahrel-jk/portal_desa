<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-ivory-text leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Monitoring Adopsi
                </h2>
                <p class="text-xs text-ash-text mt-1">Pantau tren pendaftaran dan aktivitas desa secara real-time.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-xs text-ash-text hover:text-ivory-text transition">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Statistic Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="relative bg-graphite-card border border-slate-border/15 rounded-2xl p-5 overflow-hidden group hover:border-cobalt/30 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-cobalt/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-semibold text-ash-text uppercase tracking-widest">Total Pendaftar</div>
                        <div class="w-8 h-8 rounded-lg bg-cobalt/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-ivory-text">{{ $stats['total'] }}</div>
                    <div class="mt-1 text-xs text-ash-text">desa terdaftar</div>
                </div>

                <div class="relative bg-graphite-card border border-slate-border/15 rounded-2xl p-5 overflow-hidden group hover:border-green-400/30 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-semibold text-ash-text uppercase tracking-widest">Tayang</div>
                        <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-green-400">{{ $stats['published'] }}</div>
                    <div class="mt-1 text-xs text-ash-text">desa tayang</div>
                </div>

                <div class="relative bg-graphite-card border border-slate-border/15 rounded-2xl p-5 overflow-hidden group hover:border-amber-400/30 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-semibold text-ash-text uppercase tracking-widest">Menunggu</div>
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-amber-400">{{ $stats['pending'] }}</div>
                    <div class="mt-1 text-xs text-ash-text">menunggu review</div>
                </div>

                <div class="relative bg-graphite-card border border-slate-border/15 rounded-2xl p-5 overflow-hidden group hover:border-red-400/30 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="text-xs font-semibold text-ash-text uppercase tracking-widest">Ditolak</div>
                        <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-extrabold text-red-400">{{ $stats['rejected'] }}</div>
                    <div class="mt-1 text-xs text-ash-text">pendaftaran ditolak</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Chart Section --}}
                <div class="lg:col-span-2">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-5 border-b border-slate-border/15 flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-bold text-ivory-text">Tren Pendaftaran</h3>
                                <p class="text-xs text-ash-text mt-0.5">6 bulan terakhir</p>
                            </div>
                            <div class="w-8 h-8 rounded-lg bg-cobalt/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                            </div>
                        </div>
                        <div class="p-6 flex-grow">
                            <div class="relative" style="height: 220px;">
                                <canvas id="registrationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Inactive Villages Section --}}
                <div class="lg:col-span-1">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden h-full flex flex-col">
                        <div class="px-6 py-5 border-b border-slate-border/15">
                            <h3 class="text-base font-bold text-ivory-text">Desa Kurang Aktif</h3>
                            <p class="text-xs text-ash-text mt-0.5">Tidak ada update berita &gt; 30 hari</p>
                        </div>
                        <div class="flex-grow overflow-y-auto max-h-[340px]">
                            @if($inactiveVillages->count() > 0)
                                <ul class="divide-y divide-slate-border/10">
                                    @foreach($inactiveVillages as $village)
                                        <li class="p-4 hover:bg-obsidian-button/30 transition-colors">
                                            <div class="flex justify-between items-start mb-1.5">
                                                <div class="font-medium text-ivory-text text-sm leading-tight">{{ $village->name }}</div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-500/15 text-red-400 border border-red-500/20 flex-shrink-0 ml-2">
                                                    {{ $village->last_activity_days === 'Belum pernah' ? 'Blm ada' : $village->last_activity_days . ' hr' }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-ash-text mb-2">{{ $village->kecamatan }}, {{ $village->kabupaten }}</div>
                                            <div class="text-[11px] text-ash-text/60 space-y-1">
                                                @if($village->contact_phone)
                                                    <div class="flex items-center gap-1.5">
                                                        <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                        {{ $village->contact_phone }}
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-1.5 truncate">
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                    <span class="truncate">{{ $village->user->email ?? 'Tidak ada email' }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex flex-col items-center justify-center py-12 px-6 text-center h-full">
                                    <div class="w-14 h-14 rounded-2xl bg-green-500/10 flex items-center justify-center mb-4">
                                        <svg class="w-7 h-7 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-ivory-text">Semua Aktif! 🎉</p>
                                    <p class="text-xs text-ash-text mt-1">Semua desa yang tayang telah memperbarui berita dalam 30 hari terakhir.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('registrationChart').getContext('2d');

            const labels = {!! json_encode($chartLabels) !!};
            const data = {!! json_encode($chartValues) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendaftaran',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 0.9)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1a2235',
                            borderColor: 'rgba(59, 130, 246, 0.3)',
                            borderWidth: 1,
                            padding: 14,
                            titleFont: { family: 'Inter', size: 12, weight: '600' },
                            bodyFont: { family: 'Inter', size: 16, weight: '700' },
                            displayColors: false,
                            callbacks: {
                                title: (items) => items[0].label,
                                label: (item) => `${item.raw} pendaftaran`,
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                color: '#6b7280',
                                font: { family: 'Inter', size: 11 }
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.04)',
                                drawBorder: false,
                            },
                            border: { display: false }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                            border: { display: false },
                            ticks: {
                                color: '#6b7280',
                                font: { family: 'Inter', size: 11 }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
