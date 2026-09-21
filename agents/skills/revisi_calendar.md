# Prompt Agentic AI — Redesign Kalender Agenda Liquid Glass

## Peran

Kamu adalah **senior product designer sekaligus frontend engineer**. Tugasmu adalah mendesain ulang halaman **Kalender Agenda Desa Sumberan** agar terasa modern, ramah publik, responsif, dan memiliki karakter **organic liquid glass** yang tetap konsisten dengan mini UI guideline Portal Desa.

Kerjakan langsung pada codebase yang tersedia. Jangan berhenti di tahap analisis, wireframe, atau rekomendasi. Periksa struktur proyek, identifikasi file halaman kalender dan design system yang aktif, lalu implementasikan, jalankan pemeriksaan yang relevan, dan validasi hasilnya pada desktop serta mobile.

---

## Tujuan Utama

Ubah halaman kalender agenda menjadi tampilan dua kolom:

1. **Kolom kiri:** kalender interaktif dalam panel liquid glass.
2. **Kolom kanan:** daftar agenda mendatang yang mudah dipindai.

Kalender harus memiliki titik-titik berwarna sebagai penanda tanggal yang mempunyai kegiatan. Saat tanggal dipilih, tampilkan detail agenda tanggal tersebut di bawah grid kalender.

---

## Aturan Visual yang Wajib Dipatuhi

### 1. Gradasi hanya boleh berada di panel kalender

Ini adalah aturan paling penting:

- Terapkan gradasi lembut **hanya pada latar panel kalender**.
- Jangan pasang gradasi pada `body`, halaman utama, navbar, daftar agenda, kartu agenda, atau section lain.
- Latar halaman harus berupa warna solid `#eef0ea`.
- Navbar dan kartu agenda boleh memakai efek kaca transparan serta blur, tetapi **tanpa gradient**.
- Hindari decorative gradient orb, bokeh, glow besar, atau wash yang menyebar ke seluruh halaman.

Contoh yang benar:

```css
body {
  background: var(--bg);
}

.calendar-glass {
  background: linear-gradient(
    145deg,
    rgba(255, 255, 255, 0.76),
    rgba(232, 168, 124, 0.22)
  );
  backdrop-filter: blur(28px) saturate(135%);
  -webkit-backdrop-filter: blur(28px) saturate(135%);
}
```

Contoh yang dilarang:

```css
body,
.page,
main {
  background-image: linear-gradient(...);
}
```

### 2. Gunakan palet Sage Terracotta dari guideline

```css
:root {
  --bg: #eef0ea;
  --fg: #2a2f23;
  --card: #ffffff;
  --card-fg: #2a2f23;
  --primary: #c4654a;
  --primary-fg: #ffffff;
  --secondary: #87a878;
  --secondary-fg: #ffffff;
  --muted: #d7dacb;
  --muted-fg: #5c6652;
  --accent: #e8a87c;
  --accent-fg: #3d2b1f;
  --border: rgba(42, 47, 35, 0.10);

  --glass: rgba(255, 255, 255, 0.56);
  --glass-strong: rgba(255, 255, 255, 0.76);
  --glass-border: rgba(255, 255, 255, 0.82);
  --shadow-glass:
    0 24px 70px -32px rgba(42, 47, 35, 0.34),
    inset 0 1px 0 rgba(255, 255, 255, 0.90);
}
```

Jika proyek sudah memakai semantic design tokens atau format warna lain seperti OKLCH, konversikan nilai ini dan tetap gunakan token. Jangan menyebarkan warna hardcoded ke komponen.

### 3. Tipografi

- Heading: `Outfit`, bobot 600, 700, dan 800.
- Body: `Figtree`, bobot 400, 500, 600, dan 700.
- Eyebrow: 11px, bold, uppercase, letter spacing `0.15em`, warna primary.
- Jangan gunakan Inter atau Poppins.

### 4. Layout dan ukuran

- Lebar konten maksimum: `1120px`.
- Desktop: grid dua kolom, kalender sekitar `380px`, agenda memakai sisa lebar.
- Mobile: susun vertikal; kalender berada di atas daftar agenda.
- Padding horizontal: 16px pada mobile, 24px pada desktop.
- Radius panel utama dan kartu: 20px.
- Jangan menaruh kartu di dalam kartu secara berlebihan.

---

## Struktur Halaman

### Navbar

Buat navbar mengambang berbentuk pill:

