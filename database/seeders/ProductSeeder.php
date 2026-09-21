<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageNews;
use App\Models\VillageProduct;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed UMKM products and additional news for Pujon Kidul.
     */
    public function run(): void
    {
        // Find Pujon Kidul (or the first published klasik village)
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            $village = Village::published()->first();
        }

        if (! $village) {
            $this->command->warn('No published village found. Skipping product seeder.');

            return;
        }

        $user = $village->user;
        $userId = $user?->id;

        $this->seedProducts($village, $userId);
        $this->seedAdditionalNews($village, $userId);

        $this->command->info("Products and news seeded for: {$village->name}");
    }

    /**
     * Seed UMKM products.
     */
    private function seedProducts(Village $village, ?int $userId): void
    {
        $products = [
            [
                'name' => 'Susu Segar Sapi Perah',
                'slug' => 'susu-segar-sapi-perah',
                'description' => 'Susu segar murni langsung dari peternakan sapi perah Desa Pujon Kidul. Diproses secara higienis tanpa bahan pengawet. Kaya kalsium dan protein, cocok untuk segala usia. Tersedia dalam kemasan 1 liter.',
                'price' => 15000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567890',
            ],
            [
                'name' => 'Keripik Apel Malang',
                'slug' => 'keripik-apel-malang',
                'description' => 'Keripik apel renyah khas Malang yang terbuat dari apel pilihan lokal. Digoreng vacuum sehingga rasa manis aslinya tetap terjaga. Tanpa pewarna dan pemanis buatan. Kemasan 100 gram.',
                'price' => 25000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567891',
            ],
            [
                'name' => 'Yoghurt Probiotik',
                'slug' => 'yoghurt-probiotik',
                'description' => 'Yoghurt probiotik segar dari susu sapi murni hasil peternakan desa. Difermentasi alami dengan bakteri baik untuk kesehatan pencernaan. Tersedia rasa original, stroberi, dan mangga.',
                'price' => 20000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567890',
            ],
            [
                'name' => 'Keju Mozarella Lokal',
                'slug' => 'keju-mozarella-lokal',
                'description' => 'Keju mozarella premium yang diproduksi langsung dari susu sapi lokal Pujon Kidul. Tekstur lembut dan meleleh sempurna, cocok untuk pizza, pasta, dan berbagai masakan. Kemasan 250 gram.',
                'price' => 35000,
                'category' => 'Olahan Susu',
                'contact_whatsapp' => '6281234567892',
            ],
            [
                'name' => 'Dodol Susu',
                'slug' => 'dodol-susu',
                'description' => 'Dodol susu tradisional yang dimasak dengan susu segar dan gula aren. Tekstur kenyal, manis dan gurih. Oleh-oleh khas desa wisata Pujon Kidul yang selalu jadi favorit wisatawan.',
                'price' => 18000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567893',
            ],
            [
                'name' => 'Sabun Susu Kambing',
                'slug' => 'sabun-susu-kambing',
                'description' => 'Sabun alami berbahan dasar susu kambing etawa segar dari peternakan desa. Diperkaya minyak zaitun dan vitamin E untuk kulit lebih lembut dan sehat. Kemasan 80 gram per batang.',
                'price' => 12000,
                'category' => 'Kerajinan & Perawatan',
                'contact_whatsapp' => '6281234567894',
            ],
            [
                'name' => 'Kopi Robusta Pujon',
                'slug' => 'kopi-robusta-pujon',
                'description' => 'Biji kopi robusta pilihan dari kebun kopi dataran tinggi Pujon. Di-roasting medium untuk cita rasa khas yang bold dan earthy. Tersedia dalam bentuk biji dan bubuk. Kemasan 200 gram.',
                'price' => 30000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567895',
            ],
            [
                'name' => 'Madu Hutan Asli',
                'slug' => 'madu-hutan-asli',
                'description' => 'Madu murni yang dipanen langsung dari hutan di sekitar kawasan Pujon. Tanpa campuran dan tanpa proses pemanasan berlebih. Kaya antioksidan dan enzim alami. Kemasan botol 350ml.',
                'price' => 45000,
                'category' => 'Makanan & Minuman',
                'contact_whatsapp' => '6281234567890',
            ],
        ];

        foreach ($products as $product) {
            VillageProduct::updateOrCreate(
                ['village_id' => $village->id, 'slug' => $product['slug']],
                array_merge($product, [
                    'village_id' => $village->id,
                    'is_active' => true,
                    'created_by' => $userId,
                ])
            );
        }
    }

    /**
     * Seed additional news articles.
     */
    private function seedAdditionalNews(Village $village, ?int $userId): void
    {
        $newsItems = [
            [
                'title' => 'Festival Susu Segar Desa Pujon Kidul Meriahkan Akhir Pekan',
                'slug' => 'festival-susu-segar-desa-pujon-kidul',
                'content' => 'Desa Pujon Kidul kembali menggelar Festival Susu Segar tahunan yang diikuti oleh puluhan peternak sapi perah lokal. Acara ini menampilkan lomba memerah susu, pameran olahan susu, dan edukasi peternakan bagi anak-anak. Festival ini menjadi daya tarik wisatawan dan membantu promosi produk UMKM desa.',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pelatihan Digital Marketing untuk Pelaku UMKM Desa',
                'slug' => 'pelatihan-digital-marketing-umkm-desa',
                'content' => 'Sebanyak 30 pelaku UMKM Desa Pujon Kidul mengikuti pelatihan digital marketing yang diselenggarakan oleh pemerintah desa bekerja sama dengan Diskominfo Kabupaten Malang. Pelatihan ini mencakup pemanfaatan media sosial, fotografi produk, dan cara berjualan online. Diharapkan setelah pelatihan ini, produk-produk UMKM desa dapat menjangkau pasar yang lebih luas.',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Posyandu Balita dan Lansia Rutin Setiap Bulan',
                'slug' => 'posyandu-balita-lansia-rutin',
                'content' => 'Pemerintah Desa Pujon Kidul terus menjalankan program Posyandu untuk balita dan lansia secara rutin setiap bulannya. Kegiatan ini meliputi penimbangan berat badan, pengukuran tinggi badan, pemberian vitamin, dan konsultasi kesehatan gratis bersama bidan desa. Warga sangat antusias mengikuti kegiatan ini.',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($newsItems as $news) {
            VillageNews::updateOrCreate(
                ['village_id' => $village->id, 'slug' => $news['slug']],
                array_merge($news, [
                    'village_id' => $village->id,
                    'created_by' => $userId,
                ])
            );
        }
    }
}
