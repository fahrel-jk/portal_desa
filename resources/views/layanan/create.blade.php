<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('layanan.dashboard') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Pengajuan Layanan
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-8 shadow-2xl">
                <h3 class="text-xl font-bold text-ivory-text mb-1">{{ $service->name }}</h3>
                <p class="text-sm text-ash-text mb-6">{{ $service->description }}</p>

                @if($service->requirements)
                    <div class="bg-cobalt/10 border border-cobalt/20 rounded-xl p-4 mb-6">
                        <h4 class="font-semibold text-cobalt mb-2 text-sm">Persyaratan yang dibutuhkan:</h4>
                        <div class="text-sm text-ivory-text prose prose-invert prose-sm">
                            {!! nl2br(e($service->requirements)) !!}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('layanan.store', $service->id) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Notes -->
                    <div class="mb-5">
                        <x-input-label for="notes" value="Catatan Tambahan (Opsional)" />
                        <textarea id="notes" name="notes" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm text-sm" rows="3" placeholder="Misal: Keperluan untuk melamar pekerjaan...">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <!-- Attachment -->
                    <div class="mb-6">
                        <x-input-label for="attachment" value="Unggah Dokumen Persyaratan (KTP/KK/Surat Pengantar)" />
                        <input id="attachment" name="attachment" type="file" accept=".jpg,.jpeg,.png,.pdf"
                            class="mt-1 block w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cobalt/10 file:text-cobalt hover:file:bg-cobalt/20 transition" />
                        <p class="mt-1 text-xs text-ash-text">Maksimal 2MB. Format JPG, PNG, atau PDF.</p>
                        <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-border/15">
                        <x-primary-button>
                            Kirim Pengajuan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
