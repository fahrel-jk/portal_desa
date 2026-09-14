<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <h2 class="font-bold text-xl text-ivory-text leading-tight">
                Tambah Data Anggaran
            </h2>
            <a href="{{ route('desa.anggaran.index') }}" class="text-sm text-cobalt hover:underline">← Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-graphite-card overflow-hidden border border-slate-border/15 rounded-2xl p-8">

                <form method="POST" action="{{ route('desa.anggaran.store') }}" x-data="{
                    kategori: '{{ old('kategori', 'pendapatan') }}'
                }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <x-input-label for="tahun_anggaran" value="Tahun Anggaran" />
                            <x-text-input id="tahun_anggaran" name="tahun_anggaran" type="number"
                                class="mt-1 block w-full" :value="old('tahun_anggaran', date('Y'))"
                                min="2020" max="2030" required />
                            <x-input-error :messages="$errors->get('tahun_anggaran')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kategori" value="Kategori" />
                            <select id="kategori" name="kategori" x-model="kategori"
                                class="mt-1 block w-full rounded-md border-slate-border bg-obsidian-button text-ivory-text shadow-sm focus:border-cobalt focus:ring-cobalt" required>
                                @foreach(\App\Models\Anggaran::KATEGORI_OPTIONS as $key => $label)
                                    <option value="{{ $key }}" {{ old('kategori') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-5" x-show="kategori === 'belanja'" x-transition>
                        <x-input-label for="bidang" value="Bidang" />
                        <select id="bidang" name="bidang"
                            class="mt-1 block w-full rounded-md border-slate-border bg-obsidian-button text-ivory-text shadow-sm focus:border-cobalt focus:ring-cobalt">
                            <option value="">— Pilih Bidang —</option>
                            @foreach(\App\Models\Anggaran::BIDANG_OPTIONS as $bidang)
                                <option value="{{ $bidang }}" {{ old('bidang') === $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('bidang')" class="mt-2" />
                    </div>

                    <div class="mb-5">
                        <x-input-label for="uraian" value="Uraian (Nama Pos Anggaran)" />
                        <x-text-input id="uraian" name="uraian" type="text" class="mt-1 block w-full"
                            :value="old('uraian')" required placeholder="Contoh: Belanja Pegawai, Pajak Bumi & Bangunan" />
                        <x-input-error :messages="$errors->get('uraian')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <x-input-label for="jumlah_anggaran" value="Jumlah Anggaran (Rp)" />
                            <x-text-input id="jumlah_anggaran" name="jumlah_anggaran" type="number"
                                class="mt-1 block w-full" :value="old('jumlah_anggaran')"
                                min="0" step="0.01" required placeholder="0" />
                            <x-input-error :messages="$errors->get('jumlah_anggaran')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="jumlah_realisasi" value="Jumlah Realisasi (Rp)" />
                            <x-text-input id="jumlah_realisasi" name="jumlah_realisasi" type="number"
                                class="mt-1 block w-full" :value="old('jumlah_realisasi', 0)"
                                min="0" step="0.01" placeholder="0" />
                            <x-input-error :messages="$errors->get('jumlah_realisasi')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="keterangan" value="Keterangan (Opsional)" />
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="mt-1 block w-full border-slate-border bg-obsidian-button text-ivory-text focus:border-cobalt focus:ring-cobalt rounded-md shadow-sm"
                            placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>
                            Simpan Data Anggaran
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
