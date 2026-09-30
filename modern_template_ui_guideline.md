# Mini UI Guideline — Template Modern (Portal Desa)

Dokumen ini berisi panduan UI, token desain, konvensi komponen, serta aturan integrasi Blade/React untuk **Template Modern** pada platform Portal Desa.

---

## 1. Identitas Desain & Konsep Visual

* **Konsep:** Clean, organic SaaS-inspired multi-tenant design dengan gaya modern glassmorphism.
* **Karakter Visual:** Modern, ramah publik, responsif, dengan sudut melengkung halus (*rounded corners*), batas (*border*) bernuansa transparan, dan tipografi kontras.
* **Target:** Halaman profil desa publik yang responsif untuk berbagai ukuran layar (mobile, tablet, desktop).

---

## 2. Tipografi & Hirarki Teks

Template Modern menggunakan kombinasi dua font Google Fonts:

| Peran | Font Family | Weight | Karakteristik / CSS Rules |
|---|---|---|---|
| **Headings** (H1–H6) | `'Outfit'`, sans-serif | 600, 700, 800 | `letter-spacing: -0.025em; line-height: 1.15; color: var(--fg);` |
| **Body Text** | `'Figtree'`, sans-serif | 400, 500, 600 | `line-height: 1.65; color: var(--fg);` |
| **Eyebrow / Badge** | `'Figtree'`, sans-serif | 700 | `font-size: 0.6875rem (11px); letter-spacing: 0.15em; text-transform: uppercase; color: var(--primary);` |

---

## 3. Palet Warna & Sistem Tema Dynamic (`CSS Custom Properties`)

Tema disuntikkan secara dinamis dari database Laravel (`$village->theme_color`) ke `:root` melalui CSS Variables.

### Daftar Variable `:root`

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
}
```

### 4 Presets Tema bawaan

| Nama Preset Tema | Subtitle / Karakter | Background (`--bg`) | Text (`--fg`) | Accent / Primary (`--primary`) |
|---|---|---|---|---|
| `sumberan-sage` *(Default)* | Earthy Organic / Sage & Terracotta | `#eef0ea` | `#2a2f23` | `#c4654a` |
| `laut-senja` | Fresh Coastal / Teal & Amber | `#f0f2f5` | `#1e293b` | `#0f766e` |
| `kopi-susu` | Warm Coffee / Warm Earth & Cream | `#f5f0eb` | `#43302b` | `#8c5a45` |
| `monokrom-elegan` | Slate / Minimalist Dark Slate | `#f8fafc` | `#0f172a` | `#334155` |

---

## 4. Sistem Layout & Spacing

* **Container Max Width:** `1120px` (`max-w-[1120px] mx-auto`)
* **Outer Section Padding:**
  * Mobile: `1.5rem 1rem` (24px vertikal, 16px horizontal)
  * Desktop: `2.5rem 1.5rem` (40px vertikal, 24px horizontal)
* **Inner Card Spacing / Padding:**
  * Standard Card Padding: `p-6` hingga `p-7` (24px–28px) untuk memberi *breathing room* yang luas.
  * Card Gap Grid: `gap-6` (24px).
* **Border Radius Standards:**
  * Large Container / Hero / Main Cards: `1.25rem` (20px) — `rounded-2xl`
  * Buttons / Badges / Input Pill: `0.75rem` (12px) hingga `1rem` (16px)

---

## 5. Spesifikasi Komponen (UI Tokens)

### A. Floating Navbar Pill (`.navbar-pill`)
* **Background:** `rgba(255, 255, 255, 0.85)`
* **Backdrop Filter:** `blur(24px)`
* **Border:** `1px solid rgba(255, 255, 255, 0.8)`
* **Shadow:** `0 4px 20px rgba(0,0,0,0.05)`
* **Radius:** `9999px` (Full Pill)

### B. Cards Utama (`.card`)
* **Background:** `var(--card)`
* **Border:** `1px solid var(--border)`
* **Radius:** `1.25rem` (20px)
* **Inner Padding:** `p-6` / `p-7`

### C. Tombol Aksi (`.btn-primary` & `.btn-ghost`)
```css
/* Primary Button */
.btn-primary {
  background-color: var(--primary);
  color: var(--primary-fg);
  font-weight: 600;
  border-radius: 0.75rem;
  padding: 0.75rem 1.75rem;
  font-size: 0.9375rem;
  transition: all 0.2s ease;
}
.btn-primary:hover {
  filter: brightness(1.08);
  box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 30%, transparent);
}

/* Ghost Button */
.btn-ghost {
  background-color: transparent;
  color: var(--fg);
  font-weight: 600;
  border-radius: 0.75rem;
  padding: 0.75rem 1.75rem;
  border: 1px solid var(--border);
}
```

---

## 6. Spesifikasi Komponen Berita (`CardNews` / React Integration)

Berdasarkan komponen `CardNews` (`card-news.tsx`):

* **Ukuran Card:** Fixed height `h-[420px]` / `min-h-[420px]`
* **Gambar Latar (Cover Image):** `object-cover w-full h-full transform group-hover:scale-105 transition-transform duration-500`
* **Gradient Overlay Dark:** `bg-gradient-to-t from-black/85 via-black/40 to-transparent` (memastikan kontras teks putih optimal).
* **Inner Container Padding:** `p-7` (28px dari tepi border).
* **Kepadatan Teks & Spacing:**
  * Gap antar elemen: `space-y-4`
  * Ruang Atas (Top Spacer): `h-32`
  * Judul: `text-xl font-bold line-clamp-2` dengan `style={{ color: '#ffffff' }}`
  * Ringkasan Berita: `text-sm text-gray-200 line-clamp-2`
* **Animasi Hover (Reveal Action Bar):**
  * Bar Tanggal & Tombol Detail disembunyikan secara default (`opacity-0 translate-y-4`).
  * Saat kursor diarahkan ke card (`group-hover`), bar ini meluncur naik: `group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300`.

---

## 7. Spesifikasi Komponen FAQ (`FaqPro` / React Integration)

Berdasarkan komponen `FaqPro` (`faq-pro.tsx`):

* **Container Outer Padding:** `p-8` / `px-8 py-6`
* **Accordion Container:** `rounded-2xl border border-[var(--border)] bg-white/70 backdrop-blur-sm shadow-sm`
* **Search Input Bar:**
  * Height: `h-14`
  * Icon Search: `lucide-react` Search icon di sebelah kiri (`pl-12`)
  * Radius: `rounded-2xl`
* **State Animation:** Motion spring animations (`type: "spring", stiffness: 300, damping: 30`).

---

## 8. Catatan Khusus Developer & Integrasi

> [!IMPORTANT]
> **Aturan Kontras Judul di Komponen React:**
> Blade template modern menetapkan CSS global `h1, h2, h3, h4, h5, h6 { color: var(--fg); }`. Saat membuat komponen React dengan latar gelap/overlay (seperti Card News), **selalu gunakan inline style `style={{ color: '#ffffff' }}`** pada tag heading (`<h3>`, `<h2>`, dll) agar tidak tertimpa oleh warna `--fg` global.

> [!TIP]
> **Sistem Interop Tema:**
> Jangan memasang theme switcher lokal independen di komponen React. Biarkan komponen React mewarisi CSS custom variables (`var(--bg)`, `var(--primary)`, `var(--border)`) dari environment Blade template.