- Posisi sticky di bagian atas.
- Latar kaca putih transparan tanpa gradasi.
- `backdrop-filter: blur(24px)`.
- Border putih transparan.
- Tinggi sekitar 64px.
- Brand **Desa Sumberan** di kiri.
- Navigasi desktop di tengah.
- Tombol **Hubungi kami** di kanan.
- Tombol menu ikon pada mobile.

### Intro halaman

Tampilkan:

- Eyebrow: `AGENDA WARGA`
- Heading: `Kalender Agenda`
- Deskripsi: `Pantau kegiatan sosial, pembangunan, dan budaya di lingkungan Desa Sumberan.`

Jangan bungkus bagian intro dalam kartu.

### Panel kalender

Panel kalender harus:

- Menjadi satu-satunya area dengan gradasi.
- Memiliki efek liquid glass yang halus, tidak berlebihan.
- Menampilkan bulan `September` dan tahun `2026`.
- Memiliki tombol ikon bulan sebelumnya dan berikutnya dengan tooltip.
- Menampilkan header hari `Sen, Sel, Rab, Kam, Jum, Sab, Min`.
- Menampilkan tanggal dalam grid 7 kolom dengan ukuran stabil.
- Tanggal yang memiliki agenda diberi titik kecil berwarna di bawah angka.
- Tanggal aktif tampil sebagai bidang penuh berwarna terracotta.
- Titik pada tanggal aktif berubah putih agar tetap kontras.
- Klik tanggal mengubah detail agenda di bawah kalender.
- Jika tidak ada agenda, tampilkan `Tidak ada agenda pada tanggal ini.`

### Daftar agenda

Tampilkan judul `Daftar Agenda Mendatang` dan badge jumlah kegiatan.

Setiap agenda harus memiliki:

- Blok tanggal yang ringkas.
- Kategori.
- Jam dengan ikon.
- Lokasi dengan ikon.
- Judul kegiatan.
- Ringkasan maksimal dua baris.
- Garis aksen vertikal berwarna di sisi kiri.
- Latar kaca putih transparan **tanpa gradasi**.
- Hover naik sekitar 2px jika pengguna tidak mengaktifkan reduced motion.

---

## Data Contoh

Gunakan data ini bila codebase belum memiliki data agenda:

```ts
type AgendaTone =
  | "primary"
  | "secondary"
  | "blue"
  | "violet"
  | "pink"
  | "accent";

type Agenda = {
  day: number;
  title: string;
  category: string;
  time: string;
  location: string;
  description: string;
  tone: AgendaTone;
};

const agendas: Agenda[] = [
  {
    day: 17,
    title: "Musyawarah Perencanaan Pembangunan Desa",
    category: "Musyawarah",
    time: "09:00 – 12:00",
    location: "Balai Desa Sumberan",
    description:
      "Musyawarah rutin desa membahas rencana pembangunan dan prioritas anggaran semester berikutnya.",
    tone: "blue",
  },
  {
    day: 18,
    title: "Kerja Bakti Rutin Warga",
    category: "Umum",
    time: "14:00 – 16:00",
    location: "Lingkungan RT/RW",
    description:
      "Kerja bakti rutin untuk menjaga kebersihan dan kenyamanan lingkungan desa.",
    tone: "secondary",
  },
  {
    day: 20,
    title: "Festival Budaya Sumberan",
    category: "Sosial & Budaya",
    time: "08:00 – 11:00",
    location: "Lapangan Desa",
    description:
      "Perayaan budaya lokal bersama warga dan pelaku seni Desa Sumberan.",
    tone: "primary",
  },
  {
    day: 22,
    title: "Penyuluhan Pertanian Organik",
    category: "Pertanian",
    time: "07:00 – 10:00",
    location: "Balai Pertemuan",
    description:
      "Penyuluhan praktik pertanian organik bagi kelompok tani desa.",
    tone: "violet",
  },
  {
    day: 24,
    title: "Lomba Poskamling",
    category: "Keamanan",
    time: "18:00 – selesai",
    location: "Seluruh Dusun",
    description:
      "Kegiatan kebersamaan warga untuk memperkuat keamanan antar dusun.",
    tone: "pink",
  },
  {
    day: 25,
    title: "Pasar Tani Jumat",
    category: "Ekonomi Desa",
    time: "06:30 – 10:00",
    location: "Halaman Balai Desa",
    description: "Pasar hasil panen dan produk olahan warga Desa Sumberan.",
    tone: "secondary",
  },
  {
    day: 27,
    title: "Senam Sehat Bersama",
    category: "Kesehatan",
    time: "06:00 – 07:30",
    location: "Lapangan Desa",
    description: "Senam pagi terbuka bagi seluruh warga dan keluarga.",
    tone: "primary",
  },
  {
    day: 29,
    title: "Kelas UMKM Desa",
    category: "Pelatihan",
    time: "13:00 – 15:00",
    location: "Ruang Serbaguna",
    description:
      "Pelatihan pengemasan dan pemasaran digital untuk pelaku usaha desa.",
    tone: "accent",
  },
];
```

