<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Pendaftaran Desa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 overflow-hidden rounded-2xl p-8">
                <x-portal.step-indicator :current="1" :total="4" />

                <h3 class="text-lg font-bold text-ivory-text mb-1">Data Dasar Desa</h3>
                <p class="text-sm text-ash-text mb-6">Masukkan informasi dasar tentang desa Anda.</p>

                <form method="POST" action="{{ route('wizard.store-step1') }}">
                    @csrf

                    <!-- Nama Desa -->
                    <div class="mb-5">
                        <x-input-label for="name" value="Nama Desa" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $data['name'] ?? '')" required autofocus
                            placeholder="contoh: Ladang Panjang" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @if(isset($data['slug_preview']))
                            <p class="mt-1 text-xs text-ash-text">
                                Desa Anda akan tayang di: <span class="font-mono text-cobalt">/desa/{{ $data['slug_preview'] }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Kecamatan -->
                    <div class="mb-5">
                        <x-input-label for="kecamatan" value="Kecamatan" />
                        <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full"
                            :value="old('kecamatan', $data['kecamatan'] ?? '')" required
                            placeholder="contoh: Kecamatan Sukolilo" />
                        <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                    </div>

                    <!-- Kabupaten -->
                    <div class="mb-5">
                        <x-input-label for="kabupaten" value="Kabupaten / Kota" />
                        <x-text-input id="kabupaten" name="kabupaten" type="text" class="mt-1 block w-full"
                            :value="old('kabupaten', $data['kabupaten'] ?? '')" required
                            placeholder="contoh: Kabupaten Pasuruan" />
                        <x-input-error :messages="$errors->get('kabupaten')" class="mt-2" />
                    </div>

                    <!-- Alamat Kantor -->
                    <div class="mb-6">
                        <x-input-label for="address" value="Alamat Kantor Desa" />
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm placeholder:text-ash-text"
                            required placeholder="Alamat lengkap kantor desa">{{ old('address', $data['address'] ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Lanjut ke Langkah 2
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
