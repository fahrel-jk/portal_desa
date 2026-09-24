@php
    $allNavs = collect($village->getOrderedNavSections())->where('enabled', true);
    $mainNavs = $allNavs->where('placement', 'main');
    $dropdownNavs = $allNavs->where('placement', 'dropdown');

    $resolveUrl = function($item) use ($village) {
        if ($item['type'] === 'route') {
            return route($item['target'], $village->slug);
        } elseif ($item['type'] === 'hash') {
            return route('village.show', $village->slug) . $item['target'];
        } elseif ($item['type'] === 'custom') {
            return $item['target'];
        }
        return '#';
    };
@endphp

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
                @foreach($mainNavs as $nav)
                    <a href="{{ $resolveUrl($nav) }}" class="transition-colors hover:text-accent">{{ $nav['label'] }}</a>
                @endforeach

                @if($dropdownNavs->count() > 0)
                    {{-- Lainnya Dropdown --}}
                    <div class="relative" @click.outside="lainnyaOpen = false">
                        <button @click="lainnyaOpen = !lainnyaOpen" class="inline-flex items-center gap-1 transition-colors hover:text-accent">
                            Lainnya
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="lainnyaOpen ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div x-show="lainnyaOpen" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="absolute right-0 mt-2 w-44 bg-surface border border-border rounded-md shadow-lg py-1 z-50">
                            @foreach($dropdownNavs as $nav)
                                <a href="{{ $resolveUrl($nav) }}" @click="lainnyaOpen = false" class="block px-4 py-2 text-sm text-foreground hover:bg-muted transition-colors">{{ $nav['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
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
                    @foreach($mainNavs as $nav)
                        <a @click="mobileMenuOpen = false" href="{{ $resolveUrl($nav) }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                            {{ $nav['label'] }}
                        </a>
                    @endforeach

                    @if($dropdownNavs->count() > 0)
                        {{-- Lainnya collapsible --}}
                        <div>
                            <button @click="mobileLainnya = !mobileLainnya" class="flex items-center justify-between w-full gap-3 px-3 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                                <span class="flex items-center gap-3">
                                    Lainnya
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="transition-transform" :class="mobileLainnya ? 'rotate-180' : ''"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div x-show="mobileLainnya" x-collapse x-cloak class="ml-6 pl-3 border-l border-border flex flex-col gap-1">
                                @foreach($dropdownNavs as $nav)
                                    <a @click="mobileMenuOpen = false" href="{{ $resolveUrl($nav) }}" class="flex items-center gap-3 px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted transition-colors">
                                        {{ $nav['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Mobile action buttons --}}
                <div class="mt-3 pt-3 border-t border-border flex flex-col gap-2">
                    <a href="/login" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors text-muted-foreground hover:bg-muted hover:text-foreground h-9 px-3 text-xs border border-border">Login Admin</a>
                    <a @click="mobileMenuOpen = false" href="{{ route('desa.request-akses.create', $village->slug) }}" class="inline-flex min-h-10 items-center justify-center gap-2 font-medium transition-colors bg-accent text-accent-foreground hover:bg-accent-hover h-10 px-3 text-sm">Hubungi Kami</a>
                </div>
            </nav>
        </div>
    </header>
