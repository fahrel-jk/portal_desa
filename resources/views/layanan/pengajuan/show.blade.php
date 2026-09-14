<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('layanan.pengajuan.index') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Detail Pengajuan #{{ $pengajuan->kode_tracking }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Status Banner --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-ivory-text">{{ $pengajuan->layanan->name }}</h3>
                    <p class="text-sm text-ash-text mt-1">Diajukan pada {{ $pengajuan->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div>
                    @if($pengajuan->status === 'diajukan')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                            Menunggu Diproses
                        </span>
                    @elseif($pengajuan->status === 'diproses')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                            Sedang Diproses
                        </span>
                    @elseif($pengajuan->status === 'selesai')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-500/10 text-green-500 border border-green-500/20">
                            Selesai & Disetujui
                        </span>
                    @elseif($pengajuan->status === 'ditolak')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-500/10 text-red-500 border border-red-500/20">
                            Pengajuan Ditolak
                        </span>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            @if($pengajuan->status === 'ditolak' && $pengajuan->alasan_ditolak)
                <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-6 shadow-xl">
                    <h4 class="text-red-400 font-bold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Alasan Penolakan
                    </h4>
                    <p class="text-ivory-text text-sm">{{ $pengajuan->alasan_ditolak }}</p>
                </div>
            @endif

            @if($pengajuan->status === 'selesai' && $pengajuan->file_surat_hasil)
                <div class="bg-graphite-card border border-green-500/30 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-32 h-32 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <div class="relative z-10">
                        <h4 class="text-green-400 font-bold mb-2 text-lg">Surat Hasil Telah Terbit</h4>
                        <p class="text-ash-text text-sm mb-6">Permohonan Anda telah disetujui dan surat digital telah di-generate secara otomatis oleh sistem.</p>
                        
                        <a href="{{ route('layanan.pengajuan.download', $pengajuan->kode_tracking) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-500 text-white rounded-xl font-bold shadow-lg shadow-green-900/50 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Surat PDF
                        </a>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Data Pemohon --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Data Pemohon</h4>
                    <dl class="space-y-4">
                        @foreach($pengajuan->data_pemohon as $key => $value)
                            <div>
                                <dt class="text-xs text-ash-text/70 mb-1 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                                <dd class="text-sm font-medium text-ivory-text">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                {{-- Dokumen Pendukung --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Dokumen Terlampir</h4>
                    
                    @if($pengajuan->dokumen->isEmpty())
                        <p class="text-sm text-ash-text">Tidak ada dokumen yang dilampirkan.</p>
                    @else
                        <div class="space-y-3">
                            @foreach($pengajuan->dokumen as $dok)
                                <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank" class="flex items-center p-3 border border-slate-border/20 rounded-xl bg-obsidian-button/50 hover:bg-obsidian-button transition group">
                                    <div class="w-10 h-10 bg-slate-border/10 rounded-lg flex items-center justify-center shrink-0 mr-3">
                                        <svg class="w-5 h-5 text-ash-text group-hover:text-cobalt transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-ivory-text truncate">{{ $dok->nama_file }}</p>
                                        <p class="text-xs text-ash-text">Lihat dokumen &rarr;</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
