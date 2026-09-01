# Alur 3 — Update Konten Setelah Tayang

## Aktor
**Perwakilan Desa** (yang desanya sudah berstatus `published`)

## Prasyarat
- Desa sudah berstatus `published`

## Langkah-langkah

### 1. Login ke Dashboard
Perwakilan desa login dan masuk ke dashboard. Terlihat status "Sudah Tayang" beserta link ke halaman publik.

### 2. Pilih Aksi
Dashboard menampilkan 3 tombol aksi cepat:

#### Edit Profil
- Ubah deskripsi/sejarah, kontak, jam layanan, alamat
- Perubahan langsung tersimpan ke database

#### Kelola Berita
- Tambah berita baru (judul, konten, cover image)
- Edit/hapus berita yang sudah ada

#### Kelola Perangkat Desa
- Tambah/edit/hapus data perangkat desa
- Ubah urutan tampilan

### 3. Hasil
Semua perubahan **langsung tayang** di halaman publik `/desa/{slug}` tanpa memerlukan approval admin.

## Catatan Teknis
- Sengaja dibuat tanpa approval agar operasional harian desa tidak macet menunggu admin
- Approval hanya relevan untuk keputusan "boleh tayang publik atau tidak" (Alur 2)
