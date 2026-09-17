@extends('village.templates.modern.layout', ['title' => 'Transparansi APBDes'])

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <div class="eyebrow" style="margin-bottom: 0.75rem;">Transparansi Keuangan</div>
    <h1 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; margin-bottom: 1rem;">APBDes Desa {{ $village->name }}</h1>
    <p style="color: var(--muted-fg); max-width: 600px; margin: 0 auto; font-size: 1.125rem;">Wujud transparansi pengelolaan keuangan desa untuk masyarakat.</p>
</div>

<div style="max-width: 1120px; margin: 0 auto; margin-bottom: 4rem;">
    @if($years->count() > 0)
        {{-- Year Selector + Download --}}
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 2.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <label for="tahun-select" style="font-size: 0.875rem; font-weight: 700; color: var(--fg);">Tahun Anggaran:</label>
                <select id="tahun-select"
                    onchange="window.location.href='{{ route('village.apbdes', $village->slug) }}?tahun=' + this.value"
                    style="padding: 0.5rem 1rem; border-radius: 0.5rem; border: 1px solid var(--border); background-color: var(--card); color: var(--fg); font-family: inherit; font-size: 0.875rem; font-weight: 600;">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('village.apbdes.pdf', ['slug' => $village->slug, 'tahun' => $selectedYear]) }}" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.875rem; gap: 0.5rem;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Unduh PDF
            </a>
        </div>

        {{-- Summary Cards --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
            {{-- Pendapatan --}}
            <div class="card" style="padding: 1.5rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -1rem; right: -1rem; width: 6rem; height: 6rem; background-color: rgba(16, 185, 129, 0.1); border-radius: 50%;"></div>
                <div style="display: flex; items-center: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background-color: rgba(16, 185, 129, 0.1); display: flex; align-items: center; justify-content: center; color: #10b981;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <span style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted-fg);">Pendapatan</span>
                </div>
                <p style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--fg); margin-bottom: 0.5rem;">Rp {{ number_format($totals['pendapatan']['anggaran'], 0, ',', '.') }}</p>
                <p style="font-size: 0.8125rem; color: var(--muted-fg);">
                    Realisasi: <span style="font-weight: 700; color: #10b981;">Rp {{ number_format($totals['pendapatan']['realisasi'], 0, ',', '.') }}</span>
                </p>
            </div>

            {{-- Belanja --}}
            <div class="card" style="padding: 1.5rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -1rem; right: -1rem; width: 6rem; height: 6rem; background-color: rgba(239, 68, 68, 0.1); border-radius: 50%;"></div>
                <div style="display: flex; items-center: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background-color: rgba(239, 68, 68, 0.1); display: flex; align-items: center; justify-content: center; color: #ef4444;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <span style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted-fg);">Belanja</span>
                </div>
                <p style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--fg); margin-bottom: 0.5rem;">Rp {{ number_format($totals['belanja']['anggaran'], 0, ',', '.') }}</p>
                <p style="font-size: 0.8125rem; color: var(--muted-fg);">
                    Realisasi: <span style="font-weight: 700; color: #ef4444;">Rp {{ number_format($totals['belanja']['realisasi'], 0, ',', '.') }}</span>
                </p>
            </div>

            {{-- SiLPA --}}
            <div class="card" style="padding: 1.5rem; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -1rem; right: -1rem; width: 6rem; height: 6rem; background-color: rgba(59, 130, 246, 0.1); border-radius: 50%;"></div>
                <div style="display: flex; items-center: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="width: 2.5rem; height: 2.5rem; border-radius: 0.5rem; background-color: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <span style="font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted-fg);">Selisih (SiLPA)</span>
                </div>
                <p style="font-family: Outfit, sans-serif; font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem; {{ $selisih >= 0 ? 'color: #10b981;' : 'color: #ef4444;' }}">
                    {{ $selisih >= 0 ? '' : '-' }}Rp {{ number_format(abs($selisih), 0, ',', '.') }}
                </p>
                <p style="font-size: 0.8125rem; color: var(--muted-fg);">
                    {{ $selisih >= 0 ? 'Surplus (sisa anggaran)' : 'Defisit (belanja melebihi pendapatan)' }}
                </p>
            </div>
        </div>

        {{-- Chart --}}
        @if(count($chartData) > 0)
            <div class="card" style="padding: 2rem; margin-bottom: 2.5rem;">
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--fg); display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Grafik Anggaran vs Realisasi Belanja
                </h3>
                <div style="position: relative; max-height: 400px; width: 100%;">
                    <canvas id="apbdesChart"></canvas>
                </div>
            </div>
        @endif

        {{-- Table --}}
        <div class="card" style="overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--border);">
                <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--fg); margin: 0;">Rincian APBDes {{ $selectedYear }}</h3>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background-color: color-mix(in srgb, var(--muted) 40%, transparent); border-bottom: 1px solid var(--border);">
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg);">No</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg);">Uraian</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg);">Bidang</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg); text-align: right;">Anggaran</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg); text-align: right;">Realisasi</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--muted-fg); text-align: right;">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $currentKategori = ''; $no = 1; @endphp
                        @foreach($anggarans as $item)
                            @if($currentKategori !== $item->kategori)
                                @php $currentKategori = $item->kategori; @endphp
                                <tr style="background-color: color-mix(in srgb, var(--muted) 20%, transparent);">
                                    <td colspan="6" style="padding: 0.75rem 1.5rem; border-bottom: 1px solid var(--border);">
                                        <span style="font-size: 0.8125rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: {{ $item->kategori === 'pendapatan' ? '#047857' : ($item->kategori === 'belanja' ? '#be123c' : '#1d4ed8') }};">
                                            {{ ucfirst($item->kategori) }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                            @php
                                $pct = $item->jumlah_anggaran > 0 ? round(($item->jumlah_realisasi / $item->jumlah_anggaran) * 100, 1) : 0;
                            @endphp
                            <tr style="border-bottom: 1px solid var(--border); transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='color-mix(in srgb, var(--muted) 30%, transparent)'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--muted-fg);">{{ $no++ }}</td>
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="font-size: 0.875rem; font-weight: 600; color: var(--fg);">{{ $item->uraian }}</div>
                                    @if($item->keterangan)
                                        <div style="font-size: 0.75rem; color: var(--muted-fg); margin-top: 0.25rem;">{{ $item->keterangan }}</div>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: var(--muted-fg);">{{ $item->bidang ?? '-' }}</td>
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: var(--fg); text-align: right; font-family: monospace;">
                                    {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}
                                </td>
                                <td style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 600; color: var(--fg); text-align: right; font-family: monospace;">
                                    {{ number_format($item->jumlah_realisasi, 0, ',', '.') }}
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right;">
                                    <span style="display: inline-block; padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 700; {{ $pct >= 80 ? 'background-color: #d1fae5; color: #065f46;' : ($pct >= 50 ? 'background-color: #fef3c7; color: #92400e;' : 'background-color: #fee2e2; color: #991b1b;') }}">
                                        {{ $pct }}%
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        
                        <tr style="background-color: var(--muted); border-top: 2px solid var(--border);">
                            <td colspan="3" style="padding: 1.25rem 1.5rem; font-size: 0.875rem; font-weight: 800; text-transform: uppercase; color: var(--fg);">Total Keseluruhan</td>
                            <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem; font-weight: 800; color: var(--fg); text-align: right; font-family: monospace;">
                                {{ number_format($totals['pendapatan']['anggaran'] + $totals['belanja']['anggaran'] + $totals['pembiayaan']['anggaran'], 0, ',', '.') }}
                            </td>
                            <td style="padding: 1.25rem 1.5rem; font-size: 0.875rem; font-weight: 800; color: var(--fg); text-align: right; font-family: monospace;">
                                {{ number_format($totals['pendapatan']['realisasi'] + $totals['belanja']['realisasi'] + $totals['pembiayaan']['realisasi'], 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    @else
        <div class="card" style="padding: 4rem 2rem; text-align: center;">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            <h3 style="font-family: Outfit, sans-serif; font-size: 1.25rem; font-weight: 700; color: var(--fg); margin-bottom: 0.5rem;">Belum Ada Data Anggaran</h3>
            <p style="color: var(--muted-fg);">Data transparansi anggaran desa ini belum tersedia.</p>
        </div>
    @endif
</div>

@if(count($chartData) > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('apbdesChart').getContext('2d');
        const chartData = @json($chartData);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.map(d => d.label),
                datasets: [
                    {
                        label: 'Anggaran',
                        data: chartData.map(d => d.anggaran),
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderRadius: 4,
                        barPercentage: 0.6,
                    },
                    {
                        label: 'Realisasi',
                        data: chartData.map(d => d.realisasi),
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 4,
                        barPercentage: 0.6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: "'Figtree', sans-serif" } } },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000000) return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                                return 'Rp ' + value;
                            },
                            font: { family: "'Figtree', sans-serif", size: 11 }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        ticks: { font: { family: "'Figtree', sans-serif", size: 11 }, maxRotation: 45 },
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endpush
@endif
@endsection
