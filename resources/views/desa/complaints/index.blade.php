<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            {{ __('Pengaduan Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-obsidian-button/30 border-b border-slate-border/20 text-xs uppercase tracking-wider text-ash-text">
                                <th class="p-4 font-medium">Tanggal</th>
                                <th class="p-4 font-medium">Pelapor</th>
                                <th class="p-4 font-medium">Kategori</th>
                                <th class="p-4 font-medium">Status</th>
                                <th class="p-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @forelse($complaints as $complaint)
                                <tr class="hover:bg-slate-border/5 transition">
                                    <td class="p-4 text-sm text-ash-text">
                                        {{ $complaint->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="p-4">
                                        <p class="text-sm font-semibold text-ivory-text">{{ $complaint->name }}</p>
                                        <p class="text-xs text-ash-text">{{ Str::limit($complaint->content, 40) }}</p>
                                    </td>
                                    <td class="p-4 text-sm text-ivory-text">
                                        {{ $complaint->category }}
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                                'processing' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'resolved' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'rejected' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'processing' => 'Diproses',
                                                'resolved' => 'Selesai',
                                                'rejected' => 'Ditolak',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $statusColors[$complaint->status] }}">
                                            {{ $statusLabels[$complaint->status] }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <a href="{{ route('desa.complaints.show', $complaint) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-obsidian-button hover:bg-slate-border/20 text-ivory-text rounded-md transition border border-slate-border/30">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-ash-text">
                                        Belum ada pengaduan dari warga.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($complaints->hasPages())
                    <div class="px-6 py-4 border-t border-slate-border/20">
                        {{ $complaints->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
