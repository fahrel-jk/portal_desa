<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Dashboard Layanan Warga
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-status-approved-bg/20 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 mb-8">
                <h3 class="text-lg font-bold text-ivory-text mb-2">Desa {{ $village->name }}</h3>
                <p class="text-sm text-ash-text">Selamat datang di portal layanan administrasi digital. Pilih layanan yang Anda butuhkan di bawah ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Daftar Layanan Tersedia --}}
                <div>
                    <h3 class="text-lg font-bold text-ivory-text mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Layanan Tersedia
                    </h3>
                    <div class="space-y-4">
                        @forelse($services as $service)
                            <div class="bg-obsidian-button/50 border border-slate-border/15 rounded-xl p-5 hover:border-cobalt/30 transition group">
                                <h4 class="font-bold text-ivory-text">{{ $service->name }}</h4>
                                <p class="text-xs text-ash-text mt-1 mb-3">{{ Str::limit($service->description, 100) }}</p>
                                <a href="{{ route('layanan.create', $service->id) }}" class="inline-flex items-center text-sm font-medium text-cobalt hover:text-cobalt-hover transition">
                                    Ajukan Layanan &rarr;
                                </a>
                            </div>
                        @empty
                            <div class="bg-obsidian-button/30 border border-slate-border/10 rounded-xl p-6 text-center text-ash-text text-sm">
                                Belum ada layanan digital yang disediakan oleh desa ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Riwayat Pengajuan --}}
                <div>
                    <h3 class="text-lg font-bold text-ivory-text mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Riwayat Pengajuan Saya
                    </h3>
                    <div class="space-y-4">
                        @forelse($requests as $req)
                            <div class="bg-obsidian-button/50 border border-slate-border/15 rounded-xl p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-ivory-text">{{ $req->service->name }}</h4>
                                    @if($req->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Pending</span>
                                    @elseif($req->status === 'processed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">Diproses</span>
                                    @elseif($req->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">Selesai</span>
                                    @elseif($req->status === 'rejected')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">Ditolak</span>
                                    @endif
                                </div>
                                <p class="text-xs text-ash-text mb-2">Diajukan pada {{ $req->created_at->format('d M Y, H:i') }}</p>
                                
                                @if($req->response_message)
                                    <div class="mt-3 bg-black/20 p-3 rounded-lg border border-slate-border/10">
                                        <p class="text-xs text-ash-text mb-1">Pesan dari Desa:</p>
                                        <p class="text-sm text-ivory-text">{{ $req->response_message }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="bg-obsidian-button/30 border border-slate-border/10 rounded-xl p-6 text-center text-ash-text text-sm">
                                Anda belum pernah mengajukan layanan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
