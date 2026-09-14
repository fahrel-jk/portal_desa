<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$village = \App\Models\Village::where('slug', 'sumberan')->first();
if ($village && $village->news->count() == 0) {
    \App\Models\VillageNews::create([
        'village_id' => $village->id, 
        'title' => 'Kerja Bakti Massal Sambut Kemerdekaan', 
        'slug' => 'kerja-bakti-massal-sambut-kemerdekaan', 
        'content' => 'Warga desa bergotong royong membersihkan lingkungan dan menghias jalanan desa dengan pernak-pernik merah putih untuk menyambut hari kemerdekaan. Kegiatan ini diikuti oleh ratusan warga dari berbagai dusun.', 
        'published_at' => now(), 
        'created_by' => 1
    ]);
    \App\Models\VillageNews::create([
        'village_id' => $village->id, 
        'title' => 'Penyaluran BLT Tahap 3 Berjalan Lancar', 
        'slug' => 'penyaluran-blt-tahap-3-lancar', 
        'content' => 'Pemerintah desa sukses menyalurkan Bantuan Langsung Tunai (BLT) tahap ke-3 kepada keluarga penerima manfaat. Diharapkan bantuan ini dapat sedikit meringankan beban ekonomi warga.', 
        'published_at' => now()->subDays(2), 
        'created_by' => 1
    ]);
    \App\Models\VillageNews::create([
        'village_id' => $village->id, 
        'title' => 'Panen Raya Padi Tembus Rekor Baru', 
        'slug' => 'panen-raya-padi-tembus-rekor', 
        'content' => 'Kelompok tani desa berhasil mencapai rekor panen tertinggi tahun ini berkat penggunaan sistem irigasi baru dan pendampingan intensif dari dinas pertanian.', 
        'published_at' => now()->subDays(5), 
        'created_by' => 1
    ]);
    echo "Dummy news created successfully!\n";
} else {
    echo "News already exists or village not found.\n";
}
