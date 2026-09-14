<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Pengajuan Layanan Masuk
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6 shadow-xl">
                
                {{-- Filters --}}
                <div class="mb-6 pb-6 border-b border-slate-border/20 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                    <form method="GET" action="{{ route('desa.pengajuan-masuk.index') }}" class="flex gap-2">
                        <select name="status" onchange="this.form.submit()" class="bg-obsidian-button border-slate-border text-ivory-text text-sm rounded-lg focus:ring-cobalt focus:border-cobalt">
                            <option value="">Semua Status</option>
                            <option value="diajukan" {{ request('status') === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>
                </div>

                @if($pengajuan->isEmpty())
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-ash-text mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-ash-text">Tidak ada pengajuan layanan yang ditemukan.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-ash-text">
                            <thead class="text-xs uppercase bg-obsidian-button/50 text-ash-text">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">Kode / Tgl</th>
                                    <th scope="col" class="px-6 py-3">Pemohon</th>
                                    <th scope="col" class="px-6 py-3">Layanan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-border/20">
                                @foreach($pengajuan as $item)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-ivory-text">{{ $item->kode_tracking }}</div>
                                            <div class="text-xs text-ash-text/70 mt-1">{{ $item->created_at->format('d M Y, H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-ivory-text">{{ $item->user->name }}</div>
                                            <div class="text-xs text-ash-text/70 mt-1">NIK: {{ $item->data_pemohon['nik'] ?? '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">{{ $item->layanan->name }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->status === 'diajukan')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Diajukan</span>
                                            @elseif($item->status === 'diproses')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">Diproses</span>
                                            @elseif($item->status === 'selesai')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">Selesai</span>
                                            @elseif($item->status === 'ditolak')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('desa.pengajuan-masuk.show', $item->id) }}" class="text-cobalt hover:text-white text-sm font-medium transition">Review &rarr;</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pengajuan->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
