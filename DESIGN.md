# DESIGN.md — Portal Desa

Dokumen ini adalah acuan visual. Baca bersama `AGENTS.md` sebelum membuat
komponen UI apa pun. **Ada DUA target desain berbeda** dalam proyek ini —
jangan dicampur:

| Target | Gaya | Analog referensi |
|---|---|---|
| **A. Situs Portal Desa** (landing pendaftaran + dashboard admin/perwakilan) | SaaS/agency modern — bold, funnel jelas, banyak CTA | asain.co.id, nore.web.id, fincash (TailGrids), Nox (agent-kit-site) |
| **B. Halaman publik desa yang di-generate** (`/desa/{slug}`) | Profil instansi/desa — informatif, tenang, dipercaya | Situs nagari (Ladang Panjang) yang sudah dibahas sebelumnya |

## 1. Target A — Situs Portal Desa (Landing + Dashboard)

### 1.1 Prinsip
Ini pada dasarnya "jualan layanan" ke perwakilan desa — modelnya sama seperti
agency jasa pembuatan website (referensi asain.co.id, nore.web.id): funnel-nya
jelas dari hero → manfaat/fitur → cara kerja → CTA daftar. Bedanya, di sini
"harga" diganti "syarat/tier" (karena gratis, bukan produk komersial), dan CTA
akhirnya "Daftarkan Desa Anda" alih-alih "Booking via WhatsApp".

### 1.2 Struktur Landing Page (`/`)
1. **Header** — logo "Portal Desa", nav (Beranda, Cara Kerja, Desa Terdaftar,
   Masuk), tombol utama "Daftarkan Desa" di kanan (mengacu pola CTA-di-header
   ala Nox: "Try for free").
2. **Hero** — headline besar + subheadline singkat + CTA utama, ditemani
   visual (mockup halaman desa hasil generate, bukan foto stok) — mengacu
   pola hero Nox (headline besar, visual produk di bawahnya, bukan foto orang).
3. **Strip Statistik/Kepercayaan** — "X desa telah bergabung", "Y kabupaten
   terjangkau" — mengacu pola "2.000+ website dibangun" di asain.co.id, tapi
   diganti jadi angka adopsi asli/dummy platform ini.
4. **Cara Kerja (3-4 langkah)** — Daftar → Pilih Template → Isi Konten →
   Disetujui & Tayang — kartu horizontal dengan ikon, mengacu pola "Build AI
   agents..." feature grid di Nox.
5. **Pilihan Template** — grid 2 kartu (Klasik, Modern) dengan thumbnail
   preview, mengacu pola portfolio grid di nore.web.id/asain.co.id.
6. **FAQ Accordion** — pertanyaan umum perwakilan desa (Berapa lama proses
   approval? Apakah bisa edit setelah tayang? dst.) — mengacu pola FAQ di
   nore.web.id dan Nox persis.
7. **CTA Akhir + Footer** — ajakan daftar sekali lagi, footer kontak Diskominfo.

### 1.3 Dashboard Admin Provinsi & Perwakilan Desa
Beda dari landing — di sini prioritaskan kejelasan status & antrean kerja,
mengacu pola dashboard SaaS modern (card ringkasan + tabel), bukan pola
marketing:
- **Admin Provinsi**: kartu ringkasan (Menunggu Review, Disetujui, Ditolak),
  tabel antrean pendaftaran dengan tombol Approve/Reject cepat, halaman detail
  desa untuk review sebelum keputusan.
- **Perwakilan Desa**: wizard pendaftaran multi-step dengan progress
  indicator jelas (mis. "Langkah 2 dari 4"), dan setelah published, dashboard
  sederhana untuk kelola berita/konten.

## 2. Target B — Halaman Publik Desa (`/desa/{slug}`)

Ini BUKAN landing SaaS — ini representasi resmi pemerintahan desa. Ikuti
prinsip civic-trust yang sama seperti dibahas untuk LAPOR PAK, disederhanakan:
- Header: nama desa + logo, nav (Beranda, Profil, Berita, Layanan, Kontak).
- Hero singkat: foto/hero image desa + nama desa + kecamatan/kabupaten.
- Section Profil: sejarah singkat, struktur perangkat (dari `village_officials`).
- Section Berita: daftar berita terbaru (dari `village_news`).
- Section Layanan (opsional): direktori administrasi (dari `village_services`).
- Footer: kontak, jam layanan, alamat kantor desa.

Dua template (Klasik, Modern) berbagi STRUKTUR data yang sama di atas —
bedanya hanya di layout/styling (mis. Klasik: header solid + list; Modern:
header dengan overlay image + card grid), bukan konten yang ditampilkan.

## 3. Palet Warna

| Target | Token | Hex | Pemakaian |
|---|---|---|---|
| A (Portal) | `--portal-primary` | `#4F46E5` (indigo-600) | CTA utama, aksen link, header dashboard |
| A (Portal) | `--portal-dark` | `#1E1B4B` (indigo-950) | Hero background gelap (opsional, kalau mau kontras ala Nox) |
| A (Portal) | `--status-pending` | `#FEF3C7` bg / `#92400E` text | Badge status "Menunggu Review" |
| A (Portal) | `--status-approved` | `#DCFCE7` bg / `#166534` text | Badge status "Disetujui/Tayang" |
| A (Portal) | `--status-rejected` | `#FEE2E2` bg / `#991B1B` text | Badge status "Ditolak" |
| B (Desa) | `--village-primary` | `#1D4ED8` (blue-700) | Header, tombol, aksen — beda dari warna Portal supaya kedua target visually berbeda |
| B (Desa) | `--surface` | `#FFFFFF` / `#F9FAFB` | Card, background section |

**Alasan sengaja beda warna primer A vs B:** supaya siapa pun yang lihat
screenshot langsung tahu ini halaman "sistem Portal Desa" vs "halaman desa
sungguhan" — mencegah campur aduk konteks saat demo ke pembimbing.

## 4. Tipografi

- Font: `Inter`, konsisten dengan LAPOR PAK.
- Target A boleh lebih ekspresif: H1 hero 32-36px bold, banyak whitespace,
  CTA button besar (ala SaaS modern).
- Target B lebih konservatif: H1 24-28px, mengikuti prinsip yang sama dengan
  DESIGN.md LAPOR PAK (civic-trust, bukan flashy).

## 5. Komponen Reusable (Blade Component)

- `<x-portal.status-badge status="pending|approved|rejected" />`
- `<x-portal.stat-card label="" value="" />`
- `<x-portal.step-indicator current="2" total="4" />` — progress wizard
- `<x-village.section title="">...</x-village.section>` — wrapper section
  konsisten dipakai di kedua template desa (Klasik & Modern)

## 6. Yang TIDAK boleh dilakukan

- Jangan pakai warna/token Target A di halaman publik desa (Target B), atau
  sebaliknya — ini akan membingungkan saat demo.
- Jangan tambah template ketiga sebelum 2 template pertama (Klasik, Modern)
  benar-benar selesai dan teruji dengan data dummy.
- Landing page Portal Desa jangan pakai foto stok generik — pakai mockup
  hasil generate halaman desa asli (dari data seed) sebagai visual hero,
  supaya lebih meyakinkan saat demo ke pembimbing.
