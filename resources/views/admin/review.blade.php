<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Review Desa: {{ $village->name }}
            </h2>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.preview', $village) }}" target="_blank" class="text-sm font-semibold text-cobalt hover:underline bg-cobalt/10 px-3 py-1.5 rounded-lg border border-cobalt/20 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    Preview
                </a>
                <a href="{{ route('admin.dashboard') }}" class="text-sm text-ash-text hover:underline">← Kembali</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Village Info --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-ivory-text">{{ $village->name }}</h3>
                                <p class="text-sm text-ash-text">{{ $village->kecamatan }}, {{ $village->kabupaten }}</p>
                            </div>
                            <x-portal.status-badge :status="$village->status" />
                        </div>

                        <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                            <div>
                                <dt class="text-ash-text">Slug URL</dt>
                                <dd class="font-mono text-cobalt">/desa/{{ $village->slug }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Template</dt>
                                <dd class="font-medium">{{ $village->template->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Alamat</dt>
                                <dd>{{ $village->address ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Diajukan</dt>
                                <dd>{{ $village->submitted_at?->format('d M Y, H:i') ?? '-' }}</dd>
                            </div>
                        </dl>

                        @if($village->description)
                            <div class="mt-4 pt-4 border-t border-slate-border/10">
                                <h4 class="text-sm font-medium text-ash-text mb-2">Deskripsi</h4>
                                <p class="text-sm text-ivory-text">{{ $village->description }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Kontak --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <h4 class="font-semibold text-ivory-text mb-3">Kontak</h4>
                        <dl class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <dt class="text-ash-text">Telepon</dt>
                                <dd>{{ $village->contact_phone ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Email</dt>
                                <dd>{{ $village->contact_email ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Jam Layanan</dt>
                                <dd>{{ $village->office_hours ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-ash-text">Perwakilan</dt>
                                <dd>{{ $village->user?->name ?? '-' }} ({{ $village->user?->email ?? '-' }})</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Perangkat Desa --}}
                    @if($village->officials->count() > 0)
                        <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                            <h4 class="font-semibold text-ivory-text mb-3">Perangkat Desa ({{ $village->officials->count() }} orang)</h4>
                            <div class="space-y-2">
                                @foreach($village->officials as $official)
                                    <div class="flex items-center gap-3 p-3 bg-obsidian-button/30 rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-cobalt/10 flex items-center justify-center text-cobalt font-semibold text-sm">
                                            {{ strtoupper(substr($official->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-ivory-text text-sm">{{ $official->name }}</div>
                                            <div class="text-xs text-ash-text">{{ $official->position }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar Actions --}}
                <div class="space-y-6">
                    {{-- Action Buttons --}}
                    @if($village->status === 'pending_review')
                        <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                            <h4 class="font-semibold text-ivory-text mb-4">Keputusan</h4>

                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.approve', $village) }}" class="mb-4">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition"
                                    onclick="return confirm('Yakin ingin menyetujui desa ini? Halaman desa akan langsung tayang untuk publik.')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui & Tayangkan
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form method="POST" action="{{ route('admin.reject', $village) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="rejection_reason" class="block text-sm font-medium text-ivory-text mb-1">
                                        Alasan Penolakan
                                    </label>
                                    <textarea id="rejection_reason" name="rejection_reason" rows="3"
                                        class="w-full bg-obsidian-button border-slate-border text-ivory-text focus:border-red-500 focus:ring-red-500 rounded-lg shadow-sm text-sm placeholder:text-ash-text"
                                        placeholder="Jelaskan apa yang perlu diperbaiki...">{{ old('rejection_reason') }}</textarea>
                                    <x-input-error :messages="$errors->get('rejection_reason')" class="mt-1" />
                                </div>
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
                                    onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Pendaftaran
                                </button>
                            </form>
                        </div>
                    @endif

                    {{-- Status Info --}}
                    <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-6">
                        <h4 class="font-semibold text-ivory-text mb-3">Status</h4>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-ash-text">Status saat ini:</span>
                                <div class="mt-1"><x-portal.status-badge :status="$village->status" /></div>
                            </div>
                            @if($village->approved_at)
                                <div>
                                    <span class="text-ash-text">Disetujui pada:</span>
                                    <div class="font-medium">{{ $village->approved_at->format('d M Y, H:i') }}</div>
                                </div>
                            @endif
                            @if($village->rejection_reason)
                                <div>
                                    <span class="text-ash-text">Alasan penolakan:</span>
                                    <div class="mt-1 text-red-700 bg-red-500/10 rounded-lg p-2 border border-red-500/20">{{ $village->rejection_reason }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Preview Link --}}
                    @if($village->status === 'published')
                        <a href="{{ url('/desa/' . $village->slug) }}"
                            class="block w-full text-center px-4 py-3 bg-cobalt text-white font-semibold rounded-lg hover:bg-cobalt-hover transition" target="_blank">
                            Lihat Halaman Publik →
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
