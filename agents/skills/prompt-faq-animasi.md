# Prompt Agentic AI — Animasi FAQ Portal Desa Sumberan

## ROLE
Kamu adalah senior frontend engineer untuk portal informasi Desa Sumberan.
Stack: **Laravel 11 (Blade)**, **Tailwind CSS v3/v4**, **Alpine.js** untuk interaksi Blade,
dan **React 18 (TypeScript)** untuk beberapa halaman/komponen yang di-mount lewat Vite.

## TUJUAN
Bangun ulang section FAQ pada landing page agar interaktif dan beranimasi halus,
konsisten dengan identitas visual "clean organic" yang sudah berjalan
(palet sage–terracotta, font Outfit untuk heading, Figtree untuk body).

## FITUR WAJIB
1. **Pencarian FAQ** — memfilter pertanyaan & jawaban secara real-time (case-insensitive).
   Tampilkan pesan "Tidak ada hasil" jika kosong, beserta tombol reset pencarian.
2. **Accordion animasi halus**:
   - Buka/tutup dengan transisi tinggi (grid-template-rows: 0fr → 1fr) + opacity, durasi ±300ms, easing `ease-out` / cubic-bezier halus.
   - Hanya satu item terbuka dalam satu waktu (single-open accordion).
   - Ikon chevron berotasi 180° saat terbuka.
   - Item pertama terbuka secara default.
3. **Stagger reveal** — item FAQ muncul berurutan saat section masuk viewport
   (IntersectionObserver), delay 60–90ms antar item, fade + translateY(12px).
4. **Aksesibilitas**: gunakan `<button>` untuk trigger, `aria-expanded`,
   `aria-controls`, panel dengan `role="region"`, fokus keyboard terlihat jelas,
   dan hormati `prefers-reduced-motion`.
5. **Desain**: kartu FAQ dengan border tipis, radius 16px, latar surface lembut,
   badge kategori kecil di atas judul, hover state halus. Judul section memakai
   Outfit, body Figtree. Warna dari token CSS (sage untuk aksen, terracotta untuk highlight).

## DATA FAQ (contoh awal)
- "Bagaimana cara mengurus surat keterangan domisili?" — kategori Layanan
- "Apa saja syarat pengajuan KTP baru?" — kategori Kependudukan
- "Bagaimana cara mengajukan bantuan sosial?" — kategori Bantuan Sosial
- "Di mana saya bisa melihat informasi APBDes?" — kategori Transparansi
- "Bagaimana prosedur perizinan UMKM desa?" — kategori Ekonomi

## DELIVERABLE
1. Komponen Blade + Alpine.js (`resources/views/components/faq-section.blade.php`).
2. Komponen React TypeScript (`resources/js/components/FaqSection.tsx`) dengan
   mount point Vite, untuk halaman yang sudah memakai React.
3. CSS animasi bersama (`resources/css/faq.css`) yang dipakai kedua versi.
4. Jangan ubah routing, controller, atau bagian halaman lain di luar section FAQ.

## BATASAN
- Jangan tambah dependency baru selain yang sudah ada (Alpine.js, Tailwind, React).
- Jangan gunakan library animasi eksternal (Framer Motion dsb.) — cukup CSS transition + IntersectionObserver.
- Semua teks dalam Bahasa Indonesia.

---

# IMPLEMENTASI

## A. CSS animasi bersama — `resources/css/faq.css`

```css
/* === Animasi accordion (teknis grid-rows) === */
.faq-panel {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 300ms cubic-bezier(0.22, 1, 0.36, 1),
              opacity 250ms ease-out;
  opacity: 0;
}
.faq-panel[data-open="true"] {
  grid-template-rows: 1fr;
  opacity: 1;
}
.faq-panel > div {
  overflow: hidden;
}

/* === Rotasi chevron === */
.faq-chevron {
  transition: transform 300ms cubic-bezier(0.22, 1, 0.36, 1);
}
.faq-chevron[data-open="true"] {
  transform: rotate(180deg);
}

/* === Stagger reveal saat masuk viewport === */
.faq-reveal {
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 500ms ease-out, transform 500ms ease-out;
  transition-delay: var(--reveal-delay, 0ms);
}
.faq-reveal.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* === Hormati prefers-reduced-motion === */
@media (prefers-reduced-motion: reduce) {
  .faq-panel,
  .faq-chevron,
  .faq-reveal {
    transition: none !important;
  }
  .faq-reveal {
    opacity: 1;
    transform: none;
  }
}
```

## B. Versi Laravel Blade + Alpine.js

