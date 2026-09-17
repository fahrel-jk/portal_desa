@extends('village.templates.modern.layout', ['title' => 'Permohonan Informasi PPID'])

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-top: 2rem;">
    <div class="page-header" style="margin-bottom: 2.5rem; text-align: left; padding: 2rem; background: transparent; border-radius: 0;">
        <div class="eyebrow" style="margin-bottom: 0.75rem;">Formulir Online</div>
        <h1 style="font-size: clamp(2rem, 4vw, 2.75rem); font-weight: 800; margin-bottom: 1rem; color: var(--fg);">Permohonan Informasi Publik</h1>
        <p style="color: var(--muted-fg); font-size: 1.125rem;">Isi formulir di bawah ini untuk mengajukan permohonan informasi publik ke PPID Desa {{ $village->name }}.</p>
    </div>

    @if(session('success'))
        <div style="background-color: color-mix(in srgb, var(--primary) 15%, transparent); border-left: 4px solid var(--primary); padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2.5rem;">
            <div style="display: flex; gap: 1rem; align-items: flex-start;">
                <svg class="w-6 h-6 shrink-0" style="color: var(--primary);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <h3 style="font-weight: 700; color: var(--fg); margin-bottom: 0.25rem;">Permohonan Terkirim!</h3>
                    <p style="color: var(--muted-fg); font-size: 0.9375rem;">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="card" style="padding: 2.5rem; margin-bottom: 4rem;">
        <form action="{{ route('village.ppid.request.store', $village->slug) }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
            @csrf

            <h3 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-bottom: 0.5rem;">Data Pemohon</h3>

            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-2">
                <div>
                    <label for="name" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Nama Lengkap <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'"
                           placeholder="Contoh: Budi Santoso">
                    @error('name') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="agency" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Asal Instansi / Pribadi <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="agency" id="agency" required value="{{ old('agency') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'"
                           placeholder="Contoh: Warga RT 01 / Universitas XYZ">
                    @error('agency') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="md:grid-cols-2">
                <div>
                    <label for="phone" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Nomor WhatsApp <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="phone" id="phone" required value="{{ old('phone') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'"
                           placeholder="Contoh: 081234567890">
                    @error('phone') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Email <span style="font-weight: 400; color: var(--muted-fg);">(Opsional)</span></label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}" 
                           style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                           onblur="this.style.borderColor='var(--border)'"
                           placeholder="Contoh: budi@gmail.com">
                    @error('email') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
                </div>
            </div>

            <h3 style="font-family: Outfit, sans-serif; font-size: 1.125rem; font-weight: 700; color: var(--fg); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-bottom: 0.5rem; margin-top: 1rem;">Rincian Informasi</h3>

            <div>
                <label for="content" style="display: block; font-size: 0.875rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--fg);">Rincian Informasi yang Dibutuhkan <span style="color: #ef4444;">*</span></label>
                <textarea name="content" id="content" rows="5" required
                          style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--border); background-color: var(--bg); color: var(--fg); font-family: inherit; font-size: 1rem; transition: border-color 0.2s; resize: vertical;"
                          onfocus="this.style.borderColor='var(--primary)'; this.style.outline='none';"
                          onblur="this.style.borderColor='var(--border)'"
                          placeholder="Jelaskan secara spesifik informasi atau dokumen publik yang Anda butuhkan...">{{ old('content') }}</textarea>
                @error('content') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <p style="font-size: 0.875rem; color: var(--muted-fg); margin: 0; max-width: 60%;">Data Anda akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan pelayanan PPID Desa {{ $village->name }}.</p>
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('village.ppid', $village->slug) }}" class="btn-ghost">Batal</a>
                    <button type="submit" class="btn-primary">Kirim Permohonan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
