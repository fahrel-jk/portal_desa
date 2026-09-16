<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Produk UMKM
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
                    <h3 class="text-lg font-semibold text-ivory-text">Daftar Produk UMKM</h3>
                    <a href="{{ route('desa.products.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                        + Tambah Produk
                    </a>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="group relative rounded-xl overflow-hidden bg-obsidian-button/30 border border-slate-border/15 flex flex-col">
                                {{-- Product Image --}}
                                <div class="aspect-[4/3] overflow-hidden bg-obsidian-button/30">
                                    @if($product->image_path)
                                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-ash-text">
                                            <svg class="w-12 h-12 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Product Info --}}
                                <div class="p-4 flex-grow flex flex-col">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <h4 class="font-semibold text-ivory-text text-sm leading-tight">{{ $product->name }}</h4>
                                        @if(!$product->is_active)
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-400 font-bold uppercase shrink-0">Nonaktif</span>
                                        @endif
                                    </div>
                                    @if($product->category)
                                        <p class="text-xs text-ash-text mb-2">{{ $product->category }}</p>
                                    @endif
                                    @if($product->price)
                                        <p class="text-cobalt font-bold text-sm mt-auto">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    @endif

                                    {{-- Actions --}}
                                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-border/15">
                                        <a href="{{ route('desa.products.edit', $product) }}" class="flex-1 text-center text-xs bg-cobalt/10 text-cobalt hover:bg-cobalt/20 px-3 py-1.5 rounded transition font-medium">
                                            Edit
                                        </a>
                                        <form action="{{ route('desa.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')" class="flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-xs bg-red-600/10 text-red-400 hover:bg-red-600/20 px-3 py-1.5 rounded transition font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center text-ash-text">
                        <svg class="w-12 h-12 mx-auto mb-4 text-ash-text/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Belum ada produk UMKM. Klik "Tambah Produk" untuk memulai.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
