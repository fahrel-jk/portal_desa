<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumen PPID') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('desa.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul / Nama Dokumen</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $document->title) }}" required>
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="Peraturan Desa" {{ old('category', $document->category) == 'Peraturan Desa' ? 'selected' : '' }}>Peraturan Desa</option>
                                <option value="Keputusan Kepala Desa" {{ old('category', $document->category) == 'Keputusan Kepala Desa' ? 'selected' : '' }}>Keputusan Kepala Desa</option>
                                <option value="Laporan Keuangan" {{ old('category', $document->category) == 'Laporan Keuangan' ? 'selected' : '' }}>Laporan Keuangan</option>
                                <option value="Formulir Warga" {{ old('category', $document->category) == 'Formulir Warga' ? 'selected' : '' }}>Formulir Warga</option>
                                <option value="Dokumen Perencanaan" {{ old('category', $document->category) == 'Dokumen Perencanaan' ? 'selected' : '' }}>Dokumen Perencanaan (RPJMDes/RKPDes)</option>
                                <option value="Lainnya" {{ old('category', $document->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700">Ganti File Dokumen (PDF, Opsional)</label>
                            <div class="mt-1 flex items-center text-sm text-gray-500 mb-2">
                                File saat ini: <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 hover:underline ml-1">Lihat Dokumen</a>
                            </div>
                            <input type="file" name="file" id="file" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti file.</p>
                            @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Keterangan Singkat (Opsional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $document->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="is_active" value="1" {{ old('is_active', $document->is_active) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Publikasikan dokumen ini sekarang</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('desa.documents.index') }}" class="mr-4 text-gray-600 hover:underline">Batal</a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
