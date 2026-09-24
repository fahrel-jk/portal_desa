<p align="center">
  <strong>🏘️ Portal Desa</strong><br>
  <em>Platform SaaS Internal untuk Pembuatan & Pengelolaan Website Desa (CMS Builder)</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white" alt="MySQL 8">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js&logoColor=white" alt="Alpine.js 3">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License">
</p>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Latar Belakang](#-latar-belakang)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur & Tech Stack](#-arsitektur--tech-stack)
- [Struktur Direktori](#-struktur-direktori)
- [Skema Database](#-skema-database)
- [Alur Bisnis](#-alur-bisnis)
- [Prasyarat](#-prasyarat)
- [Instalasi & Menjalankan](#-instalasi--menjalankan)
- [Kredensial Akun Demo](#-kredensial-akun-demo)
- [Skenario Demo (Walkthrough)](#-skenario-demo-walkthrough)
- [Pengujian (Testing)](#-pengujian-testing)
- [Dokumentasi Anchor Link (`#`)](#-dokumentasi-anchor-link-)
- [Konvensi Kode](#-konvensi-kode)
- [Lisensi](#-lisensi)

---

## 🏠 Tentang Proyek

**Portal Desa** adalah platform *"SaaS internal"* yang memungkinkan perwakilan desa/kelurahan di Provinsi Jawa Timur untuk membuat halaman web resmi desa mereka secara mandiri (*self-service*) — **tanpa perlu menulis kode satu baris pun**.

Cukup dengan mendaftar, mengisi form wizard 4 langkah, memilih template, dan menunggu persetujuan admin, maka halaman publik desa langsung tersedia di URL `/desa/{slug}` lengkap dengan fitur **CMS Layout & Navbar Builder**.

> **Catatan:** Proyek ini merupakan **purwarupa (prototype) akademik** untuk syarat konversi SKS magang, bukan produk yang akan langsung di-deploy ke domain publik. Semua akses menggunakan localhost.

---

## 🎓 Latar Belakang

| Item | Detail |
|---|---|
| **Jenis** | Purwarupa akademik — syarat konversi SKS magang |
| **Instansi Mitra** | Bidang Aplikasi Informatika, Diskominfo Provinsi Jawa Timur |
| **Tujuan** | Membuktikan konsep platform pembuatan website desa secara self-service & CMS dinamis |
| **Cakupan** | Demo localhost dengan beberapa desa contoh (data dummy/seed) |
| **Mode Akses** | Path-based (`/desa/{slug}`), bukan subdomain |

---

## ✨ Fitur Utama

### 🧙 Self-Service Onboarding (Wizard 4 Langkah)
Perwakilan desa mendaftar dan mengisi data melalui wizard interaktif:
1. **Data Dasar** — Nama desa, kecamatan, kabupaten, deskripsi
2. **Pilih Template** — Klasik atau Modern (dengan preview visual)
3. **Upload Media** — Logo desa, foto hero, dan media lainnya
4. **Perangkat Desa** — Struktur organisasi dan jabatan

### 🧩 CMS Page & Navbar Navigation Builder (Baru! 🌟)
Operator desa dapat mengkustomisasi tampilan landing page & navigasi seperti CMS profesional (Wordpress/Blogger):
- **🧱 Layout Bagian Homepage**:
  - Mengubah urutan tampil bagian (*sections*) dengan tombol panah up/down.
  - Mengubah judul kustom setiap bagian (misal: *Cerita Kampung Kami*).
  - Mengaktifkan/menyembunyikan bagian (*Hero, Profil, Layanan, Berita, Agenda, APBDes, Galeri, UMKM, Lokasi, Pengaduan, FAQ*).
- **🔗 Navigation Menu Builder (Navbar CMS)**:
  - Mengubah urutan item menu di navbar header.
  - Mengganti label nama menu sesuai keinginan.
  - Memilih penempatan lokasi menu (**Navbar Utama** vs **Dropdown 'Lainnya'**).
  - **Tambah Link Kustom (`#anchor` / URL Eksternal)** dengan tombol helper chip cepat `#berita`, `#galeri`, `#produk`, `#lokasi`, `#kontak`, `#faq`, `#perangkat`, `#statistik`.
  - **Pratinjau Live High-Contrast**: Simulator visual navbar real-time langsung di dashboard admin desa.

### 🔐 Sistem Approval Admin
- Admin Provinsi meninjau setiap pendaftaran baru
- Fitur *Approve* (terbitkan) atau *Reject* (tolak dengan alasan)
- Preview halaman desa sebelum disetujui
- Notifikasi otomatis ke perwakilan desa

### 🎨 Template System
- 2 template siap pakai: **Klasik** dan **Modern**
- Satu controller (`VillagePageController`) me-render tampilan berdasarkan template & konfigurasi CMS desa
- Setiap template memiliki layout, liquid glass, dan nuansa visual khas yang responsif

### 📰 Manajemen Konten (Pasca-Publish)
Setelah desa disetujui, perwakilan desa dapat langsung mengelola:
- **Profil Desa** — Edit info kontak, alamat, jam operasional
- **Tata Letak & Navbar CMS** — Kelola urutan homepage & menu navigasi
- **Berita Desa** — Buat, edit, hapus artikel berita
- **Perangkat Desa** — Tambah/edit struktur organisasi
- **Layanan Administrasi** — Direktori layanan publik desa
- **Galeri Foto** — Upload dan kelola foto kegiatan
- **Peta Interaktif** — Titik lokasi penting di desa (dengan koordinat)
- **Transparansi Anggaran (APBDes)** — Input dan publikasi data anggaran

> **Penting:** Pembaruan konten & tata letak langsung tayang tanpa perlu approval ulang — approval hanya untuk penerbitan pertama kali.

---

## 🏗 Arsitektur & Tech Stack

```
┌─────────────────────────────────────────────────────────────┐
│                        BROWSER                              │
│  Landing Page ─── Auth ─── Wizard ─── CMS Builder ─── Publik│
└────────────────────────┬────────────────────────────────────┘
                         │  HTTP
┌────────────────────────▼────────────────────────────────────┐
│                   LARAVEL 12 (Backend)                       │
│                                                              │
│  Routes (web.php)                                            │
│    ├── Public    → LandingPageController, VillagePageController│
│    ├── Auth      → Breeze (Login, Register)                  │
│    ├── Wizard    → WizardController (4 steps + review)       │
│    ├── Desa      → LayoutController (CMS Builder),           │
│    │               DashboardController, GalleryController,   │
│    │               AnggaranController, TitikLokasiController  │
│    ├── Admin     → AdminDashboardController, MonitoringController│
│    └── Layanan   → PengajuanController                       │
│                                                              │
│  Services & Helpers                                          │
│    ├── VillageRegistrationService (slug, validation, commit) │
│    └── SuratGeneratorService (PDF generation)                │
│                                                              │
│  Views (Blade + Tailwind CSS 4 + Alpine.js)                  │
│    ├── desa/layout.blade.php (CMS Builder Homepage & Nav)    │
│    ├── village/templates/ (klasik, modern)                   │
│    └── admin/ (dashboard, review, monitoring)                │
└────────────────────────┬────────────────────────────────────┘
                         │
┌────────────────────────▼────────────────────────────────────┐
│                    MySQL 8 Database                          │
│  users, villages (layout_settings, navigation_settings),     │
│  templates, village_officials, village_news, village_services│
└─────────────────────────────────────────────────────────────┘
```

---

## 📁 Struktur Direktori

```
portal_desa/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                    # Controller untuk Admin Provinsi
│   │   │   ├── Desa/                     # Controller untuk Perwakilan Desa
│   │   │   │   ├── LayoutController.php  #   📌 CMS Builder (Layout & Navigation)
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── ...
│   │   │   ├── VillagePageController.php # Render halaman publik desa dinamis
│   │   │   └── WizardController.php
│   ├── Models/
│   │   └── Village.php                   # Helper getOrderedLayoutSections() & getOrderedNavSections()
├── docs/
│   └── anchor_links_guide.md             # 📌 Dokumentasi resmi Anchor Link (#)
├── database/
│   ├── migrations/                       # Termasuk migration navigation_settings
│   └── seeders/                          # Demo data seeder
├── resources/views/
│   ├── desa/
│   │   └── layout.blade.php              # 📌 View CMS Builder Tabbed (Homepage & Navbar)
│   ├── village/templates/
│   │   ├── klasik/header.blade.php       # Dynamic Header Klasik
│   │   └── modern/header.blade.php       # Dynamic Header Modern
├── tests/
│   ├── Feature/
│   │   └── VillageLayoutTest.php         # 📌 Test suite CMS Layout & Navigation (100% PASS)
└── README.md                             # ← Anda sedang membaca ini
```

---

## 🗄 Skema Database (Kolom CMS)

Tabel `villages` menyimpan konfigurasi dinamis dalam format JSON:

```json
{
  "layout_settings": [
    {"id": "hero", "title": "Banner Utama", "enabled": true},
    {"id": "profile", "title": "Profil & Aparatur Desa", "enabled": true},
    {"id": "services", "title": "Layanan Utama Warga", "enabled": true}
  ],
  "navigation_settings": [
    {"id": "home", "label": "Beranda", "type": "route", "target": "village.show", "placement": "main", "enabled": true},
    {"id": "custom-1", "label": "Wisata Desa", "type": "custom", "target": "https://wisata.example.com", "placement": "main", "enabled": true},
    {"id": "contact", "label": "Kontak", "type": "hash", "target": "#kontak", "placement": "dropdown", "enabled": true}
  ]
}
```

---

## 🚀 Instalasi & Menjalankan

### 1️⃣ Clone & Install Dependencies
```bash
git clone <repo-url>
cd portal_desa
composer install
npm install
```

### 2️⃣ Konfigurasi Environment & Key
```bash
cp .env.example .env
php artisan key:generate
```

### 3️⃣ Migrate & Seed Data
```bash
php artisan migrate --seed
php artisan storage:link
```

### 4️⃣ Jalankan Aplikasi
```bash
# Jalankan server lokal & Vite
composer dev
# Atau dipisah:
# php artisan serve
# npm run dev
```

Buka **http://localhost:8000** di browser Anda. 🎉

---

## 🔑 Kredensial Akun Demo

Password semua akun: **`password`**

| Role | Email | Status Desa |
|---|---|---|
| **Admin Provinsi** | `admin@jatimprov.go.id` | — |
| **Desa (Published)** | `published@desa.id` | `published` |
| **Desa (Pending)** | `pending@desa.id` | `pending_review` |

---

## 📖 Skenario Penggunaan CMS Navigation Builder

1. Login sebagai operator desa (`published@desa.id` / `password`).
2. Masuk ke menu **Pengaturan Web / Layout** (`/desa/kelola/layout`).
3. Klik tab **🔗 Menu Navigasi (Navbar CMS)**.
4. **Reorder & Edit Label**: Naik/turunkan posisi menu atau ubah nama teks menu.
5. **Ubah Penempatan**: Pilih apakah menu tampil di **Navbar Utama** atau masuk ke Dropdown **Lainnya**.
6. **Tambah Link Kustom**:
   - Ketik label & URL target (URL web luar atau anchor link `#`).
   - Atau klik tombol chip cepat (`#berita`, `#galeri`, `#produk`, `#lokasi`, `#kontak`, `#faq`).
7. Simpan Pengaturan → Buka web desa publik untuk melihat navbar dirender secara dinamis!

---

## 🧪 Pengujian (Testing)

Semua test suite menggunakan **Pest** dan berjalan 100% Lulus:

```bash
# Jalankan semua test suite (74 tests passed)
php artisan test

# Jalankan test khusus CMS Layout & Navbar Navigation
php artisan test --filter=VillageLayoutTest
```

---

## 📍 Dokumentasi Anchor Link (`#`)

Dokumentasi detail mengenai daftar ID anchor link yang tersedia pada landing page desa dapat dilihat pada file:
📄 [docs/anchor_links_guide.md](file:///d:/dokumen%20tugas/magang/portal_desa/docs/anchor_links_guide.md)

---

## 📐 Konvensi Kode

- **PSR-12 Standard**: Diformat otomatis menggunakan `./vendor/bin/pint`.
- **Clean Architecture**: Controller tipis, model helper encapsulation, dan Blade template modular.

---

<p align="center">
  <em>Dibangun dengan ❤️ menggunakan Laravel 12 · Blade · Tailwind CSS 4 · Alpine.js</em><br>
  <em>Bidang Aplikasi Informatika — Diskominfo Provinsi Jawa Timur</em>
</p>
