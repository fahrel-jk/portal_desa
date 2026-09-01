<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Layanan Administrasi
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl">
                <div class="p-6 border-b border-slate-border/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-ivory-text">Daftar Layanan Administrasi</h3>
                    <a href="{{ route('desa.services.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Layanan
                    </a>
                </div>

                @if($services->count() > 0)
                    <div class="divide-y divide-slate-border/10">
                        @foreach($services as $service)
                            <div class="p-6 hover:bg-obsidian-button/30 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-ivory-text text-base mb-1">{{ $service->name }}</h4>
                                        @if($service->description)
                                            <p class="text-sm text-ash-text mb-3">{{ $service->description }}</p>
                                        @endif
                                        @if($service->requirements)
                                            <div class="bg-obsidian-button/50 rounded-lg p-3 border border-slate-border/10">
                                                <p class="text-xs text-ash-text uppercase tracking-wider font-medium mb-1">Persyaratan:</p>
                                                <p class="text-sm text-ivory-text/80 whitespace-pre-line">{{ $service->requirements }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 shrink-0">
                                        <a href="{{ route('desa.services.edit', $service) }}" class="text-sm text-cobalt hover:underline">Edit</a>
                                        <form action="{{ route('desa.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-400 hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-obsidian-button rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-ash-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h4 class="text-lg font-medium text-ivory-text mb-1">Belum ada layanan</h4>
                        <p class="text-ash-text text-sm">Tambahkan layanan administrasi yang tersedia di desa Anda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
