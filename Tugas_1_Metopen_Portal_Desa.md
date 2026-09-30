# Tugas 1 – Analisis Literatur Penelitian Terdahulu

**Nama**: [Isi Nama Anda]
**NIM**: [Isi NIM Anda]
**Kelas**: [Isi Kelas Anda]

---

### A. Topik (Judul Penelitian)
**Rancang Bangun Platform Portal Desa Berbasis *Software as a Service* (SaaS) Menggunakan Metode Prototyping (Studi Kasus: Diskominfo Provinsi Jawa Timur)**

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

---

### E. Latar Belakang Penelitian (Disusun Berdasarkan Research Gap)

Kebutuhan digitalisasi di tingkat desa saat ini semakin mendesak. Sejak adanya Undang-Undang Desa, pemerintah desa dituntut untuk lebih terbuka dan cepat dalam melayani warganya. Pemanfaatan sistem informasi berbasis digital terbukti mampu mempermudah warga dalam mengurus administrasi persuratan dan meningkatkan kepuasan masyarakat terhadap layanan kantor desa (Doni & Saimi, 2026). Selain itu, keberadaan website desa juga menjadi sarana penting untuk keterbukaan informasi publik, terutama dalam mempublikasikan anggaran APBDes dan progres pembangunan desa secara transparan (Nur & Rodiyah, 2025).

Namun kenyataannya, digitalisasi desa di lapangan sering kali menemui jalan buntu. Sebagian besar desa tidak memiliki staf khusus yang paham IT dan tidak memiliki anggaran rutin untuk menyewa hosting atau membeli server sendiri. Temuan Mirza (2021) juga menegaskan bahwa keterbatasan keahlian IT internal dan rumitnya pengelolaan server mandiri memang menjadi hambatan utama pada instansi pemerintahan daerah. Dampaknya, tidak sedikit website desa yang akhirnya mati suri atau terbengkalai setelah program pelatihan selesai, karena perangkat desa kebingungan saat harus melakukan perawatan teknis sendirian.

Jika melihat penelitian-penelitian terdahulu, sistem informasi desa yang dikembangkan umumnya masih bersifat *stand-alone*, yaitu satu aplikasi hanya dibuat dan di-hosting terpisah untuk satu desa tertentu saja (Haries Muhammad, 2025; Nur & Rodiyah, 2025). Cara seperti ini sangat tidak efisien jika ingin diterapkan secara merata di satu kabupaten atau provinsi. Biaya pengadaan dan sewa server harus dikeluarkan berulang kali untuk tiap desa, belum lagi standar tampilan dan keamanannya yang jadi berbeda-beda. Pemeliharaan aplikasinya pun menjadi sangat merepotkan karena harus diperbarui satu per satu di setiap desa.

Di sisi lain, pemanfaatan teknologi komputasi awan dengan model *Software as a Service* (SaaS) sebenarnya sudah terbukti bisa memangkas biaya operasional dan meniadakan beban perawatan perangkat keras di instansi publik (Said, 2023). Sayangnya, riset-riset *e-government* berbasis *cloud* selama ini hampir selalu ditujukan untuk instansi besar seperti kementerian atau pemerintah kota, dan pembahasannya masih banyak yang sebatas konsep teori. Masih jarang ada penelitian terapan yang merancang platform SaaS *multi-tenant* yang secara spesifik dibuat ramah pengguna (*zero-code* dan *self-service*) agar bisa langsung dipakai oleh perangkat desa tanpa perlu mengerti hal-hal teknis.

Melihat celah masalah (*research gap*) tersebut, penelitian ini mengusulkan perancangan **Platform *Software as a Service* (SaaS) untuk Sistem Informasi dan Layanan Administrasi Desa** (Portal Desa). Dengan konsep ini, perangkat desa cukup mendaftar secara mandiri lewat alur *wizard* yang mudah dipahami, memilih template yang diinginkan, dan mengisi konten desa tanpa perlu menyentuh kode pemrograman maupun menyewa server sendiri. Sistem ini juga terhubung dengan pengawasan dinas terkait (Diskominfo) untuk proses verifikasi. Melalui pendekatan ini, desa bisa memiliki website resmi yang siap pakai, hemat biaya, dan mudah dirawat, sehingga proses transformasi digital desa bisa terwujud secara nyata dan berkelanjutan.

---

### F. Rumusan Masalah

Berdasarkan latar belakang dan identifikasi masalah yang telah dipaparkan, rumusan masalah dalam penelitian ini adalah sebagai berikut:

1. Bagaimana menganalisis kebutuhan fungsional dan non-fungsional dalam pengembangan platform Portal Desa berbasis *Software as a Service* (SaaS) pada lingkungan Dinas Komunikasi dan Informatika (Diskominfo) Provinsi Jawa Timur?
2. Bagaimana merancang dan membangun arsitektur purwarupa platform Portal Desa berbasis *multi-tenant* SaaS menggunakan metode *prototyping* agar perangkat desa dapat membuat dan mengelola website desa secara mandiri (*self-service*)?
3. Bagaimana menguji kelayakan dan fungsionalitas platform Portal Desa menggunakan pengujian *black-box testing* serta mengevaluasi tingkat penerimaan pengguna (*User Acceptance Testing*) oleh aparatur desa dan admin Diskominfo Provinsi Jawa Timur?

---

### G. Tujuan Penelitian

