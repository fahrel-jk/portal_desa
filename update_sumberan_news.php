<?php

use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$village = Village::where('slug', 'sumberan')->first();
if (! $village) {
    echo "Village Sumberan not found\n";
    exit(1);
}

// Clear existing news for village to ensure clean seed
VillageNews::where('village_id', $village->id)->delete();

$adminUser = User::first();
$userId = $adminUser ? $adminUser->id : 1;

$newsItems = [
    [
        'title' => 'Desa Sumberan Terpilih Sebagai Desa Wisata Terbaik',
        'slug' => 'desa-wisata-terbaik',
        'content' => 'Desa Sumberan resmi masuk dalam nominasi desa wisata terbaik tingkat kabupaten tahun 2026. Penghargaan ini diraih berkat keberhasilan warga dalam melestarikan kawasan persawahan organik, tata kelola kebersihan lingkungan, serta kebudayaan gotong royong yang menjadi daya tarik utama wisatawan.',
        'published_at' => '2026-09-12 09:00:00',
    ],
    [
        'title' => 'Pembagian Bibit Pohon untuk Penghijauan Dusun',
        'slug' => 'pembagian-bibit-pohon',
        'content' => 'Ribuan bibit pohon buah dan pelindung dibagikan secara gratis kepada warga di tiap dusun Desa Sumberan. Program penghijauan ini bertujuan menjaga kelestarian mata air desa serta meningkatkan ketersediaan buah-buahan lokal bagi generasi mendatang.',
        'published_at' => '2026-09-08 10:30:00',
    ],
    [
        'title' => 'Pelatihan Digital Marketing untuk Pelaku UMKM',
        'slug' => 'pelatihan-digital-marketing-umkm',
        'content' => 'Tiga puluh pelaku UMKM Desa Sumberan mengikuti pelatihan pemasaran digital yang diselenggarakan di Balai Desa. Peserta diajarkan cara membuat foto produk menarik, membuka toko online, serta memasarkan produk olahan pangan desa melalui media sosial.',
        'published_at' => '2026-09-04 13:00:00',
    ],
    [
        'title' => 'Penyaluran Bantuan Pangan Tahap Ketiga',
        'slug' => 'penyaluran-bantuan-pangan',
        'content' => 'Penyaluran bantuan beras tahap ketiga bagi Keluarga Penerima Manfaat (KPM) di Desa Sumberan berlangsung dengan lancar dan tertib. Setiap KPM menerima 10 kg beras kualitas premium yang disalurkan langsung oleh tim pendamping desa.',
        'published_at' => '2026-08-29 08:30:00',
    ],
];

foreach ($newsItems as $item) {
    VillageNews::create([
        'village_id' => $village->id,
        'title' => $item['title'],
        'slug' => $item['slug'],
        'content' => $item['content'],
        'published_at' => $item['published_at'],
        'created_by' => $userId,
    ]);
}

echo 'Successfully seeded '.count($newsItems)." news items for Desa Sumberan.\n";
