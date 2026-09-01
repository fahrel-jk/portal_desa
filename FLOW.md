# FLOW.md — Alur Portal Desa

Dokumen ini merinci setiap alur (flow) dalam sistem, sebagai acuan saat
membangun controller, route, dan state machine status. Baca bersama
`AGENTS.md` (skema data) dan `DESIGN.md` (tampilan tiap langkah).

---

## Alur 1 — Pendaftaran Desa (Wizard, oleh Perwakilan Desa)

```
[Registrasi Akun]
        |
        v
[Login sebagai perwakilan_desa]
        |
        v
[Wizard Langkah 1: Data Dasar]
  - Nama desa, kecamatan, kabupaten, alamat kantor
  - Sistem cek slug otomatis (preview: "desa Anda akan tayang di /desa/xxx")
        |
        v
[Wizard Langkah 2: Pilih Template]
  - Pilih salah satu: Klasik / Modern
  - Preview thumbnail masing-masing
        |
        v
[Wizard Langkah 3: Identitas Visual]
  - Upload logo desa
  - Upload foto hero/utama desa
        |
        v
[Wizard Langkah 4: Profil & Struktur]
  - Deskripsi/sejarah singkat desa
  - Daftar perangkat desa (nama, jabatan, foto opsional) — bisa tambah baris
  - Kontak (telepon, email, jam layanan)
        |
        v
[Review sebelum submit]
  - Tampilkan preview lengkap semua data dari 4 langkah
  - Tombol "Kirim untuk Ditinjau"
        |
        v
[Submit] --> status village: draft -> pending_review
        |
        v
[Notifikasi ke Admin Provinsi: ada pendaftaran baru]
[Notifikasi ke Perwakilan Desa: "Pendaftaran terkirim, menunggu tinjauan"]
```

**Catatan teknis:** progress wizard disimpan di session (bukan DB) sampai
langkah "Review" — supaya perwakilan desa bisa balik-balik antar langkah
tanpa membuat baris `villages` yang setengah jadi di database.

---

## Alur 2 — Review & Approval (oleh Admin Provinsi)

```
[Admin buka Dashboard]
        |
        v
[Lihat daftar antrean: status = pending_review]
        |
        v
[Klik salah satu desa] --> [Halaman Detail Review]
  - Tampilkan semua data yang diisi di Alur 1
  - Preview halaman desa APA ADANYA (render pakai template yang dipilih,
    tapi belum published/belum bisa diakses publik)
        |
        v
   [Admin memutuskan]
        |
   +----+----+
   |         |
[Approve]  [Reject]
   |         |
   v         v
status:    status:
published  rejected
approved_at  rejection_reason (wajib diisi)
   |         |
   v         v
[Notif ke     [Notif ke
perwakilan    perwakilan desa:
desa: "Desa   "Perlu revisi:
Anda sudah    <alasan>"]
tayang di
/desa/{slug}"]
                |
                v
        [Perwakilan desa bisa
        edit data & submit ulang]
        --> status: pending_review lagi
```

**Catatan teknis:** approval HANYA terjadi sekali di titik ini (publish
pertama kali). Setelah `published`, alur berikutnya (Alur 3) tidak melalui
proses approval ini lagi.

---

## Alur 3 — Update Konten Setelah Tayang (oleh Perwakilan Desa)

```
[Perwakilan desa login] --> [Dashboard Desa]
        |
        v
   [Pilih aksi]
        |
   +----+----+----+
   |    |    |    |
[Edit  [Kelola [Edit  [Kelola
Profil] Berita] Kontak] Perangkat]
   |    |    |    |
   v    v    v    v
[Simpan langsung ke DB]
   |
   v
[Perubahan LANGSUNG tayang di /desa/{slug} — tanpa approval ulang]
```

**Catatan teknis:** ini sengaja dibuat tanpa approval supaya operasional
harian desa tidak macet menunggu admin provinsi. Approval hanya relevan
untuk keputusan "boleh tayang publik atau tidak" di Alur 2, bukan untuk
tiap perubahan konten kecil.

