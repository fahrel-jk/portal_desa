<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Desa Belum Tersedia - Portal Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-ivory-text bg-obsidian-button/30 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 max-w-lg">
        <svg class="w-24 h-24 text-ash-text mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <h1 class="text-3xl font-bold text-ivory-text mb-2">Desa Belum Tersedia</h1>
        <p class="text-ash-text mb-8">
            Halaman untuk desa dengan alamat URL <span class="font-mono bg-obsidian-button px-2 py-1 rounded text-cobalt">/desa/{{ $slug }}</span> belum diterbitkan, masih dalam tahap review, atau tidak ditemukan.
        </p>
        <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-cobalt border border-transparent rounded-lg font-semibold text-white hover:bg-cobalt-hover transition">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
