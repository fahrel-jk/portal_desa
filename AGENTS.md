# AGENTS.md — Portal Desa

Konteks untuk agentic coding tool yang mengerjakan proyek ini. Baca seluruh
file ini sebelum membuat/mengubah kode apa pun.

## 1. Tentang Proyek

**Nama produk:** Portal Desa
**Jenis:** Purwarupa (prototype) akademik untuk syarat konversi SKS magang —
proyek kedua, terpisah dari LAPOR PAK.
**Instansi mitra:** Bidang Aplikasi Informatika, Diskominfo Provinsi Jawa Timur.
**Mode demo:** Localhost saja. TIDAK ada rencana deploy ke domain publik atau
subdomain asli — semua akses tenant memakai path, bukan subdomain.

**Konsep:** Portal Desa adalah platform "SaaS internal" tempat perwakilan
desa/lurah mendaftar secara mandiri (self-service), memilih template, mengisi
konten dasar lewat form wizard, lalu setelah disetujui admin, sistem otomatis
menghasilkan halaman profil desa publik di path `/desa/{slug}` — tanpa
perwakilan desa perlu menulis kode apa pun.

**PENTING — batasan akademik:** ini purwarupa untuk demo ke pembimbing
magang, bukan produk yang akan langsung dipakai ribuan desa se-Jatim. Cukup
buktikan alurnya jalan untuk beberapa desa contoh (data dummy/seed).

## 2. Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 (PHP 8.2+) |
| Database | MySQL 8 |
| Multi-tenant | **Path-based**, BUKAN subdomain. Route `/desa/{slug}` yang query data desa berdasarkan kolom `slug`. Jangan pasang package multi-tenancy (`stancl/tenancy` dkk) — overkill untuk kebutuhan ini. |
| Auth & Role | Laravel Breeze + role: `admin_provinsi`, `perwakilan_desa` |
| Frontend | Blade + Tailwind CSS |
| File upload | Local disk (`storage/app/public`) untuk logo/foto desa |
| Testing | PHPUnit / Pest |

## 3. Setup & Perintah Umum

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

Test:
```bash
php artisan test
```

## 4. Struktur Peran (Role)

| Role | Deskripsi |
|---|---|
| `admin_provinsi` | Diskominfo. Approve/reject pendaftaran desa, monitoring adopsi, kelola template. |
| `perwakilan_desa` | Kepala desa/lurah/operator. Isi wizard pendaftaran, edit konten desa sendiri setelah disetujui. |
| Publik (tanpa login) | Akses halaman `/desa/{slug}` yang sudah berstatus `published`. |

Satu akun `perwakilan_desa` hanya terhubung ke SATU `village_id`. Tidak ada
akses lintas-desa untuk role ini.

## 5. Skema Data Inti

- `users` (name, email, password, role, village_id nullable — nullable untuk admin_provinsi)
- `villages` (name, slug unique, kecamatan, kabupaten, description, logo_path,
  hero_image_path, contact_phone, contact_email, office_hours, address,
  template_id, status enum[draft, pending_review, published, rejected],
  rejection_reason nullable, submitted_at, approved_at nullable, approved_by nullable)
- `templates` (name, slug, thumbnail_path, is_active bool) — minimal 2 seed data: "Klasik", "Modern"
- `village_officials` (village_id, name, position, photo_path nullable, order) — struktur perangkat desa
- `village_news` (village_id, title, slug, content, cover_image_path nullable, published_at, created_by)
- `village_services` (village_id, name, requirements text, description) — opsional, direktori layanan administrasi

**Aturan penting soal slug:** `slug` di tabel `villages` HARUS unique dan
digenerate otomatis dari nama desa (mis. "Ladang Panjang" → `ladang-panjang`),
dengan penanganan collision (tambah angka di belakang kalau slug sudah
dipakai). Validasi ini di Service layer, bukan di controller.

## 6. Alur Bisnis Kunci

1. Perwakilan desa daftar akun → isi wizard multi-step: (a) data dasar desa,
   (b) pilih template, (c) upload logo/foto, (d) isi profil & struktur
   perangkat → submit → status `pending_review`.
2. Admin provinsi lihat antrean pendaftaran → review data → approve
   (status jadi `published`, halaman `/desa/{slug}` otomatis bisa diakses
   publik) atau reject (status `rejected`, wajib isi `rejection_reason`,
   perwakilan desa bisa revisi dan submit ulang).
3. Setelah `published`, perwakilan desa masih bisa login untuk update
   konten (berita, profil, kontak) — perubahan langsung tayang tanpa perlu
   approval ulang (approval hanya untuk publish PERTAMA KALI, bukan tiap
   update konten — supaya operasional gak macet menunggu admin tiap kali).
4. Halaman publik `/desa/{slug}` merender data desa ke dalam template Blade
   yang dipilih (`templates.slug` menentukan Blade view yang dipakai),
   bukan HTML statis per desa.

## 7. Konvensi Kode

- Ikuti PSR-12. Jalankan `./vendor/bin/pint` sebelum commit.
- Logic slug generation & validasi wizard di Service class
  (`app/Services/VillageRegistrationService.php`), bukan di controller.
- Rendering halaman publik desa: satu controller (`VillagePageController`)
  yang resolve template Blade berdasarkan `village.template.slug`, BUKAN
  route/controller terpisah per template.
- Wizard multi-step pakai session untuk simpan progress antar-step sebelum
  submit final (jangan commit ke DB tiap step, commit sekali di step terakhir).
- Nama file/kelas Inggris, label UI & konten Bahasa Indonesia.

## 8. Testing yang Wajib Ada

- Feature test: slug otomatis ter-generate unik, termasuk skenario nama desa
  yang sama diinput dua kali (collision handling).
- Feature test: desa dengan status `draft`/`pending_review`/`rejected` TIDAK
  bisa diakses di `/desa/{slug}` oleh publik (404 atau pesan "belum tersedia").
- Feature test: desa dengan status `published` bisa diakses publik.
- Feature test: perwakilan desa tidak bisa mengedit data desa lain (otorisasi).
- Feature test: admin approve mengubah status jadi `published` dan mengisi
  `approved_at`/`approved_by`; admin reject mengharuskan `rejection_reason`.

## 9. Yang TIDAK boleh dilakukan agent tanpa bertanya dulu

- Memasang subdomain wildcard atau package multi-tenancy penuh — di luar
  scope purwarupa localhost.
- Menghapus/mengubah migration yang sudah dijalankan di data seed demo.
- Menambah lebih dari 2 template di tahap awal (mulai dari 2 dulu, biar
  gak keburu berat sebelum fitur inti selesai).
- Membuat proses approval untuk setiap update konten kecil (lihat aturan
  bisnis §6.3) — hanya publish pertama kali yang butuh approval admin.
