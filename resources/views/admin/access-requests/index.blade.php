<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Daftar Request Akses Layanan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex flex-col gap-2">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm text-green-400 font-medium">{{ session('success') }}</p>
                    </div>
                    @if(session('generated_password'))
                        <div class="bg-black/30 p-3 rounded-lg border border-slate-border/20 ml-8 inline-block">
                            <p class="text-xs text-ash-text mb-1">User telah dibuat. Sampaikan informasi login ini ke pemohon:</p>
                            <p class="text-sm text-ivory-text font-mono">Email: {{ session('generated_email') }}</p>
                            <p class="text-sm text-amber-400 font-mono font-bold mt-1">Password: {{ session('generated_password') }}</p>
                            <p class="text-xs text-red-400 mt-1 mt-2 font-medium">⚠️ Simpan password ini! Password tidak akan ditampilkan lagi.</p>
                        </div>
                    @endif
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start gap-3">
                    <p class="text-sm text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Filter Form --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 mb-6">
                <form method="GET" action="{{ route('admin.access-requests.index') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="mt-1 block w-48 bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm text-sm">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="village_id" value="Desa Tujuan" />
                        <select id="village_id" name="village_id" class="mt-1 block w-64 bg-obsidian-button border-slate-border text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-lg shadow-sm text-sm">
                            <option value="">Semua Desa</option>
                            @foreach($villages as $v)
                                <option value="{{ $v->id }}" {{ request('village_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-primary-button type="submit">Filter</x-primary-button>
                        <a href="{{ route('admin.access-requests.index') }}" class="inline-flex items-center px-4 py-2 bg-transparent border border-slate-border/50 rounded-md font-semibold text-xs text-ash-text uppercase tracking-widest hover:bg-white/5 active:bg-white/10 focus:outline-none focus:ring-2 focus:ring-cobalt focus:ring-offset-2 focus:ring-offset-onyx-canvas transition ease-in-out duration-150 ml-2">Reset</a>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-border/10">
                        <thead class="bg-obsidian-button/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Pemohon</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Desa Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Keperluan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @forelse($requests as $req)
                                <tr class="hover:bg-obsidian-button/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-ivory-text">{{ $req->nama_lengkap }}</div>
                                        <div class="text-xs text-ash-text">{{ $req->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                        {{ $req->village->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-ash-text">
                                        {{ Str::limit($req->jabatan_keperluan, 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($req->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-500/10 text-amber-500 border border-amber-500/20">Pending</span>
                                        @elseif($req->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-500 border border-green-500/20">Approved</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/10 text-red-500 border border-red-500/20">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                        {{ $req->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.access-requests.show', $req) }}" class="text-sm font-medium text-cobalt hover:text-cobalt-hover transition">
                                            Detail & Review &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-ash-text">
                                        Tidak ada data pengajuan akses ditemukan.
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
