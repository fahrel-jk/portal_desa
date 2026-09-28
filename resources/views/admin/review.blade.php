<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <p class="text-xs text-ash-text font-medium uppercase tracking-widest mb-1">Review Pendaftaran</p>
                <h2 class="font-bold text-xl text-ivory-text leading-tight">{{ $village->name }}</h2>
                <p class="text-xs text-ash-text mt-0.5">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.preview', $village) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-cobalt bg-cobalt/10 hover:bg-cobalt/20 px-3 py-1.5 rounded-lg border border-cobalt/20 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    Preview Halaman
                </a>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-ash-text hover:text-ivory-text transition">← Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- Village Info --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <div class="flex items-start justify-between mb-5">
                            <div>
                                <h3 class="text-lg font-bold text-ivory-text">{{ $village->name }}</h3>
                                <p class="text-sm text-ash-text mt-0.5">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                            </div>
                            <x-portal.status-badge :status="$village->status" />
                        </div>

                        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-ash-text uppercase tracking-wider">Slug URL</div>
                                <div class="font-mono text-cobalt text-sm">/desa/{{ $village->slug }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-ash-text uppercase tracking-wider">Template</div>
                                <div class="font-medium text-ivory-text">{{ $village->template->name }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-ash-text uppercase tracking-wider">Alamat</div>
                                <div class="text-ivory-text">{{ $village->address ?? '-' }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs font-semibold text-ash-text uppercase tracking-wider">Diajukan</div>
                                <div class="text-ivory-text">{{ $village->submitted_at?->format('d M Y, H:i') ?? '-' }}</div>
                            </div>
                        </div>

                        @if($village->description)
                            <div class="mt-5 pt-5 border-t border-slate-border/10">
                                <div class="text-xs font-semibold text-ash-text uppercase tracking-wider mb-2">Deskripsi</div>
                                <p class="text-sm text-ivory-text leading-relaxed">{{ $village->description }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Kontak --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <h4 class="text-xs font-semibold text-ash-text uppercase tracking-wider mb-4">Informasi Kontak</h4>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div class="space-y-1">
                                <div class="text-xs text-ash-text">Telepon</div>
                                <div class="font-medium text-ivory-text">{{ $village->contact_phone ?? '-' }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs text-ash-text">Email</div>
                                <div class="font-medium text-ivory-text">{{ $village->contact_email ?? '-' }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs text-ash-text">Jam Layanan</div>
                                <div class="font-medium text-ivory-text">{{ $village->office_hours ?? '-' }}</div>
                            </div>
                            <div class="space-y-1">
                                <div class="text-xs text-ash-text">Perwakilan</div>
                                <div class="font-medium text-ivory-text">{{ $village->user?->name ?? '-' }}</div>
                                <div class="text-xs text-ash-text">{{ $village->user?->email ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                            <h4 class="text-xs font-semibold text-ash-text uppercase tracking-wider mb-4">
                                Perangkat Desa
                                <span class="ml-2 text-[10px] font-bold bg-cobalt/10 text-cobalt px-1.5 py-0.5 rounded-full">{{ $village->officials->count() }}</span>
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($village->officials as $official)
                                    <div class="flex items-center gap-3 p-3 bg-obsidian-button/30 rounded-xl border border-slate-border/10">
                                        <div class="w-9 h-9 rounded-full bg-cobalt/15 flex items-center justify-center text-cobalt font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($official->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-ivory-text text-sm truncate">{{ $official->name }}</div>
                                            <div class="text-xs text-ash-text truncate">{{ $official->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar Actions --}}
                <div class="space-y-5">

                    {{-- Action Buttons --}}
                    @if($village->status === 'pending_review')
                        <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                            <h4 class="text-xs font-semibold text-ash-text uppercase tracking-wider mb-5">Keputusan Review</h4>

                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.approve', $village) }}" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600/80 hover:bg-green-600 text-white font-semibold rounded-xl border border-green-500/30 hover:border-green-500/60 transition-all duration-200 shadow-lg shadow-green-900/20"
                                    onclick="return confirm('Yakin ingin menyetujui desa ini? Halaman desa akan langsung tayang untuk publik.')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui &amp; Tayangkan
                                </button>
                            </form>

                            <div class="relative my-4">
                                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-border/15"></div></div>
                                <div class="relative flex justify-center"><span class="bg-graphite-card px-3 text-xs text-ash-text">atau</span></div>
                            </div>

                            {{-- Reject --}}
                            <form method="POST" action="{{ route('admin.reject', $village) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="rejection_reason" class="block text-xs font-semibold text-ash-text mb-2">
                                        Alasan Penolakan
                                    </label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="3"
                                        class="w-full bg-obsidian-button border border-slate-border/30 focus:border-red-500/60 focus:ring-1 focus:ring-red-500/30 text-ivory-text rounded-xl shadow-sm text-sm placeholder:text-ash-text/50 p-3 transition"
                                        placeholder="Jelaskan apa yang perlu diperbaiki...">{{ old('rejection_reason') }}</textarea>
                                    <x-input-error :messages="$errors->get('rejection_reason')" class="mt-1" />
                                </div>
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 font-semibold rounded-xl border border-red-500/20 hover:border-red-500/40 transition-all duration-200 text-sm"
                                    onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Pendaftaran
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Status Info --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <h4 class="text-xs font-semibold text-ash-text uppercase tracking-wider mb-4">Informasi Status</h4>
                        <div class="space-y-4 text-sm">
                            <div>
                                <div class="text-xs text-ash-text mb-1.5">Status saat ini</div>
                                <x-portal.status-badge :status="$village->status" />
                            </div>
                            @if($village->approved_at)
                                <div>
                                    <div class="text-xs text-ash-text mb-1">Disetujui pada</div>
                                    <div class="font-medium text-ivory-text">{{ $village->approved_at->format('d M Y, H:i') }}</div>
                                </div>
                            @endif
                            @if($village->rejection_reason)
                                <div>
                                    <div class="text-xs text-ash-text mb-1.5">Alasan penolakan</div>
                                    <div class="text-sm text-red-300 bg-red-500/10 rounded-xl p-3 border border-red-500/20 leading-relaxed">{{ $village->rejection_reason }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Live Link --}}
                    @if($village->status === 'published')
                        <a href="{{ url('/desa/' . $village->slug) }}" target="_blank"
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-cobalt hover:bg-cobalt-hover text-white font-semibold rounded-xl transition shadow-lg shadow-cobalt/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Lihat Halaman Publik
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
