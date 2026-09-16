<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('desa.faqs.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                            <input type="text" name="question" id="question" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('question') }}" required placeholder="Contoh: Apa saja syarat membuat KTP baru?">
                            @error('question') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                            <textarea name="answer" id="answer" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Tuliskan jawaban yang jelas dan lengkap...">{{ old('answer') }}</textarea>
                            @error('answer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Urutan (Opsional)</label>
                            <input type="number" name="order" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('order', 0) }}">
                            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil akan ditampilkan lebih atas.</p>
                            @error('order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Aktifkan FAQ ini sekarang</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('desa.faqs.index') }}" class="mr-4 text-gray-600 hover:underline">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Simpan FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
