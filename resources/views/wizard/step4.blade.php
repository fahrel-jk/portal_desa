<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Pendaftaran Desa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                <x-portal.step-indicator :current="4" :total="4" />

                <h3 class="text-lg font-semibold text-ivory-text mb-1">Profil & Struktur Perangkat</h3>
                <p class="text-sm text-ash-text mb-6">Lengkapi informasi profil dan daftarkan perangkat desa.</p>

                <form method="POST" action="{{ route('wizard.store-step4') }}" id="step4-form">
                    @csrf

                    <!-- Deskripsi / Sejarah -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Deskripsi / Sejarah Singkat Desa" />
                        <textarea id="description" name="description" rows="4"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Ceritakan sejarah singkat dan keunggulan desa Anda...">{{ old('description', $data['description'] ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Kontak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="contact_phone" value="Telepon Kantor" />
                            <x-text-input id="contact_phone" name="contact_phone" type="text" class="mt-1 block w-full"
                                :value="old('contact_phone', $data['contact_phone'] ?? '')"
                                placeholder="0343-123456" />
                            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact_email" value="Email Desa" />
                            <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full"
                                :value="old('contact_email', $data['contact_email'] ?? '')"
                                placeholder="desa@example.com" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-8">
                        <x-input-label for="office_hours" value="Jam Layanan" />
                        <x-text-input id="office_hours" name="office_hours" type="text" class="mt-1 block w-full"
                            :value="old('office_hours', $data['office_hours'] ?? '')"
                            placeholder="Senin - Jumat, 08:00 - 15:00 WIB" />
                        <x-input-error :messages="$errors->get('office_hours')" class="mt-2" />
                    </div>

                    <!-- Struktur Perangkat Desa -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-ivory-text">Perangkat Desa</h4>
                                <p class="text-sm text-ash-text">Tambahkan daftar perangkat desa (nama dan jabatan).</p>
                            </div>
                            <button type="button" onclick="addOfficial()"
                                class="inline-flex items-center px-3 py-1.5 bg-cobalt/10 text-cobalt text-sm font-medium rounded-md hover:bg-indigo-100 transition">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah
                            </button>
                        </div>

                        <div id="officials-container" class="space-y-3">
                            @php
                                $officials = old('officials', $data['officials'] ?? [['name' => '', 'position' => '']]);
                            @endphp
                            @foreach($officials as $index => $official)
                                <div class="flex flex-col sm:flex-row items-start gap-3 official-row" data-index="{{ $index }}">
                                    <div class="flex-1">
                                        <x-text-input name="officials[{{ $index }}][name]" type="text" class="block w-full"
                                            :value="$official['name'] ?? ''" placeholder="Nama perangkat" required />
                                    </div>
                                    <div class="flex-1">
                                        <x-text-input name="officials[{{ $index }}][position]" type="text" class="block w-full"
                                            :value="$official['position'] ?? ''" placeholder="Jabatan" required />
                                    </div>
                                    <button type="button" onclick="removeOfficial(this)"
                                        class="mt-1 p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('wizard.step3') }}"
                            class="inline-flex items-center px-4 py-2 bg-graphite-card border border-slate-border rounded-md font-semibold text-xs text-ivory-text uppercase tracking-widest shadow-sm hover:bg-obsidian-button/30 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <x-primary-button>
                            Tinjau & Kirim
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
        let officialIndex = {{ count($officials ?? []) }};

        function addOfficial() {
            const container = document.getElementById('officials-container');
            const row = document.createElement('div');
            row.className = 'flex items-start gap-3 official-row';
            row.dataset.index = officialIndex;
            row.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="officials[${officialIndex}][name]"
                        class="block w-full border-slate-border focus:border-indigo-500 focus:ring-cobalt rounded-md shadow-sm"
                        placeholder="Nama perangkat" required />
                </div>
                <div class="flex-1">
                    <input type="text" name="officials[${officialIndex}][position]"
                        class="block w-full border-slate-border focus:border-indigo-500 focus:ring-cobalt rounded-md shadow-sm"
                        placeholder="Jabatan" required />
                </div>
                <button type="button" onclick="removeOfficial(this)"
                    class="mt-1 p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            container.appendChild(row);
            officialIndex++;
        }

        function removeOfficial(btn) {
            const container = document.getElementById('officials-container');
            if (container.children.length > 1) {
                btn.closest('.official-row').remove();
            }
        }
    </script>
</x-app-layout>
