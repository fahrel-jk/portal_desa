<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Edit Agenda
            </h2>
            <a href="{{ route('desa.agenda.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Daftar Agenda</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card border border-slate-border/15 rounded-2xl p-5 sm:p-8">
                <form action="{{ route('desa.agenda.update', $agenda) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    {{-- Judul --}}
                    <div class="mb-5">
                        <label for="title" class="block text-sm font-medium text-ivory-text mb-1">Judul Agenda <span class="text-red-400">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $agenda->title) }}" required
                            class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                        @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                        <div>
                            <label for="event_date" class="block text-sm font-medium text-ivory-text mb-1">Tanggal <span class="text-red-400">*</span></label>
                            <input type="date" name="event_date" id="event_date" value="{{ old('event_date', $agenda->event_date->format('Y-m-d')) }}" required
                                class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                            @error('event_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-ivory-text mb-1">Jam Mulai</label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $agenda->start_time ? substr($agenda->start_time, 0, 5) : '') }}"
                                class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                            @error('start_time') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-ivory-text mb-1">Jam Selesai</label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $agenda->end_time ? substr($agenda->end_time, 0, 5) : '') }}"
                                class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                            @error('end_time') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Kategori & Lokasi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label for="category" class="block text-sm font-medium text-ivory-text mb-1">Kategori <span class="text-red-400">*</span></label>
                            <select name="category" id="category" required
                                class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                                @foreach(\App\Models\VillageAgenda::CATEGORY_OPTIONS as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $agenda->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-ivory-text mb-1">Lokasi</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $agenda->location) }}"
                                class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">
                            @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label for="description" class="block text-sm font-medium text-ivory-text mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full rounded-lg border-slate-border bg-obsidian-button text-ivory-text text-sm px-4 py-2.5 focus:border-cobalt focus:ring-cobalt">{{ old('description', $agenda->description) }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    {{-- Penting --}}
                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="hidden" name="is_important" value="0">
                            <input type="checkbox" name="is_important" value="1" {{ old('is_important', $agenda->is_important) ? 'checked' : '' }}
                                class="rounded border-slate-border bg-obsidian-button text-cobalt focus:ring-cobalt">
                            <span class="text-sm text-ivory-text">Tandai sebagai agenda penting</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-cobalt text-white text-sm font-semibold rounded-md hover:bg-cobalt-hover transition">
                            Perbarui Agenda
                        </button>
                        <a href="{{ route('desa.agenda.index') }}" class="text-sm text-ash-text hover:text-ivory-text transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
