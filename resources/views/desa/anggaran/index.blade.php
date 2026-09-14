<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Anggaran (APBDes)
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

            {{-- Filter Tahun --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <label for="tahun" class="text-sm font-medium text-ash-text">Tahun Anggaran:</label>
                        @if($years->count() > 0)
                            <select id="tahun" onchange="window.location.href='{{ route('desa.anggaran.index') }}?tahun=' + this.value"
                                class="rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2 focus:border-cobalt focus:ring-cobalt">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="text-sm text-ash-text">Belum ada data anggaran</span>
                        @endif
                    </div>
                    <a href="{{ route('desa.anggaran.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Anggaran
                    </a>
                </div>
            </div>

            {{-- Ringkasan Total --}}
            @if($anggarans->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                            </div>
                            <span class="text-sm text-ash-text">Total Pendapatan</span>
                        </div>
                        <p class="text-xl font-bold text-emerald-400">Rp {{ number_format($totals['pendapatan'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                </svg>
                            </div>
                            <span class="text-sm text-ash-text">Total Belanja</span>
                        </div>
                        <p class="text-xl font-bold text-red-400">Rp {{ number_format($totals['belanja'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>
                            <span class="text-sm text-ash-text">Total Pembiayaan</span>
                        </div>
                        <p class="text-xl font-bold text-blue-400">Rp {{ number_format($totals['pembiayaan'], 0, ',', '.') }}</p>
                    </div>
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl">
                <div class="p-6 border-b border-slate-border/10">
                    <h3 class="text-lg font-semibold text-ivory-text">
                        Rincian Anggaran {{ $selectedYear ? 'Tahun ' . $selectedYear : '' }}
                    </h3>
                </div>

                @if($anggarans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-obsidian-button/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Bidang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase">Uraian</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase">Anggaran</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase">Realisasi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($anggarans as $item)
                                    <tr class="hover:bg-obsidian-button/30 transition">
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $item->kategori === 'pendapatan' ? 'bg-emerald-500/10 text-emerald-400' : '' }}
                                                {{ $item->kategori === 'belanja' ? 'bg-red-500/10 text-red-400' : '' }}
                                                {{ $item->kategori === 'pembiayaan' ? 'bg-blue-500/10 text-blue-400' : '' }}
                                            ">
                                                {{ ucfirst($item->kategori) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-ash-text">{{ $item->bidang ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-ivory-text text-sm">{{ $item->uraian }}</div>
                                            @if($item->keterangan)
                                                <div class="text-xs text-ash-text mt-1">{{ Str::limit($item->keterangan, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ivory-text text-right font-mono">
                                            Rp {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ivory-text text-right font-mono">
                                            Rp {{ number_format($item->jumlah_realisasi, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('desa.anggaran.edit', $item) }}" class="text-cobalt hover:underline mr-3">Edit</a>
                                            <form action="{{ route('desa.anggaran.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data anggaran ini?')">
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
                        Belum ada data anggaran{{ $selectedYear ? ' untuk tahun ' . $selectedYear : '' }}.
                        <a href="{{ route('desa.anggaran.create') }}" class="text-cobalt hover:underline ml-1">Tambah sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
