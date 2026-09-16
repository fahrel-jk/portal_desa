<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            {{ __('Permohonan Informasi PPID') }}
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
                                <th class="p-4 font-medium">Pemohon</th>
                                <th class="p-4 font-medium">Instansi</th>
                                <th class="p-4 font-medium">Status</th>
                                <th class="p-4 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @forelse($requests as $infoRequest)
                                <tr class="hover:bg-slate-border/5 transition">
                                    <td class="p-4 text-sm text-ash-text">
                                        {{ $infoRequest->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="p-4">
                                        <p class="text-sm font-semibold text-ivory-text">{{ $infoRequest->name }}</p>
                                        <p class="text-xs text-ash-text">HP: {{ $infoRequest->phone }}</p>
                                    </td>
                                    <td class="p-4 text-sm text-ivory-text">
                                        {{ $infoRequest->agency }}
                                    </td>
                                    <td class="p-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20',
                                                'processed' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'completed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'rejected' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Menunggu',
                                                'processed' => 'Diproses',
                                                'completed' => 'Selesai',
                                                'rejected' => 'Ditolak',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $statusColors[$infoRequest->status] ?? 'bg-slate-500/10 text-slate-400' }}">
                                            {{ $statusLabels[$infoRequest->status] ?? $infoRequest->status }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <button type="button" x-data x-on:click="$dispatch('open-modal', 'view-request-{{ $infoRequest->id }}')" class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-obsidian-button hover:bg-slate-border/20 text-ivory-text rounded-md transition border border-slate-border/30">
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-ash-text">
                                        Belum ada permohonan informasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-slate-border/20">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>

            {{-- Modals for Viewing Requests --}}
            @foreach($requests as $infoRequest)
                <x-modal name="view-request-{{ $infoRequest->id }}" maxWidth="lg">
                    <div class="p-6 bg-graphite-card text-ivory-text">
                        <div class="flex items-center justify-between border-b border-slate-border/20 pb-4 mb-4">
                            <h2 class="text-xl font-bold">Detail Permohonan</h2>
                            <button x-on:click="$dispatch('close')" class="text-ash-text hover:text-ivory-text transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="space-y-4 text-sm">
                            <div>
                                <h3 class="text-ash-text text-xs uppercase tracking-wider mb-1">Informasi Pemohon</h3>
                                <p class="font-semibold">{{ $infoRequest->name }}</p>
                                <p class="text-ash-text">{{ $infoRequest->agency }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-ash-text text-xs uppercase tracking-wider mb-1">Email</h3>
                                    <p>{{ $infoRequest->email }}</p>
                                </div>
                                <div>
                                    <h3 class="text-ash-text text-xs uppercase tracking-wider mb-1">WhatsApp</h3>
                                    <p>{{ $infoRequest->phone }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-ash-text text-xs uppercase tracking-wider mb-1">Tanggal Pengajuan</h3>
                                <p>{{ $infoRequest->created_at->format('d M Y H:i') }}</p>
                            </div>

                            <div>
                                <h3 class="text-ash-text text-xs uppercase tracking-wider mb-2">Isi Permohonan</h3>
                                <div class="bg-obsidian-button/50 p-4 rounded-xl border border-slate-border/20">
                                    {{ $infoRequest->content }}
                                </div>
                            </div>

                            <form x-data="{ selectedStatus: '{{ $infoRequest->status }}' }" action="{{ route('desa.information-requests.update', $infoRequest) }}" method="POST" enctype="multipart/form-data" x-on:click.stop class="pt-4 border-t border-slate-border/20 mt-6">
                                @csrf
                                @method('PATCH')
                                <h3 class="text-ash-text text-xs uppercase tracking-wider mb-3">Update Status</h3>
                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    @php
                                        $statuses = [
                                            'pending' => 'Menunggu',
                                            'processed' => 'Diproses',
                                            'completed' => 'Selesai',
                                            'rejected' => 'Ditolak',
                                        ];
                                    @endphp
                                    @foreach($statuses as $value => $label)
                                        <label x-on:click.stop class="flex items-center p-2 border border-slate-border/20 rounded-lg cursor-pointer hover:bg-slate-border/10 transition"
                                               x-bind:class="selectedStatus === '{{ $value }}' ? 'bg-emerald-500/10 border-emerald-500/30' : ''">
                                            <input type="radio" name="status" value="{{ $value }}" x-model="selectedStatus" class="text-emerald-500 focus:ring-emerald-500 bg-obsidian-button border-slate-border/30" x-on:click.stop>
                                            <span class="ml-2 text-xs font-medium"
                                                  x-bind:class="selectedStatus === '{{ $value }}' ? 'text-ivory-text' : 'text-ash-text'">
                                                {{ $label }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="mb-4">
                                    <label class="text-ash-text text-xs uppercase tracking-wider mb-1 block">Pesan Balasan Admin (Opsional)</label>
                                    <textarea name="admin_reply" rows="3" class="w-full bg-obsidian-button border-slate-border/30 rounded-lg text-sm text-ivory-text focus:ring-emerald-500 focus:border-emerald-500 p-2">{{ $infoRequest->admin_reply }}</textarea>
                                </div>

                                <div class="mb-6">
                                    <label class="text-ash-text text-xs uppercase tracking-wider mb-1 block">File Balasan/Dokumen (Opsional)</label>
                                    @if($infoRequest->admin_reply_file_path)
                                        <div class="mb-2 text-xs text-emerald-400">
                                            File sudah diunggah. Unggah file baru untuk mengganti.
                                        </div>
                                    @endif
                                    <input type="file" name="admin_reply_file" class="w-full text-sm text-ash-text file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-border/20 file:text-ivory-text hover:file:bg-slate-border/30 focus:outline-none" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                                </div>

                                <button type="submit" class="w-full px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-lg shadow-emerald-500/20">
                                    Simpan Status & Balasan
                                </button>
                            </form>
                        </div>
                    </div>
                </x-modal>
            @endforeach

        </div>
    </div>
</x-app-layout>
