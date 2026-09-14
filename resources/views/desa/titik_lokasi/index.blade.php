<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Titik Lokasi
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-ivory-text">Daftar Titik Lokasi</h3>
                    <a href="{{ route('desa.titik-lokasi.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Titik Lokasi
                    </a>
                </div>

                @if($titikLokasis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-slate-border/15">
                                    <th class="py-3 px-4 text-ash-text font-semibold text-xs uppercase tracking-wider">Nama Lokasi</th>
                                    <th class="py-3 px-4 text-ash-text font-semibold text-xs uppercase tracking-wider">Kategori</th>
                                    <th class="py-3 px-4 text-ash-text font-semibold text-xs uppercase tracking-wider">Koordinat</th>
                                    <th class="py-3 px-4 text-ash-text font-semibold text-xs uppercase tracking-wider">Foto</th>
                                    <th class="py-3 px-4 text-ash-text font-semibold text-xs uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-border/10">
                                @foreach($titikLokasis as $titik)
                                    <tr class="hover:bg-obsidian-button/20 transition">
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-ivory-text">{{ $titik->nama_lokasi }}</div>
                                            @if($titik->deskripsi)
                                                <div class="text-xs text-ash-text mt-0.5 line-clamp-1">{{ Str::limit($titik->deskripsi, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @php
                                                $badgeColors = [
                                                    'pemerintahan' => 'bg-blue-500/20 text-blue-400',
                                                    'kesehatan' => 'bg-green-500/20 text-green-400',
                                                    'pendidikan' => 'bg-amber-500/20 text-amber-400',
                                                    'ibadah' => 'bg-purple-500/20 text-purple-400',
                                                    'lainnya' => 'bg-gray-500/20 text-gray-400',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeColors[$titik->kategori] ?? $badgeColors['lainnya'] }}">
                                                {{ ucfirst($titik->kategori) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-ash-text text-xs font-mono">
                                            {{ number_format($titik->latitude, 5) }}, {{ number_format($titik->longitude, 5) }}
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($titik->foto)
                                                <img src="{{ Storage::url($titik->foto) }}" alt="{{ $titik->nama_lokasi }}" class="w-10 h-10 rounded object-cover border border-slate-border/15">
                                            @else
                                                <span class="text-xs text-ash-text/50">—</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('desa.titik-lokasi.edit', $titik) }}" class="text-xs text-cobalt hover:underline font-medium">Edit</a>
                                                <form action="{{ route('desa.titik-lokasi.destroy', $titik) }}" method="POST" onsubmit="return confirm('Hapus titik lokasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-400 hover:underline font-medium">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-12 text-center text-ash-text">
                        <svg class="w-12 h-12 mx-auto mb-4 text-ash-text/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Belum ada titik lokasi. Klik "Tambah Titik Lokasi" untuk menandai fasilitas desa di peta.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
