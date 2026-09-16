<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageComplaint;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            $village = Village::published()->first();
        }

        if (! $village) {
            $this->command->warn('No published village found. Skipping complaint seeder.');
            return;
        }

        VillageComplaint::create([
            'village_id' => $village->id,
            'name' => 'Budi Santoso',
            'contact' => '081234567890',
            'category' => 'Infrastruktur & Pembangunan',
            'content' => 'Lampu jalan di pertigaan Dusun Krajan mati sejak 3 hari lalu. Mohon segera diperbaiki karena jalanan sangat gelap saat malam hari dan rawan kecelakaan.',
            'status' => 'pending',
        ]);

        VillageComplaint::create([
            'village_id' => $village->id,
            'name' => 'Siti Aminah',
            'contact' => '085712341234',
            'category' => 'Pelayanan Publik',
            'content' => 'Antrean untuk pembuatan surat pengantar KTP di kantor desa kemarin sangat lama karena loket hanya buka satu. Mohon dievaluasi agar pelayanan bisa lebih cepat.',
            'status' => 'processing',
        ]);

        VillageComplaint::create([
            'village_id' => $village->id,
            'name' => 'Anonim',
            'contact' => null,
            'category' => 'Ketertiban & Keamanan',
            'content' => 'Sering ada pemuda yang nongkrong dan minum minuman keras di pos ronda RT 03 pada malam minggu. Sangat meresahkan warga sekitar.',
            'status' => 'resolved',
        ]);

        $this->command->info("Data pengaduan dummy berhasil ditambahkan untuk desa: {$village->name}");
    }
}
