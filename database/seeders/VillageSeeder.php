<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;
use App\Models\VillageOfficial;
use App\Models\VillageService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure demo image directories exist
        Storage::disk('public')->makeDirectory('villages/logos');
        Storage::disk('public')->makeDirectory('villages/heroes');

        // Copy demo placeholder images if they exist
        $this->ensureDemoImages();

        // Create admin provinsi
        $admin = User::create([
            'name' => 'Admin Diskominfo',
            'email' => 'admin@portaldesa.test',
            'password' => 'password',
            'role' => 'admin_provinsi',
            'village_id' => null,
        ]);

        $klasik = Template::where('slug', 'klasik')->first();
        $modern = Template::where('slug', 'modern')->first();

        // --- Desa 1: Published (Klasik template) ---
        $desa1 = Village::create([
            'name' => 'Ladang Panjang',
            'slug' => 'ladang-panjang',
            'kecamatan' => 'Kecamatan Sukolilo',
            'kabupaten' => 'Kabupaten Pasuruan',
            'description' => 'Desa Ladang Panjang terletak di kaki Gunung Arjuno dengan potensi pertanian dan wisata alam yang menjanjikan. Didirikan sejak era kolonial, desa ini memiliki sejarah panjang dalam perjuangan kemerdekaan.',
            'logo_path' => 'villages/logos/demo-logo.png',
            'hero_image_path' => 'villages/heroes/demo-hero.png',
            'contact_phone' => '0343-123456',
            'contact_email' => 'desa.ladangpanjang@example.com',
            'office_hours' => 'Senin - Jumat, 08:00 - 15:00 WIB',
            'address' => 'Jl. Raya Ladang Panjang No. 1, Kec. Sukolilo, Kab. Pasuruan',
            'template_id' => $klasik->id,
            'status' => 'published',
            'submitted_at' => now()->subDays(14),
            'approved_at' => now()->subDays(12),
            'approved_by' => $admin->id,
        ]);

        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@ladangpanjang.test',
            'password' => 'password',
            'role' => 'perwakilan_desa',
            'village_id' => $desa1->id,
        ]);

        $this->seedOfficials($desa1);
        $this->seedNews($desa1, $user1);
        $this->seedServices($desa1);

        // --- Desa 2: Pending Review (Modern template) ---
        $desa2 = Village::create([
            'name' => 'Sumber Makmur',
            'slug' => 'sumber-makmur',
            'kecamatan' => 'Kecamatan Gempol',
            'kabupaten' => 'Kabupaten Pasuruan',
            'description' => 'Desa Sumber Makmur dikenal sebagai sentra industri kerajinan tangan dan batik khas Pasuruan. Masyarakatnya aktif dalam kegiatan gotong royong dan pengembangan UMKM.',
            'logo_path' => 'villages/logos/demo-logo.png',
            'hero_image_path' => 'villages/heroes/demo-hero-2.png',
            'contact_phone' => '0343-654321',
            'contact_email' => 'desa.sumbermakmur@example.com',
            'office_hours' => 'Senin - Jumat, 08:00 - 14:00 WIB',
            'address' => 'Jl. Mawar No. 5, Kec. Gempol, Kab. Pasuruan',
            'template_id' => $modern->id,
            'status' => 'published',
            'submitted_at' => now()->subDays(5),
            'approved_at' => now()->subDays(3),
            'approved_by' => $admin->id,
        ]);

        $user2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@sumbermakmur.test',
            'password' => 'password',
            'role' => 'perwakilan_desa',
            'village_id' => $desa2->id,
        ]);

        $this->seedOfficials($desa2);
        $this->seedNews($desa2, $user2);

        // --- Desa 3: Draft (Klasik template) ---
        $desa3 = Village::create([
            'name' => 'Taman Indah',
            'slug' => 'taman-indah',
            'kecamatan' => 'Kecamatan Pandaan',
            'kabupaten' => 'Kabupaten Pasuruan',
            'description' => 'Desa Taman Indah memiliki taman wisata air yang menjadi destinasi favorit warga sekitar.',
            'contact_phone' => '0343-789012',
            'contact_email' => 'desa.tamanindah@example.com',
            'office_hours' => 'Senin - Jumat, 08:00 - 15:00 WIB',
            'address' => 'Jl. Taman Raya No. 10, Kec. Pandaan, Kab. Pasuruan',
            'template_id' => $klasik->id,
            'status' => 'draft',
        ]);

        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@tamanindah.test',
            'password' => 'password',
            'role' => 'perwakilan_desa',
            'village_id' => $desa3->id,
        ]);

        // --- Desa 4: Rejected (Modern template) ---
        $desa4 = Village::create([
            'name' => 'Karya Bakti',
            'slug' => 'karya-bakti',
            'kecamatan' => 'Kecamatan Bangil',
            'kabupaten' => 'Kabupaten Pasuruan',
            'description' => 'Desa Karya Bakti terkenal dengan tradisi gotong royong yang kuat dan program pemberdayaan pemuda.',
            'contact_phone' => '0343-345678',
            'contact_email' => 'desa.karyabakti@example.com',
            'office_hours' => 'Senin - Jumat, 08:00 - 14:30 WIB',
            'address' => 'Jl. Merdeka No. 15, Kec. Bangil, Kab. Pasuruan',
            'template_id' => $modern->id,
            'status' => 'rejected',
            'rejection_reason' => 'Data perangkat desa belum lengkap. Mohon tambahkan foto dan jabatan untuk semua perangkat desa.',
            'submitted_at' => now()->subDays(5),
        ]);

        User::create([
            'name' => 'Dewi Kartini',
            'email' => 'dewi@karyabakti.test',
            'password' => 'password',
            'role' => 'perwakilan_desa',
            'village_id' => $desa4->id,
        ]);

        $this->seedOfficials($desa4);

        // --- Desa 5: Pending Review (Modern template, for review demo) ---
        $desa5 = Village::create([
            'name' => 'Tanjung Sari',
            'slug' => 'tanjung-sari',
            'kecamatan' => 'Kecamatan Rembang',
            'kabupaten' => 'Kabupaten Pasuruan',
            'description' => 'Desa Tanjung Sari merupakan desa pesisir yang terkenal dengan hasil laut dan tradisi nelayan turun-temurun.',
            'contact_phone' => '0343-111222',
            'contact_email' => 'desa.tanjungsari@example.com',
            'office_hours' => 'Senin - Jumat, 07:30 - 14:00 WIB',
            'address' => 'Jl. Pantai Sari No. 3, Kec. Rembang, Kab. Pasuruan',
            'template_id' => $modern->id,
            'status' => 'pending_review',
            'submitted_at' => now()->subDays(1),
        ]);

        User::create([
            'name' => 'Hasan Basri',
            'email' => 'hasan@tanjungsari.test',
            'password' => 'password',
            'role' => 'perwakilan_desa',
            'village_id' => $desa5->id,
        ]);

        $this->seedOfficials($desa5);
    }

    /**
     * Seed village officials.
     */
    private function seedOfficials(Village $village): void
    {
        $officials = [
            ['name' => 'H. Sumarno, S.Sos', 'position' => 'Kepala Desa', 'order' => 1],
            ['name' => 'Rina Wati, S.E.', 'position' => 'Sekretaris Desa', 'order' => 2],
            ['name' => 'Joko Priyono', 'position' => 'Kepala Urusan Keuangan', 'order' => 3],
            ['name' => 'Sri Wahyuni', 'position' => 'Kepala Urusan Umum', 'order' => 4],
        ];

        foreach ($officials as $official) {
            VillageOfficial::create(array_merge($official, [
                'village_id' => $village->id,
            ]));
        }
    }

    /**
     * Seed village news.
     */
    private function seedNews(Village $village, User $author): void
    {
        $newsItems = [
            [
                'title' => 'Program Tanam Padi Organik Berhasil Panen Perdana',
                'slug' => 'program-tanam-padi-organik-berhasil-panen-perdana',
                'content' => 'Program penanaman padi organik yang dimulai sejak 6 bulan lalu akhirnya membuahkan hasil. Panen perdana dilakukan hari ini dengan hasil yang memuaskan. Kepala Desa berharap program ini dapat terus berlanjut dan menjadi contoh bagi desa lain di kecamatan.',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Gotong Royong Perbaikan Jalan Desa',
                'slug' => 'gotong-royong-perbaikan-jalan-desa',
                'content' => 'Warga desa bersama-sama melakukan perbaikan jalan desa sepanjang 500 meter yang rusak akibat musim hujan. Kegiatan ini diikuti oleh lebih dari 100 warga dari berbagai RT. Pemerintah desa menyediakan material bangunan, sedangkan tenaga kerja berasal dari swadaya masyarakat.',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($newsItems as $news) {
            VillageNews::create(array_merge($news, [
                'village_id' => $village->id,
                'created_by' => $author->id,
            ]));
        }
    }

    /**
     * Seed village services.
     */
    private function seedServices(Village $village): void
    {
        $services = [
            [
                'name' => 'Surat Keterangan Domisili',
                'requirements' => "1. KTP asli dan fotokopi\n2. Kartu Keluarga asli dan fotokopi\n3. Surat pengantar dari RT/RW\n4. Pas foto 3x4 (2 lembar)",
                'description' => 'Surat keterangan yang menerangkan bahwa seseorang benar-benar berdomisili di wilayah desa.',
            ],
            [
                'name' => 'Surat Keterangan Usaha',
                'requirements' => "1. KTP asli dan fotokopi\n2. Surat pengantar dari RT/RW\n3. Foto lokasi usaha\n4. Mengisi formulir permohonan",
                'description' => 'Surat keterangan yang menerangkan bahwa seseorang memiliki usaha di wilayah desa.',
            ],
        ];

        foreach ($services as $service) {
            VillageService::create(array_merge($service, [
                'village_id' => $village->id,
            ]));
        }
    }

    /**
     * Ensure demo placeholder images exist in storage.
     */
    private function ensureDemoImages(): void
    {
        // These files should already exist in storage/app/public/villages/
        // from initial project setup. This method just ensures the directories exist.
        $requiredFiles = [
            'villages/logos/demo-logo.png' => 'demo-logo.png',
            'villages/heroes/demo-hero.png' => 'demo-hero.png',
            'villages/heroes/demo-hero-2.png' => 'demo-hero-2.png',
        ];

        foreach ($requiredFiles as $destination => $sourceFile) {
            if (! Storage::disk('public')->exists($destination)) {
                $sourcePath = database_path('seeders/demo-images/'.$sourceFile);
                if (file_exists($sourcePath)) {
                    $dir = dirname($destination);
                    Storage::disk('public')->makeDirectory($dir);
                    Storage::disk('public')->put($destination, file_get_contents($sourcePath));
                }
            }
        }
    }
}
