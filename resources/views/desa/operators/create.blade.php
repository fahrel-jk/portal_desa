<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Operator Desa
            </h2>
            <a href="{{ route('desa.operators.index') }}" class="text-sm text-ash-text hover:text-ivory-text transition">
                &larr; Batal
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 overflow-hidden rounded-2xl p-8 shadow-2xl">
                <p class="text-sm text-ash-text mb-6">Tambahkan akun admin baru untuk mengelola profil dan layanan desa Anda.</p>

                <form method="POST" action="{{ route('desa.operators.store') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-5">
                        <x-input-label for="name" value="Nama Operator" />
                        <x-text-input id="name" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-5">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        <p class="text-xs text-ash-text mt-1">Email ini akan digunakan operator untuk login.</p>
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <x-input-label for="password" value="Password Sementara" />
                        <x-text-input id="password" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                        <x-text-input id="password_confirmation" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            Simpan Operator Baru
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