```blade
{{-- resources/views/components/faq-section.blade.php --}}
@php
  $faqs = [
    ['kategori' => 'Layanan',      'q' => 'Bagaimana cara mengurus surat keterangan domisili?', 'a' => 'Datang ke kantor desa dengan membawa KTP dan KK asli. Surat selesai dalam 1 hari kerja dan gratis.'],
    ['kategori' => 'Kependudukan', 'q' => 'Apa saja syarat pengajuan KTP baru?',                 'a' => 'Fotokopi KK, surat pengantar RT/RW, dan pas foto. Usia minimal 17 tahun atau sudah menikah.'],
    ['kategori' => 'Bantuan Sosial','q' => 'Bagaimana cara mengajukan bantuan sosial?',           'a' => 'Isi formulir di kantor desa, lampirkan KK dan surat keterangan tidak mampu dari RT/RW.'],
    ['kategori' => 'Transparansi', 'q' => 'Di mana saya bisa melihat informasi APBDes?',          'a' => 'APBDes dipublikasikan di papan informasi kantor desa dan halaman Transparansi situs ini.'],
    ['kategori' => 'Ekonomi',      'q' => 'Bagaimana prosedur perizinan UMKM desa?',              'a' => 'Ajukan surat keterangan usaha ke kantor desa dengan KTP, KK, dan foto lokasi usaha.'],
  ];
@endphp

<section
  x-data="{
    open: 0,
    query: '',
    faqs: @js($faqs),
    get filtered() {
      const q = this.query.trim().toLowerCase();
      if (!q) return this.faqs;
      return this.faqs.filter(f =>
        f.q.toLowerCase().includes(q) || f.a.toLowerCase().includes(q)
      );
    },
    toggle(i) { this.open = this.open === i ? -1 : i; }
  }"
  x-init="
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
      });
    }, { threshold: 0.15 });
    document.querySelectorAll('.faq-reveal').forEach((el, i) => {
      el.style.setProperty('--reveal-delay', (i * 75) + 'ms');
      io.observe(el);
    });
  "
  class="mx-auto max-w-3xl px-6 py-16"
>
  <h2 class="font-[Outfit] text-3xl font-semibold text-slate-800">Pertanyaan yang Sering Diajukan</h2>
  <p class="mt-2 font-[Figtree] text-slate-600">Temukan jawaban seputar layanan dan informasi Desa Sumberan.</p>

  {{-- Pencarian --}}
  <div class="relative mt-8">
    <input
      x-model.debounce.150ms="query"
      type="search"
      placeholder="Cari pertanyaan…"
      class="w-full rounded-2xl border border-slate-200 bg-white/70 px-5 py-3.5 font-[Figtree] text-slate-800 shadow-sm backdrop-blur focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
    />
  </div>

  {{-- Daftar FAQ --}}
  <div class="mt-8 space-y-4">
    <template x-for="(faq, i) in filtered" :key="faq.q">
      <div class="faq-reveal rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur">
        <button
          type="button"
          @click="toggle(i)"
          :aria-expanded="open === i"
          :aria-controls="'faq-panel-' + i"
          class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-500"
        >
          <span>
            <span class="mb-1 inline-block rounded-full bg-emerald-50 px-3 py-0.5 text-xs font-medium text-emerald-700" x-text="faq.kategori"></span>
            <span class="block font-[Outfit] text-lg font-medium text-slate-800" x-text="faq.q"></span>
          </span>
          <svg class="faq-chevron h-5 w-5 shrink-0 text-emerald-600" :data-open="open === i" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </button>
        <div
          class="faq-panel"
          :id="'faq-panel-' + i"
          role="region"
          :data-open="open === i"
        >
          <div>
            <p class="px-6 pb-5 font-[Figtree] leading-relaxed text-slate-600" x-text="faq.a"></p>
          </div>
        </div>
      </div>
    </template>

    {{-- Hasil kosong --}}
    <div x-show="filtered.length === 0" x-cloak class="rounded-2xl border border-dashed border-slate-300 p-10 text-center">
      <p class="font-[Figtree] text-slate-500">Tidak ada hasil untuk pencarian tersebut.</p>
      <button @click="query = ''" class="mt-3 rounded-full bg-emerald-600 px-5 py-2 font-[Figtree] text-sm font-medium text-white hover:bg-emerald-700">Reset pencarian</button>
    </div>
  </div>
</section>
```

## C. Versi React (TypeScript)

