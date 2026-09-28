<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-ivory-text leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard Admin Provinsi
                </h2>
                <p class="text-xs text-ash-text mt-1">Kelola dan review pendaftaran desa dari seluruh Jawa Timur.</p>
            </div>
            <a href="{{ route('admin.monitoring') }}"
               class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-cobalt bg-cobalt/10 hover:bg-cobalt/20 rounded-lg transition border border-cobalt/20">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Monitoring
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="relative bg-graphite-card border border-amber-400/20 border-l-4 border-l-amber-400 rounded-2xl p-5 overflow-hidden group hover:border-amber-400/40 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-amber-400/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-amber-400/10 transition-colors pointer-events-none"></div>
                    <div class="text-2xl font-extrabold text-amber-400">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Menunggu Review</div>
                </div>
                <div class="relative bg-graphite-card border border-green-400/20 border-l-4 border-l-green-400 rounded-2xl p-5 overflow-hidden group hover:border-green-400/40 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-green-400/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-green-400/10 transition-colors pointer-events-none"></div>
                    <div class="text-2xl font-extrabold text-green-400">{{ $stats['published'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Disetujui / Tayang</div>
                </div>
                <div class="relative bg-graphite-card border border-red-400/20 border-l-4 border-l-red-400 rounded-2xl p-5 overflow-hidden group hover:border-red-400/40 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-400/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-red-400/10 transition-colors pointer-events-none"></div>
                    <div class="text-2xl font-extrabold text-red-400">{{ $stats['rejected'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Ditolak</div>
                </div>
                <div class="relative bg-graphite-card border border-cobalt/20 border-l-4 border-l-cobalt rounded-2xl p-5 overflow-hidden group hover:border-cobalt/40 transition-all duration-300">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-cobalt/5 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:bg-cobalt/10 transition-colors pointer-events-none"></div>
                    <div class="text-2xl font-extrabold text-cobalt">{{ $stats['total'] }}</div>
                    <div class="text-xs text-ash-text uppercase tracking-widest mt-1">Total Terdaftar</div>
                </div>
            </div>

            {{-- Pending Queue --}}
            @if($pendingVillages->count() > 0)
                <div class="bg-graphite-card border border-amber-400/20 rounded-2xl overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-slate-border/15 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                        <h3 class="text-base font-bold text-ivory-text">Antrean Menunggu Review</h3>
                        <span class="ml-auto inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400/10 text-amber-400 border border-amber-400/20">
                            {{ $pendingVillages->count() }} desa
                        </span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-border/10">
                            <thead class="bg-obsidian-button/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider">Nama Desa</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden sm:table-cell">Kecamatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden md:table-cell">Perwakilan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden lg:table-cell">Template</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden lg:table-cell">Diajukan</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-ash-text uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-border/10">
                                @foreach($pendingVillages as $village)
                                    <tr class="hover:bg-obsidian-button/30 transition group">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-ivory-text text-sm">{{ $village->name }}</div>
                                            <div class="text-xs text-ash-text/60 font-mono mt-0.5">/desa/{{ $village->slug }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-ash-text hidden sm:table-cell">{{ $village->kecamatan }}</td>
                                        <td class="px-6 py-4 text-sm text-ash-text hidden md:table-cell">{{ $village->user?->name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-ash-text hidden lg:table-cell">{{ $village->template->name }}</td>
                                        <td class="px-6 py-4 text-sm text-ash-text hidden lg:table-cell">{{ $village->submitted_at?->diffForHumans() ?? '-' }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.review', $village) }}"
                                               class="inline-flex items-center gap-1 text-xs font-semibold text-cobalt hover:text-white bg-cobalt/10 hover:bg-cobalt px-3 py-1.5 rounded-lg border border-cobalt/20 hover:border-cobalt transition-all duration-200">
                                                Review
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                <div class="px-6 py-4 border-b border-slate-border/15 flex items-center justify-between">
                    <h3 class="text-base font-bold text-ivory-text">Semua Desa Terdaftar</h3>
                    <span class="text-xs text-ash-text">{{ $allVillages->count() }} total</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-border/10">
                        <thead class="bg-obsidian-button/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider">Nama Desa</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden sm:table-cell">Kabupaten</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider hidden md:table-cell">Template</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-ash-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-ash-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @foreach($allVillages as $village)
                                <tr class="hover:bg-obsidian-button/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-ivory-text text-sm">{{ $village->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-ash-text hidden sm:table-cell">{{ $village->kabupaten }}</td>
                                    <td class="px-6 py-4 text-sm text-ash-text hidden md:table-cell">{{ $village->template->name }}</td>
                                    <td class="px-6 py-4">
                                        <x-portal.status-badge :status="$village->status" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('admin.review', $village) }}"
                                               class="text-xs font-semibold text-cobalt hover:underline transition">
                                                Detail
                                            </a>

                                            @if($village->status === 'published')
                                                <a href="{{ url('/desa/' . $village->slug) }}"
                                                   class="text-xs font-semibold text-green-400 hover:underline transition" target="_blank">
                                                    Lihat
                                                </a>

                                                <form action="{{ route('admin.toggle-featured', $village) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-base transition {{ $village->is_featured ? 'text-amber-400 hover:text-amber-300' : 'text-ash-text/40 hover:text-amber-400' }}"
                                                            title="{{ $village->is_featured ? 'Unfeature' : 'Tampilkan di Beranda' }}">
                                                        ★
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.destroy', $village) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('PERINGATAN: Anda akan menghapus desa ini beserta seluruh datanya secara permanen. Apakah Anda yakin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-ash-text/40 hover:text-red-400 transition"
                                                        title="Hapus Desa">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
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
