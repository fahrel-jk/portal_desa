# 📍 Panduan Daftar Anchor Link (`#`) — Portal Desa CMS

Dokumen ini berisi rujukan lengkap daftar **Anchor Link (`#`)** yang digunakan untuk penataan **Menu Navigasi Navbar (CMS Builder)** pada platform Portal Desa.

---

## 🚀 1. Tabel Ringkasan Anchor Link Utama

| Target URL (`#`) | Nama Bagian | Deskripsi Konten | Template Klasik | Template Modern |
|---|---|---|:---:|:---:|
| `#beranda` | Banner Utama / Hero | Bagian header & sambutan paling atas | ✅ | ✅ |
| `#profil` | Profil & Sejarah Desa | Cerita ringkas dan profil desa | ✅ | ✅ |
| `#statistik` | Data Kependudukan | Grafik & statistik kependudukan warga | ✅ | ✅ |
| `#perangkat` | Aparatur / SOTK | Daftar perangkat & struktur organisasi desa | ✅ | ✅ |
| `#layanan` | Direktori Layanan | Pintasan layanan administrasi warga | ✅ | ✅ |
| `#berita` | Kabar & Berita Desa | Artikel berita & pengumuman desa terbaru | ✅ | ✅ |
| `#agenda` | Agenda Kegiatan | Jadwal & kalender acara kegiatan desa | ✅ | ✅ |
| `#galeri` | Galeri Foto | Foto dokumentasi kegiatan desa | ✅ | ✅ |
| `#produk` | Produk UMKM Desa | Katalog produk UMKM buatan warga desa | ✅ | ✅ |
| `#lokasi` | Peta & Lokasi Desa | Peta digital & alamat kantor desa | ✅ | ✅ |
| `#faq` | FAQ / Tanya Jawab | Accordion pertanyaan umum warga | ✅ | ✅ |
| `#kontak` | Footer Kontak | Informasi kontak, jam kerja, & alamat | ✅ | ✅ |

---

## 📂 2. Detail Lokasi Kode & Baris File

### A. Template Klasik
📄 **File:** `resources/views/village/templates/klasik.blade.php`

- `#beranda` → `L77`: `<section id="beranda" class="bg-background">`
- `#layanan` → `L136`: `<section id="layanan" class="scroll-mt-20">`
- `#berita` → `L174`: `<section id="berita" class="scroll-mt-20">`
- `#profil` → `L215`: `<section id="profil" class="scroll-mt-20">`
- `#statistik` → `L259`: `<section id="statistik" class="scroll-mt-20">`
- `#agenda` → `L294`: `<section id="agenda" class="scroll-mt-20">`
- `#galeri` → `L409`: `<section id="galeri" class="scroll-mt-20">`
- `#produk` → `L438`: `<section id="produk" class="scroll-mt-20">`
- `#lokasi` → `L506`: `<section id="lokasi" class="scroll-mt-20">`
- `#faq` → `L592`: `<section id="faq" class="scroll-mt-20">`
- `#kontak` → `L634`: `<footer id="kontak" class="bg-deep">`

### B. Template Modern
📄 **File:** `resources/views/village/templates/modern.blade.php` & `footer.blade.php`

- `#profil` → `L314`: `<section id="profil" class="scroll-mt-20">`
- `#statistik` → `L340`: `<div id="statistik" class="scroll-mt-20">`
- `#perangkat` → `L408`: `<div id="perangkat" class="card scroll-mt-20">`
- `#layanan` → `L463`: `<section id="layanan" class="scroll-mt-20">`
- `#berita` → `L506`: `<section id="berita" class="scroll-mt-20">`
- `#agenda` → `L592`: `<section id="agenda" class="scroll-mt-20">`
- `#galeri` → `L721`: `<section id="galeri" class="scroll-mt-20">`
- `#produk` → `L751`: `<section id="produk" class="scroll-mt-20">`
- `#lokasi` → `L811`: `<section id="lokasi" class="scroll-mt-20">`
- `#faq` → `L879`: `<section id="faq" class="scroll-mt-20">`
- `#kontak` → `footer.blade.php:L4`: `<footer id="kontak">`
