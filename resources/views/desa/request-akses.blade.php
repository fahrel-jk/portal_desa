<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request Akses - {{ $village->name }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-onyx-canvas text-ivory-text min-h-screen">
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center px-4 sm:px-0">
                <h2 class="font-bold text-2xl text-ivory-text leading-tight">
                    Request Akses Layanan - {{ $village->name }}
                </h2>
                <a href="{{ route('village.show', $village->slug) }}" class="text-sm text-cobalt hover:text-cobalt-hover transition">
                    &larr; Kembali ke Profil Desa
                </a>
            </div>

            <div class="bg-graphite-card border border-slate-border/15 overflow-hidden rounded-2xl p-8 shadow-2xl">
                <h3 class="text-lg font-bold text-ivory-text mb-1">Formulir Pendaftaran Akun Warga Layanan</h3>
                <p class="text-sm text-ash-text mb-6">Lengkapi data berikut untuk mengajukan permohonan akses layanan digital administrasi desa.</p>

                @if(session('error'))
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                        <p class="text-sm text-red-400">{{ session('error') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('desa.request-akses.store', $village->slug) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-5">
                        <x-input-label for="nama_lengkap" value="Nama Lengkap (sesuai KTP)" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full"
                            :value="old('nama_lengkap')" required autofocus
                            placeholder="M. Fulan" />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>

                    <!-- NIK -->
                    <div class="mb-5">
                        <x-input-label for="nik" value="NIK (Nomor Induk Kependudukan)" />
                        <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full"
                            :value="old('nik')" required maxlength="16" minlength="16"
                            placeholder="16 Digit NIK" />
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>

                    <!-- Jabatan / Keperluan -->
                    <div class="mb-5">
                        <x-input-label for="jabatan_keperluan" value="Jabatan / Tujuan Keperluan" />
                        <x-text-input id="jabatan_keperluan" name="jabatan_keperluan" type="text" class="mt-1 block w-full"
                            :value="old('jabatan_keperluan')" required
                            placeholder="contoh: Warga / Pengurusan Surat Pindah" />
                        <x-input-error :messages="$errors->get('jabatan_keperluan')" class="mt-2" />
                    </div>

                    <!-- No HP -->
                    <div class="mb-5">
                        <x-input-label for="no_hp" value="Nomor Handphone (WhatsApp)" />
                        <x-text-input id="no_hp" name="no_hp" type="text" class="mt-1 block w-full"
                            :value="old('no_hp')" required
                            placeholder="0812xxxx" />
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <x-input-label for="email" value="Alamat Email Aktif" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email')" required
                            placeholder="fulan@example.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <p class="mt-1 text-xs text-ash-text">Password akun akan digenerate secara otomatis oleh sistem setelah disetujui.</p>
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div class="mb-6">
                        <x-input-label for="dokumen_pendukung" value="Dokumen Pendukung (KTP/Surat Pengantar)" />
                        <input id="dokumen_pendukung" name="dokumen_pendukung" type="file" required accept=".jpg,.jpeg,.png,.pdf"
                            class="mt-1 block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-cobalt/20 transition" />
                        <p class="mt-1 text-xs text-ash-text">Maksimal 2MB. Format JPG, PNG, atau PDF.</p>
                        <x-input-error :messages="$errors->get('dokumen_pendukung')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-border/15">
                        <x-primary-button>
                            Kirim Permohonan Akses
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
