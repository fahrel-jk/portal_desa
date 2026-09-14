# Tugas 1 – Analisis Literatur Penelitian Terdahulu

**Nama**: [Isi Nama Anda]
**NIM**: [Isi NIM Anda]
**Kelas**: [Isi Kelas Anda]

---

### A. Topik (Judul Sementara)
**Pengembangan Platform *Software as a Service* (SaaS) untuk Sistem Informasi dan Layanan Administrasi Desa Terintegrasi**

---

### B. Tabel Analisis Penelitian Terdahulu

| No | Penulis & Tahun | Judul | Metode | Hasil Penelitian | Keterbatasan |
|:---|:---|:---|:---|:---|:---|
| 1 | Mirza, Yaser (2021) | Challenges for Public Sector Organisations in Cloud Adoption: A Case Study of South Australian Public Sector Agency | Studi Kasus / Kualitatif | Mengidentifikasi bahwa tantangan utama sektor publik (pemerintah lokal) dalam adopsi cloud/SaaS meliputi keamanan data, privasi, kurangnya keahlian IT internal, dan integrasi dengan sistem lama (legacy). | Studi kasus terbatas pada konteks pemerintahan Australia Selatan, regulasi dan kesiapannya mungkin berbeda dengan negara berkembang. |
| 2 | Said, Ramisha (2023) | Cloud-Based Government Services: Enhancing Public Sector Operations | Studi Literatur / Deskriptif Kualitatif | Sistem informasi berbasis cloud mempercepat layanan sektor publik (pemerintah daerah) serta mengurangi hambatan birokrasi dan biaya pemeliharaan IT. | Belum membahas mekanisme kustomisasi *multi-tenant* yang dibutuhkan agar sistem bisa beradaptasi ke entitas spesifik seperti desa. |
| 3 | Nur, R.M., & Rodiyah, I. (2025) | Efektivitas Sistem Informasi Desa dalam Meningkatkan Keterbukaan Informasi Publik di Desa Larangan | Kualitatif / Studi Kasus | Sistem Informasi Desa terbukti efektif meningkatkan transparansi administrasi dan akses informasi publik masyarakat secara real-time. | Evaluasi dampak hanya dilakukan pada satu desa, aplikasi dibangun *stand-alone* sehingga repot jika dikelola tanpa SDM IT desa. |
| 4 | Haries Muhammad (2025) | Sistem Informasi Dokumen Proposal Pembangunan Desa Berbasis Website Pada Kantor Kepala Desa Reungkam | Prototyping / *SDLC Waterfall* | Menghasilkan platform website yang mendigitalisasi arsip dokumen pemerintahan dan proposal di tingkat desa secara spesifik. | Sistem dibangun monolitik (1 *source code* untuk 1 desa). Biaya *setup* awal tinggi jika harus direplikasi untuk desa lain. |
| 5 | Doni, D., & Saimi, S. (2026) | Pemanfaatan Sistem Informasi Desa (SID) terhadap Peningkatan Pelayanan Publik di Desa Penyampak dan Desa Tebing | Kualitatif Deskriptif | Digitalisasi administrasi publik desa mengurangi proses layanan manual (persuratan dsb) sehingga meningkatkan kepuasan masyarakat luas. | Aplikasi belum diimplementasikan dengan arsitektur SaaS mandiri, sehingga masih butuh instalasi manual per-desa. |

---

### C. Tabel Posisi Penelitian Setelah Ditemukan Gap

| Aspek | Penelitian Terdahulu | Penelitian yang Diusulkan |
|:---|:---|:---|
| **Topik/Fokus** | Pemanfaatan *cloud* untuk layanan publik secara umum dan digitalisasi administrasi untuk satu atau beberapa desa spesifik. | Pengembangan Sistem Informasi Desa (SID) dengan penerapan arsitektur *SaaS Multi-tenant* berbasis *cloud*. |
| **Metode** | Studi literatur implementasi *cloud* & metode studi kasus perancangan website desa berbasis *stand-alone*. | Pengembangan sistem (SDLC) yang mengakomodasi desain sistem tersentralisasi (*path-based routing*) untuk melayani banyak desa sekaligus. |
| **Fokus Penelitian** | Transparansi, efektivitas persuratan lokal, dan kesiapan infrastruktur untuk beralih ke *cloud*. | Skalabilitas aplikasi: perancangan *Portal Desa* dimana setiap perangkat desa dapat mendaftar (self-service) dan *launch* web-nya tanpa teknisi. |
| **Research Gap** | 1. Mayoritas SID lokal dirancang *stand-alone* (1 instalasi untuk 1 desa), mahal & sulit dipelihara oleh desa.<br>2. Penerapan *cloud computing* E-gov masih luas di sektor publik kota, namun implementasi SaaS siap pakai untuk unit administratif terkecil (desa) belum optimal dieksplorasi. | Membangun purwarupa platform SaaS internal "Portal Desa" yang mensentralisasi proses *deployment* agar pembuatan sistem digital desa tidak butuh instalasi manual (*zero setup*). |

---

### D. Referensi (APA 7th Edition)

Doni, D., & Saimi, S. (2026). Pemanfaatan Sistem Informasi Desa (SID) terhadap Peningkatan Pelayanan Publik di Desa Penyampak dan Desa Tebing. *Jurnal Ilmu Siber Dan Informatika Digital (JUISIK)*, 6(2). https://doi.org/10.55606/juisik.v6i2.2434

Haries Muhammad. (2025). Sistem Informasi Dokumen Proposal Pembangunan Desa Berbasis Website Pada Kantor Kepala Desa Reungkam. *Jurnal Sistem Informasi Dan Teknologi (JSIMTEK)*, 3(2), 154–162. https://doi.org/10.33020/jsimtek.v3i2.896

Mirza, Yaser. (2021). Challenges for Public Sector Organisations in Cloud Adoption: A Case Study of South Australian Public Sector Agency. *International Journal of Managing Public Sector Information and Communication Technologies (IJMPICT)*, 12(3/4). https://doi.org/10.5121/ijmpict.2021.12301

Nur, R. M., & Rodiyah, I. (2025). Efektivitas Sistem Informasi Desa dalam Meningkatkan Keterbukaan Informasi Publik di Desa Larangan. *Sawala: Jurnal Administrasi Negara*, 13(1), 91–98. https://doi.org/10.30656/sawala.v13.i1.9800

Said, Ramisha. (2023). *Cloud-Based Government Services: Enhancing Public Sector Operations*. OSF Preprints. https://doi.org/10.31219/osf.io/8yrfp
