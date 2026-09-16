<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lapor Desa — {{ $village->name }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --background: #FAF7F0;
            --foreground: #1A1A1A;
            --deep: #313F33;
            --primary: #313F33;
            --primary-hover: #263328;
            --primary-foreground: #FFFFFF;
            --accent: #BA704F;
            --accent-hover: #A05B3D;
            --accent-foreground: #FFFFFF;
            --surface: #FFFFFF;
            --muted: #E8E5DA;
            --muted-foreground: #6B7280;
            --border: #E5E2D5;
            --card: #FFFFFF;
            --secondary: #F3F0E6;
            
            --text-dark: var(--foreground);
            --text-light: var(--muted-foreground);
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-dark);
            background-color: var(--secondary);
        }
        h1, h2, h3, h4, h5, h6, .font-serif {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    {{-- Topbar --}}
    <div style="background-color: var(--primary);" class="text-white py-2 px-4 text-sm hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                @if($village->contact_phone)
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    {{ $village->contact_phone }}
                </span>
                @endif
                @if($village->contact_email)
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    {{ $village->contact_email }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-border shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center gap-3">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="h-10 w-10 object-contain">
                    @endif
                    <div>
                        <a href="{{ route('village.show', $village->slug) }}" class="font-serif font-bold text-xl leading-tight block" style="color: var(--primary);">Desa {{ $village->name }}</a>
                        <span class="text-[10px] text-muted-foreground uppercase tracking-widest font-semibold">Kec. {{ $village->kecamatan }}</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('village.show', $village->slug) }}" class="text-sm font-medium hover:text-accent transition-colors flex items-center gap-2 border border-border px-4 py-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            
            <div class="text-center mb-10">
                <h1 class="font-serif text-3xl md:text-4xl font-bold mb-4" style="color: var(--primary);">Lapor Desa</h1>
                <p class="text-muted-foreground">Sampaikan aspirasi, pengaduan, atau laporan kejadian di lingkungan Desa {{ $village->name }}. Laporan Anda akan langsung diterima oleh admin/perangkat desa.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-5 bg-green-50 border border-green-200 rounded-xl flex items-start gap-4">
                    <div class="bg-green-100 p-2 rounded-full mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-800">Laporan Terkirim!</h4>
                        <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white border border-border shadow-sm rounded-2xl p-6 md:p-10">
                <form action="{{ route('village.complaint.store', $village->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-text-dark mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full rounded-md border border-border px-4 py-2.5 focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="contact" class="block text-sm font-medium text-text-dark mb-2">Nomor Telepon / WhatsApp</label>
                            <input type="text" id="contact" name="contact" value="{{ old('contact') }}"
                                class="w-full rounded-md border border-border px-4 py-2.5 focus:border-accent focus:ring focus:ring-accent/20 transition-all"
                                placeholder="Opsional (agar bisa dihubungi)">
                            @error('contact')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-text-dark mb-2">Kategori Laporan <span class="text-red-500">*</span></label>
                        <select id="category" name="category" required class="w-full rounded-md border border-border px-4 py-2.5 focus:border-accent focus:ring focus:ring-accent/20 transition-all bg-white">
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih Kategori</option>
                            <option value="Infrastruktur & Pembangunan" {{ old('category') == 'Infrastruktur & Pembangunan' ? 'selected' : '' }}>Infrastruktur & Pembangunan (Jalan rusak, fasilitas desa)</option>
                            <option value="Pelayanan Publik" {{ old('category') == 'Pelayanan Publik' ? 'selected' : '' }}>Pelayanan Publik (Administrasi, aparatur)</option>
                            <option value="Ketertiban & Keamanan" {{ old('category') == 'Ketertiban & Keamanan' ? 'selected' : '' }}>Ketertiban & Keamanan (Gangguan warga)</option>
                            <option value="Sosial & Bantuan" {{ old('category') == 'Sosial & Bantuan' ? 'selected' : '' }}>Sosial & Bantuan (Bansos, kesehatan)</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya / Aspirasi Umum</option>
                        </select>
                        @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-text-dark mb-2">Isi Laporan / Aspirasi <span class="text-red-500">*</span></label>
                        <textarea id="content" name="content" rows="6" required
                            class="w-full rounded-md border border-border px-4 py-3 focus:border-accent focus:ring focus:ring-accent/20 transition-all resize-y"
                            placeholder="Ceritakan detail masalah atau aspirasi Anda di sini..."></textarea>
                        @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-text-dark mb-2">Lampiran Foto Bukti</label>
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg"
                            class="w-full text-sm text-muted-foreground file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-secondary file:text-primary hover:file:bg-border transition-all cursor-pointer">
                        <p class="text-xs text-muted-foreground mt-2">Format: JPG, PNG. Maksimal 4MB. Opsional namun sangat disarankan.</p>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-4 border-t border-border">
                        <button type="submit" class="w-full py-3.5 text-white font-bold rounded-lg transition-colors flex justify-center items-center gap-2" style="background-color: var(--primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                            Kirim Laporan
                        </button>
                        <p class="text-center text-xs text-muted-foreground mt-4">
                            Dengan mengirimkan form ini, Anda menyetujui bahwa laporan akan ditinjau oleh Pemerintah Desa {{ $village->name }}.
                        </p>
                    </div>
                </form>
            </div>
            
        </div>
    </main>

    {{-- Footer --}}
    <footer class="text-white py-6 text-center text-sm mt-auto" style="background-color: var(--primary);">
        <p>&copy; {{ date('Y') }} Portal Desa {{ $village->name }}. All rights reserved.</p>
    </footer>

</body>
</html>
