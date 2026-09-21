# Prompt Agentic AI — Redesign Section Berita Portal Desa (Template Modern)

Salin seluruh isi file ini sebagai prompt untuk agentic AI.

---

## Tugas

Redesign section "Berita & Pengumuman" di landing page. Masalah saat ini: teks pada kartu berita mepet ke border (tidak ada padding yang cukup). Buat ulang kartu dengan gaya **hover-reveal card** seperti TravelCard (21st.dev): gambar penuh menutupi kartu, teks duduk di atas gradient gelap dari bawah, dan saat kursor diarahkan ke kartu muncul baris berisi **tanggal berita + tombol "Detail"** yang langsung mengarah ke halaman detail berita.

JANGAN pakai label "harga" atau "Book Now" — konteksnya berita: labelnya "Tanggal Berita" dan tombolnya "Detail".

## Struktur Section

- Eyebrow: `KABAR DESA` — uppercase, letter-spacing lebar, font-size 11px, warna primary.
- Judul: `Berita & pengumuman`.
- Link kanan: `Lihat semua →` menuju halaman daftar berita (`/berita`).
- Grid kartu: 1 kolom mobile, 2 kolom `sm`, 4 kolom `lg`.
- Deskripsi/ringkasan berita di landing page cukup singkat (maksimal 2 baris, pakai line-clamp) supaya semua kartu tingginya seragam.

## Desain Kartu Berita (penting — ini perbaikan utamanya)

Setiap kartu:

- Tinggi tetap ± 420px, `rounded-2xl`, `overflow-hidden`, border halus, seluruh kartu adalah link ke `/berita/[slug]`.
- Gambar memenuhi kartu (`absolute inset-0 object-cover`), sedikit membesar (`scale-105`) saat hover dengan transisi halus.
- Overlay gradient gelap dari bawah ke atas agar teks selalu terbaca.
- **Konten teks WAJIB punya padding 28px (p-7) dari semua sisi kartu** — inilah perbaikan untuk masalah teks mepet border. Jangan pakai padding di bawah 24px.
- Isi konten (dari atas ke bawah, menempel di bagian bawah kartu):
  1. Badge kategori berita (chip kecil).
  2. Judul berita — tebal, maksimal 2 baris (`line-clamp-2`).
  3. Ringkasan singkat — maksimal 2 baris (`line-clamp-2`).
  4. Baris hover-reveal: label kecil uppercase `TANGGAL BERITA` + tanggalnya (misal `12 Sep 2026`), dan tombol `Detail` dengan ikon panah kanan. Baris ini tersembunyi secara default dan muncul saat hover (animasi opacity + translate-y halus). Tombol berubah warna (background primary) saat kartu di-hover.

## Halaman yang Harus Ada

1. **Landing page** — section berita seperti di atas.
2. **Halaman daftar berita** (`/berita`) — grid semua kartu berita (3 kolom desktop).
3. **Halaman detail berita** (`/berita/[slug]`) — breadcrumb, tanggal, gambar (aspect 4:3), judul, dan isi berita lengkap dalam kartu dengan padding nyaman (p-7).

## Data Berita (4 item contoh)

| Slug | Judul | Tanggal |
|---|---|---|
| desa-wisata-terbaik | Desa Sumberan masuk nominasi desa wisata terbaik | 12 Sep 2026 |
| pembagian-bibit-pohon | Pembagian bibit pohon gratis untuk warga | 08 Sep 2026 |
| pelatihan-digital-marketing-umkm | Pelatihan digital marketing untuk pelaku UMKM | 04 Sep 2026 |
| penyaluran-bantuan-pangan | Penyaluran bantuan pangan tahap ketiga | 29 Agu 2026 |

Setiap berita punya: slug, kategori, judul, ringkasan singkat, isi lengkap (beberapa paragraf), tanggal, label tanggal, gambar, alt gambar.

## Gaya Visual (ikuti panduan UI template modern)

- Font heading: **Outfit** (weight 600–800). Font body: **Figtree**.
- Warna (tema sumberan-sage):
  - Background: `#eef0ea`
  - Teks utama: `#2a2f23`
  - Primary: `#c4654a`
  - Secondary: `#87a878`
  - Accent: `#e8a87c`
  - Border: `rgba(42,47,35,0.10)`
- Container: `max-w-[1120px] mx-auto`.
- Padding section: mobile `1.5rem 1rem`, desktop `2.5rem 1.5rem`.
- Nuansa: clean, organic, SaaS modern. Hindari gradien ungu/indigo generik.

## Kriteria Selesai (verifikasi)

1. Teks di dalam kartu berjarak minimal 24–28px dari border kartu di semua sisi — tidak ada lagi teks yang mepet.
2. Saat hover: gambar zoom halus, baris "Tanggal Berita + tombol Detail" muncul dengan animasi.
3. Klik kartu / tombol Detail membuka halaman detail berita yang benar.
4. Semua kartu di grid tingginya seragam karena ringkasan dibatasi 2 baris.
5. Build tanpa error; tampilan rapi di mobile maupun desktop.