---

## Referensi Implementasi CSS

Adaptasikan contoh berikut dengan sistem token dan utility proyek yang sudah ada. Jangan mengganti arsitektur framework hanya untuk mengikuti contoh.

```css
:root {
  --bg: #eef0ea;
  --fg: #2a2f23;
  --primary: #c4654a;
  --primary-fg: #ffffff;
  --secondary: #87a878;
  --muted: #d7dacb;
  --muted-fg: #5c6652;
  --accent: #e8a87c;
  --border: rgba(42, 47, 35, 0.10);
  --glass: rgba(255, 255, 255, 0.56);
  --glass-strong: rgba(255, 255, 255, 0.76);
  --glass-border: rgba(255, 255, 255, 0.82);
  --calendar-gradient: linear-gradient(
    145deg,
    rgba(255, 255, 255, 0.76),
    rgba(232, 168, 124, 0.22)
  );
  --shadow-glass:
    0 24px 70px -32px rgba(42, 47, 35, 0.34),
    inset 0 1px 0 rgba(255, 255, 255, 0.90);
}

body {
  min-width: 320px;
  background: var(--bg); /* solid, jangan gunakan gradient */
  color: var(--fg);
  font-family: "Figtree", sans-serif;
}

h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: "Outfit", sans-serif;
}

.soft-glass {
  background: var(--glass); /* solid transparan, bukan gradient */
  border: 1px solid var(--glass-border);
  backdrop-filter: blur(20px) saturate(125%);
  -webkit-backdrop-filter: blur(20px) saturate(125%);
  box-shadow: var(--shadow-glass);
}

.calendar-glass {
  background: var(--calendar-gradient); /* satu-satunya gradient halaman */
  border: 1px solid var(--glass-border);
  backdrop-filter: blur(28px) saturate(135%);
  -webkit-backdrop-filter: blur(28px) saturate(135%);
  box-shadow: var(--shadow-glass);
}

@media (prefers-reduced-motion: no-preference) {
  .agenda-row {
    transition:
      transform 220ms ease,
      background-color 220ms ease,
      border-color 220ms ease;
  }

  .agenda-row:hover {
    transform: translateY(-2px);
  }
}
```

---

## Referensi Implementasi React untuk Grid Kalender

Gunakan komponen tombol dari design system proyek, bukan `<button>` mentah, jika komponen tersebut tersedia.

```tsx
const calendarDays = Array.from({ length: 30 }, (_, index) => index + 1);

function CalendarGrid({
  agendas,
  selectedDay,
  onSelectDay,
}: {
  agendas: Agenda[];
  selectedDay: number;
  onSelectDay: (day: number) => void;
}) {
  return (
    <div className="mt-3 grid grid-cols-7 gap-y-1 text-center text-sm font-semibold">
      <span aria-hidden="true" />

      {calendarDays.map((day) => {
        const event = agendas.find((agenda) => agenda.day === day);
        const active = selectedDay === day;

        return (
          <Button
            key={day}
            type="button"
            variant="ghost"
            size="icon"
            onClick={() => onSelectDay(day)}
            className={cn(
              "relative mx-auto size-10 rounded-xl",
              active
                ? "bg-primary text-primary-foreground shadow-lg shadow-primary/25 hover:bg-primary/90"
                : "hover:bg-glass-strong",
            )}
            aria-label={`${day} September${event ? `, ${event.title}` : ""}`}
            aria-pressed={active}
          >
            {day}

            {event ? (
              <span
                aria-hidden="true"
                className={cn(
                  "absolute bottom-1 size-1.5 rounded-full",
                  active ? "bg-primary-foreground" : toneClasses[event.tone].dot,
                )}
              />
            ) : null}
          </Button>
        );
      })}
    </div>
  );
}
```

Contoh mapping warna titik dan garis agenda:

