<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-bold text-xl text-ivory-text leading-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                    Tata Letak Homepage Desa (Layout Manager)
                </h2>
                <p class="text-xs text-ash-text mt-1">Atur urutan dan visibilitas setiap bagian halaman depan web desa Anda (seperti WordPress / Blogger Builder).</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('/desa/' . $village->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-cobalt bg-cobalt/10 hover:bg-cobalt/20 rounded-lg transition border border-cobalt/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    Pratinjau Web Desa
                </a>
                <a href="{{ route('dashboard') }}" class="text-xs text-ash-text hover:text-ivory-text transition">← Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="layoutBuilder({{ json_encode($sections) }})">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Left Side: Section Controls --}}
                <div class="lg:col-span-8">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 sm:p-8">
                        <div class="flex items-center justify-between pb-6 border-b border-slate-border/15 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-ivory-text">Urutan & Pengaturan Bagian</h3>
                                <p class="text-xs text-ash-text">Gunakan tombol panah ke atas/bawah untuk memindahkan urutan tampil bagian di homepage.</p>
                            </div>
                            <button type="button" @click="resetToDefault()" class="text-xs text-amber-400 hover:text-amber-300 transition font-medium">
                                Reset Ke Default
                            </button>
                        </div>

                        <form method="POST" action="{{ route('desa.layout.update') }}" id="layout-form">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-3">
                                <template x-for="(section, index) in items" :key="section.id">
                                    <div class="bg-obsidian-button/50 border rounded-xl p-4 transition-all duration-200"
                                         :class="section.enabled ? 'border-slate-border/30 hover:border-cobalt/40' : 'border-slate-border/10 opacity-60 bg-slate-900/30'">
                                        
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                            
                                            {{-- Left info & Title input --}}
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div class="flex flex-col items-center justify-center gap-1">
                                                    <button type="button" @click="moveUp(index)" :disabled="index === 0"
                                                            class="p-1 rounded text-ash-text hover:text-ivory-text disabled:opacity-20 hover:bg-white/5 transition"
                                                            title="Naikkan urutan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                                    </button>
                                                    <span class="text-[11px] font-mono font-bold text-slate-500" x-text="index + 1"></span>
                                                    <button type="button" @click="moveDown(index)" :disabled="index === items.length - 1"
                                                            class="p-1 rounded text-ash-text hover:text-ivory-text disabled:opacity-20 hover:bg-white/5 transition"
                                                            title="Turunkan urutan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                                    </button>
                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    {{-- Hidden inputs for form submit --}}
                                                    <input type="hidden" :name="'sections[' + index + '][id]'" :value="section.id">
                                                    <input type="hidden" :name="'sections[' + index + '][enabled]'" :value="section.enabled ? 1 : 0">

                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-xs font-bold uppercase tracking-wider px-2 py-0.5 rounded text-cobalt bg-cobalt/10 border border-cobalt/20" x-text="getSectionTag(section.id)"></span>
                                                        <span class="text-xs text-ash-text font-mono" x-text="'#' + section.id"></span>
                                                    </div>

                                                    <input type="text" :name="'sections[' + index + '][title]'" x-model="section.title"
                                                           class="w-full text-sm font-semibold text-ivory-text bg-transparent border-b border-transparent hover:border-slate-border/30 focus:border-cobalt focus:ring-0 px-0 py-0.5 transition"
                                                           placeholder="Nama Judul Bagian">
                                                </div>
                                            </div>

                                            {{-- Right controls: Toggle Enable/Disable --}}
                                            <div class="flex items-center gap-4 shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-border/10">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" x-model="section.enabled" class="sr-only peer">
                                                    <div class="w-11 h-6 bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cobalt"></div>
                                                    <span class="ms-3 text-xs font-medium" :class="section.enabled ? 'text-green-400' : 'text-slate-500'" x-text="section.enabled ? 'Aktif' : 'Sembunyi'"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </template>
                            </div>

                            <div class="mt-8 pt-6 border-t border-slate-border/15 flex items-center justify-between">
                                <span class="text-xs text-ash-text">
                                    Total: <strong class="text-ivory-text" x-text="items.length"></strong> bagian, 
                                    Aktif: <strong class="text-green-400" x-text="items.filter(i => i.enabled).length"></strong>
                                </span>

                                <x-primary-button type="submit" class="px-6 py-2.5">
                                    Simpan Tata Letak
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Side: Live Structure Preview Card --}}
                <div class="lg:col-span-4">
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 sticky top-24">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-border/15 mb-4">
                            <h4 class="font-bold text-sm text-ivory-text flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                                Struktur Halaman Utama
                            </h4>
                            <span class="text-[10px] uppercase font-bold text-ash-text tracking-wider bg-white/5 px-2 py-0.5 rounded">Pratinjau Urutan</span>
                        </div>

                        <p class="text-xs text-ash-text mb-4">Urutan bagian yang akan tampil di halaman web publik desa Anda saat diakses warga:</p>

                        <div class="space-y-2">
                            <template x-for="(section, idx) in items.filter(i => i.enabled)" :key="section.id">
                                <div class="flex items-center gap-3 p-2.5 rounded-lg bg-obsidian-button/40 border border-slate-border/15">
                                    <span class="w-5 h-5 rounded-full bg-cobalt/20 text-cobalt font-bold text-[10px] flex items-center justify-center font-mono" x-text="idx + 1"></span>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-xs font-semibold text-ivory-text truncate" x-text="section.title"></div>
                                        <div class="text-[10px] text-ash-text font-mono" x-text="section.id"></div>
                                    </div>
                                    <span class="text-[10px] text-green-400 font-semibold bg-green-500/10 px-1.5 py-0.5 rounded">Aktif</span>
                                </div>
                            </template>

                            <div x-show="items.filter(i => i.enabled).length === 0" class="p-4 text-center text-xs text-slate-500 border border-dashed border-slate-border/20 rounded-lg">
                                Tidak ada bagian yang diaktifkan.
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-border/15 text-center">
                            <a href="{{ url('/desa/' . $village->slug) }}" target="_blank" class="text-xs text-cobalt hover:underline font-semibold flex items-center justify-center gap-1">
                                Lihat Langsung di Web Desa →
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function layoutBuilder(initialSections) {
            return {
                items: initialSections,
                defaultSections: @json(App\Models\Village::defaultLayoutSections()),

                moveUp(index) {
                    if (index > 0) {
                        const temp = this.items[index];
                        this.items[index] = this.items[index - 1];
                        this.items[index - 1] = temp;
                    }
                },

                moveDown(index) {
                    if (index < this.items.length - 1) {
                        const temp = this.items[index];
                        this.items[index] = this.items[index + 1];
                        this.items[index + 1] = temp;
                    }
                },

                resetToDefault() {
                    if (confirm('Apakah Anda yakin ingin mengembalikan tata letak ke susunan standar (default)?')) {
                        this.items = JSON.parse(JSON.stringify(this.defaultSections));
                    }
                },

                getSectionTag(id) {
                    const map = {
                        hero: 'BANNER',
                        statistics: 'STATISTIK',
                        profile: 'PROFIL',
                        services: 'LAYANAN',
                        news: 'BERITA',
                        agenda: 'AGENDA',
                        galleries: 'GALERI',
                        products: 'PRODUK UMKM',
                        complaint_banner: 'PENGADUAN',
                        map: 'PETA',
                        faq: 'FAQ'
                    };
                    return map[id] || 'SECTION';
                }
            };
        }
    </script>
</x-app-layout>