Sejalan dengan rumusan masalah yang telah ditetapkan, sasaran yang ingin dicapai melalui penelitian ini adalah:

1. Mengidentifikasi dan menganalisis kebutuhan sistem informasi dan administrasi desa terintegrasi berbasis SaaS *multi-tenant* yang relevan dengan kebutuhan Diskominfo Provinsi Jawa Timur dan pemerintah desa.
2. Merancang dan mengimplementasikan purwarupa (*prototype*) platform Portal Desa berbasis SaaS dengan arsitektur *path-based routing* dan *framework* Laravel melalui tahapan metode *prototyping*.
3. Menguji fungsionalitas fitur sistem menggunakan metode *black-box testing* serta mengukur tingkat kemudahan dan penerimaan sistem oleh pengguna (*User Acceptance Testing*) bagi perangkat desa dan administrator dinas.

---

### H. Manfaat Penelitian

Hasil dari penelitian ini diharapkan dapat memberikan kontribusi yang optimal, baik secara teoritis maupun praktis:

#### 1. Manfaat Teoretis
* Memberikan sumbangsih pemikiran dan referensi akademis dalam bidang Manajemen Informatika dan Rekayasa Perangkat Lunak, khususnya mengenai penerapan arsitektur *Software as a Service* (SaaS) *multi-tenant* pada instansi birokrasi pemerintahan daerah dan desa.
* Memperkaya khazanah keilmuan terkait implementasi metode *prototyping* dalam perancangan platform pembuatan website mandiri (*self-service web generator*) yang ditujukan bagi pengguna dengan latar belakang non-teknis.

#### 2. Manfaat Praktis
* **Bagi Pengambil Kebijakan (Diskominfo Provinsi Jawa Timur):**
  Menyediakan solusi platform terpusat untuk memfasilitasi, memantau, dan menstandarisasi tata kelola website desa di wilayah Jawa Timur secara efisien tanpa harus mengeluarkan anggaran pengadaan server terpisah untuk setiap desa.
* **Bagi Pemerintah Desa dan Perangkat Desa:**
  Memudahkan perangkat desa dalam memiliki dan mengelola website resmi desa (informasi profil, berita, transparansi APBDes, dan galeri) secara mandiri tanpa perlu memahami bahasa pemrograman maupun mengelola infrastruktur server (*zero setup*).
* **Bagi Masyarakat:**
  Meningkatkan keterbukaan akses informasi publik desa secara transparan serta mempermudah pengajuan permohonan layanan administrasi desa secara daring.
* **Bagi Peneliti:**
  Menerapkan dan mengasah kompetensi praktis dalam pengembangan perangkat lunak berbasis *cloud*, pengelolaan basis data terpusat, serta pengujian sistem dalam studi kasus nyata di instansi pemerintahan.

---

### I. Batasan Penelitian

Agar pelaksanaan penelitian tugas akhir ini tetap terarah, fokus, dan sesuai dengan standar akademik program studi, ditetapkan batasan penelitian sebagai berikut:

1. **Fokus Masalah:**
   * Penelitian difokuskan pada perancangan dan pembangunan purwarupa (*prototype*) platform pembuatan website desa mandiri (*self-service onboarding* dengan *wizard* 4 langkah), pengelolaan konten dinamis desa (profil, aparatur desa, berita, transparansi APBDes, galeri foto, peta titik lokasi), alur persetujuan admin provinsi (*approval/rejection workflow*), serta pengajuan layanan administrasi dasar oleh warga.
   * Sistem tidak mencakup transaksi pembayaran keuangan desa, integrasi sistem perpajakan, tanda tangan elektronik tersertifikasi (BSrE/BSSN), maupun integrasi langsung dengan Sistem Informasi Administrasi Kependudukan (SIAK) nasional.

2. **Jenis Data yang Digunakan:**
   * Data yang digunakan meliputi data profil desa, struktur organisasi aparatur desa, arsip publikasi berita kegiatan, ringkasan laporan APBDes tahunan, serta data formulir pengajuan layanan persuratan warga.
   * Pada tahap pengujian prototipe, data yang dimuat menggunakan data contoh representatif (*seed/dummy data*) desa-desa di wilayah Jawa Timur.

3. **Metode yang Diterapkan:**
   * Metode pengembangan perangkat lunak yang digunakan adalah **Metode Prototyping** (analisis kebutuhan, perancangan cepat, pembangunan purwarupa, evaluasi pengguna, dan penyempurnaan sistem).
   * Arsitektur perangkat lunak menggunakan model *multi-tenancy* basis data tunggal (*single database*) dengan mekanisme *path-based routing* (`/desa/{slug}`).
   * Pengujian sistem dibatasi pada pengujian fungsionalitas (*black-box testing*) menggunakan *framework* pengujian otomatis (Pest PHPUnit) dan pengujian penerimaan pengguna (*User Acceptance Testing*) melalui kuesioner.

4. **Konteks atau Lingkungan Penelitian:**
   * Penelitian dilakukan dalam konteks studi kasus magang pada Bidang Aplikasi Informatika, Dinas Komunikasi dan Informatika (Diskominfo) Provinsi Jawa Timur.
   * Implementasi dan pengujian sistem dijalankan pada lingkungan server lokal (*localhost* / lingkungan pengujian internal) sebagai purwarupa pembuktian konsep (*proof of concept*), dan belum mencakup tahap penyebaran (*deployment*) ke domain publik pemerintah provinsi.

