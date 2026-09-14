<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Pendaftaran Desa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                <x-portal.step-indicator :current="2" :total="4" />

                <h3 class="text-lg font-semibold text-ivory-text mb-1">Pilih Template</h3>
                <p class="text-sm text-ash-text mb-6">Pilih tampilan untuk halaman desa Anda. Template bisa diubah nanti.</p>

                <form method="POST" action="{{ route('wizard.store-step2') }}">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        @foreach($templates as $template)
                            <label for="template-{{ $template->id }}"
                                class="relative cursor-pointer rounded-xl border-2 p-4 transition-all duration-200 hover:shadow-md
                                    {{ (old('template_id', $data['template_id'] ?? '') == $template->id) ? 'border-portal-primary bg-cobalt/10 shadow-md' : 'border-slate-border/15 bg-graphite-card hover:border-slate-border' }}
                                ">
                                <input type="radio" id="template-{{ $template->id }}" name="template_id"
                                    value="{{ $template->id }}" class="sr-only"
                                    {{ (old('template_id', $data['template_id'] ?? '') == $template->id) ? 'checked' : '' }}
                                    onchange="selectTemplate(this)" required>

                                <!-- Template Preview -->
                                <div class="aspect-video bg-obsidian-button rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                                    @if($template->thumbnail_path)
                                        <img src="{{ Storage::url($template->thumbnail_path) }}"
                                            alt="Preview {{ $template->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-ash-text mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                                            </svg>
                                            <span class="text-xs text-ash-text">Template {{ $template->name }}</span>
                                        </div>
                                    @endif
                                </div>

                                <h4 class="font-semibold text-ivory-text">{{ $template->name }}</h4>
                                <p class="text-sm text-ash-text mt-1">
                                    @if($template->slug === 'klasik')
                                        Header solid dengan daftar konten — tampilan bersih dan formal.
                                    @else
                                        Header dengan overlay gambar dan grid kartu — tampilan modern dan dinamis.
                                    @endif
                                </p>

                                <!-- Selected indicator -->
                                <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 flex items-center justify-center
                                    {{ (old('template_id', $data['template_id'] ?? '') == $template->id) ? 'border-portal-primary bg-cobalt' : 'border-slate-border' }}
                                ">
                                    @if(old('template_id', $data['template_id'] ?? '') == $template->id)
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <x-input-error :messages="$errors->get('template_id')" class="mb-8" />

                    {{-- Theme Color Selection --}}
                    <h3 class="text-lg font-semibold text-ivory-text mb-1 border-t border-slate-border/15 pt-6 mt-2">Pilih Warna Tema</h3>
                    <p class="text-sm text-ash-text mb-6">Pilih warna utama yang merepresentasikan desa Anda.</p>

                    @php
                        $colors = [
                            ['hex' => '#0c8c5e', 'name' => 'Hijau Mint'],
                            ['hex' => '#1e40af', 'name' => 'Biru Tua'],
                            ['hex' => '#991b1b', 'name' => 'Merah Marun'],
                            ['hex' => '#5b21b6', 'name' => 'Ungu Gelap'],
                            ['hex' => '#047857', 'name' => 'Zamrud'],
                            ['hex' => '#0f172a', 'name' => 'Hitam Elegan']
                        ];
                        $selectedColor = old('theme_color', $data['theme_color'] ?? '#0c8c5e');
                    @endphp

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                        @foreach($colors as $color)
                            <label for="color-{{ Str::slug($color['name']) }}"
                                class="relative flex items-center gap-3 p-3 cursor-pointer rounded-xl border-2 transition-all duration-200
                                {{ $selectedColor == $color['hex'] ? 'border-portal-primary bg-cobalt/10' : 'border-slate-border/15 bg-graphite-card hover:border-slate-border' }}"
                                onclick="selectColor(this)">
                                
                                <input type="radio" id="color-{{ Str::slug($color['name']) }}" name="theme_color"
                                    value="{{ $color['hex'] }}" class="sr-only"
                                    {{ $selectedColor == $color['hex'] ? 'checked' : '' }}>
                                
                                <div class="w-6 h-6 rounded-full shadow-sm flex-shrink-0" style="background-color: {{ $color['hex'] }}"></div>
                                <span class="text-sm font-medium text-ivory-text">{{ $color['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    
                    <x-input-error :messages="$errors->get('theme_color')" class="mb-4" />

                    <div class="flex justify-between">
                        <a href="{{ route('wizard.step1') }}"
                            class="inline-flex items-center px-4 py-2 bg-graphite-card border border-slate-border rounded-md font-semibold text-xs text-ivory-text uppercase tracking-widest shadow-sm hover:bg-obsidian-button/30 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <x-primary-button>
                            Lanjut ke Langkah 3
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectTemplate(radio) {
            // Remove selection from all
            document.querySelectorAll('label[for^="template-"]').forEach(label => {
                label.classList.remove('border-portal-primary', 'bg-cobalt/10', 'shadow-md');
                label.classList.add('border-slate-border/15', 'bg-graphite-card');
                const indicator = label.querySelector('.absolute > svg');
                const indicatorDiv = label.querySelector('.absolute');
                if (indicatorDiv) {
                    indicatorDiv.classList.remove('border-portal-primary', 'bg-cobalt');
                    indicatorDiv.classList.add('border-slate-border');
                    indicatorDiv.innerHTML = '';
                }
            });

            // Add selection to selected
            const label = radio.closest('label');
            label.classList.add('border-portal-primary', 'bg-cobalt/10', 'shadow-md');
            label.classList.remove('border-slate-border/15', 'bg-graphite-card');
            const indicatorDiv = label.querySelector('.absolute');
            if (indicatorDiv) {
                indicatorDiv.classList.add('border-portal-primary', 'bg-cobalt');
                indicatorDiv.classList.remove('border-slate-border');
                indicatorDiv.innerHTML = '<svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>';
            }
        }

        function selectColor(label) {
            // Remove selection from all
            document.querySelectorAll('input[name="theme_color"]').forEach(radio => {
                const parent = radio.closest('label');
                parent.classList.remove('border-portal-primary', 'bg-cobalt/10');
                parent.classList.add('border-slate-border/15', 'bg-graphite-card');
            });

            // Add selection to clicked
            label.classList.add('border-portal-primary', 'bg-cobalt/10');
            label.classList.remove('border-slate-border/15', 'bg-graphite-card');
        }
    </script>
</x-app-layout>
