<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Layanan Administrasi
            </h2>
            <p class="text-sm text-ash-text mt-1">
                Desa {{ auth()->user()->village->name ?? 'Belum terhubung' }}
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-status-approved-bg/20 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Ajukan Layanan Baru --}}
            <div>
                <h3 class="text-lg font-bold text-ivory-text mb-4">
                    Ajukan Layanan Baru
                </h3>
                
                @if($services->isEmpty())
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-10 text-center">
                        <svg class="w-16 h-16 text-slate-border/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-ash-text">Belum ada layanan administrasi yang disediakan oleh desa Anda.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($services as $service)
                            <a href="{{ route('layanan.pengajuan.create', $service->id) }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition flex-shrink-0">
                                        <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-ivory-text group-hover:text-cobalt transition">{{ $service->name }}</h4>
                                        <p class="text-xs text-ash-text mt-1 line-clamp-1">{{ $service->description }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Riwayat Pengajuan --}}
            <div>
                <h3 class="text-lg font-bold text-ivory-text mb-4 mt-8">
                    Riwayat Pengajuan
                </h3>
                
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                    @if($pengajuan->isEmpty())
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-obsidian-button rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-ash-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                            <p class="text-ash-text">Anda belum memiliki riwayat pengajuan layanan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="text-xs uppercase bg-obsidian-button/50 text-ash-text border-b border-slate-border/15">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">Kode Tracking</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Layanan</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Pengajuan</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-border/15 text-ash-text">
                                    @foreach($pengajuan as $item)
                                        <tr class="hover:bg-obsidian-button/30 transition-colors">
                                            <td class="px-6 py-4 font-medium text-ivory-text">
                                                {{ $item->kode_tracking }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $item->layanan->name }}
                                            </td>
                                            <td class="px-6 py-4 text-xs">
                                                {{ $item->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($item->status === 'diajukan')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                                        Diajukan
                                                    </span>
                                                @elseif($item->status === 'diproses')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-cobalt/10 text-cobalt border border-cobalt/20">
                                                        Diproses
                                                    </span>
                                                @elseif($item->status === 'selesai')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-green-500/10 text-green-500 border border-green-500/20">
                                                        Selesai
                                                    </span>
                                                @elseif($item->status === 'ditolak')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20">
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('layanan.pengajuan.show', $item->kode_tracking) }}" class="inline-flex items-center px-4 py-2 bg-obsidian-button border border-slate-border/20 rounded-lg text-xs font-semibold text-ivory-text hover:border-cobalt/50 hover:text-cobalt transition-colors">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($pengajuan->hasPages())
                            <div class="p-4 border-t border-slate-border/15 bg-obsidian-button/20">
                                {{ $pengajuan->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Riwayat Permohonan PPID --}}
            <div>
                <div class="flex items-center justify-between mb-4 mt-8">
                    <h3 class="text-lg font-bold text-ivory-text">
                        Riwayat Permohonan Informasi (PPID)
                    </h3>
                    <a href="{{ route('layanan.ppid.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-cobalt text-white rounded-lg text-sm font-semibold hover:bg-cobalt/90 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Ajukan Permohonan
                    </a>
                </div>
                
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                    @if($ppidRequests->isEmpty())
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-obsidian-button rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-ash-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-ash-text">Anda belum memiliki riwayat permohonan informasi PPID.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="text-xs uppercase bg-obsidian-button/50 text-ash-text border-b border-slate-border/15">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-semibold">Tujuan / Instansi</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-border/15 text-ash-text">
                                    @foreach($ppidRequests as $item)
                                        <tr class="hover:bg-obsidian-button/30 transition-colors">
                                            <td class="px-6 py-4 font-medium text-ivory-text">
                                                {{ Str::limit($item->agency, 30) }}
                                            </td>
                                            <td class="px-6 py-4 text-xs">
                                                {{ $item->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($item->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                                        Pending
                                                    </span>
                                                @elseif($item->status === 'processed')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-cobalt/10 text-cobalt border border-cobalt/20">
                                                        Diproses
                                                    </span>
                                                @elseif($item->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-green-500/10 text-green-500 border border-green-500/20">
                                                        Selesai
                                                    </span>
                                                @elseif($item->status === 'rejected')
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20">
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('layanan.ppid.show', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-obsidian-button border border-slate-border/20 rounded-lg text-xs font-semibold text-ivory-text hover:border-cobalt/50 hover:text-cobalt transition-colors">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($ppidRequests->hasPages())
                            <div class="p-4 border-t border-slate-border/15 bg-obsidian-button/20">
                                {{ $ppidRequests->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
