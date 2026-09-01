<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-status-approved-bg/20 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            @if(isset($village))
                {{-- Village exists — show status --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-ivory-text">{{ $village->name }}</h3>
                            <p class="text-sm text-ash-text">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                        </div>
                        <x-portal.status-badge :status="$village->status" />
                    </div>

                    @if($village->status === 'pending_review')
                        <div class="mt-4 bg-amber-500/10 border border-amber-500/20 rounded-xl p-4">
                            <p class="text-sm text-amber-300">
                                <strong>Menunggu tinjauan.</strong> Pendaftaran desa Anda sedang ditinjau oleh admin. Anda akan mendapat notifikasi setelah proses selesai.
                            </p>
                        </div>
                    @elseif($village->status === 'rejected')
                        <div class="mt-4 bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                            <p class="text-sm text-red-300">
                                <strong>Pendaftaran ditolak.</strong> {{ $village->rejection_reason }}
                            </p>
                            <a href="{{ route('wizard.step1') }}" class="mt-2 inline-block text-sm text-red-400 font-medium hover:underline">
                                Revisi dan kirim ulang →
                            </a>
                        </div>
                    @elseif($village->status === 'published')
                        <div class="mt-4 bg-green-500/10 border border-green-500/20 rounded-xl p-4">
                            <p class="text-sm text-green-300">
                                <strong>Desa Anda sudah tayang!</strong>
                                <a href="{{ url('/desa/' . $village->slug) }}" class="underline font-medium hover:text-green-200 transition" target="_blank">
                                    Lihat halaman desa →
                                </a>
                            </p>
                        </div>
                    @elseif($village->status === 'draft')
                        <div class="mt-4 bg-slate-border/10 border border-slate-border/20 rounded-xl p-4">
                            <p class="text-sm text-ash-text">
                                Pendaftaran belum selesai.
                                <a href="{{ route('wizard.step1') }}" class="text-cobalt font-medium hover:underline">
                                    Lanjutkan pendaftaran →
                                </a>
                            </p>
                        </div>
                    @endif
                </div>

                @if($village->status === 'published')
                    {{-- Quick actions for published village --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('desa.profile.edit') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Edit Profil</h4>
                                    <p class="text-xs text-ash-text">Ubah deskripsi & kontak</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.news.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Kelola Berita</h4>
                                    <p class="text-xs text-ash-text">Tambah & edit berita desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.officials.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Perangkat Desa</h4>
                                    <p class="text-xs text-ash-text">Kelola struktur organisasi</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.services.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Layanan</h4>
                                    <p class="text-xs text-ash-text">Kelola layanan administrasi</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @else
                {{-- No village — prompt wizard --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-10 text-center">
                    <svg class="w-16 h-16 text-slate-border/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <h3 class="text-lg font-bold text-ivory-text mb-2">Belum Ada Desa Terdaftar</h3>
                    <p class="text-ash-text mb-6">Mulai daftarkan desa Anda melalui wizard pendaftaran.</p>
                    <a href="{{ route('wizard.step1') }}"
                        class="inline-flex items-center px-8 py-3 bg-cobalt text-pure-white font-semibold rounded-full hover:bg-cobalt-hover hover:scale-[1.02] transition-all shadow-lg shadow-cobalt/20">
                        Daftarkan Desa Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
