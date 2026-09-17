@extends('village.templates.modern.layout', ['title' => 'Lapor Desa - Pengaduan & Aspirasi'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">
    <div class="page-header" style="margin-bottom: 2.5rem; text-align: left; padding: 2rem; background: transparent; border-radius: 0;">
        <div class="eyebrow" style="margin-bottom: 0.75rem;">Layanan Aspirasi</div>
        <h1 style="font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; margin-bottom: 1rem; color: var(--fg);">Suara Anda Membangun Desa</h1>
        <p style="color: var(--muted-fg); font-size: 1.125rem;">Sampaikan pengaduan, kritik, saran, atau permohonan informasi kepada perangkat desa secara langsung dan transparan.</p>
    </div>

    @if(session('success'))
        <div style="background-color: color-mix(in srgb, var(--primary) 15%, transparent); border-left: 4px solid var(--primary); padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2.5rem;">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <svg class="w-6 h-6 shrink-0" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h3 style="font-weight: 700; color: var(--fg); margin-bottom: 0.25rem;">Berhasil!</h3>
                    <p style="color: var(--muted-fg); font-size: 0.9375rem;">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="card" style="padding: 2.5rem; margin-bottom: 4rem;">
        <form action="{{ route('village.complaint.store', $village->slug) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-2">
                <div>
                    <label for="name" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'">
                    @error('name') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="contact" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Nomor HP / WhatsApp <span style="font-weight: 400; color: var(--muted-fg);">(Opsional)</span></label>
                    <input type="text" name="contact" id="contact" value="{{ old('contact') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'">
                    @error('contact') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="category" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Kategori Laporan <span style="color: #ef4444;">*</span></label>
                <select name="category" id="category" required 
                        style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem top 50%; background-size: 0.65rem auto;"
                        onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                        onblur="this.style.borderColor='var(--border)'">
                    <option value="">Pilih kategori...</option>
                    <option value="pengaduan" {{ old('category') == 'pengaduan' ? 'selected' : '' }}>Pengaduan Layanan / Fasilitas</option>
                    <option value="aspirasi" {{ old('category') == 'aspirasi' ? 'selected' : '' }}>Aspirasi / Saran / Ide</option>
                    <option value="informasi" {{ old('category') == 'informasi' ? 'selected' : '' }}>Permintaan Informasi</option>
                </select>
                @error('category') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="content" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Isi Laporan <span style="color: #ef4444;">*</span></label>
                <textarea name="content" id="content" rows="6" required placeholder="Jelaskan laporan atau aspirasi Anda secara detail..."
                          style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s; resize: vertical;"
                          onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                          onblur="this.style.borderColor='var(--border)'">{{ old('content') }}</textarea>
                @error('content') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="image" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Lampiran Foto <span style="font-weight: 400; color: var(--muted-fg);">(Opsional, Max 4MB)</span></label>
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg"
                       style="display: block; width: 100%; font-size: 0.875rem; color: var(--muted-fg);
                       file:mr-4 file:py-2.5 file:px-4
                       file:rounded-lg file:border-0
                       file:font-semibold
                       file:bg-[var(--primary)] file:text-[var(--primary-fg)]
                       hover:file:brightness-110 cursor-pointer">
                @error('image') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" class="btn-primary" style="width: 100%;">
                    Kirim Laporan
                </button>
                <p style="text-align: center; font-size: 0.75rem; color: var(--muted-fg); margin-top: 1rem;">
                    Identitas Anda akan dirahasiakan dan hanya dapat dilihat oleh admin perangkat desa.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
