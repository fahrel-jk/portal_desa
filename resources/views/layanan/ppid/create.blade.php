<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('layanan.dashboard') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Ajukan Permohonan Informasi PPID
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-8 shadow-xl">
                
                <div class="mb-8">
                    <p class="text-sm text-ash-text">
                        Gunakan formulir ini untuk mengajukan permohonan informasi publik ke Desa {{ $village->name }}. Silakan isi data dengan lengkap dan jelas.
                    </p>
                </div>

                <form method="POST" action="{{ route('layanan.ppid.store') }}" class="space-y-6">
                    @csrf

                    <h3 class="text-lg font-bold text-ivory-text mb-4 border-b border-slate-border/20 pb-2">Data Pemohon</h3>

                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="text" name="name" :value="auth()->user()->name" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="agency" value="Tujuan / Instansi / Individu" />
                        <x-text-input id="agency" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="text" name="agency" :value="old('agency')" required />
                        <x-input-error :messages="$errors->get('agency')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="phone" value="Nomor WhatsApp" />
                            <x-text-input id="phone" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="text" name="phone" :value="old('phone')" required />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Alamat Email" />
                            <x-text-input id="email" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt" type="email" name="email" :value="auth()->user()->email" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-ivory-text mt-8 mb-4 border-b border-slate-border/20 pb-2">Rincian Informasi</h3>

                    <div>
                        <x-input-label for="content" value="Rincian Informasi yang Dibutuhkan" />
                        <textarea id="content" name="content" rows="5" class="block mt-1 w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" required placeholder="Jelaskan secara spesifik informasi yang Anda butuhkan...">{{ old('content') }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-8">
                        <x-primary-button class="bg-cobalt hover:bg-cobalt/80 border-none">
                            Kirim Permohonan
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
