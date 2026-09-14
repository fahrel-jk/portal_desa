<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <a href="{{ route('desa.pengajuan-masuk.index') }}" class="text-ash-text hover:text-ivory-text transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h2 class="font-bold text-xl text-ivory-text leading-tight">
                    Review Pengajuan #{{ $pengajuan->kode_tracking }}
                </h2>
            </div>
            <div>
                @if($pengajuan->status === 'diajukan')
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">Diajukan</span>
                @elseif($pengajuan->status === 'diproses')
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-blue-500/10 text-blue-500 border border-blue-500/20">Diproses</span>
                @elseif($pengajuan->status === 'selesai')
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-green-500/10 text-green-500 border border-green-500/20">Selesai</span>
                @elseif($pengajuan->status === 'ditolak')
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold bg-red-500/10 text-red-500 border border-red-500/20">Ditolak</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-red-300">{{ session('error') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Data & Dokumen --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4 border-b border-slate-border/20 pb-2">Informasi Layanan</h4>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-ivory-text">{{ $pengajuan->layanan->name }}</h3>
                            <p class="text-sm text-ash-text mt-1">Diajukan oleh: <span class="text-ivory-text font-medium">{{ $pengajuan->user->name }}</span> pada {{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4 border-b border-slate-border/20 pb-2">Data Pemohon (Form Dinamis)</h4>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            @foreach($pengajuan->data_pemohon as $key => $value)
                                <div class="{{ strlen($value) > 50 ? 'sm:col-span-2' : '' }}">
                                    <dt class="text-xs text-ash-text/70 mb-1 capitalize">{{ str_replace('_', ' ', $key) }}</dt>
                                    <dd class="text-sm font-medium text-ivory-text">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4 border-b border-slate-border/20 pb-2">Dokumen Pendukung</h4>
                        @if($pengajuan->dokumen->isEmpty())
                            <p class="text-sm text-ash-text">Pemohon tidak melampirkan dokumen apapun.</p>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($pengajuan->dokumen as $dok)
                                    <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank" class="flex items-center p-4 border border-slate-border/20 rounded-xl bg-obsidian-button/50 hover:bg-obsidian-button hover:border-cobalt/50 transition group">
                                        <div class="w-12 h-12 bg-slate-border/10 rounded-lg flex items-center justify-center shrink-0 mr-4">
                                            <svg class="w-6 h-6 text-ash-text group-hover:text-cobalt transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-ivory-text truncate">{{ $dok->nama_file }}</p>
                                            <p class="text-xs text-ash-text mt-0.5">Klik untuk melihat file PDF/Image</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Right Column: Action Box --}}
                <div class="space-y-6">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl sticky top-24">
                        <h4 class="text-sm font-semibold uppercase tracking-wider text-ash-text mb-4 border-b border-slate-border/20 pb-2">Aksi & Keputusan</h4>
                        
                        <form method="POST" action="{{ route('desa.pengajuan-masuk.update', $pengajuan->id) }}" class="space-y-5" x-data="{ status: '{{ $pengajuan->status }}' }">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <x-input-label for="status" value="Ubah Status" />
                                <select id="status" name="status" x-model="status" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm">
                                    <option value="diajukan" {{ $pengajuan->status === 'diajukan' ? 'selected' : '' }}>Diajukan (Baru)</option>
                                    <option value="diproses" {{ $pengajuan->status === 'diproses' ? 'selected' : '' }}>Diproses (Sedang dikerjakan)</option>
                                    <option value="selesai" {{ $pengajuan->status === 'selesai' ? 'selected' : '' }}>Selesai (Setujui & Generate PDF)</option>
                                    <option value="ditolak" {{ $pengajuan->status === 'ditolak' ? 'selected' : '' }}>Ditolak (Tolak pengajuan)</option>
                                </select>
                            </div>

                            <div x-show="status === 'ditolak'" x-transition x-cloak>
                                <x-input-label for="alasan_ditolak" value="Alasan Penolakan (Wajib jika ditolak)" />
                                <textarea id="alasan_ditolak" name="alasan_ditolak" rows="3" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" :required="status === 'ditolak'">{{ $pengajuan->alasan_ditolak }}</textarea>
                                <x-input-error :messages="$errors->get('alasan_ditolak')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="catatan_operator" value="Catatan Internal Operator (Opsional)" />
                                <textarea id="catatan_operator" name="catatan_operator" rows="3" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm">{{ $pengajuan->catatan_operator }}</textarea>
                            </div>
                            
                            <div x-show="status === 'selesai' && !'{{ $pengajuan->file_surat_hasil }}'" x-cloak class="p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg text-xs text-blue-300">
                                <span class="font-bold">Info:</span> Menyimpan dengan status <strong>Selesai</strong> akan secara otomatis men-generate file surat PDF untuk warga.
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-cobalt border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-cobalt/80 focus:bg-cobalt/80 active:bg-cobalt/90 focus:outline-none focus:ring-2 focus:ring-cobalt focus:ring-offset-2 focus:ring-offset-onyx-canvas transition ease-in-out duration-150">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    @if($pengajuan->file_surat_hasil)
                        <div class="bg-graphite-card border border-green-500/30 rounded-2xl p-6 shadow-xl">
                            <h4 class="text-sm font-semibold uppercase tracking-wider text-green-400 mb-4 border-b border-green-500/20 pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Surat Berhasil Terbit
                            </h4>
                            <p class="text-xs text-ash-text mb-4">File surat PDF hasil *auto-generate* telah berhasil dibuat dan disimpan.</p>
                            <a href="{{ asset('storage/' . $pengajuan->file_surat_hasil) }}" target="_blank" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition">
                                Lihat Surat PDF
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
