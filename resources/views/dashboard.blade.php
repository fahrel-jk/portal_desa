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
                    @php
                        $pendingComplaints = $village->complaints()->where('status', 'pending')->count();
                        $pendingInformationRequests = $village->informationRequests()->where('status', 'pending')->count();
                        $pendingPengajuan = \App\Models\PengajuanLayanan::where('desa_id', $village->id)->where('status', 'diajukan')->count();
                        $totalPending = $pendingComplaints + $pendingInformationRequests + $pendingPengajuan;
                    @endphp

                    {{-- Operator Categorized Dashboard with Search & Tabs --}}
                    <div x-data="{
                        activeCategory: 'all',
                        searchQuery: '',
                        matchesSearch(title, desc, keywords) {
                            if (!this.searchQuery.trim()) return true;
                            const query = this.searchQuery.toLowerCase();
                            return title.toLowerCase().includes(query) ||
                                   desc.toLowerCase().includes(query) ||
                                   keywords.toLowerCase().includes(query);
                        },
                        showCategory(cat) {
                            return this.activeCategory === 'all' || this.activeCategory === cat;
                        }
                    }" class="space-y-8">

                        {{-- Operator Guidance & Search Bar --}}
                        <div class="bg-graphite-card border border-slate-border/20 rounded-2xl p-6 shadow-sm">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-base font-bold text-ivory-text">Panduan Fitur Operator Desa</h3>
                                    <p class="text-xs text-ash-text mt-1">
                                        Fitur di bawah telah dikelompokkan berdasarkan tugas. Gunakan pencarian atau pilih kategori di bawah jika Anda kesulitan menemukan fungsi yang dicari.
                                    </p>
                                </div>

                                {{-- Realtime Search Bar --}}
                                <div class="relative min-w-[260px] sm:min-w-[320px]">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-ash-text/60">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text"
                                           x-model="searchQuery"
                                           placeholder="Cari fitur (misal: surat, berita, foto, anggaran)..."
                                           class="w-full pl-9 pr-8 py-2 text-xs rounded-xl bg-obsidian-button/50 border border-slate-border/20 focus:border-cobalt focus:ring-1 focus:ring-cobalt text-ivory-text placeholder-ash-text/50">
                                    <button x-show="searchQuery"
                                            @click="searchQuery = ''"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-xs text-ash-text hover:text-ivory-text">
                                        ✕
                                    </button>
                                </div>
                            </div>

                            {{-- Category Tabs Filter --}}
                            <div class="flex items-center gap-2 mt-5 overflow-x-auto pb-1 scrollbar-none border-t border-slate-border/10 pt-4">
                                <button @click="activeCategory = 'all'"
                                        :class="activeCategory === 'all' ? 'bg-cobalt text-white font-semibold' : 'bg-obsidian-button/60 text-ash-text hover:bg-obsidian-button hover:text-ivory-text'"
                                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 whitespace-nowrap">
                                    <span>Semua Fitur</span>
                                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-white/20">17</span>
                                </button>
                                <button @click="activeCategory = 'warga'"
                                        :class="activeCategory === 'warga' ? 'bg-rose-600 text-white font-semibold' : 'bg-obsidian-button/60 text-ash-text hover:bg-obsidian-button hover:text-ivory-text'"
                                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 whitespace-nowrap">
                                    <span>Permohonan & Warga</span>
                                    @if($totalPending > 0)
                                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-rose-500 text-white animate-pulse font-bold">{{ $totalPending }} Baru</span>
                                    @else
                                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/10">3</span>
                                    @endif
                                </button>
                                <button @click="activeCategory = 'kabar'"
                                        :class="activeCategory === 'kabar' ? 'bg-emerald-600 text-white font-semibold' : 'bg-obsidian-button/60 text-ash-text hover:bg-obsidian-button hover:text-ivory-text'"
                                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 whitespace-nowrap">
                                    <span>Kabar & Informasi Desa</span>
                                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/10">5</span>
                                </button>
                                <button @click="activeCategory = 'profil'"
                                        :class="activeCategory === 'profil' ? 'bg-blue-600 text-white font-semibold' : 'bg-obsidian-button/60 text-ash-text hover:bg-obsidian-button hover:text-ivory-text'"
                                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 whitespace-nowrap">
                                    <span>Profil & Transparansi</span>
                                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/10">6</span>
                                </button>
                                <button @click="activeCategory = 'pengaturan'"
                                        :class="activeCategory === 'pengaturan' ? 'bg-purple-600 text-white font-semibold' : 'bg-obsidian-button/60 text-ash-text hover:bg-obsidian-button hover:text-ivory-text'"
                                        class="px-3.5 py-1.5 rounded-lg text-xs transition flex items-center gap-1.5 whitespace-nowrap">
                                    <span>Pengaturan Website</span>
                                    <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-black/10">3</span>
                                </button>
                            </div>
                        </div>

                        {{-- KATEGORI 1: PERMOHONAN & PELAYANAN WARGA --}}
                        <div x-show="showCategory('warga')" class="space-y-4">
                            <div class="flex items-center justify-between border-b border-rose-500/20 pb-2">
                                <div>
                                    <h3 class="text-base font-bold text-ivory-text flex items-center gap-2">
                                        Permohonan & Pelayanan Warga
                                        <span class="text-xs font-normal text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/20">Layanan Masuk</span>
                                    </h3>
                                    <p class="text-xs text-ash-text">Kelola permohonan surat administrasi, laporan pengaduan warga, dan permohonan PPID.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- 1. Pengajuan Surat --}}
                                <a href="{{ route('desa.pengajuan-masuk.index') }}"
                                   x-show="matchesSearch('Pengajuan Surat Warga', 'Proses permohonan surat administrasi warga', 'surat pengajuan masukan permohonan layanan')"
                                   class="bg-graphite-card border border-rose-500/30 hover:border-rose-500 rounded-2xl p-5 hover:shadow-lg transition-all group relative">
                                    @if($pendingPengajuan > 0)
                                        <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md z-10 animate-pulse">
                                            {{ $pendingPengajuan }} Baru
                                        </span>
                                    @endif
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-rose-500 transition">Pengajuan Surat Warga</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Surat</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Proses dan verifikasi permohonan surat administrasi dari warga.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 2. Pengaduan Warga --}}
                                <a href="{{ route('desa.complaints.index') }}"
                                   x-show="matchesSearch('Pengaduan Warga', 'Tanggapi laporan dan keluhan warga', 'pengaduan keluhan laporan aduan masyarakat')"
                                   class="bg-graphite-card border border-rose-500/30 hover:border-rose-500 rounded-2xl p-5 hover:shadow-lg transition-all group relative">
                                    @if($pendingComplaints > 0)
                                        <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md z-10 animate-pulse">
                                            {{ $pendingComplaints }} Baru
                                        </span>
                                    @endif
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-rose-500 transition">Pengaduan Warga</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Laporan</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Tanggapi laporan, masukan, dan pengaduan dari warga desa.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 3. Permohonan Info --}}
                                <a href="{{ route('desa.information-requests.index') }}"
                                   x-show="matchesSearch('Permohonan Informasi (PPID)', 'Kelola permohonan berkas dan info publik', 'permohonan ppid berkas dokumen publik info')"
                                   class="bg-graphite-card border border-rose-500/30 hover:border-rose-500 rounded-2xl p-5 hover:shadow-lg transition-all group relative">
                                    @if($pendingInformationRequests > 0)
                                        <span class="absolute -top-2 -right-2 bg-rose-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md z-10 animate-pulse">
                                            {{ $pendingInformationRequests }} Baru
                                        </span>
                                    @endif
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-rose-500 transition">Permohonan Info PPID</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">PPID</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Tanggapi permohonan berkas & transparansi informasi publik.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- KATEGORI 2: KABAR & INFORMASI DESA --}}
                        <div x-show="showCategory('kabar')" class="space-y-4">
                            <div class="flex items-center justify-between border-b border-emerald-500/20 pb-2">
                                <div>
                                    <h3 class="text-base font-bold text-ivory-text flex items-center gap-2">
                                        Kabar, Acara & Informasi Desa
                                        <span class="text-xs font-normal text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/20">Konten Web</span>
                                    </h3>
                                    <p class="text-xs text-ash-text">Publikasikan kabar terbaru, foto dokumentasi kegiatan, jadwal agenda, produk UMKM, dan FAQ.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- 1. Kelola Berita --}}
                                <a href="{{ route('desa.news.index') }}"
                                   x-show="matchesSearch('Kelola Berita Desa', 'Tambah dan edit artikel berita desa', 'berita artikel kabar informasi publikasi berita')"
                                   class="bg-graphite-card border border-emerald-500/20 hover:border-emerald-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-emerald-500 transition">Kelola Berita Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Berita</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Tambah, ubah, dan tampilkan artikel berita & kabar desa.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 2. Galeri Foto --}}
                                <a href="{{ route('desa.galleries.index') }}"
                                   x-show="matchesSearch('Galeri Foto Desa', 'Unggah foto kegiatan dan fasilitas desa', 'galeri foto foto-foto gambar dokumentasi kegiatan')"
                                   class="bg-graphite-card border border-emerald-500/20 hover:border-emerald-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-emerald-500 transition">Galeri Foto Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Dokumentasi</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Upload album foto kegiatan dan pemandangan desa.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 3. Agenda Kegiatan --}}
                                <a href="{{ route('desa.agenda.index') }}"
                                   x-show="matchesSearch('Agenda & Acara Desa', 'Jadwal kegiatan dan kalender desa', 'agenda jadwal acara kegiatan kalender')"
                                   class="bg-graphite-card border border-emerald-500/20 hover:border-emerald-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-emerald-500 transition">Agenda & Acara Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Jadwal</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Catat pengumuman acara & kalender kegiatan mendatang.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 4. Produk UMKM --}}
                                <a href="{{ route('desa.products.index') }}"
                                   x-show="matchesSearch('Produk UMKM Desa', 'Promosi produk lokal dan usaha warga', 'produk umkm jualan olahan usaha warga lokal')"
                                   class="bg-graphite-card border border-emerald-500/20 hover:border-emerald-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-emerald-500 transition">Produk UMKM Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Ekonomi</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Promosikan produk kerajinan & olahan unggulan warga.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 5. FAQ --}}
                                <a href="{{ route('desa.faqs.index') }}"
                                   x-show="matchesSearch('FAQ (Tanya Jawab Warga)', 'Pertanyaan dan jawaban umum untuk warga', 'faq tanya jawab pertanyaan informasi bantuan')"
                                   class="bg-graphite-card border border-emerald-500/20 hover:border-emerald-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-emerald-500 transition">FAQ (Tanya Jawab Warga)</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Tanya Jawab</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Kelola daftar pertanyaan yang sering ditanyakan warga.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- KATEGORI 3: PROFIL & TRANSPARANSI DESA --}}
                        <div x-show="showCategory('profil')" class="space-y-4">
                            <div class="flex items-center justify-between border-b border-cobalt/20 pb-2">
                                <div>
                                    <h3 class="text-base font-bold text-ivory-text flex items-center gap-2">
                                        Profil, Demografi & Transparansi
                                        <span class="text-xs font-normal text-cobalt bg-cobalt/10 px-2 py-0.5 rounded-full border border-cobalt/20">Data Resmi</span>
                                    </h3>
                                    <p class="text-xs text-ash-text">Kelola profil resmi desa, pengurus aparat, statistik penduduk, APBDes, dokumen publik, dan peta.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- 1. Edit Profil --}}
                                <a href="{{ route('desa.profile.edit') }}"
                                   x-show="matchesSearch('Edit Profil Desa', 'Ubah deskripsi visi misi dan kontak desa', 'edit profil tentang desa visi misi sejarah alamat kontak')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Edit Profil Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Profil Utama</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Ubah sejarah desa, deskripsi, visi-misi, & kontak resmi.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 2. Perangkat Desa --}}
                                <a href="{{ route('desa.officials.index') }}"
                                   x-show="matchesSearch('Perangkat & Aparat Desa', 'Kelola pengurus dan struktur organisasi', 'perangkat aparatur pejabat lurah kades struktur organisasi pengurus')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Perangkat & Aparat Desa</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Pengurus</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Kelola struktur organisasi & foto perangkat desa.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 3. Statistik --}}
                                <a href="{{ route('desa.demographics.index') }}"
                                   x-show="matchesSearch('Statistik Kependudukan', 'Update data demografi kependudukan desa', 'statistik kependudukan jumlah penduduk demografi warga jiwa grafik')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Statistik Penduduk</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Demografi</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Update data jumlah penduduk & profesi warga.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 4. Anggaran APBDes --}}
                                <a href="{{ route('desa.anggaran.index') }}"
                                   x-show="matchesSearch('Anggaran APBDes', 'Transparansi laporan APBDes dan keuangan desa', 'anggaran apbdes keuangan dana uang pendapatan belanja transparansi')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Anggaran APBDes</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Keuangan</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Kelola transparansi pendapatan & belanja APBDes.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 5. Dokumen PPID Publik --}}
                                <a href="{{ route('desa.documents.index') }}"
                                   x-show="matchesSearch('Dokumen PPID Publik', 'Unggah dokumen publik perdes dan aturan resmi', 'dokumen ppid perdes sk surat keputusan publik berkas pdf')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Dokumen PPID Publik</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Dokumen</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Unggah dokumen peraturan perdes & SK publik.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 6. Titik Lokasi Peta --}}
                                <a href="{{ route('desa.titik-lokasi.index') }}"
                                   x-show="matchesSearch('Titik Lokasi (Peta Peta)', 'Kelola lokasi penting dan peta fasilitas desa', 'titik lokasi peta lokasi fasilitas kantor sekolah tempat')"
                                   class="bg-graphite-card border border-cobalt/20 hover:border-cobalt rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-cobalt/10 text-cobalt flex items-center justify-center flex-shrink-0 group-hover:bg-cobalt group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-cobalt transition">Titik Lokasi (Peta)</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Peta</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Tandai lokasi kantor, sekolah & fasilitas umum desa.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- KATEGORI 4: PENGATURAN WEBSITE --}}
                        <div x-show="showCategory('pengaturan')" class="space-y-4">
                            <div class="flex items-center justify-between border-b border-purple-500/20 pb-2">
                                <div>
                                    <h3 class="text-base font-bold text-ivory-text flex items-center gap-2">
                                        Pengaturan Website & Pengelola
                                        <span class="text-xs font-normal text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded-full border border-purple-500/20">Pengaturan Web</span>
                                    </h3>
                                    <p class="text-xs text-ash-text">Atur urutan tampilan website desa, katalog daftar layanan publik, dan pengguna pengelola operator.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                {{-- 1. Page Builder Tata Letak --}}
                                <a href="{{ route('desa.layout.index') }}"
                                   x-show="matchesSearch('Tata Letak Layout (Page Builder)', 'Atur urutan dan tampilkan bagian web', 'tata letak layout page builder urutan susunan posisi tampilan')"
                                   class="bg-graphite-card border border-purple-500/30 hover:border-purple-500 rounded-2xl p-5 hover:shadow-lg transition-all group relative overflow-hidden">
                                    <div class="absolute top-0 right-0 bg-purple-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-bl-lg">
                                        Page Builder
                                    </div>
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between pr-14">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-purple-500 transition">Tata Letak (Layout)</h4>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Atur posisi & tampilkan/sembunyikan bagian web.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 2. Katalog Layanan Publik --}}
                                <a href="{{ route('desa.services.index') }}"
                                   x-show="matchesSearch('Katalog Layanan Publik', 'Kelola daftar jenis layanan administrasi desa', 'layanan administrasi syarat daftar jenis katalog layanan')"
                                   class="bg-graphite-card border border-purple-500/20 hover:border-purple-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-purple-500 transition">Katalog Layanan</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Persyaratan</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Kelola jenis & syarat pengajuan surat warga.</p>
                                        </div>
                                    </div>
                                </a>

                                {{-- 3. Kelola Operator --}}
                                <a href="{{ route('desa.operators.index') }}"
                                   x-show="matchesSearch('Kelola Operator Web', 'Kelola akun pengelola dan staf admin desa', 'operator admin staf akun pengelola user')"
                                   class="bg-graphite-card border border-purple-500/20 hover:border-purple-500 rounded-2xl p-5 hover:shadow-lg transition-all group">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <h4 class="font-bold text-sm text-ivory-text group-hover:text-purple-500 transition">Kelola Operator Web</h4>
                                                <span class="text-[10px] text-ash-text bg-obsidian-button px-2 py-0.5 rounded">Akun Staf</span>
                                            </div>
                                            <p class="text-xs text-ash-text mt-1 leading-relaxed">Tambah & atur hak akses staf pengelola web desa.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

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
