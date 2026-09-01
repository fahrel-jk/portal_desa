<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-white min-h-screen flex flex-col">
    
    {{-- Header --}}
    <header class="bg-desa-primary shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center gap-4">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-16 h-16 object-contain bg-white p-1 rounded-full shadow-sm">
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">{{ $village->name }}</h1>
                    <p class="text-desa-light mt-1">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            {{-- Left Column (Main Info) --}}
            <div class="lg:col-span-2 space-y-12">
                
                {{-- Hero Image --}}
                @if($village->hero_image_path)
                    <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 aspect-video">
                        <img src="{{ Storage::url($village->hero_image_path) }}" alt="Pemandangan {{ $village->name }}" class="w-full h-full object-cover">
                    </div>
                @endif

                {{-- Deskripsi --}}
                @if($village->description)
                    <section>
                        <h2 class="text-2xl font-bold text-desa-primary mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-desa-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Profil Desa
                        </h2>
                        <div class="prose prose-lg text-gray-700 leading-relaxed">
                            {!! nl2br(e($village->description)) !!}
                        </div>
                    </section>
                @endif

                {{-- Berita --}}
                @if($village->news->count() > 0)
                    <section class="border-t border-gray-200 pt-12">
                        <h2 class="text-2xl font-bold text-desa-primary mb-8">Berita & Pengumuman</h2>
                        <div class="space-y-6">
                            @foreach($village->news as $news)
                                <article class="flex flex-col sm:flex-row gap-6 bg-gray-50 rounded-xl p-5 hover:bg-gray-100 transition border border-gray-100">
                                    @if($news->cover_image_path)
                                        <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="w-full sm:w-48 h-32 object-cover rounded-lg shadow-sm">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-desa-secondary mb-1">{{ $news->published_at->format('d F Y') }}</div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $news->title }}</h3>
                                        <p class="text-gray-600 line-clamp-2">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- Right Column (Sidebar) --}}
            <aside class="space-y-8">
                
                {{-- Kontak --}}
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-bold text-gray-900 mb-5">Informasi & Kontak</h3>
                    <ul class="space-y-4">
                        @if($village->address)
                            <li class="flex gap-3">
                                <svg class="w-5 h-5 text-desa-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <span class="text-gray-700 text-sm">{{ $village->address }}</span>
                            </li>
                        @endif
                        @if($village->contact_phone)
                            <li class="flex gap-3">
                                <svg class="w-5 h-5 text-desa-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                <span class="text-gray-700 text-sm">{{ $village->contact_phone }}</span>
                            </li>
                        @endif
                        @if($village->contact_email)
                            <li class="flex gap-3">
                                <svg class="w-5 h-5 text-desa-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                <span class="text-gray-700 text-sm">{{ $village->contact_email }}</span>
                            </li>
                        @endif
                        @if($village->office_hours)
                            <li class="flex gap-3">
                                <svg class="w-5 h-5 text-desa-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span class="text-gray-700 text-sm">{{ $village->office_hours }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Perangkat Desa --}}
                @if($village->officials->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-5">Perangkat Desa</h3>
                        <div class="space-y-4">
                            @foreach($village->officials as $official)
                                <div class="flex items-center gap-4">
                                    @if($official->photo_path)
                                        <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}" class="w-12 h-12 rounded-full object-cover border border-gray-100 shadow-sm">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-desa-primary text-white flex items-center justify-center font-bold shadow-sm">
                                            {{ strtoupper(substr($official->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">{{ $official->name }}</div>
                                        <div class="text-xs text-desa-secondary font-medium">{{ $official->position }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Layanan Administrasi --}}
                @if($village->services->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
                        <h3 class="text-lg font-bold text-gray-900 mb-5">Layanan Administrasi</h3>
                        <div class="space-y-4">
                            @foreach($village->services as $service)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                    <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $service->name }}</h4>
                                    @if($service->description)
                                        <p class="text-xs text-gray-600 mb-2">{{ $service->description }}</p>
                                    @endif
                                    @if($service->requirements)
                                        <div class="text-xs text-desa-primary">
                                            <span class="font-medium">Persyaratan:</span>
                                            <p class="text-gray-600 whitespace-pre-line mt-1">{{ $service->requirements }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
            </aside>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} {{ $village->name }}. Diberdayakan oleh Portal Desa Jawa Timur.</p>
        </div>
    </footer>
</body>
</html>
