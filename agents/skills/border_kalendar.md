# Prompt Redesign Border Kalender Modern

Gunakan gambar referensi kalender yang saya lampirkan sebagai acuan struktur dan isi. Redesign **hanya tampilan kartu serta border kalender**, tanpa mengubah data, urutan acara, fungsi, atau informasi yang sudah tersedia.

## Tujuan desain

Buat daftar kalender terasa lebih modern, bersih, ringan, dan profesional. Hasil akhirnya harus tetap ramah untuk website desa, mudah dibaca oleh berbagai usia, serta tidak terlihat seperti desain buatan AI yang berlebihan.

## Bagian yang harus dipertahankan

Setiap kartu acara tetap memiliki:

- Kotak tanggal di sebelah kiri.
- Nama bulan dan angka tanggal.
- Label kategori dengan warna berbeda.
- Judul kegiatan.
- Ikon dan informasi waktu.
- Ikon dan informasi lokasi.
- Susunan daftar vertikal.
- Warna kategori yang sudah ada.
- Seluruh data dan fungsi asli.

Jangan menghapus, menambahkan, atau mengganti fitur. Jangan mengubah teks dan isi acara kecuali diperlukan untuk menyesuaikan pemenggalan baris pada layar kecil.

## Arah visual yang dipilih: Modern Card Refinement

### Kartu utama

- Gunakan latar putih atau warna permukaan netral yang sangat terang.
- Tambahkan border luar tipis sebesar `1px` dengan warna abu-abu lembut.
- Gunakan radius sekitar `16px` agar modern tetapi tidak terlalu membulat.
- Gunakan bayangan tipis dan menyebar, bukan bayangan gelap atau dramatis.
- Seluruh kartu harus terlihat sebagai satu kesatuan.
- Pastikan bagian tanggal dan isi acara memiliki tinggi yang sama.
- Gunakan `overflow: hidden` agar aksen dan latar tidak keluar dari sudut kartu.

### Kotak tanggal

- Letakkan di sisi kiri dengan lebar tetap sekitar `72px`.
- Gunakan warna latar kategori dengan opacity sangat rendah.
- Tambahkan garis aksen kategori selebar `4px` pada sisi paling kiri.
- Jangan memakai border tebal mengelilingi seluruh kotak tanggal.
- Jangan membuat kotak tanggal terlihat terpisah atau menumpuk di atas kartu utama.
- Nama bulan ditampilkan kecil dan semi-bold.
- Angka tanggal lebih besar, tebal, dan memiliki kontras tinggi.

### Isi acara

- Gunakan ruang dalam sekitar `12–16px`.
- Label kategori diletakkan di atas judul.
- Pertahankan titik warna kecil di depan label kategori.
- Judul harus menjadi informasi paling dominan setelah tanggal.
- Waktu dan lokasi menggunakan warna teks sekunder yang tetap mudah dibaca.
- Jarak antarelemen harus rapat namun tidak sesak.

### Interaksi

Saat pointer berada di atas kartu:

- Border menjadi sedikit lebih tegas.
- Bayangan bertambah sangat halus.
- Kartu dapat bergerak naik maksimal `1px`.
- Jangan menggunakan efek membesar, glow, atau animasi mencolok.
- Hormati pengaturan `prefers-reduced-motion`.

## Responsif

- Desain harus tetap rapi mulai lebar layar sekitar `320px`.
- Kotak tanggal tidak boleh mengecil atau berubah ukuran ketika judul panjang.
- Judul boleh turun ke baris berikutnya; jangan dipotong jika masih tersedia ruang vertikal.
- Waktu dan lokasi boleh berpindah ke baris berikutnya di layar sempit.
- Tidak boleh ada teks saling menimpa atau keluar dari kartu.

## Larangan desain

- Jangan gunakan glassmorphism berat.
- Jangan gunakan gradient mencolok.
- Jangan memakai border neon atau glow.
- Jangan membuat semua sudut terlalu bulat seperti kapsul.
- Jangan menggunakan bayangan hitam pekat.
- Jangan membuat kartu di dalam kartu.
- Jangan mengubah warna kategori menjadi satu warna yang sama.
- Jangan mengubah inti fitur atau struktur informasi kalender.

## Contoh CSS

Sesuaikan nama class dengan struktur proyek yang sudah ada. Jika proyek memiliki design token, gunakan token tersebut dan jangan mengganti sistem warna global.

