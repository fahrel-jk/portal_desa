<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('layanan.pengajuan.index') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Ajukan {{ $layanan->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-8 shadow-xl">
                
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-ivory-text mb-2">Persyaratan Dokumen</h3>
                    <div class="p-4 bg-obsidian-button/50 border border-slate-border/20 rounded-xl text-sm text-ash-text whitespace-pre-line">{{ $layanan->requirements ?: 'Tidak ada deskripsi persyaratan khusus.' }}</div>
                </div>

                <form method="POST" action="{{ route('layanan.pengajuan.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

                    <h3 class="text-lg font-bold text-ivory-text mb-4 border-b border-slate-border/20 pb-2">Data Pemohon</h3>

                    <div>
                        <x-input-label for="nama" value="Nama Lengkap" />
                        <x-text-input id="nama" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="text" name="nama" :value="auth()->user()->name" required autofocus />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" />
                        <x-text-input id="nik" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="text" name="nik" :value="old('nik')" required />
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat Lengkap" />
                        <textarea id="alamat" name="alamat" rows="3" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" required>{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="keperluan" value="Tujuan / Keperluan" />
                        <textarea id="keperluan" name="keperluan" rows="3" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" required placeholder="Contoh: Mengurus pendaftaran sekolah">{{ old('keperluan') }}</textarea>
                        <x-input-error :messages="$errors->get('keperluan')" class="mt-2" />
                    </div>

                    <h3 class="text-lg font-bold text-ivory-text mt-8 mb-4 border-b border-slate-border/20 pb-2">Unggah Dokumen</h3>

                    <div>
                        <x-input-label for="dokumen_ktp" value="Dokumen KTP (PDF/JPG/PNG)" />
                        <input type="file" id="dokumen_ktp" name="dokumen_ktp" class="block mt-1 w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-cobalt file:text-white hover:file:bg-cobalt/80 focus:outline-none" required accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-xs text-ash-text mt-1">Maksimal 2MB</p>
                        <x-input-error :messages="$errors->get('dokumen_ktp')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="dokumen_kk" value="Dokumen Kartu Keluarga (Opsional)" />
                        <input type="file" id="dokumen_kk" name="dokumen_kk" class="block mt-1 w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-obsidian-button file:text-ivory-text hover:file:bg-obsidian-button/80 border border-slate-border/20 focus:outline-none" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="text-xs text-ash-text mt-1">Maksimal 2MB</p>
                        <x-input-error :messages="$errors->get('dokumen_kk')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <x-primary-button class="bg-cobalt hover:bg-cobalt/80 border-none">
                            Kirim Pengajuan
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
