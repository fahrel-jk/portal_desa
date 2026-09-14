<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Kelola Operator Desa
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-ash-text hover:text-ivory-text transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/10 border border-green-500/20 rounded-xl p-4 flex items-start gap-3">
                    <p class="text-sm text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex items-start gap-3">
                    <p class="text-sm text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-ivory-text">Daftar Operator ({{ $village->name }})</h3>
                    <p class="text-sm text-ash-text">Kelola siapa saja yang bisa mengedit website desa ini.</p>
                </div>
                <a href="{{ route('desa.operators.create') }}" class="inline-flex items-center px-4 py-2 bg-cobalt text-white rounded-lg hover:bg-cobalt-hover transition font-medium text-sm shadow-lg shadow-cobalt/20">
                    + Tambah Operator
                </a>
            </div>

            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-border/10">
                        <thead class="bg-obsidian-button/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-ash-text uppercase tracking-wider">Terdaftar Sejak</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-ash-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-border/10">
                            @foreach($operators as $operator)
                                <tr class="hover:bg-obsidian-button/30 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-border/30 flex items-center justify-center text-ivory-text font-bold text-xs uppercase">
                                                {{ substr($operator->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-ivory-text">{{ $operator->name }}</div>
                                                @if(auth()->id() === $operator->id)
                                                    <span class="text-[10px] bg-cobalt/20 text-cobalt px-2 py-0.5 rounded-full mt-1 inline-block">Anda (Saat Ini)</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                        {{ $operator->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-ash-text">
                                        {{ $operator->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if(auth()->id() !== $operator->id)
                                            <form action="{{ route('desa.operators.destroy', $operator) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akses operator ini? (Akun akan dihapus)')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-400 transition" title="Hapus Operator">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
