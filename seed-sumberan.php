<?php

use App\Models\Village;
use App\Models\VillageDemographic;
use App\Models\VillageFaq;
use App\Models\VillageOfficial;

$v = Village::where('slug', 'sumberan')->first();
if (!$v) { echo "NOT FOUND\n"; return; }

// === VISI & MISI ===
$v->visi = 'Mewujudkan Desa Sumberan yang mandiri, berdaya saing, dan berbudaya melalui tata kelola pemerintahan yang transparan serta pemberdayaan potensi lokal.';
$v->misi = "Meningkatkan kualitas pelayanan publik yang mudah diakses oleh seluruh warga desa
Mengembangkan potensi pertanian organik dan ekonomi kreatif berbasis kearifan lokal
Membangun infrastruktur desa yang mendukung konektivitas dan kesejahteraan warga
Melestarikan budaya dan tradisi gotong royong sebagai identitas desa
Mendorong partisipasi pemuda dalam pembangunan desa melalui inovasi digital";

// === SEJARAH ===
$v->history = "Desa Sumberan berdiri sejak masa pemerintahan kolonial Belanda pada awal abad ke-20. Nama \"Sumberan\" berasal dari kata \"sumber\" yang merujuk pada mata air alami yang menjadi pusat kehidupan penduduk awal di wilayah ini.

Pada tahun 1945, warga Desa Sumberan turut aktif dalam perjuangan kemerdekaan sebagai bagian dari gerakan pertahanan rakyat di wilayah Jawa Timur. Setelah kemerdekaan, desa ini berkembang pesat sebagai sentra pertanian padi dan palawija.

Memasuki era reformasi, Desa Sumberan bertransformasi menjadi desa yang mengedepankan transparansi pemerintahan. Pada tahun 2018, desa ini meraih penghargaan sebagai Desa Terbaik tingkat kecamatan dalam bidang tata kelola keuangan desa.

Saat ini, Desa Sumberan terus berinovasi dengan memanfaatkan teknologi digital untuk pelayanan warga, termasuk melalui portal desa ini sebagai wujud komitmen keterbukaan informasi publik.";

$v->save();
echo "Visi, misi, history saved.\n";

// === DEMOGRAPHICS ===
$demoData = [
    // Gender
    ['type' => 'gender', 'label' => 'Laki-laki', 'count' => 1847],
    ['type' => 'gender', 'label' => 'Perempuan', 'count' => 1923],
    // Age
    ['type' => 'age', 'label' => '0-14 tahun', 'count' => 782],
    ['type' => 'age', 'label' => '15-24 tahun', 'count' => 645],
    ['type' => 'age', 'label' => '25-44 tahun', 'count' => 1104],
    ['type' => 'age', 'label' => '45-64 tahun', 'count' => 876],
    ['type' => 'age', 'label' => '65+ tahun', 'count' => 363],
    // Religion
    ['type' => 'religion', 'label' => 'Islam', 'count' => 3502],
    ['type' => 'religion', 'label' => 'Kristen', 'count' => 148],
    ['type' => 'religion', 'label' => 'Katolik', 'count' => 87],
    ['type' => 'religion', 'label' => 'Hindu', 'count' => 33],
];

foreach ($demoData as $d) {
    VillageDemographic::create(array_merge($d, ['village_id' => $v->id]));
}
echo "Demographics seeded (" . count($demoData) . " records).\n";

// === FAQ ===
$faqData = [
    ['question' => 'Bagaimana cara mengurus Surat Keterangan Domisili?', 'answer' => "Warga dapat datang langsung ke Balai Desa Sumberan dengan membawa KTP, KK, dan surat pengantar dari RT/RW. Proses pengurusan memakan waktu kurang lebih 15-30 menit pada jam kerja.\n\nAlternatifnya, warga dapat mengajukan secara online melalui fitur Layanan di portal desa ini."],
    ['question' => 'Kapan jadwal pelayanan administrasi di kantor desa?', 'answer' => "Kantor Desa Sumberan melayani warga setiap hari Senin sampai Jumat, pukul 08.00 – 15.00 WIB.\n\nUntuk hari Sabtu, kantor desa buka setengah hari (08.00 – 12.00 WIB) hanya untuk pelayanan darurat."],
    ['question' => 'Apakah desa menyediakan layanan pengaduan warga?', 'answer' => "Ya, Desa Sumberan menyediakan layanan pengaduan melalui fitur \"Lapor Desa\" yang tersedia di portal ini. Warga juga bisa menyampaikan aspirasi langsung pada saat Musyawarah Desa (Musdes) yang diadakan secara berkala."],
    ['question' => 'Bagaimana cara mendapatkan informasi bantuan sosial?', 'answer' => "Informasi mengenai bantuan sosial (BLT, PKH, BPNT) dapat dilihat melalui halaman Berita di portal ini. Warga juga bisa menghubungi Sekretaris Desa untuk konfirmasi data penerima bantuan.\n\nDesa Sumberan berkomitmen menyalurkan bantuan secara transparan dan tepat sasaran."],
    ['question' => 'Di mana saya bisa melihat laporan keuangan desa?', 'answer' => "Laporan keuangan desa (APBDes) dapat diakses secara publik melalui menu \"APBDes\" di navigasi portal ini. Laporan mencakup rincian pendapatan, belanja, dan pembiayaan desa per tahun anggaran."],
];

foreach ($faqData as $idx => $f) {
    VillageFaq::create(array_merge($f, ['village_id' => $v->id, 'order' => $idx + 1]));
}
echo "FAQ seeded (" . count($faqData) . " records).\n";

// === ADDITIONAL OFFICIALS (Sumberan only has 1) ===
$officialData = [
    ['name' => 'Hj. Siti Aminah, S.Pd.', 'position' => 'Sekretaris Desa', 'order' => 2],
    ['name' => 'Ahmad Fauzi', 'position' => 'Kepala Urusan Keuangan', 'order' => 3],
    ['name' => 'Dwi Lestari, A.Md.', 'position' => 'Kepala Urusan Perencanaan', 'order' => 4],
    ['name' => 'Bambang Sutrisno', 'position' => 'Kepala Seksi Pelayanan', 'order' => 5],
    ['name' => 'Ratna Dewi', 'position' => 'Kepala Seksi Kesejahteraan', 'order' => 6],
];

foreach ($officialData as $o) {
    VillageOfficial::create(array_merge($o, ['village_id' => $v->id]));
}
echo "Officials seeded (" . count($officialData) . " added).\n";

echo "\n=== DONE ===\n";
