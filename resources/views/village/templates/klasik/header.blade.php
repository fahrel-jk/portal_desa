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

            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-7 text-sm text-muted-foreground lg:flex">
                <a href="{{ route('village.show', $village->slug) }}" class="transition-colors hover:text-accent {{ request()->routeIs('village.show') ? 'text-accent font-semibold' : '' }}">Home</a>
                <a href="{{ route('village.profile', $village->slug) }}" class="transition-colors hover:text-accent {{ request()->routeIs('village.profile') ? 'text-accent font-semibold' : '' }}">Profil</a>
                <a href="{{ route('village.services', $village->slug) }}" class="transition-colors hover:text-accent {{ request()->routeIs('village.services') || request()->routeIs('village.service.show') ? 'text-accent font-semibold' : '' }}">Layanan</a>
                <a href="{{ route('village.show', $village->slug) }}#berita" class="transition-colors hover:text-accent">Berita</a>
                <a href="{{ route('village.agenda', $village->slug) }}" class="transition-colors hover:text-accent {{ request()->routeIs('village.agenda') ? 'text-accent font-semibold' : '' }}">Agenda</a>
                <a href="{{ route('village.apbdes', $village->slug) }}" class="transition-colors hover:text-accent {{ request()->routeIs('village.apbdes') ? 'text-accent font-semibold' : '' }}">APBDes</a>
                {{-- Lainnya Dropdown --}}
                <div class="relative" @click.outside="lainnyaOpen = false">
                    <button @click="lainnyaOpen = !lainnyaOpen" class="inline-flex items-center gap-1 transition-colors hover:text-accent">
                        Lainnya
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="lainnyaOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="lainnyaOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="absolute right-0 mt-2 w-44 bg-surface border border-border rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('village.ppid', $village->slug) }}" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">PPID</a>
                        @if($village->galleries->count() > 0)
                        <a href="{{ route('village.show', $village->slug) }}#galeri" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Galeri</a>
                        @endif
                        @if($village->products->where('is_active', true)->count() > 0)
                        <a href="{{ route('village.show', $village->slug) }}#produk" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Produk UMKM</a>
                        @endif
                        @if($village->latitude && $village->longitude)
                        <a href="{{ route('village.show', $village->slug) }}#lokasi" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Lokasi</a>
                        @endif
                        <a href="{{ route('village.show', $village->slug) }}#kontak" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">Kontak</a>
                    </div>
                </div>
            </nav>


            <div class="flex items-center gap-2">
                {{-- Desktop action buttons --}}
                <div class="hidden items-center gap-2 lg:flex">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs">Login</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-md font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-9 px-3 text-xs">Hubungi Kami</a>
                </div>

                {{-- Mobile hamburger button --}}
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden inline-flex items-center justify-center size-10 rounded border border-border text-foreground hover:bg-muted transition-colors"
                    :aria-expanded="mobileMenuOpen"
                    aria-label="Buka menu navigasi"
                >
                    <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
                    <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Panel --}}
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
            class="lg:hidden border-t border-border bg-surface"
        >
            <nav class="mx-auto max-w-7xl px-4 py-4 sm:px-6">
                <div class="flex flex-col gap-1">
                    <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Home
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.profile', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Profil
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.services', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8l6 6v12a2 2 0 0 1-2 2z"></path><path d="M14 2v6h6"></path></svg>
                        Layanan
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#berita" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2m0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8z"></path></svg>
                        Berita
                    </a>
                    <a @click="mobileMenuOpen = false" href="{{ route('village.agenda', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                        Agenda
                    </a>
                    <a href="{{ route('village.apbdes', $village->slug) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        APBDes
                    </a>
                    {{-- Lainnya collapsible --}}
                    <div>
                        <button @click="mobileLainnya = !mobileLainnya" class="flex items-center justify-between w-full gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                            <span class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent shrink-0"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                Lainnya
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="mobileLainnya" x-collapse x-cloak class="ml-6 pl-3 border-l border-border">
                            <a @click="mobileMenuOpen = false" href="{{ route('village.ppid', $village->slug) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                PPID
                            </a>
                            @if($village->galleries->count() > 0)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#galeri" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Galeri
                            </a>
                            @endif
                            @if($village->products->where('is_active', true)->count() > 0)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#produk" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Produk UMKM
                            </a>
                            @endif
                            @if($village->latitude && $village->longitude)
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#lokasi" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Lokasi
                            </a>
                            @endif
                            <a @click="mobileMenuOpen = false" href="{{ route('village.show', $village->slug) }}#kontak" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                Kontak
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Mobile action buttons --}}
                <div class="mt-3 pt-3 border-t border-border flex flex-col gap-2">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs border border-border">Login Admin</a>
                    <a @click="mobileMenuOpen = false" href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-10 px-3 text-sm">Hubungi Kami</a>
                </div>
            </nav>
        </div>
    </header>
