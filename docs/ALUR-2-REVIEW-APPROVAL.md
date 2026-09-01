# Alur 2 — Review & Approval

## Aktor
**Admin Provinsi** (Diskominfo Jawa Timur)

## Prasyarat
- Ada desa dengan status `pending_review` di antrean

## Langkah-langkah

### 1. Buka Dashboard Admin
Admin login dan masuk ke dashboard (`/admin/dashboard`). Terlihat kartu statistik dan tabel antrean desa yang menunggu review.

### 2. Review Detail Desa
Admin klik **"Review"** pada salah satu desa. Halaman detail menampilkan:
- Semua data yang diisi perwakilan desa (profil, perangkat, kontak)
- Tombol **"Preview Tampilan Publik"** untuk melihat pratinjau halaman desa sesuai template yang dipilih

### 3. Keputusan Admin

#### Jika Disetujui (Approve)
- Status berubah: `pending_review` → `published`
- `approved_at` dan `approved_by` terisi otomatis
- Halaman `/desa/{slug}` langsung bisa diakses publik
- Notifikasi dikirim ke perwakilan desa: *"Desa Anda sudah tayang!"*

#### Jika Ditolak (Reject)
- Status berubah: `pending_review` → `rejected`
- Admin **wajib** mengisi `rejection_reason`
- Notifikasi dikirim ke perwakilan desa: *"Perlu revisi: [alasan]"*
- Perwakilan desa bisa edit data → submit ulang → status kembali ke `pending_review`

## State Machine

```
pending_review ──(admin approve)──> published
pending_review ──(admin reject)──> rejected
rejected ──(perwakilan edit + submit ulang)──> pending_review
```

## Catatan Teknis
- Approval hanya terjadi **sekali** (publish pertama kali)
- Setelah `published`, update konten tidak memerlukan approval lagi (lihat Alur 3)
