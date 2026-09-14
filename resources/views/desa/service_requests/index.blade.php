<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Pengajuan Layanan Warga
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-status-approved-bg/20 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-border/10">
                        <thead class="bg-obsidian-button/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Catatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @forelse($requests as $req)
                                <tr class="hover:bg-obsidian-button/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-ivory-text">{{ $req->user->name }}</div>
                                        <div class="text-xs text-ash-text">{{ $req->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ivory-text font-medium">
                                        {{ $req->service->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-ash-text">
                                        {{ Str::limit($req->notes, 30) ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                        {{ $req->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($req->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Pending</span>
                                        @elseif($req->status === 'processed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-500 border border-blue-500/20">Diproses</span>
                                        @elseif($req->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">Selesai</span>
                                        @elseif($req->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        {{-- Trigger Modal --}}
                                        <button onclick="document.getElementById('modal-{{ $req->id }}').classList.remove('hidden')" class="text-cobalt hover:text-cobalt-hover font-medium">
                                            Proses &rarr;
                                        </button>
                                    </td>
                                </tr>

                                {{-- Modal Proses --}}
                                <div id="modal-{{ $req->id }}" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
                                    <div class="bg-graphite-card border border-slate-border/20 rounded-2xl p-6 w-full max-w-lg shadow-2xl">
                                        <div class="flex justify-between items-start mb-4">
                                            <h3 class="text-xl font-bold text-ivory-text">Proses Pengajuan: {{ $req->service->name }}</h3>
                                            <button onclick="document.getElementById('modal-{{ $req->id }}').classList.add('hidden')" class="text-ash-text hover:text-ivory-text">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        
                                        <div class="mb-4 bg-obsidian-button/50 p-4 rounded-xl border border-slate-border/10">
                                            <p class="text-sm text-ash-text mb-1">Pemohon:</p>
                                            <p class="font-medium text-ivory-text mb-3">{{ $req->user->name }} ({{ $req->user->email }})</p>
                                            
                                            <p class="text-sm text-ash-text mb-1">Catatan Warga:</p>
                                            <p class="text-sm text-ivory-text mb-3">{{ $req->notes ?: 'Tidak ada catatan.' }}</p>
                                            
                                            @if($req->attachment_path)
                                                <p class="text-sm text-ash-text mb-1">Dokumen Lampiran:</p>
                                                <a href="{{ Storage::url($req->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-cobalt hover:underline">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Lihat Dokumen
                                                </a>
                                            @else
                                                <p class="text-sm text-ash-text mb-1">Dokumen Lampiran:</p>
                                                <p class="text-sm text-ivory-text">Tidak ada lampiran.</p>
                                            @endif
                                        </div>

                                        <form method="POST" action="{{ route('desa.service-requests.update-status', $req->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div class="mb-4">
                                                <x-input-label for="status-{{ $req->id }}" value="Ubah Status" />
                                                <select id="status-{{ $req->id }}" name="status" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm text-sm" required>
                                                    <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="processed" {{ $req->status === 'processed' ? 'selected' : '' }}>Diproses (Sedang dikerjakan)</option>
                                                    <option value="completed" {{ $req->status === 'completed' ? 'selected' : '' }}>Selesai (Siap diambil/dikirim)</option>
                                                    <option value="rejected" {{ $req->status === 'rejected' ? 'selected' : '' }}>Ditolak (Berkas tidak lengkap dll)</option>
                                                </select>
                                            </div>

                                            <div class="mb-6">
                                                <x-input-label for="response_message-{{ $req->id }}" value="Pesan / Balasan untuk Warga (Opsional)" />
                                                <textarea id="response_message-{{ $req->id }}" name="response_message" rows="2" class="mt-1 block w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm text-sm" placeholder="Misal: Surat sudah jadi dan bisa diambil di kantor desa.">{{ $req->response_message }}</textarea>
                                            </div>

                                            <div class="flex justify-end gap-3">
                                                <button type="button" onclick="document.getElementById('modal-{{ $req->id }}').classList.add('hidden')" class="px-4 py-2 text-sm font-medium text-ash-text hover:text-ivory-text transition">Batal</button>
                                                <x-primary-button>Simpan Perubahan</x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-ash-text">
                                        Belum ada pengajuan layanan dari warga.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-slate-border/15">
                        {{ $requests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