---

## Alur 4 — Akses Publik ke Halaman Desa

```
[Warga buka /desa/{slug}]
        |
        v
[Sistem cari village berdasarkan slug]
        |
   +----+----+
   |         |
[Ditemukan,  [Tidak ditemukan ATAU
status =     status != published]
published]      |
   |             v
   v          [Tampilkan halaman
[Render        "Desa belum tersedia"
template       (404 friendly, bukan
sesuai         error teknis mentah)]
village.
template]
   |
   v
[Halaman desa tampil: Profil,
Berita, Layanan, Kontak — sesuai
data yang diisi & template pilihan]
```

---

## Alur 5 — Monitoring Adopsi (oleh Admin Provinsi)

```
[Admin buka halaman "Monitoring Adopsi"]
        |
        v
[Tampilkan agregat:
  - Total desa terdaftar (semua status)
  - Total desa published
  - Total desa pending_review
  - Grafik jumlah pendaftaran per bulan
  - Daftar desa yang published tapi belum update berita
    dalam X hari terakhir (indikator "kurang aktif")]
```

Ini fitur nice-to-have (bukan wajib di MVP) — kerjakan setelah Alur 1-4
selesai dan teruji.

---

## Alur 6 — Kontak & Feedback Publik (di luar rencana awal, ditambahkan kemudian)

Fitur ini ditambahkan setelah Alur 1-5 sudah tersusun. Tujuannya memberi
pengunjung landing page cara untuk mengirim pertanyaan/masukan kepada
Diskominfo tanpa perlu login.

```
[Warga/pengunjung buka landing page (/)]
        |
        v
[Scroll ke bagian "Hubungi Kami" / "Get in touch"]
        |
        v
[Isi form kontak: nama (wajib), email (wajib),
 telepon (opsional), pesan (wajib)]
        |
        v
[Submit] --> validasi server-side
        |
   +----+----+
   |         |
[GAGAL]   [BERHASIL]
   |         |
   v         v
[Tampilkan     [Simpan ke tabel `feedback`,
 error          kolom is_read = false (default)]
 validasi]         |
                   v
              [Tampilkan flash message:
               "Terima kasih! Pesan Anda telah kami terima..."]
```

### Sisi Admin Provinsi

```
[Admin login → Dashboard → menu "Kelola Pesan"]
        |
        v
[Tampilkan daftar feedback masuk (paginated, 10 per halaman),
 diurutkan terbaru lebih dulu]
        |
        v
[Admin klik "Tandai Sudah Dibaca" pada pesan tertentu]
        |
        v
[Update kolom is_read = true]
```

**Catatan teknis:**
- Model: `App\Models\Feedback` — field: `name`, `email`, `phone`, `message`,
  `is_read` (boolean, default false).
- Controller publik: `ContactController@store` — validasi dan simpan.
- Controller admin: `Admin\FeedbackController@index` (list) dan
  `@markAsRead` (update status).
- Route: `POST /contact` (publik), `GET /admin/feedback` dan
  `PATCH /admin/feedback/{feedback}/read` (admin only).
- Status hanya 2: `unread` (is_read=false) dan `read` (is_read=true).
- **Tidak ada notifikasi otomatis** ke admin saat pesan baru masuk — admin
  perlu mengecek halaman "Kelola Pesan" secara manual.

---

## Ringkasan State Machine `villages.status`

```
draft --(submit wizard)--> pending_review
pending_review --(admin approve)--> published
pending_review --(admin reject)--> rejected
rejected --(perwakilan desa edit + submit ulang)--> pending_review
published --(TIDAK bisa balik ke status lain lewat alur normal)
```

Tidak ada jalur dari `published` kembali ke status lain dalam scope
purwarupa ini — kalau nanti dibutuhkan (mis. admin ingin unpublish
sementara), itu pengembangan lanjutan, catat sebagai rekomendasi di laporan
evaluasi, jangan diimplementasikan sekarang supaya scope tetap terjaga.

