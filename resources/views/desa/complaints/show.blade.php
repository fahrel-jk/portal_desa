<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('desa.complaints.index') }}" class="text-ash-text hover:text-ivory-text transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </a>
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                {{ __('Detail Pengaduan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Detail Laporan --}}
                <div class="md:col-span-2 space-y-6">
                    <div class="bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <p class="text-sm font-semibold text-cobalt mb-1">{{ $complaint->category }}</p>
                                <h3 class="text-xl font-bold text-ivory-text">{{ $complaint->name }}</h3>
                                <p class="text-sm text-ash-text mt-1">{{ $complaint->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($complaint->contact)
                            <div class="mb-6 bg-obsidian-button/30 rounded-xl p-4 border border-slate-border/20 inline-flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="text-ash-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span class="text-sm font-medium text-ivory-text">{{ $complaint->contact }}</span>
                            </div>
                        @endif

                        <div class="prose prose-invert max-w-none">
                            <p class="text-ash-text leading-relaxed whitespace-pre-line">{{ $complaint->content }}</p>
                        </div>
                        
                        @if($complaint->image_path)
                            <div class="mt-8 pt-6 border-t border-slate-border/20">
                                <p class="text-sm font-medium text-ivory-text mb-4">Lampiran Foto</p>
                                <img src="{{ Storage::url($complaint->image_path) }}" alt="Lampiran Pengaduan" class="rounded-xl border border-slate-border/20 max-h-96 object-cover">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Status Update --}}
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-graphite-card shadow-lg sm:rounded-2xl border border-slate-border/20 p-6">
                        <h3 class="text-lg font-bold text-ivory-text mb-4">Update Status</h3>
                        
                        <form action="{{ route('desa.complaints.update_status', $complaint) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-4">
                                @php
                                    $statuses = [
                                        'pending' => 'Menunggu',
                                        'processing' => 'Diproses',
                                        'resolved' => 'Selesai',
                                        'rejected' => 'Ditolak',
                                    ];
                                @endphp

                                @foreach($statuses as $value => $label)
                                    <label class="flex items-center p-3 border border-slate-border/20 rounded-xl cursor-pointer hover:bg-slate-border/10 transition {{ $complaint->status === $value ? 'bg-cobalt/10 border-cobalt/50' : '' }}">
                                        <input type="radio" name="status" value="{{ $value }}" class="text-cobalt focus:ring-cobalt bg-obsidian-button border-slate-border/30" {{ $complaint->status === $value ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm font-medium {{ $complaint->status === $value ? 'text-ivory-text' : 'text-ash-text' }}">
                                            {{ $label }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            <button type="submit" class="w-full mt-6 px-4 py-2.5 bg-cobalt hover:bg-cobalt-hover text-pure-white font-semibold rounded-lg transition shadow-lg shadow-cobalt/20">
                                Simpan Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
