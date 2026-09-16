<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('layanan.dashboard') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Detail Permohonan Informasi
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Status Banner --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-bold text-ivory-text">Permohonan ke: {{ $ppidRequest->agency }}</h3>
                    <p class="text-sm text-ash-text mt-1">Diajukan pada {{ $ppidRequest->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div>
                    @if($ppidRequest->status === 'pending')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                            Pending
                        </span>
                    @elseif($ppidRequest->status === 'processed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-blue-500/10 text-blue-500 border border-blue-500/20">
                            Sedang Diproses
                        </span>
                    @elseif($ppidRequest->status === 'completed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-500/10 text-green-500 border border-green-500/20">
                            Selesai
                        </span>
                    @elseif($ppidRequest->status === 'rejected')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-500/10 text-red-500 border border-red-500/20">
                            Ditolak
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

            {{-- Admin Reply Section --}}
            @if($ppidRequest->admin_reply || $ppidRequest->admin_reply_file_path)
                <div class="bg-obsidian-button border border-cobalt/30 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <h4 class="text-cobalt font-bold text-lg">Balasan dari Admin Desa</h4>
                    </div>
                    
                    @if($ppidRequest->admin_reply)
                        <div class="bg-graphite-card p-4 rounded-xl text-ivory-text text-sm mb-4 whitespace-pre-line border border-slate-border/20">
                            {{ $ppidRequest->admin_reply }}
                        </div>
                    @endif

                    @if($ppidRequest->admin_reply_file_path)
                        <a href="{{ route('layanan.ppid.download', $ppidRequest->id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-cobalt hover:bg-cobalt/80 text-white rounded-xl font-bold shadow-lg shadow-cobalt/20 transition mt-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download Dokumen Balasan
                        </a>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Data Pemohon --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Data Pemohon</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-xs text-ash-text/70 mb-1">Nama Lengkap</dt>
                            <dd class="text-sm font-medium text-ivory-text">{{ $ppidRequest->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-ash-text/70 mb-1">Tujuan / Instansi</dt>
                            <dd class="text-sm font-medium text-ivory-text">{{ $ppidRequest->agency }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-ash-text/70 mb-1">Nomor WhatsApp</dt>
                            <dd class="text-sm font-medium text-ivory-text">{{ $ppidRequest->phone }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-ash-text/70 mb-1">Alamat Email</dt>
                            <dd class="text-sm font-medium text-ivory-text">{{ $ppidRequest->email }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Rincian Informasi --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Rincian Informasi</h4>
                    <div class="p-4 bg-obsidian-button border border-slate-border/20 rounded-xl text-sm text-ivory-text whitespace-pre-line h-full min-h-[150px]">
                        {{ $ppidRequest->content }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
