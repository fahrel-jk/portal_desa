<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $village->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 flex flex-col min-h-screen">
    
    {{-- Hero Header --}}
    <header class="relative bg-gray-900 min-h-[400px] flex items-center justify-center text-center px-4 overflow-hidden">
        @if($village->hero_image_path)
            <img src="{{ Storage::url($village->hero_image_path) }}" alt="Hero {{ $village->name }}" class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-overlay">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 to-transparent"></div>
        
        <div class="relative z-10 max-w-4xl mx-auto flex flex-col items-center">
            @if($village->logo_path)
                <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-24 h-24 object-contain bg-white/10 backdrop-blur-md p-2 rounded-2xl shadow-xl mb-6 border border-white/20">
            @endif
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4 drop-shadow-md">{{ $village->name }}</h1>
            <p class="text-lg text-gray-200 font-medium tracking-wide">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
        </div>
    </header>

    {{-- Main Content Grid --}}
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-16 relative z-20">
        
        {{-- Quick Contact Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @if($village->contact_phone)
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-desa-light flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-desa-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Telepon</div>
                        <div class="font-bold text-gray-900">{{ $village->contact_phone }}</div>
                    </div>
                </div>
            @endif
            @if($village->contact_email)
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-desa-light flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-desa-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Email</div>
                        <div class="font-bold text-gray-900">{{ $village->contact_email }}</div>
                    </div>
                </div>
            @endif
            @if($village->office_hours)
                <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex items-center gap-4 hover:-translate-y-1 transition duration-300">
                    <div class="w-12 h-12 rounded-full bg-desa-light flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-desa-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jam Layanan</div>
                        <div class="font-bold text-gray-900">{{ $village->office_hours }}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Left/Main Col --}}
            <div class="lg:col-span-8 space-y-12">
                
                {{-- Profil --}}
                @if($village->description)
                    <section class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-desa-primary text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            Profil Desa
                        </h2>
                        <div class="prose prose-lg text-gray-600 leading-relaxed max-w-none">
                            {!! nl2br(e($village->description)) !!}
                        </div>
                    </section>
                @endif

                {{-- Berita Grid --}}
                @if($village->news->count() > 0)
                    <section>
                        <h2 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-desa-primary text-white flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                            </span>
                            Berita & Pengumuman
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($village->news as $news)
                                <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:shadow-gray-200/50 transition duration-300 border border-gray-100 flex flex-col group">
                                    @if($news->cover_image_path)
                                        <div class="aspect-video overflow-hidden">
                                            <img src="{{ Storage::url($news->cover_image_path) }}" alt="{{ $news->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        </div>
                                    @endif
                                    <div class="p-6 flex-grow flex flex-col">
                                        <div class="text-xs font-bold text-desa-primary mb-3">{{ $news->published_at->format('d F Y') }}</div>
                                        <h3 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-desa-primary transition">{{ $news->title }}</h3>
                                        <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-grow">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            {{-- Right/Sidebar --}}
            <aside class="lg:col-span-4 space-y-8">
                
                {{-- Alamat --}}
                @if($village->address)
                    <div class="bg-gray-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-gray-900/20">
                        <div class="absolute top-0 right-0 p-8 opacity-10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 relative z-10">Alamat Kantor</h3>
                        <p class="text-gray-300 leading-relaxed relative z-10">{{ $village->address }}</p>
                    </div>
                @endif

                {{-- Perangkat Desa --}}
                @if($village->officials->count() > 0)
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 mb-6">Perangkat Desa</h3>
                        <div class="space-y-6">
                            @foreach($village->officials as $official)
                                <div class="flex items-center gap-4 group">
                                    @if($official->photo_path)
                                        <img src="{{ Storage::url($official->photo_path) }}" alt="{{ $official->name }}" class="w-14 h-14 rounded-full object-cover border-2 border-transparent group-hover:border-desa-primary transition duration-300 shadow-sm">
                                    @else
                                        <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center font-bold text-xl group-hover:bg-desa-primary group-hover:text-white transition duration-300 shadow-sm">
                                            {{ strtoupper(substr($official->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $official->name }}</div>
                                        <div class="text-sm text-desa-primary font-medium">{{ $official->position }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Layanan Administrasi --}}
                @if($village->services->count() > 0)
                    <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-black text-gray-900 mb-6">Layanan Administrasi</h3>
                        <div class="space-y-4">
                            @foreach($village->services as $service)
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 hover:border-desa-primary/30 transition duration-300">
                                    <h4 class="font-bold text-gray-900 mb-1">{{ $service->name }}</h4>
                                    @if($service->description)
                                        <p class="text-sm text-gray-600 mb-3">{{ $service->description }}</p>
                                    @endif
                                    @if($service->requirements)
                                        <div class="bg-white rounded-xl p-3 border border-gray-100">
                                            <p class="text-xs font-semibold text-desa-primary uppercase tracking-wider mb-1">Persyaratan</p>
                                            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $service->requirements }}</p>
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
    <footer class="bg-white border-t border-gray-200 py-10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                @if($village->logo_path)
                    <img src="{{ Storage::url($village->logo_path) }}" class="h-8 w-auto grayscale opacity-50">
                @endif
                <span class="font-bold text-gray-900">{{ $village->name }}</span>
            </div>
            <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Hak Cipta Dilindungi. Diberdayakan oleh Portal Desa Jawa Timur.</p>
        </div>
    </footer>
</body>
</html>
