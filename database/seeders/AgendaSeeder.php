<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageAgenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Seed sample agenda events for demo village.
     */
    public function run(): void
    {
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            $village = Village::published()->first();
        }

        if (! $village) {
            $this->command->warn('No published village found. Skipping agenda seeder.');
            return;
        }

        $baseDate = now();

        $agendas = [
            [
                'title' => 'Musyawarah Desa - Rencana Pembangunan Jalan',
                'description' => 'Musyawarah rutin desa membahas rencana pembangunan jalan dusun 3 dan prioritas anggaran semester berikutnya.',
                'event_date' => $baseDate->copy()->addDays(2)->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '12:00',
                'location' => 'Balai Desa',
                'category' => 'musyawarah',
                'is_important' => true,
            ],
            [
                'title' => 'Posyandu Balita & Lansia',
                'description' => 'Kegiatan posyandu rutin bulanan untuk pemeriksaan kesehatan balita (timbang badan, imunisasi) dan lansia (cek tekanan darah).',
                'event_date' => $baseDate->copy()->addDays(5)->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '11:00',
                'location' => 'Pos Kesehatan Desa',
                'category' => 'kesehatan',
                'is_important' => false,
            ],
            [
                'title' => 'Kerja Bakti Bersih Lingkungan',
                'description' => 'Gotong royong membersihkan saluran irigasi dan lingkungan sekitar dusun 1 dan 2.',
                'event_date' => $baseDate->copy()->addDays(7)->format('Y-m-d'),
                'start_time' => '07:00',
                'end_time' => '10:00',
                'location' => 'Dusun 1 & 2',
                'category' => 'gotong_royong',
                'is_important' => false,
            ],
            [
                'title' => 'Pengajian Rutin Bulanan',
                'description' => 'Pengajian rutin warga dilanjutkan dengan sesi tanya jawab dan silaturahmi.',
                'event_date' => $baseDate->copy()->addDays(10)->format('Y-m-d'),
                'start_time' => '19:30',
                'end_time' => '21:00',
                'location' => 'Masjid Baitul Amin',
                'category' => 'keagamaan',
                'is_important' => false,
            ],
            [
                'title' => 'Pelatihan Keterampilan UMKM',
                'description' => 'Pelatihan pembuatan kemasan dan pemasaran online untuk pelaku UMKM desa. Kerjasama dengan Disperindag.',
                'event_date' => $baseDate->copy()->addDays(14)->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '15:00',
                'location' => 'Aula Balai Desa',
                'category' => 'pendidikan',
                'is_important' => true,
            ],
            [
                'title' => 'Festival Budaya Desa',
                'description' => 'Perayaan tahunan dengan penampilan seni budaya, bazar kuliner lokal, dan lomba antar-dusun.',
                'event_date' => $baseDate->copy()->addDays(20)->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '17:00',
                'location' => 'Lapangan Desa',
                'category' => 'sosial',
                'is_important' => true,
            ],
            [
                'title' => 'Rapat PKK Desa',
                'description' => 'Rapat koordinasi bulanan PKK desa membahas program kerja dan pembagian tugas.',
                'event_date' => $baseDate->copy()->addDays(3)->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'location' => 'Balai Desa',
                'category' => 'umum',
                'is_important' => false,
            ],
            [
                'title' => 'Vaksinasi Hewan Ternak',
                'description' => 'Program vaksinasi rutin untuk hewan ternak warga (sapi, kambing). Kerjasama dengan Dinas Peternakan.',
                'event_date' => $baseDate->copy()->addDays(12)->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '14:00',
                'location' => 'Kandang Kelompok Ternak',
                'category' => 'kesehatan',
                'is_important' => false,
            ],
        ];

        foreach ($agendas as $agenda) {
            VillageAgenda::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'title' => $agenda['title'],
                ],
                array_merge($agenda, ['village_id' => $village->id])
            );
        }

        $this->command->info("8 agenda contoh berhasil ditambahkan untuk: {$village->name}");
    }
}