```tsx
// resources/js/components/FaqSection.tsx
import { useEffect, useMemo, useRef, useState } from 'react'

export type Faq = { kategori: string; q: string; a: string }

export default function FaqSection({ faqs }: { faqs: Faq[] }) {
  const [open, setOpen] = useState(0)
  const [query, setQuery] = useState('')
  const sectionRef = useRef<HTMLElement>(null)

  const filtered = useMemo(() => {
    const q = query.trim().toLowerCase()
    if (!q) return faqs
    return faqs.filter(
      (f) => f.q.toLowerCase().includes(q) || f.a.toLowerCase().includes(q),
    )
  }, [faqs, query])

  // Stagger reveal via IntersectionObserver
  useEffect(() => {
    const root = sectionRef.current
    if (!root) return
    const items = root.querySelectorAll<HTMLElement>('.faq-reveal')
    const io = new IntersectionObserver(
      (entries) =>
        entries.forEach((e) => {
          if (e.isIntersecting) {
            e.target.classList.add('is-visible')
            io.unobserve(e.target)
          }
        }),
      { threshold: 0.15 },
    )
    items.forEach((el, i) => {
      el.style.setProperty('--reveal-delay', `${i * 75}ms`)
      io.observe(el)
    })
    return () => io.disconnect()
  }, [filtered.length])

  return (
    <section ref={sectionRef} className="mx-auto max-w-3xl px-6 py-16">
      <h2 className="font-[Outfit] text-3xl font-semibold text-slate-800">
        Pertanyaan yang Sering Diajukan
      </h2>
      <p className="mt-2 font-[Figtree] text-slate-600">
        Temukan jawaban seputar layanan dan informasi Desa Sumberan.
      </p>

      <input
        type="search"
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        placeholder="Cari pertanyaan…"
        className="mt-8 w-full rounded-2xl border border-slate-200 bg-white/70 px-5 py-3.5 font-[Figtree] text-slate-800 shadow-sm backdrop-blur focus:border-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
      />

      <div className="mt-8 space-y-4">
        {filtered.map((faq, i) => {
          const isOpen = open === i
          return (
            <div
              key={faq.q}
              className="faq-reveal rounded-2xl border border-slate-200 bg-white/80 shadow-sm backdrop-blur"
            >
              <button
                type="button"
                onClick={() => setOpen(isOpen ? -1 : i)}
                aria-expanded={isOpen}
                aria-controls={`faq-panel-${i}`}
                className="flex w-full items-center justify-between gap-4 px-6 py-5 text-left focus-visible:outline focus-visible:outline-2 focus-visible:outline-emerald-500"
              >
                <span>
                  <span className="mb-1 inline-block rounded-full bg-emerald-50 px-3 py-0.5 text-xs font-medium text-emerald-700">
                    {faq.kategori}
                  </span>
                  <span className="block font-[Outfit] text-lg font-medium text-slate-800">
                    {faq.q}
                  </span>
                </span>
                <svg
                  data-open={isOpen}
                  className="faq-chevron h-5 w-5 shrink-0 text-emerald-600"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  strokeWidth={2}
                >
                  <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div
                id={`faq-panel-${i}`}
                role="region"
                data-open={isOpen}
                className="faq-panel"
              >
                <div>
                  <p className="px-6 pb-5 font-[Figtree] leading-relaxed text-slate-600">
                    {faq.a}
                  </p>
                </div>
              </div>
            </div>
          )
        })}

        {filtered.length === 0 && (
          <div className="rounded-2xl border border-dashed border-slate-300 p-10 text-center">
            <p className="font-[Figtree] text-slate-500">
              Tidak ada hasil untuk pencarian tersebut.
            </p>
            <button
              onClick={() => setQuery('')}
              className="mt-3 rounded-full bg-emerald-600 px-5 py-2 font-[Figtree] text-sm font-medium text-white hover:bg-emerald-700"
            >
              Reset pencarian
            </button>
          </div>
        )}
      </div>
    </section>
  )
}
```

### Mount React lewat Vite

```blade
{{-- di dalam blade halaman --}}
<div id="faq-root" data-faqs='@json($faqs)'></div>
@vite('resources/js/faq-root.tsx')
```

```tsx
// resources/js/faq-root.tsx
import { createRoot } from 'react-dom/client'
import FaqSection, { type Faq } from './components/FaqSection'

const el = document.getElementById('faq-root')
if (el) {
  const faqs: Faq[] = JSON.parse(el.dataset.faqs ?? '[]')
  createRoot(el).render(<FaqSection faqs={faqs} />)
}
```

Kedua versi (Blade/Alpine dan React) memakai CSS `.faq-panel`, `.faq-chevron`,
dan `.faq-reveal` yang sama, sehingga animasinya identik di seluruh situs.
