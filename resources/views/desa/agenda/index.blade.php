<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Agenda Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Filter Bulan --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-medium text-ash-text">Bulan:</label>
                        <select id="filter-month" class="rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2 focus:border-cobalt focus:ring-cobalt">
                            @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
                                <option value="{{ $i + 1 }}" {{ $month == ($i + 1) ? 'selected' : '' }}>{{ $namaBulan }}</option>
                            @endforeach
                        </select>
                        <select id="filter-year" class="rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2 focus:border-cobalt focus:ring-cobalt">
                            @for($y = now()->year - 1; $y <= now()->year + 2; $y++)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <button onclick="applyFilter()" class="inline-flex items-center px-3 py-2 bg-slate-border/20 text-ivory-text text-sm rounded-md hover:bg-slate-border/30 transition">
                            Filter
                        </button>
                    </div>
                    <a href="{{ route('desa.agenda.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Agenda
                    </a>
                </div>
            </div>

            {{-- Tabel Agenda --}}
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl">
                <div class="p-6 border-b border-slate-border/10">
                    <h3 class="text-lg font-semibold text-ivory-text">
                        @php
                            $namaBulanList = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        @endphp
                        Agenda {{ $namaBulanList[$month] }} {{ $year }}
                    </h3>
                </div>

                @if($agendas->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-obsidian-button/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Judul</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($agendas as $agenda)
                                    <tr class="hover:bg-obsidian-button/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-ivory-text text-lg">{{ $agenda->event_date->format('d') }}</span>
                                                <span class="text-xs text-ash-text">{{ $agenda->event_date->translatedFormat('D') }}</span>
                                                @if($agenda->is_important)
                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse" title="Penting"></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-ivory-text text-sm">{{ $agenda->title }}</div>
                                            @if($agenda->description)
                                                <div class="text-xs text-ash-text mt-1">{{ Str::limit($agenda->description, 60) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                            @if($agenda->start_time)
                                                {{ substr($agenda->start_time, 0, 5) }}
                                                @if($agenda->end_time) - {{ substr($agenda->end_time, 0, 5) }} @endif
                                            @else
                                                <span class="text-ash-text/50">Sepanjang hari</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                            {{ $agenda->location ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php $catColors = \App\Models\VillageAgenda::CATEGORY_COLORS; @endphp
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $catColors[$agenda->category] ?? '#6B7280' }}20; color: {{ $catColors[$agenda->category] ?? '#6B7280' }}">
                                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $catColors[$agenda->category] ?? '#6B7280' }}"></span>
                                                {{ \App\Models\VillageAgenda::CATEGORY_OPTIONS[$agenda->category] ?? $agenda->category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('desa.agenda.edit', $agenda) }}" class="text-cobalt hover:underline mr-3">Edit</a>
                                            <form action="{{ route('desa.agenda.destroy', $agenda) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-ash-text">
                        Belum ada agenda untuk bulan ini.
                        <a href="{{ route('desa.agenda.create') }}" class="text-cobalt hover:underline ml-1">Tambah sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function applyFilter() {
            var month = document.getElementById('filter-month').value;
            var year = document.getElementById('filter-year').value;
            window.location.href = '{{ route('desa.agenda.index') }}?year=' + year + '&month=' + month;
        }
    </script>
</x-app-layout>
