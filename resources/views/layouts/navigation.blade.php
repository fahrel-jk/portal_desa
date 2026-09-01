<nav x-data="{ open: false }" class="bg-graphite-card/80 backdrop-blur-xl border-b border-slate-border/20 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2.5">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-cobalt rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-pure-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </div>
                        <span class="font-bold text-lg text-ivory-text tracking-tight">Portal Desa</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:ms-8 sm:flex">
                    <a href="{{ route('dashboard') }}" class="velorah-link inline-flex items-center px-1 pt-1 text-sm font-medium text-ash-text hover:text-ivory-text transition-colors {{ request()->routeIs('dashboard') ? 'text-ivory-text border-b-2 border-transparent' : '' }}">
                        Dashboard
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.feedback.index') }}" class="velorah-link inline-flex items-center px-1 pt-1 text-sm font-medium text-ash-text hover:text-ivory-text transition-colors {{ request()->routeIs('admin.feedback.*') ? 'text-ivory-text border-b-2 border-transparent' : '' }}">
                            Masukan
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-full text-ash-text hover:text-ivory-text hover:bg-obsidian-button focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-graphite-card border border-slate-border/30 rounded-xl shadow-2xl py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition">
                                Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block px-4 py-2 text-sm text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition">
                                    Keluar
                                </a>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-graphite-card border-t border-slate-border/20">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition {{ request()->routeIs('dashboard') ? 'text-ivory-text bg-obsidian-button' : '' }}">
                Dashboard
            </a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.feedback.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition {{ request()->routeIs('admin.feedback.*') ? 'text-ivory-text bg-obsidian-button' : '' }}">
                    Masukan
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-border/20 px-4">
            <div class="mb-3">
                <div class="font-medium text-base text-ivory-text">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-ash-text">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition">
                    Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-3 py-2 rounded-lg text-sm text-ash-text hover:text-ivory-text hover:bg-obsidian-button transition">
                        Keluar
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>
