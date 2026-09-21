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

                    {{-- Lainnya Dropdown (Liquid Glass & Clean Classic-Style Text) --}}
                    <div class="relative" @click.outside="lainnyaOpen = false">
                        <button @click="lainnyaOpen = !lainnyaOpen" 
                                id="dropdown-button"
                                aria-haspopup="menu"
                                :aria-expanded="lainnyaOpen"
                                class="flex items-center gap-1 text-[13.5px] font-medium transition-colors no-underline cursor-pointer"
                                style="color: var(--muted-fg); border: none; background: transparent; padding: 0;"
                                onmouseover="this.style.color='var(--fg)'" 
                                onmouseout="this.style.color='var(--muted-fg)'">
                            <span>Lainnya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200 opacity-75" :class="lainnyaOpen ? 'rotate-180 text-[var(--fg)]' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        
                        <div x-show="lainnyaOpen" 
                             x-transition:enter="transition ease-out duration-200" 
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95" 
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100" 
                             x-transition:leave="transition ease-in duration-150" 
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
                             x-transition:leave-end="opacity-0 -translate-y-2 scale-95" 
                             x-cloak 
                             class="absolute right-0 mt-3 z-50 overflow-hidden rounded-2xl"
                             style="width: 220px !important; padding: 10px !important; background: rgba(255, 255, 255, 0.88); backdrop-filter: blur(28px) saturate(180%); -webkit-backdrop-filter: blur(28px) saturate(180%); border: 1px solid rgba(255, 255, 255, 0.85); box-shadow: 0 20px 40px -12px rgba(24, 33, 27, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.95);"
                             role="menu"
                             aria-orientation="vertical"
                             aria-labelledby="dropdown-button">
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <a href="{{ route('village.ppid', $village->slug) }}" 
                                   @click="lainnyaOpen = false" 
                                   role="menuitem"
                                   class="no-underline transition-all duration-150"
                                   style="display: block; padding: 10px 24px !important; text-align: left !important; color: var(--fg); font-weight: 600; font-size: 13.5px; border-radius: 12px; font-family: Outfit, sans-serif;"
                                   onmouseover="this.style.backgroundColor='rgba(0,0,0,0.06)';this.style.color='var(--primary)'" 
                                   onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--fg)'">
                                    PPID
                                </a>
                                
                                @if($village->galleries->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#galeri" 
                                   @click="lainnyaOpen = false" 
                                   role="menuitem"
                                   class="no-underline transition-all duration-150"
                                   style="display: block; padding: 10px 24px !important; text-align: left !important; color: var(--fg); font-weight: 600; font-size: 13.5px; border-radius: 12px; font-family: Outfit, sans-serif;"
                                   onmouseover="this.style.backgroundColor='rgba(0,0,0,0.06)';this.style.color='var(--primary)'" 
                                   onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--fg)'">
                                    Galeri
                                </a>
                                @endif
                                
                                @if($village->products->where('is_active', true)->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#produk" 
                                   @click="lainnyaOpen = false" 
                                   role="menuitem"
                                   class="no-underline transition-all duration-150"
                                   style="display: block; padding: 10px 24px !important; text-align: left !important; color: var(--fg); font-weight: 600; font-size: 13.5px; border-radius: 12px; font-family: Outfit, sans-serif;"
                                   onmouseover="this.style.backgroundColor='rgba(0,0,0,0.06)';this.style.color='var(--primary)'" 
                                   onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--fg)'">
                                    Produk UMKM
                                </a>
                                @endif
                                
                                @if($village->latitude && $village->longitude)
                                <a href="{{ route('village.show', $village->slug) }}#lokasi" 
                                   @click="lainnyaOpen = false" 
                                   role="menuitem"
                                   class="no-underline transition-all duration-150"
                                   style="display: block; padding: 10px 24px !important; text-align: left !important; color: var(--fg); font-weight: 600; font-size: 13.5px; border-radius: 12px; font-family: Outfit, sans-serif;"
                                   onmouseover="this.style.backgroundColor='rgba(0,0,0,0.06)';this.style.color='var(--primary)'" 
                                   onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--fg)'">
                                    Lokasi
                                </a>
                                @endif
                                
                                <a href="{{ route('village.show', $village->slug) }}#kontak" 
                                   @click="lainnyaOpen = false" 
                                   role="menuitem"
                                   class="no-underline transition-all duration-150"
                                   style="display: block; padding: 10px 24px !important; text-align: left !important; color: var(--fg); font-weight: 600; font-size: 13.5px; border-radius: 12px; font-family: Outfit, sans-serif;"
                                   onmouseover="this.style.backgroundColor='rgba(0,0,0,0.06)';this.style.color='var(--primary)'" 
                                   onmouseout="this.style.backgroundColor='transparent';this.style.color='var(--fg)'">
                                    Kontak
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="h-5 w-px" style="background-color: var(--border);"></div>

                    <a href="{{ route('login') }}" class="text-[13px] font-medium px-4 py-1.5 rounded-lg border no-underline transition-colors" style="color: var(--muted-fg); border-color: var(--border);" onmouseover="this.style.borderColor='var(--fg)';this.style.color='var(--fg)'" onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted-fg)'">Login </a>
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
                        <button @click="mobileLainnya = !mobileLainnya" class="w-full flex items-center justify-between px-3 py-2 text-sm font-bold rounded-xl transition-colors no-underline" style="color: var(--fg); border: none; background: transparent;">
                            <span style="font-family: 'Outfit', sans-serif;">Lainnya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform duration-200" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="mobileLainnya" x-collapse x-cloak class="ml-2 pl-3 my-1 flex flex-col gap-1 border-l-2" style="border-color: rgba(0,0,0,0.08);">
                            <a href="{{ route('village.ppid', $village->slug) }}" @click="mobileOpen=false" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-lg no-underline transition-colors hover:bg-slate-100" style="color: var(--fg);">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span>PPID Desa</span>
                            </a>
                            @if($village->galleries->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#galeri" @click="mobileOpen=false" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-lg no-underline transition-colors hover:bg-slate-100" style="color: var(--fg);">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    <span>Galeri Foto</span>
                                </a>
                            @endif
                            @if($village->products->where('is_active', true)->count() > 0)
                                <a href="{{ route('village.show', $village->slug) }}#produk" @click="mobileOpen=false" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-lg no-underline transition-colors hover:bg-slate-100" style="color: var(--fg);">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    <span>Produk UMKM</span>
                                </a>
                            @endif
                            @if($village->latitude && $village->longitude)
                                <a href="{{ route('village.show', $village->slug) }}#lokasi" @click="mobileOpen=false" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-lg no-underline transition-colors hover:bg-slate-100" style="color: var(--fg);">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>Peta & Lokasi</span>
                                </a>
                            @endif
                            <a href="{{ route('village.show', $village->slug) }}#kontak" @click="mobileOpen=false" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-lg no-underline transition-colors hover:bg-slate-100" style="color: var(--fg);">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span>Kontak Desa</span>
                            </a>
                        </div>
                    </div>

                    <div class="h-px my-2" style="background-color: var(--border);"></div>
                    <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium rounded-lg border no-underline" style="color: var(--fg); border-color: var(--border);">Login</a>
                    <a href="{{ route('desa.request-akses.create', $village->slug) }}" class="btn-primary text-sm text-center mt-1 no-underline">Hubungi kami</a>
                </div>
            </div>
        </header>
    </div>
