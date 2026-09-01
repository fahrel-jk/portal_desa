# Portal Desa — Purwarupa SaaS Internal

Proyek ini adalah purwarupa (MVP) dari platform **Portal Desa**, sebuah layanan "SaaS internal" untuk Diskominfo Provinsi Jawa Timur yang memungkinkan desa-desa membuat dan mengelola halaman web resmi mereka sendiri dalam waktu 5 menit tanpa perlu koding. Proyek ini dikerjakan sebagai syarat konversi SKS magang akademik.

## 🚀 Fitur Utama

- **Self-Service Onboarding:** Perwakilan desa dapat mendaftar mandiri melalui *wizard* 4 langkah interaktif.
- **Auto-Generate Slug:** URL publik desa (misal `/desa/sumber-makmur`) dibuat secara otomatis berdasarkan nama desa dengan penanganan duplikasi cerdas.
- **Admin Approval Workflow:** Admin Provinsi dapat memonitor antrean pendaftaran dan melakukan *Approve* atau *Reject* beserta alasan (dilengkapi notifikasi).
- **Template System:** Menggunakan pendekatan satu halaman per desa (`/desa/{slug}`) yang merender tampilan berdasarkan template yang dipilih (Klasik / Modern) — BUKAN pendekatan subdomain untuk menyederhanakan *deployment* purwarupa.
- **Content Management:** Perwakilan desa yang sudah diverifikasi dapat langsung memperbarui profil, daftar perangkat desa, dan berita. Pembaruan akan langsung tayang secara *real-time* di halaman publik.

## ⚙️ Cara Instalasi & Menjalankan (Localhost)

Pastikan mesin lokal Anda memiliki PHP 8.2+ dan MySQL/SQLite terinstal.

1. **Clone & Install Dependencies**
   ```bash
   git clone <repo-url>
   cd portal_desa
   composer install
   npm install
   ```

2. **Environment & Key**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *(Pastikan mengkonfigurasi `.env` sesuai setup database Anda. Secara default Laravel menggunakan SQLite)*

3. **Migrate & Seed Data Demo**
   Langkah ini wajib untuk mengisi data template dan akun demo.
   ```bash
   php artisan migrate --seed
   ```

4. **Storage Link (Penting untuk Gambar)**
   ```bash
   php artisan storage:link
   ```

5. **Jalankan Aplikasi**
   Jalankan server PHP dan Vite untuk me-render CSS/JS.
   ```bash
   npm run build
   php artisan serve
   ```
   Buka `http://localhost:8000` di peramban (browser) Anda.

## 🔑 Kredensial Akun Demo

Untuk memudahkan demo ke pembimbing, seeder telah menyediakan beberapa akun yang bisa langsung digunakan (Password untuk semua akun: `password`):

| Role | Email | Kegunaan |
|---|---|---|
| **Admin Provinsi** | `admin@jatimprov.go.id` | Menyetujui/menolak pendaftaran, memonitor antrean |
| **Desa (Draft)** | `draft@desa.id` | Demo melanjutkan pendaftaran via Wizard |
| **Desa (Pending)** | `pending@desa.id` | Demo status menunggu *review* di *dashboard* |
| **Desa (Published)** | `published@desa.id` | Demo pengelolaan berita, perangkat desa, profil |
| **Desa (Rejected)** | `rejected@desa.id` | Demo pendaftaran ditolak dan perlu direvisi |

## 📖 Skenario Demo (Walkthrough)

Anda dapat memperagakan 4 alur (*flow*) utama kepada pembimbing sebagai berikut:

### Alur 1: Pendaftaran Baru (Perwakilan Desa)
1. Buka `http://localhost:8000` dan klik **Mulai Gratis Sekarang / Daftar**.
2. Buat akun baru (contoh email: `desa-baru@gmail.com`).
3. Anda akan masuk ke halaman *Wizard* Pendaftaran (4 Langkah). 
4. Isi data acak, pilih template (Klasik/Modern), *upload* logo (opsional), dan daftarkan perangkat desa.
5. Klik **Kirim untuk Ditinjau**.

### Alur 2: Review Pendaftaran (Admin Provinsi)
1. _Logout_ dari akun perwakilan desa. _Login_ menggunakan akun Admin (`admin@jatimprov.go.id`).
2. Di Dashboard Admin, lihat tabel **Antrean Menunggu Review**. Desa yang baru didaftarkan tadi akan muncul.
3. Klik **Review**. Admin bisa melihat detail dan klik tombol **Lihat Preview Halaman** untuk melihat pratinjau tampilan publik sebelum tayang.
4. Klik **Setujui & Tayangkan**.

### Alur 3: Pengelolaan Konten (Perwakilan Desa)
1. _Logout_ dari Admin, lalu _login_ kembali sebagai akun desa yang baru saja disetujui (atau pakai akun demo `published@desa.id`).
2. Tampilan *Dashboard* berubah menjadi menu pengelolaan desa.
3. Coba tambah **Berita Baru** atau **Perangkat Desa**. Perubahan tidak butuh persetujuan admin lagi.

### Alur 4: Halaman Publik
1. Kunjungi rute `/desa/{slug}` (bisa diklik dari dashboard perwakilan desa melalui tombol **Lihat Halaman Publik**).
2. Buktikan bahwa perubahan berita/perangkat desa di Alur 3 sudah langsung ter-render sesuai template yang dipilih (Klasik / Modern).

---
*Dibangun dengan Laravel 11, Breeze, Tailwind CSS v4, dan standar PSR-12.*
