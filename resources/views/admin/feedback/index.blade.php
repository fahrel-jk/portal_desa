<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-ivory-text leading-tight">
            Masukan & Pesan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-sm text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-border/15 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-ivory-text">Daftar Masukan dari Publik</h3>
                    <div class="text-sm text-ash-text">
                        Total: {{ $feedbacks->total() }} pesan
                    </div>
                </div>
                
                @if($feedbacks->isEmpty())
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-obsidian-button rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-ash-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="text-lg font-medium text-ivory-text mb-1">Belum ada pesan</h4>
                        <p class="text-ash-text">Kotak masuk masih kosong.</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-border/10">
                        @foreach($feedbacks as $message)
                            <div class="p-6 {{ $message->is_read ? 'opacity-70' : 'bg-obsidian-button/20' }} hover:bg-obsidian-button/40 transition">
                                <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-base font-bold text-ivory-text">{{ $message->name }}</h4>
                                            @if(!$message->is_read)
                                                <span class="bg-cobalt/20 text-cobalt text-xs px-2 py-0.5 rounded-full font-medium">Baru</span>
                                            @endif
                                            <span class="text-xs text-ash-text">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-ash-text mb-4">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                                <a href="mailto:{{ $message->email }}" class="hover:text-cobalt transition">{{ $message->email }}</a>
                                            </div>
                                            @if($message->phone)
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                    {{ $message->phone }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="bg-obsidian-button/50 rounded-xl p-4 text-sm text-ivory-text/90 leading-relaxed border border-slate-border/10">
                                            {{ $message->message }}
                                        </div>
                                    </div>
                                    
                                    <div class="shrink-0 flex items-center gap-2">
                                        @if(!$message->is_read)
                                            <form action="{{ route('admin.feedback.read', $message) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 bg-cobalt/10 hover:bg-cobalt/20 text-cobalt rounded-lg text-xs font-medium transition">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @else
                                            <span class="px-3 py-1.5 text-ash-text rounded-lg text-xs font-medium flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Sudah Dibaca
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="p-6 border-t border-slate-border/15">
                        {{ $feedbacks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
