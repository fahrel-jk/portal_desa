<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageService;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Seed additional village services for Pujon Kidul demo.
     */
    public function run(): void
    {
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            $village = Village::published()->first();
        }

        if (! $village) {
            $this->command->warn('No published village found. Skipping service seeder.');
            return;
        }

        $services = [
            [
                'name' => 'Surat Pengantar Nikah',
                'slug' => 'surat-pengantar-nikah',
                'description' => 'Layanan pembuatan surat pengantar nikah (N1-N4) dari desa sebagai syarat utama pendaftaran ke KUA.',
                'requirements' => "KTP Calon Suami & Istri (Asli & Fotokopi)\nKartu Keluarga (Asli & Fotokopi)\nSurat Pengantar dari RT/RW setempat\nFotokopi KTP Orang Tua/Wali\nFotokopi Akta Kelahiran & Ijazah Terakhir\nPas Foto ukuran 3x4 dan 4x6 (masing-masing 2 lembar background biru)",
                'process_steps' => "Datang ke kantor desa dengan membawa seluruh persyaratan\nPetugas memverifikasi kelengkapan dokumen\nMengisi formulir permohonan surat pengantar nikah\nKepala Desa menandatangani surat pengantar\nSurat pengantar dicetak dan diserahkan kepada pemohon\nPemohon membawa surat pengantar ke KUA untuk proses selanjutnya",
                'estimated_time' => '1-2 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'slug' => 'surat-keterangan-tidak-mampu',
                'description' => 'Surat Keterangan Tidak Mampu (SKTM) yang digunakan untuk keperluan keringanan biaya pendidikan, kesehatan (BPJS), atau bantuan sosial lainnya.',
                'requirements' => "KTP Pemohon & Orang Tua (Asli & Fotokopi)\nKartu Keluarga (Asli & Fotokopi)\nSurat Pengantar RT/RW\nBukti/Surat Keterangan dari sekolah/instansi terkait (jika untuk keperluan pendidikan)\nFoto Rumah (Tampak Depan, Samping, Dalam)",
                'process_steps' => "Datang ke kantor desa dengan dokumen persyaratan lengkap\nPetugas memeriksa dan memverifikasi data\nTim verifikasi desa melakukan peninjauan lapangan\nSKTM diproses setelah verifikasi lapangan disetujui\nKepala Desa menandatangani SKTM\nSKTM diserahkan kepada pemohon",
                'estimated_time' => '2-3 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kelahiran',
                'slug' => 'surat-keterangan-kelahiran',
                'description' => 'Penerbitan surat pengantar kelahiran dari desa untuk keperluan pembuatan Akta Kelahiran di Dinas Dukcapil.',
                'requirements' => "Surat Keterangan Lahir dari Bidan/Rumah Sakit (Asli)\nKTP Ayah dan Ibu (Fotokopi)\nKartu Keluarga (Asli & Fotokopi)\nFotokopi Surat Nikah / Akta Perkawinan Orang Tua\nFotokopi KTP 2 orang saksi kelahiran",
                'process_steps' => "Datang ke kantor desa dengan membawa persyaratan\nPetugas memverifikasi dokumen kelahiran\nMengisi formulir pencatatan kelahiran\nSurat Keterangan Kelahiran dicetak dan ditandatangani\nPemohon membawa ke Disdukcapil untuk pembuatan Akta Kelahiran",
                'estimated_time' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Pengantar Pindah Domisili',
                'slug' => 'surat-pengantar-pindah-domisili',
                'description' => 'Layanan pengurusan surat pengantar bagi warga yang akan pindah domisili keluar dari Desa Pujon Kidul.',
                'requirements' => "KTP Asli & Fotokopi\nKartu Keluarga (Asli)\nSurat Pengantar RT/RW\nMengisi Formulir Permohonan Pindah (tersedia di kantor desa)\nPas Foto 4x6 (2 lembar)",
                'process_steps' => "Mengurus surat pengantar dari RT/RW setempat\nDatang ke kantor desa dengan dokumen lengkap\nMengisi formulir permohonan pindah\nPetugas memverifikasi data dan memproses surat\nKepala Desa menandatangani surat pengantar pindah\nPemohon membawa surat ke Disdukcapil tujuan",
                'estimated_time' => '2-3 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Kematian',
                'slug' => 'surat-keterangan-kematian',
                'description' => 'Penerbitan surat pengantar atau keterangan kematian untuk kepengurusan Akta Kematian, asuransi, atau perbankan.',
                'requirements' => "Surat Keterangan Kematian dari Rumah Sakit/Dokter (Jika meninggal di RS)\nKTP Almarhum/Almarhumah (Asli)\nKartu Keluarga Almarhum/Almarhumah (Asli)\nKTP Pelapor (Fotokopi)\nPengantar RT/RW",
                'process_steps' => "Keluarga melapor ke RT/RW setempat\nMengurus surat pengantar dari RT/RW\nDatang ke kantor desa dengan dokumen persyaratan\nPetugas memverifikasi data kematian\nSurat Keterangan Kematian diterbitkan dan ditandatangani",
                'estimated_time' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
            [
                'name' => 'Surat Keterangan Catatan Kepolisian (SKCK)',
                'slug' => 'surat-pengantar-skck',
                'description' => 'Surat pengantar dari desa untuk pembuatan atau perpanjangan SKCK di Polsek/Polres setempat.',
                'requirements' => "KTP (Fotokopi)\nKartu Keluarga (Fotokopi)\nAkta Kelahiran/Ijazah (Fotokopi)\nSurat Pengantar RT/RW\nPas Foto 4x6 background merah (4 lembar)",
                'process_steps' => "Datang ke kantor desa dengan dokumen persyaratan\nPetugas memeriksa kelengkapan berkas\nSurat Pengantar SKCK dicetak\nKepala Desa menandatangani surat\nPemohon membawa surat ke Polsek/Polres",
                'estimated_time' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            VillageService::updateOrCreate(
                [
                    'village_id' => $village->id,
                    'name' => $service['name'],
                ],
                $service
            );
        }

        $this->command->info("6 layanan administrasi (dengan detail alur & biaya) berhasil ditambahkan untuk: {$village->name}");
    }
}
