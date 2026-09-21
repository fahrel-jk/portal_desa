{{-- ═══════════════════════════════════════
     FOOTER (Kontak & Navigasi) — Redesigned
     ═══════════════════════════════════════ --}}
<footer id="kontak" style="margin-top: 2rem; padding: 2rem 0 1.25rem; border-top: 2px solid var(--primary, #c4654a); background-color: color-mix(in srgb, var(--bg, #eef0ea) 50%, white); border-top-left-radius: 2rem; border-top-right-radius: 2rem;">
  <div style="max-width: 1120px; margin: 0 auto; padding: 0 1.5rem;">
    
    {{-- Main 4-Column Grid --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.75rem; margin-bottom: 1.5rem;">
      
      <!-- Column 1: Brand & Description -->
      <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
          @if($village->logo_path)
            <img src="{{ Storage::url($village->logo_path) }}" alt="Logo {{ $village->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: contain; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.08);">
          @else
            <div style="width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary, #c4654a); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.125rem; font-family: Outfit, sans-serif; box-shadow: 0 2px 6px rgba(196, 101, 74, 0.25);">
              {{ strtoupper(mb_substr($village->name, 0, 1)) }}
            </div>
          @endif
          <span style="font-weight: 700; font-size: 1.25rem; color: #1e293b; font-family: Outfit, sans-serif; letter-spacing: -0.01em;">Desa {{ $village->name }}</span>
        </div>

        <p style="font-size: 13.5px; line-height: 1.65; color: #64748b; font-family: Figtree, sans-serif; margin: 0; max-width: 320px;">
          Portal informasi resmi Pemerintah Desa {{ $village->name }}. Melayani dengan integritas untuk mewujudkan desa yang mandiri dan sejahtera.
        </p>
      </div>

      <!-- Column 2: Layanan Publik -->
      <div>
        <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--primary, #c4654a); margin-bottom: 1.25rem; font-family: Figtree, sans-serif;">
          LAYANAN PUBLIK
        </div>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 13.5px; font-weight: 500; font-family: Figtree, sans-serif;">
          <li>
            <a href="{{ route('village.services', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Administrasi Kependudukan
            </a>
          </li>
          <li>
            <a href="{{ route('village.services', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Pengajuan Surat Pengantar
            </a>
          </li>
          <li>
            <a href="{{ route('village.news', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Informasi Bantuan Sosial
            </a>
          </li>
          <li>
            <a href="{{ route('desa.request-akses.create', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Pusat Pengaduan
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 3: Informasi Desa -->
      <div>
        <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--primary, #c4654a); margin-bottom: 1.25rem; font-family: Figtree, sans-serif;">
          INFORMASI DESA
        </div>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; font-size: 13.5px; font-weight: 500; font-family: Figtree, sans-serif;">
          <li>
            <a href="{{ route('village.profile', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Profil & Sejarah
            </a>
          </li>
          <li>
            <a href="{{ route('village.products', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Potensi Ekonomi
            </a>
          </li>
          <li>
            <a href="{{ route('village.apbdes', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Transparansi Dana Desa
            </a>
          </li>
          <li>
            <a href="{{ route('village.agenda', $village->slug) }}" style="text-decoration: none; color: #475569; transition: color 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'" onmouseout="this.style.color='#475569'">
              Agenda Kegiatan
            </a>
          </li>
        </ul>
      </div>

      <!-- Column 4: Hubungi Kami -->
      <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div style="font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--primary, #c4654a); margin-bottom: 0.25rem; font-family: Figtree, sans-serif;">
          HUBUNGI KAMI
        </div>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.875rem; font-size: 13.5px; color: #475569; font-weight: 500; font-family: Figtree, sans-serif;">
          <li style="display: flex; align-items: flex-start; gap: 0.625rem;">
            <svg style="width: 16px; height: 16px; margin-top: 2px; flex-shrink: 0; color: var(--primary, #c4654a);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
            <span>{{ $village->address ?: 'Jl. Raya Desa ' . $village->name . ' No. 45, Kecamatan ' . $village->kecamatan }}</span>
          </li>
          <li style="display: flex; align-items: center; gap: 0.625rem;">
            <svg style="width: 16px; height: 16px; flex-shrink: 0; color: var(--primary, #c4654a);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
            <span>{{ $village->contact_email ?: 'kontak@' . $village->slug . '.desa.id' }}</span>
          </li>
          <li style="display: flex; align-items: center; gap: 0.625rem;">
            <svg style="width: 16px; height: 16px; flex-shrink: 0; color: var(--primary, #c4654a);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $village->office_hours ?: 'Senin–Jumat, 08.00–15.00 WIB' }}</span>
          </li>
        </ul>

        {{-- Social Media Pills --}}
        <div style="display: flex; align-items: center; gap: 0.625rem; padding-top: 0.5rem;">
          <a href="#" aria-label="Instagram" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'; this.style.borderColor='var(--primary, #c4654a)'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
            <svg style="width: 15px; height: 15px;" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"/></svg>
          </a>
          <a href="#" aria-label="Facebook" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'; this.style.borderColor='var(--primary, #c4654a)'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
            <svg style="width: 15px; height: 15px;" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
          </a>
          <a href="#" aria-label="Youtube" style="width: 32px; height: 32px; border-radius: 50%; border: 1px solid #e2e8f0; background: #ffffff; display: flex; align-items: center; justify-content: center; color: #64748b; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s ease;" onmouseover="this.style.color='var(--primary, #c4654a)'; this.style.borderColor='var(--primary, #c4654a)'" onmouseout="this.style.color='#64748b'; this.style.borderColor='#e2e8f0'">
            <svg style="width: 15px; height: 15px;" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.254.418-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"/></svg>
          </a>
        </div>
      </div>

    </div>

    <!-- Bottom Sub-footer / Copyright -->
    <div style="padding-top: 1rem; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; border-top: 1px solid rgba(226, 232, 240, 0.8); font-size: 12.5px; color: #64748b; font-family: Figtree, sans-serif;">
      <p style="font-style: italic; margin: 0;">
        Membangun Desa, Menjaga Tradisi.
      </p>
      <p style="margin: 0;">
        &copy; {{ date('Y') }} Pemerintah Desa {{ $village->name }}. Seluruh hak cipta dilindungi.
      </p>
    </div>

  </div>
</footer>