```css
.calendar-list {
  display: grid;
  gap: 12px;
}

.calendar-card {
  --category-color: #e63737;
  --category-soft: #fff2f2;

  display: grid;
  grid-template-columns: 72px minmax(0, 1fr);
  min-height: 82px;
  overflow: hidden;
  border: 1px solid #e7ebe7;
  border-radius: 16px;
  background: #ffffff;
  box-shadow: 0 5px 18px rgba(28, 38, 31, 0.055);
  transition:
    border-color 180ms ease,
    box-shadow 180ms ease,
    transform 180ms ease;
}

.calendar-card:hover {
  border-color: #d7ddd8;
  box-shadow: 0 9px 24px rgba(28, 38, 31, 0.08);
  transform: translateY(-1px);
}

.calendar-date {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-width: 72px;
  padding: 12px 8px;
  background: var(--category-soft);
}

.calendar-date::before {
  position: absolute;
  inset: 0 auto 0 0;
  width: 4px;
  background: var(--category-color);
  content: "";
}

.calendar-month {
  color: var(--category-color);
  font-size: 11px;
  font-weight: 600;
  line-height: 1;
  text-transform: uppercase;
}

.calendar-day {
  margin-top: 4px;
  color: #18211b;
  font-size: 26px;
  font-weight: 700;
  line-height: 1;
}

.calendar-content {
  min-width: 0;
  padding: 12px 16px;
}

.calendar-category {
  display: flex;
  align-items: center;
  gap: 6px;
  color: var(--category-color);
  font-size: 11px;
  font-weight: 700;
  line-height: 1.2;
  text-transform: uppercase;
}

.calendar-category-dot {
  width: 6px;
  height: 6px;
  flex: none;
  border-radius: 999px;
  background: var(--category-color);
}

.calendar-title {
  margin: 4px 0 6px;
  color: #202820;
  font-size: 16px;
  font-weight: 700;
  line-height: 1.25;
}

.calendar-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 4px 16px;
  color: #687a92;
  font-size: 13px;
  line-height: 1.4;
}

.calendar-meta-item {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  min-width: 0;
}

.calendar-meta-item svg {
  width: 15px;
  height: 15px;
  flex: none;
}

@media (max-width: 420px) {
  .calendar-card {
    grid-template-columns: 66px minmax(0, 1fr);
  }

  .calendar-date {
    min-width: 66px;
  }

  .calendar-content {
    padding: 11px 12px;
  }

  .calendar-title {
    font-size: 15px;
  }

  .calendar-meta {
    gap: 3px 10px;
    font-size: 12px;
  }
}

@media (prefers-reduced-motion: reduce) {
  .calendar-card {
    transition: none;
  }

  .calendar-card:hover {
    transform: none;
  }
}
```

## Contoh penetapan warna kategori

Warna berikut hanya contoh. Prioritaskan warna kategori yang sudah digunakan oleh proyek.

```html
<article
  class="calendar-card"
  style="--category-color: #e63737; --category-soft: #fff2f2;"
>
  <!-- Isi kartu kesehatan -->
</article>

<article
  class="calendar-card"
  style="--category-color: #7c3aed; --category-soft: #f5f1ff;"
>
  <!-- Isi kartu gotong royong -->
</article>

<article
  class="calendar-card"
  style="--category-color: #ec4899; --category-soft: #fff1f7;"
>
  <!-- Isi kartu sosial dan budaya -->
</article>

<article
  class="calendar-card"
  style="--category-color: #059669; --category-soft: #ecfdf5;"
>
  <!-- Isi kartu keagamaan -->
</article>
```

## Instruksi implementasi untuk agentic AI

1. Pelajari komponen kalender yang sudah ada sebelum mengubah kode.
2. Pertahankan data, pemetaan kategori, event handler, tautan, dan logika yang telah bekerja.
3. Ubah hanya class, style, atau komponen presentasi yang berkaitan dengan kartu kalender.
4. Gunakan sistem warna dan komponen desain proyek jika sudah tersedia.
5. Jangan menambahkan library baru jika perubahan dapat dibuat dengan CSS yang sudah digunakan proyek.
6. Pastikan aksesibilitas keyboard dan kontras warna tetap baik.
7. Uji minimal pada lebar layar `320px`, `390px`, `768px`, dan desktop.
8. Pastikan tidak ada teks yang terpotong, bertumpuk, atau keluar dari kartu.
9. Bandingkan hasil akhir dengan gambar referensi: struktur harus tetap sama, tetapi border terlihat lebih ringan, presisi, dan modern.

## Kriteria hasil akhir

Redesign dianggap berhasil apabila:

- Semua informasi asli masih tersedia dan berfungsi.
- Garis kategori di kiri terlihat jelas tanpa terasa berat.
- Border kartu tipis dan konsisten.
- Kotak tanggal menyatu dengan kartu utama.
- Bayangan hanya memberi kedalaman ringan.
- Judul panjang tetap mudah dibaca pada perangkat seluler.
- Tampilan terlihat dibuat secara sengaja dan profesional, bukan sebagai template AI generik.
