<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Pendaftaran Desa — Tinjau & Kirim
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-cobalt/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-cobalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-ivory-text">Tinjau Data Pendaftaran</h3>
                    <p class="text-sm text-ash-text mt-1">Pastikan semua informasi benar sebelum mengirim.</p>
                </div>

                <!-- Data Dasar -->
                <div class="border border-slate-border/15 rounded-lg p-5 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-ivory-text flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-cobalt text-white text-xs flex items-center justify-center">1</span>
                            Data Dasar
                        </h4>
                        <a href="{{ route('wizard.step1') }}" class="text-sm text-cobalt hover:underline">Ubah</a>
                    </div>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                        <div>
                            <dt class="text-ash-text">Nama Desa</dt>
                            <dd class="font-medium text-ivory-text">{{ $step1['name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-ash-text">Kecamatan</dt>
                            <dd class="font-medium text-ivory-text">{{ $step1['kecamatan'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-ash-text">Kabupaten</dt>
                            <dd class="font-medium text-ivory-text">{{ $step1['kabupaten'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-ash-text">Alamat URL</dt>
                            <dd class="font-mono text-cobalt text-xs">/desa/{{ $step1['slug_preview'] ?? \Illuminate\Support\Str::slug($step1['name']) }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-ash-text">Alamat Kantor</dt>
                            <dd class="font-medium text-ivory-text">{{ $step1['address'] }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Template -->
                <div class="border border-slate-border/15 rounded-lg p-5 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-ivory-text flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-cobalt text-white text-xs flex items-center justify-center">2</span>
                            Template
                        </h4>
                        <a href="{{ route('wizard.step2') }}" class="text-sm text-cobalt hover:underline">Ubah</a>
                    </div>
                    <p class="text-sm text-ivory-text font-medium">{{ $template->name }}</p>
                </div>

                <!-- Identitas Visual -->
                <div class="border border-slate-border/15 rounded-lg p-5 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-ivory-text flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-cobalt text-white text-xs flex items-center justify-center">3</span>
                            Identitas Visual
                        </h4>
                        <a href="{{ route('wizard.step3') }}" class="text-sm text-cobalt hover:underline">Ubah</a>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 text-sm">
                        <div>
                            <span class="text-ash-text">Logo:</span>
                            <span class="font-medium {{ !empty($step3['logo_name']) ? 'text-green-600' : 'text-ash-text' }}">
                                {{ $step3['logo_name'] ?? 'Tidak diupload' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-ash-text">Foto Utama:</span>
                            <span class="font-medium {{ !empty($step3['hero_image_name']) ? 'text-green-600' : 'text-ash-text' }}">
                                {{ $step3['hero_image_name'] ?? 'Tidak diupload' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Profil & Struktur -->
                <div class="border border-slate-border/15 rounded-lg p-5 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-ivory-text flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-cobalt text-white text-xs flex items-center justify-center">4</span>
                            Profil & Struktur
                        </h4>
                        <a href="{{ route('wizard.step4') }}" class="text-sm text-cobalt hover:underline">Ubah</a>
                    </div>

                    @if(!empty($step4['description']))
                        <div class="mb-3">
                            <span class="text-sm text-ash-text">Deskripsi:</span>
                            <p class="text-sm text-ivory-text mt-1">{{ Str::limit($step4['description'], 200) }}</p>
                        </div>
                    @endif

                    <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-4 gap-y-2 text-sm mb-3">
                        <div>
                            <dt class="text-ash-text">Telepon</dt>
                            <dd class="font-medium text-ivory-text">{{ $step4['contact_phone'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-ash-text">Email</dt>
                            <dd class="font-medium text-ivory-text">{{ $step4['contact_email'] ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-ash-text">Jam Layanan</dt>
                            <dd class="font-medium text-ivory-text">{{ $step4['office_hours'] ?? '-' }}</dd>
                        </div>
                    </dl>

                    @if(!empty($step4['officials']))
                        <div>
                            <span class="text-sm text-ash-text">Perangkat Desa ({{ count($step4['officials']) }} orang):</span>
                            <ul class="mt-1 space-y-1">
                                @foreach($step4['officials'] as $official)
                                    <li class="text-sm text-ivory-text">
                                        <span class="font-medium">{{ $official['name'] }}</span>
                                        <span class="text-ash-text">— {{ $official['position'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- Submit -->
                <form method="POST" action="{{ route('wizard.submit') }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <a href="{{ route('wizard.step4') }}"
                            class="inline-flex items-center px-4 py-2 bg-graphite-card border border-slate-border rounded-md font-semibold text-xs text-ivory-text uppercase tracking-widest shadow-sm hover:bg-obsidian-button/30 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <x-primary-button class="!bg-green-600 hover:!bg-green-700 !text-base !px-6 !py-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim untuk Ditinjau
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
