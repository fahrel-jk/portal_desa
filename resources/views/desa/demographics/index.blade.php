<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                {{ __('Statistik Kependudukan') }}
            </h2>
            <a href="{{ route('desa.demographics.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-pure-white font-semibold rounded-lg hover:bg-cobalt-hover transition">
                + Tambah Data
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400">
                    {{ session('success') }}
                </div>
            @endif

            @forelse($groupedDemographics as $type => $demographics)
                <div class="mb-8 bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-border/20 flex justify-between items-center bg-obsidian-button/30">
                        <h3 class="text-lg font-semibold text-ivory-text capitalize">Berdasarkan {{ ucfirst($type) }}</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($demographics as $item)
                                <div class="bg-obsidian-button/50 border border-slate-border/20 rounded-xl p-4 flex justify-between items-center group">
                                    <div>
                                        <p class="text-ash-text text-sm mb-1">{{ $item->label }}</p>
                                        <p class="text-2xl font-bold text-ivory-text">{{ number_format($item->count, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('desa.demographics.edit', $item) }}" class="p-2 text-cobalt hover:bg-cobalt/10 rounded-lg transition" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                                        </a>
                                        <form action="{{ route('desa.demographics.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-400 hover:bg-red-400/10 rounded-lg transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 p-12 text-center">
                    <svg class="w-16 h-16 text-slate-border/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-bold text-ivory-text mb-2">Belum Ada Data Statistik</h3>
                    <p class="text-ash-text">Tambahkan data demografi desa seperti jumlah laki-laki/perempuan atau usia warga.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
