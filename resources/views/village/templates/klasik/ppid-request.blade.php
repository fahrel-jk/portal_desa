<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Informasi Publik — {{ $village->name }}</title>
    <meta name="description" content="Formulir permohonan informasi publik PPID Desa {{ $village->name }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=libre-baskerville:400,700|ibm-plex-sans:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php
        $themeColor = $village->theme_color ?? 'default';
        $themeMap = [
            'default' => ['--background'=>'#FAF7F0','--foreground'=>'#1A1A1A','--deep'=>'#313F33','--primary'=>'#313F33','--primary-hover'=>'#263328','--primary-foreground'=>'#FFFFFF','--accent'=>'#BA704F','--accent-hover'=>'#A05B3D','--accent-foreground'=>'#FFFFFF','--surface'=>'#FFFFFF','--muted'=>'#E8E5DA','--muted-foreground'=>'#6B7280','--border'=>'#E5E2D5','--card'=>'#FFFFFF','--secondary'=>'#F3F0E6'],
        ];
        $vars = $themeMap[$themeColor] ?? $themeMap['default'];
    @endphp
    
    <style>
        :root {
            @foreach($vars as $k => $v) {{ $k }}: {{ $v }}; @endforeach
        }
        body { font-family: 'IBM Plex Sans', sans-serif; background-color: var(--background); color: var(--foreground); }
        .font-serif { font-family: 'Libre Baskerville', serif; }
        .bg-surface { background-color: var(--surface); }
        .bg-primary { background-color: var(--primary); }
        .bg-accent { background-color: var(--accent); }
        .bg-secondary { background-color: var(--secondary); }
        .bg-card { background-color: var(--card); }
        .text-accent { color: var(--accent); }
        .text-muted-foreground { color: var(--muted-foreground); }
        .border-border { border-color: var(--border); }
        .hover\:bg-accent:hover { background-color: var(--accent); color: var(--accent-foreground); }
        .ring-accent { --tw-ring-color: var(--accent); }
        .focus\:ring-accent:focus { --tw-ring-color: var(--accent); }
        .focus\:border-accent:focus { border-color: var(--accent); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-surface relative z-40 border-b border-border sticky top-0 shadow-sm" x-data="{ mobileMenuOpen: false, lainnyaOpen: false, mobileLainnya: false }">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain drop-shadow-sm rounded">
                @else
                    <span class="rounded-sm border border-primary/30 bg-primary/10 text-primary grid size-10 place-items-center font-serif text-sm font-bold uppercase">
                        {{ substr($village->name, 0, 2) }}
                    </span>
                @endif
                <span>
                    <span class="block font-serif text-[15px] font-bold leading-none">{{ $village->name }}</span>
                    <span class="mt-1 block text-[10px] uppercase tracking-[0.14em] text-muted-foreground">Kecamatan {{ $village->kecamatan }}</span>
                </span>
            </a>

            <div class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('village.ppid', $village->slug) }}" class="inline-flex items-center gap-2 text-sm text-muted-foreground hover:text-accent transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    Kembali ke PPID
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow py-10 md:py-16">
        <div class="mx-auto max-w-3xl px-4 sm:px-6">
            
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-accent/10 text-accent mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                </div>
                <h1 class="font-serif text-3xl font-bold text-primary mb-3">Permohonan Informasi</h1>
                <p class="text-muted-foreground">Silakan lengkapi formulir di bawah ini untuk mengajukan permohonan informasi publik kepada PPID Desa {{ $village->name }}.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-6 bg-green-50 border border-green-200 rounded-xl flex items-start gap-4">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800 text-lg mb-1">Permohonan Berhasil Dikirim</h3>
                        <p class="text-green-700 text-sm">{{ session('success') }}</p>
                        <div class="mt-4">
                            <a href="{{ route('village.ppid', $village->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-green-800 hover:text-green-900">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                                Kembali ke PPID
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('village.ppid.request.store', $village->slug) }}" method="POST" class="bg-card border border-border rounded-2xl shadow-sm overflow-hidden p-6 sm:p-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Nama Lengkap --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                            placeholder="Contoh: Budi Santoso">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Asal Instansi / Pribadi --}}
                    <div>
                        <label for="agency" class="block text-sm font-semibold mb-2">Asal Instansi / Pribadi <span class="text-red-500">*</span></label>
                        <input type="text" id="agency" name="agency" value="{{ old('agency') }}" required
                            class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                            placeholder="Contoh: Warga RT 01 / Universitas XYZ">
                        @error('agency')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- No. WhatsApp --}}
                    <div>
                        <label for="phone" class="block text-sm font-semibold mb-2">Nomor WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                            placeholder="Contoh: 081234567890">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-2">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                            placeholder="Contoh: budi@gmail.com">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Isi Permohonan --}}
                <div class="mb-8">
                    <label for="content" class="block text-sm font-semibold mb-2">Rincian Informasi yang Dibutuhkan <span class="text-red-500">*</span></label>
                    <textarea id="content" name="content" rows="5" required
                        class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all resize-y"
                        placeholder="Jelaskan secara spesifik informasi atau dokumen publik yang Anda butuhkan..."></textarea>
                    @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between border-t border-border pt-8 mt-4">
                    <p class="text-xs text-muted-foreground w-2/3">Data Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan pelayanan PPID Desa {{ $village->name }}.</p>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-accent text-accent-foreground font-semibold hover:bg-accent-hover transition-colors">
                        Kirim Permohonan
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                    </button>
                </div>
            </form>

        </div>
    </main>

    <footer class="bg-primary text-primary-foreground border-t border-border mt-auto py-8 text-center text-sm opacity-90">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            &copy; {{ date('Y') }} Desa {{ $village->name }}. Diberdayakan oleh Portal Desa Jawa Timur.
        </div>
    </footer>
</body>
</html>
