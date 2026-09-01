# Alur 4 — Akses Publik ke Halaman Desa

## Aktor
**Masyarakat Umum** (tanpa login)

## Langkah-langkah

### 1. Buka URL Desa
Warga mengakses `/desa/{slug}` melalui browser (contoh: `/desa/sumber-makmur`).

### 2. Sistem Memproses

#### Jika Desa Ditemukan & Status `published`
- Halaman desa di-render menggunakan template Blade yang dipilih (Klasik atau Modern)
- Konten yang ditampilkan:
  - **Profil**: nama, deskripsi, logo, foto hero
  - **Perangkat Desa**: daftar pejabat beserta jabatan
  - **Berita**: daftar berita terbaru
  - **Layanan** (opsional): direktori layanan administrasi
  - **Kontak**: telepon, email, jam layanan, alamat kantor

#### Jika Desa Tidak Ditemukan ATAU Status Bukan `published`
- Tampilkan halaman *"Desa belum tersedia"* (404 friendly, bukan error teknis mentah)

## Template Rendering
Satu controller (`VillagePageController`) me-resolve view Blade berdasarkan `village.template.slug`:
- `klasik` → `village.templates.klasik`
- `modern` → `village.templates.modern`

Fallback ke template Klasik jika view tidak ditemukan.

## Catatan Teknis
- Hanya desa dengan status `published` yang bisa diakses publik
- Status `draft`, `pending_review`, dan `rejected` mengembalikan halaman "belum tersedia"
