<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Dashboard Admin Provinsi
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 border-l-4 border-l-amber-400">
                    <div class="text-2xl font-extrabold text-ivory-text">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Menunggu Review</div>
                </div>
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 border-l-4 border-l-green-400">
                    <div class="text-2xl font-extrabold text-ivory-text">{{ $stats['published'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Disetujui / Tayang</div>
                </div>
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 border-l-4 border-l-red-400">
                    <div class="text-2xl font-extrabold text-ivory-text">{{ $stats['rejected'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Ditolak</div>
                </div>
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 border-l-4 border-l-cobalt">
                    <div class="text-2xl font-extrabold text-ivory-text">{{ $stats['total'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Total Terdaftar</div>
                </div>
            </div>

            {{-- Pending Queue --}}
            @if($pendingVillages->count() > 0)
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-slate-border/15">
                        <h3 class="text-lg font-bold text-ivory-text">Antrean Menunggu Review</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-border/10">
                            <thead class="bg-obsidian-button/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Nama Desa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Perwakilan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Template</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Diajukan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-border/10">
                                @foreach($pendingVillages as $village)
                                    <tr class="hover:bg-obsidian-button/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-ivory-text">{{ $village->name }}</div>
                                            <div class="text-xs text-ash-text/60 font-mono">/desa/{{ $village->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->kecamatan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->user?->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->template->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->submitted_at?->diffForHumans() ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('admin.review', $village) }}"
                                                class="text-sm font-medium text-cobalt hover:text-cobalt-hover transition">
                                                Review →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- All Villages --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-border/15">
                    <h3 class="text-lg font-bold text-ivory-text">Semua Desa Terdaftar</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-border/10">
                        <thead class="bg-obsidian-button/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Nama Desa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Kabupaten</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Template</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @foreach($allVillages as $village)
                                <tr class="hover:bg-obsidian-button/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-ivory-text">{{ $village->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->kabupaten }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">{{ $village->template->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-portal.status-badge :status="$village->status" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.review', $village) }}"
                                            class="text-sm font-medium text-cobalt hover:text-cobalt-hover transition">
                                            Detail
                                        </a>
                                        
                                        @if($village->status === 'published')
                                            <a href="{{ url('/desa/' . $village->slug) }}"
                                                class="text-sm font-medium text-green-600 hover:text-green-700 transition" target="_blank">
                                                Lihat
                                            </a>
                                            
                                            <form action="{{ route('admin.toggle-featured', $village) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-sm font-medium transition {{ $village->is_featured ? 'text-amber-500 hover:text-amber-600' : 'text-ash-text hover:text-ivory-text' }}" title="Tampilkan di Beranda">
                                                    ★
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.destroy', $village) }}" method="POST" class="inline" onsubmit="return confirm('PERINGATAN: Anda akan menghapus desa ini beserta seluruh datanya secara permanen. Apakah Anda yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700 transition" title="Hapus Desa">
                                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
