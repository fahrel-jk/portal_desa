<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitoring Adopsi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Statistic Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 truncate mb-1">Total Pendaftar</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 truncate mb-1">Desa Diterbitkan (Published)</div>
                        <div class="text-3xl font-bold text-green-600">{{ $stats['published'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 truncate mb-1">Menunggu Review</div>
                        <div class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100">
                    <div class="p-6">
                        <div class="text-sm font-medium text-gray-500 truncate mb-1">Ditolak</div>
                        <div class="text-3xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Chart Section --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 h-full">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-medium text-gray-900">Tren Pendaftaran (6 Bulan Terakhir)</h3>
                        </div>
                        <div class="p-6 relative">
                            <canvas id="registrationChart" height="120"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Inactive Villages Section --}}
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 h-full flex flex-col">
                        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-lg font-medium text-gray-900">Desa Kurang Aktif</h3>
                            <p class="text-sm text-gray-500 mt-1">Tidak ada update berita > 30 hari</p>
                        </div>
                        <div class="p-0 flex-grow overflow-y-auto max-h-[400px]">
                            @if($inactiveVillages->count() > 0)
                                <ul class="divide-y divide-gray-100">
                                    @foreach($inactiveVillages as $village)
                                        <li class="p-4 hover:bg-gray-50 transition-colors">
                                            <div class="flex justify-between items-start mb-1">
                                                <div class="font-medium text-gray-900">{{ $village->name }}</div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $village->last_activity_days === 'Belum pernah' ? 'Belum ada berita' : $village->last_activity_days . ' hari' }}
                                                </span>
                                            </div>
                                            <div class="text-sm text-gray-500 mb-2">
                                                {{ $village->kecamatan }}, {{ $village->kabupaten }}
                                            </div>
                                            <div class="text-xs text-gray-400 space-y-1">
                                                @if($village->contact_phone)
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                        {{ $village->contact_phone }}
                                                    </div>
                                                @endif
                                                <div class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                    {{ $village->user->email ?? 'Tidak ada email' }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm font-medium">Bagus!</p>
                                    <p class="text-xs mt-1">Semua desa yang tayang telah memperbarui berita dalam 30 hari terakhir.</p>
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
                        label: 'Jumlah Pendaftaran',
                        data: data,
                        backgroundColor: '#4f46e5', // Indigo-600
                        borderRadius: 4,
                        barThickness: 32,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { family: 'Inter', size: 13 },
                            bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                            displayColors: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                font: { family: 'Inter' }
                            },
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false,
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { family: 'Inter' }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
