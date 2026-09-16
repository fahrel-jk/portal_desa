<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Dashboard
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

            @if(isset($village))
                {{-- Village exists — show status --}}
                <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="text-lg font-bold text-ivory-text truncate">{{ $village->name }}</h3>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
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
                        <a href="{{ route('desa.galleries.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Galeri</h4>
                                    <p class="text-xs text-ash-text">Kelola foto-foto desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.products.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Produk UMKM</h4>
                                    <p class="text-xs text-ash-text">Kelola produk desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.agenda.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Agenda</h4>
                                    <p class="text-xs text-ash-text">Kelola kalender desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.titik-lokasi.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Titik Lokasi</h4>
                                    <p class="text-xs text-ash-text">Kelola peta fasilitas desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.documents.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">PPID</h4>
                                    <p class="text-xs text-ash-text">Kelola dokumen publik</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.faqs.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">FAQ</h4>
                                    <p class="text-xs text-ash-text">Tanya jawab warga</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.operators.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Operator</h4>
                                    <p class="text-xs text-ash-text">Kelola admin web desa</p>
                                </div>
                            </div>
                        </a>
                        @php
                            $pendingComplaints = $village->complaints()->where('status', 'pending')->count();
                            $pendingInformationRequests = $village->informationRequests()->where('status', 'pending')->count();
                            $pendingPengajuan = \App\Models\PengajuanLayanan::where('desa_id', $village->id)->where('status', 'diajukan')->count();
                        @endphp
                        <a href="{{ route('desa.pengajuan-masuk.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group relative">
                            @if($pendingPengajuan > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-graphite-card shadow-lg z-10 animate-pulse">
                                    {{ $pendingPengajuan }} Baru
                                </span>
                            @endif
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Pengajuan</h4>
                                    <p class="text-xs text-ash-text">Proses layanan warga</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.anggaran.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Anggaran</h4>
                                    <p class="text-xs text-ash-text">Kelola APBDes</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.demographics.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Statistik</h4>
                                    <p class="text-xs text-ash-text">Kelola demografi desa</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.complaints.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group relative">
                            @if($pendingComplaints > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-graphite-card shadow-lg z-10 animate-pulse">
                                    {{ $pendingComplaints }} Baru
                                </span>
                            @endif
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Pengaduan</h4>
                                    <p class="text-xs text-ash-text">Kelola laporan warga</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('desa.information-requests.index') }}" class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 hover:border-cobalt/30 transition group relative">
                            @if($pendingInformationRequests > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-graphite-card shadow-lg z-10 animate-pulse">
                                    {{ $pendingInformationRequests }} Baru
                                </span>
                            @endif
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cobalt/10 flex items-center justify-center group-hover:bg-cobalt/20 transition">
                                    <svg class="w-5 h-5 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-ivory-text">Permohonan Info</h4>
                                    <p class="text-xs text-ash-text">Kelola permohonan PPID</p>
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
