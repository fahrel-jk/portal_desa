<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Profil Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">
                
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('desa.profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <!-- Deskripsi / Sejarah -->
                    <div class="mb-6">
                        <x-input-label for="description" value="Deskripsi / Sejarah Singkat Desa" />
                        <textarea id="description" name="description" rows="5"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Ceritakan sejarah singkat dan keunggulan desa Anda...">{{ old('description', $village->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Kontak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="contact_phone" value="Telepon Kantor" />
                            <x-text-input id="contact_phone" name="contact_phone" type="text" class="mt-1 block w-full"
                                :value="old('contact_phone', $village->contact_phone)"
                                placeholder="0343-123456" />
                            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact_email" value="Email Desa" />
                            <x-text-input id="contact_email" name="contact_email" type="email" class="mt-1 block w-full"
                                :value="old('contact_email', $village->contact_email)"
                                placeholder="desa@example.com" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="office_hours" value="Jam Layanan" />
                        <x-text-input id="office_hours" name="office_hours" type="text" class="mt-1 block w-full"
                            :value="old('office_hours', $village->office_hours)"
                            placeholder="Senin - Jumat, 08:00 - 15:00 WIB" />
                        <x-input-error :messages="$errors->get('office_hours')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="address" value="Alamat Kantor Desa" />
                        <textarea id="address" name="address" rows="3"
                            class="mt-1 block w-full border-slate-border focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Alamat lengkap kantor desa">{{ old('address', $village->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Simpan Perubahan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
