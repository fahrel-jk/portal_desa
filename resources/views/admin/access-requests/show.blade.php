<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Review Request Akses
            </h2>
            <a href="{{ route('admin.access-requests.index') }}" class="text-sm text-ash-text hover:text-ivory-text transition">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-red-300">{{ session('error') }}</p>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-8 mb-6 shadow-xl">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-ivory-text">{{ $accessRequest->nama_lengkap }}</h3>
                        <p class="text-ash-text">Meminta akses untuk layanan Desa <span class="text-cobalt font-medium">{{ $accessRequest->village->name }}</span></p>
                    </div>
                    <div>
                        @if($accessRequest->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Pending Review</span>
                        @elseif($accessRequest->status === 'approved')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/10 text-green-500 border border-green-500/20">Disetujui</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/10 text-red-500 border border-red-500/20">Ditolak</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-slate-border/20 pt-6">
                    <div>
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Informasi Pemohon</h4>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs text-ash-text/70 mb-1">NIK</dt>
                                <dd class="text-sm font-medium text-ivory-text">{{ $accessRequest->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-ash-text/70 mb-1">Email</dt>
                                <dd class="text-sm font-medium text-ivory-text">{{ $accessRequest->email }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-ash-text/70 mb-1">Nomor HP</dt>
                                <dd class="text-sm font-medium text-ivory-text">{{ $accessRequest->no_hp }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-ash-text/70 mb-1">Jabatan / Keperluan</dt>
                                <dd class="text-sm font-medium text-ivory-text">{{ $accessRequest->jabatan_keperluan }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4">Dokumen Pendukung</h4>
                        @if($accessRequest->dokumen_pendukung)
                            <a href="{{ asset('storage/' . $accessRequest->dokumen_pendukung) }}" target="_blank" class="block p-4 border border-slate-border/20 rounded-xl bg-obsidian-button/50 hover:bg-obsidian-button transition group text-center">
                                <svg class="w-8 h-8 text-ash-text group-hover:text-cobalt transition mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="text-sm text-ivory-text block">Lihat Dokumen</span>
                            </a>
                        @else
                            <p class="text-sm text-ash-text">Tidak ada dokumen dilampirkan.</p>
                        @endif
                        
                        @if($accessRequest->status !== 'pending')
                        <div class="mt-8 border-t border-slate-border/20 pt-4">
                            <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-2">Riwayat Review</h4>
                            <p class="text-xs text-ash-text">Direview oleh: <span class="text-ivory-text">{{ $accessRequest->reviewer->name ?? 'Sistem' }}</span></p>
                            <p class="text-xs text-ash-text">Waktu: <span class="text-ivory-text">{{ $accessRequest->reviewed_at?->format('d M Y H:i') }}</span></p>
                            
                            @if($accessRequest->status === 'rejected')
                                <div class="mt-3 bg-red-500/10 border border-red-500/20 p-3 rounded-lg">
                                    <p class="text-xs text-red-400 font-semibold mb-1">Alasan Penolakan:</p>
                                    <p class="text-sm text-ivory-text">{{ $accessRequest->alasan_reject }}</p>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                @if($accessRequest->status === 'pending')
                    <div class="mt-8 pt-6 border-t border-slate-border/20 flex items-center justify-end gap-4">
                        <!-- Reject Button triggers modal -->
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'reject-modal')" class="inline-flex items-center px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-md font-semibold text-xs text-red-500 uppercase tracking-widest hover:bg-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-onyx-canvas transition ease-in-out duration-150">
                            Tolak Request
                        </button>

                        <form action="{{ route('admin.access-requests.approve', $accessRequest) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-primary-button class="bg-green-600 hover:bg-green-500 border-none text-white" onclick="return confirm('Apakah Anda yakin ingin menyetujui request ini dan men-generate akun warga layanan?')">
                                Setujui & Buat Akun
                            </x-primary-button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <x-modal name="reject-modal" focusable>
        <form method="post" action="{{ route('admin.access-requests.reject', $accessRequest) }}" class="p-6 bg-graphite-card">
            @csrf
            @method('patch')

            <h2 class="text-lg font-medium text-ivory-text">
                Tolak Pengajuan Akses
            </h2>

            <p class="mt-1 text-sm text-ash-text">
                Silakan masukkan alasan penolakan. Alasan ini mungkin dapat dilihat oleh pemohon jika mereka menanyakan statusnya.
            </p>

            <div class="mt-6">
                <x-input-label for="alasan_reject" value="Alasan Penolakan" class="sr-only" />
                <textarea id="alasan_reject" name="alasan_reject" rows="4"
                    class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm placeholder:text-ash-text"
                    required placeholder="Tulis alasan penolakan di sini..."></textarea>
                <x-input-error :messages="$errors->get('alasan_reject')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    Konfirmasi Tolak
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