```ts
const toneClasses: Record<
  Agenda["tone"],
  { dot: string; badge: string; line: string }
> = {
  primary: {
    dot: "bg-primary",
    badge: "bg-primary/10 text-primary",
    line: "border-primary",
  },
  secondary: {
    dot: "bg-secondary",
    badge: "bg-secondary/15 text-muted-foreground",
    line: "border-secondary",
  },
  blue: {
    dot: "bg-event-blue",
    badge: "bg-event-blue/10 text-event-blue",
    line: "border-event-blue",
  },
  violet: {
    dot: "bg-event-violet",
    badge: "bg-event-violet/10 text-event-violet",
    line: "border-event-violet",
  },
  pink: {
    dot: "bg-event-pink",
    badge: "bg-event-pink/10 text-event-pink",
    line: "border-event-pink",
  },
  accent: {
    dot: "bg-accent",
    badge: "bg-accent/15 text-accent-foreground",
    line: "border-accent",
  },
};
```

---

## Interaksi dan Aksesibilitas

- Semua tanggal dapat dipilih dengan keyboard.
- Gunakan `aria-pressed` untuk tanggal aktif.
- `aria-label` tanggal harus menyebutkan judul kegiatan jika ada.
- Tombol navigasi bulan wajib memiliki label yang jelas dan tooltip.
- Pastikan fokus keyboard terlihat.
- Pastikan kontras teks cukup pada kaca transparan dan tanggal aktif.
- Hormati `prefers-reduced-motion`.
- Tidak boleh ada teks, ikon, atau tombol yang saling bertumpuk pada layar kecil.

---

## Batasan Implementasi

- Pertahankan framework, router, dan design system yang sudah dipakai proyek.
- Gunakan komponen UI yang sudah tersedia untuk tombol dan tooltip.
- Jangan menambahkan backend, login, database, atau fitur di luar redesign kalender.
- Jangan membuat landing page baru.
- Jangan mengubah isi navigasi utama selain yang dibutuhkan agar tampilan responsif.
- Jangan menggunakan gradient di luar panel kalender.
- Jangan menambahkan gambar dekoratif, blob, orb, atau ilustrasi yang tidak diminta.
- Jangan hardcode warna di banyak komponen; pusatkan pada semantic design tokens.
- Jika halaman sudah memiliki data agenda, pertahankan data aktual dan hanya ubah presentasinya.

---

## Langkah Kerja Agentic

1. Audit file halaman kalender, stylesheet global, token tema, serta komponen tombol dan tooltip.
2. Pertahankan struktur proyek dan pola kode yang sudah ada.
3. Tambahkan atau sesuaikan semantic tokens Sage Terracotta dan liquid glass.
4. Pastikan `body` memakai warna solid dan hapus gradient global bila ada.
5. Terapkan gradient hanya pada class atau container kalender.
6. Bangun kalender interaktif dengan titik warna kegiatan dan detail tanggal terpilih.
7. Bangun daftar agenda dua kolom yang berubah menjadi satu kolom di mobile.
8. Pastikan metadata halaman tetap relevan dengan Kalender Agenda Desa Sumberan.
9. Jalankan pemeriksaan proyek yang tersedia.
10. Validasi secara visual pada desktop sekitar 1280px dan mobile sekitar 390px.
11. Uji klik beberapa tanggal dengan dan tanpa agenda.
12. Periksa console dan pastikan tidak ada error.
13. Jika menemukan masalah, perbaiki dan ulangi validasi sebelum menyatakan selesai.

---

## Kriteria Selesai

Pekerjaan dianggap selesai hanya jika:

- [ ] Halaman terasa seperti organic liquid glass dan tetap ramah untuk portal publik.
- [ ] Palet Sage Terracotta digunakan secara konsisten.
- [ ] Font Outfit dan Figtree digunakan sesuai peran.
- [ ] Latar halaman berwarna solid `#eef0ea`.
- [ ] Gradasi hanya terlihat di panel kalender.
- [ ] Navbar dan kartu agenda tidak memiliki gradasi.
- [ ] Tanggal yang memiliki kegiatan menampilkan titik berwarna.
- [ ] Tanggal aktif mudah dikenali dan titiknya tetap kontras.
- [ ] Detail agenda berubah ketika tanggal dipilih.
- [ ] Tanggal tanpa agenda menampilkan empty state.
- [ ] Tampilan dua kolom rapi di desktop dan satu kolom rapi di mobile.
- [ ] Tidak ada overflow horizontal atau elemen yang tumpang tindih.
- [ ] Navigasi keyboard dan fokus terlihat berfungsi.
- [ ] Tidak ada error pada pemeriksaan proyek atau browser console.

Setelah semua selesai, berikan ringkasan singkat berisi file yang diubah, hasil utama, dan validasi yang dilakukan. Jangan hanya memberikan instruksi atau potongan kode—implementasikan hasil akhirnya langsung di codebase.
