    {{-- ═══════════════════════════════════════
         NAVIGATION — Solid, above hero
         ═══════════════════════════════════════ --}}
    <div style="position: sticky; top: 0.75rem; z-index: 50; padding: 0 0.75rem; margin-bottom: 1.5rem;" class="sm:mb-8">
        <style>
            @media (min-width: 640px) {
                .navbar-sticky-wrap { top: 1.5rem !important; padding: 0 1rem !important; }
            }
        </style>
        <header class="navbar-pill" x-data="{ mobileOpen: false, lainnyaOpen: false, mobileLainnya: false }" :style="mobileOpen ? 'border-radius: 1.5rem;' : 'border-radius: 9999px;'" style="border-radius: 9999px;">
            <div style="display: flex; align-items: center; justify-content: space-between; height: 4.5rem;">

                {{-- Logo & Village Name --}}
                <a href="{{ route('village.show', $village->slug) }}" class="flex items-center gap-3 no-underline">
                    @if($village->logo_path)
                        <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" class="w-10 h-10 object-contain rounded-full" style="border: 1px solid var(--border);">
                    @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-base" style="background-color: var(--primary); color: var(--primary-fg); font-family: Outfit, sans-serif;">
                            {{ strtoupper(mb_substr($village->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-bold text-[15px]" style="color: var(--fg); font-family: Outfit, sans-serif;">Desa {{ $village->name }}</span>
                        <span class="text-[11px] font-medium" style="color: var(--muted-fg);">Portal resmi desa</span>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-7">
                    <a href="{{ route('village.show', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: {{ request()->routeIs('village.show') ? 'var(--fg)' : 'var(--muted-fg)' }};" onmouseover="this.style.color='var(--fg)'" onmouseout="{{ request()->routeIs('village.show') ? '' : "this.style.color='var(--muted-fg)'" }}">Beranda</a>
                    <a href="{{ route('village.profile', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: {{ request()->routeIs('village.profile') ? 'var(--fg)' : 'var(--muted-fg)' }};" onmouseover="this.style.color='var(--fg)'" onmouseout="{{ request()->routeIs('village.profile') ? '' : "this.style.color='var(--muted-fg)'" }}">Profil</a>
                    <a href="{{ route('village.services', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: {{ request()->routeIs('village.services') || request()->routeIs('village.service.show') ? 'var(--fg)' : 'var(--muted-fg)' }};" onmouseover="this.style.color='var(--fg)'" onmouseout="{{ request()->routeIs('village.services') || request()->routeIs('village.service.show') ? '' : "this.style.color='var(--muted-fg)'" }}">Layanan</a>
                    <a href="{{ route('village.show', $village->slug) }}#berita" class="text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg);" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">Berita</a>
                    <a href="{{ route('village.agenda', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: {{ request()->routeIs('village.agenda') ? 'var(--fg)' : 'var(--muted-fg)' }};" onmouseover="this.style.color='var(--fg)'" onmouseout="{{ request()->routeIs('village.agenda') ? '' : "this.style.color='var(--muted-fg)'" }}">Agenda</a>
                    <a href="{{ route('village.apbdes', $village->slug) }}" class="text-[13.5px] font-medium transition-colors no-underline" style="color: {{ request()->routeIs('village.apbdes') ? 'var(--fg)' : 'var(--muted-fg)' }};" onmouseover="this.style.color='var(--fg)'" onmouseout="{{ request()->routeIs('village.apbdes') ? '' : "this.style.color='var(--muted-fg)'" }}">APBDes</a>

                    {{-- Lainnya Dropdown (Liquid Glass Style) --}}
                    <div class="relative" @click.outside="lainnyaOpen = false">
                        <button @click="lainnyaOpen = !lainnyaOpen" class="flex items-center gap-1 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--muted-fg); border: none; background: transparent; padding: 0; cursor: pointer;" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--muted-fg)'">
                            Lainnya
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="lainnyaOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        
                        <div x-show="lainnyaOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 translate-y-2" 
                             x-transition:enter-end="opacity-100 translate-y-0" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 translate-y-0" 
                             x-transition:leave-end="opacity-0 translate-y-2" 
                             x-cloak 
                             class="absolute right-0 mt-4 w-48 rounded-2xl py-2 z-50 shadow-[0_8px_30px_rgb(0,0,0,0.08)]"
                             style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.6);">
                            
                            <a href="{{ route('village.ppid', $village->slug) }}" @click="lainnyaOpen = false" class="block px-4 py-2 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--fg);" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.05)'" onmouseout="this.style.backgroundColor='transparent'">PPID</a>
                            
                            @if($village->galleries->count() > 0)
                            <a href="{{ route('village.show', $village->slug) }}#galeri" @click="lainnyaOpen = false" class="block px-4 py-2 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--fg);" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.05)'" onmouseout="this.style.backgroundColor='transparent'">Galeri</a>
                            @endif
                            
                            @if($village->products->where('is_active', true)->count() > 0)
                            <a href="{{ route('village.show', $village->slug) }}#produk" @click="lainnyaOpen = false" class="block px-4 py-2 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--fg);" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.05)'" onmouseout="this.style.backgroundColor='transparent'">Produk UMKM</a>
                            @endif
                            
                            @if($village->latitude && $village->longitude)
                            <a href="{{ route('village.show', $village->slug) }}#lokasi" @click="lainnyaOpen = false" class="block px-4 py-2 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--fg);" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.05)'" onmouseout="this.style.backgroundColor='transparent'">Lokasi</a>
                            @endif
                            
                            <a href="{{ route('village.show', $village->slug) }}#kontak" @click="lainnyaOpen = false" class="block px-4 py-2 text-[13.5px] font-medium transition-colors no-underline" style="color: var(--fg);" onmouseover="this.style.backgroundColor='rgba(0,0,0,0.05)'" onmouseout="this.style.backgroundColor='transparent'">Kontak</a>
                        </div>
                    </div>

                    <div class="h-5 w-px" style="background-color: var(--border);"></div>

                    <a href="{{ route('login') }}" class="text-[13px] font-medium px-4 py-1.5 rounded-lg border no-underline transition-colors" style="color: var(--muted-fg); border-color: var(--border);" onmouseover="this.style.borderColor='var(--fg)';this.style.color='var(--fg)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted-fg)'">Login Admin</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary text-[13px] !py-2 !px-5 !rounded-full no-underline">Hubungi kami</a>
                </nav>

                {{-- Mobile Hamburger --}}
                <button aria-label="Toggle menu" class="lg:hidden p-2 rounded-lg" style="color: var(--fg); border: none; background: transparent;" @click="mobileOpen = !mobileOpen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileOpen" x-collapse x-cloak class="lg:hidden border-t py-4" style="border-color: var(--border);">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('village.show', $village->slug) }}" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Beranda</a>
                    <a href="{{ route('village.profile', $village->slug) }}" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Profil</a>
                    <a href="{{ route('village.services', $village->slug) }}" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Layanan</a>
                    <a href="{{ route('village.show', $village->slug) }}#berita" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Berita</a>
                    <a href="{{ route('village.agenda', $village->slug) }}" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">Agenda</a>
                    <a href="{{ route('village.apbdes', $village->slug) }}" @click="mobileOpen=false" class="px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg);">APBDes</a>
                    
                    {{-- Lainnya Mobile --}}
                    <div>
                        <button @click="mobileLainnya = !mobileLainnya" class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--fg); border: none; background: transparent;">
                            Lainnya
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="mobileLainnya" x-collapse x-cloak class="ml-4 pl-2 border-l" style="border-color: var(--border);">
                            <a href="{{ route('village.ppid', $village->slug) }}" @click="mobileOpen=false" class="block px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--muted-fg);">PPID</a>
                            @if($village->galleries->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#galeri" @click="mobileOpen=false" class="block px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--muted-fg);">Galeri</a>
                            @endif
                            @if($village->products->where('is_active', true)->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#produk" @click="mobileOpen=false" class="block px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--muted-fg);">Produk UMKM</a>
                            @endif
                            @if($village->latitude && $village->longitude)
                                <a href="{{ route('village.show', $village->slug) }}#lokasi" @click="mobileOpen=false" class="block px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--muted-fg);">Lokasi</a>
                            @endif
                            <a href="{{ route('village.show', $village->slug) }}#kontak" @click="mobileOpen=false" class="block px-3 py-2 text-sm font-medium rounded-lg no-underline" style="color: var(--muted-fg);">Kontak</a>
                        </div>
                    </div>

                    <div class="h-px my-2" style="background-color: var(--border);"></div>
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium rounded-lg border no-underline" style="color: var(--fg); border-color: var(--border);">Login Admin</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary text-sm text-center mt-1 no-underline">Hubungi kami</a>
                </div>
            </div>
        </header>
    </div>
