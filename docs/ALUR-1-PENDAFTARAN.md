# Alur 1 — Pendaftaran Desa (Wizard)

## Aktor
**Perwakilan Desa** (Kepala Desa / Lurah / Operator Desa)

## Prasyarat
- Perwakilan desa sudah memiliki akun dengan role `perwakilan_desa`
- Belum ada data desa terdaftar untuk akun tersebut

## Langkah-langkah

### 1. Registrasi Akun
Perwakilan desa membuat akun baru melalui halaman `/register`.

### 2. Login
Masuk menggunakan email & password yang didaftarkan.

### 3. Wizard Langkah 1: Data Dasar
- Nama desa
- Kecamatan
- Kabupaten
- Alamat kantor
- Sistem akan menampilkan preview slug otomatis: *"Desa Anda akan tayang di `/desa/xxx`"*

### 4. Wizard Langkah 2: Pilih Template
- Pilih salah satu template: **Klasik** atau **Modern**
- Thumbnail preview ditampilkan untuk masing-masing template

### 5. Wizard Langkah 3: Identitas Visual
- Upload logo desa (opsional)
- Upload foto hero/utama desa (opsional)

### 6. Wizard Langkah 4: Profil & Struktur
- Deskripsi / sejarah singkat desa
- Daftar perangkat desa: nama, jabatan, foto (opsional) — bisa tambah/hapus baris
- Kontak: telepon, email, jam layanan

### 7. Review & Submit
- Tampilan preview lengkap dari semua data 4 langkah
- Klik **"Kirim untuk Ditinjau"**
- Status desa berubah: `draft` → `pending_review`
- Notifikasi dikirim ke Admin Provinsi & Perwakilan Desa

## State Machine

```
draft ──(submit wizard)──> pending_review
```

## Catatan Teknis
- Progress wizard disimpan di **session** (bukan database) sampai langkah submit
- Perwakilan desa bisa kembali ke langkah sebelumnya tanpa kehilangan data
- Slug di-generate otomatis dari nama desa dengan penanganan collision
