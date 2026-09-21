<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\VillageDocument;
use App\Models\VillageFaq;
use Illuminate\Database\Seeder;

class PpidFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $village = Village::where('slug', 'pujon-kidul')->first();

        if (! $village) {
            return;
        }

        // 5 Dummy Documents
        $documents = [
            [
                'title' => 'RPJMDes Desa Pujon Kidul 2023-2028',
                'description' => 'Rencana Pembangunan Jangka Menengah Desa (RPJMDes) untuk periode 5 tahun ke depan.',
                'category' => 'Dokumen Perencanaan',
            ],
            [
                'title' => 'Laporan APBDes Tahun Anggaran 2023',
                'description' => 'Laporan realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) tahun 2023.',
                'category' => 'Laporan Keuangan',
            ],
            [
                'title' => 'Perdes No. 4 Tahun 2023 tentang Pengelolaan Sampah',
                'description' => 'Peraturan Desa mengenai retribusi dan tata kelola sampah lingkungan.',
                'category' => 'Peraturan Desa',
            ],
            [
                'title' => 'Formulir Pendaftaran UMKM Desa',
                'description' => 'Silakan unduh dan isi formulir ini bagi warga yang ingin mendaftarkan usahanya ke BUMDes.',
                'category' => 'Formulir Warga',
            ],
            [
                'title' => 'SK Kepala Desa Pembentukan Panitia Pilkades 2024',
                'description' => 'Surat Keputusan mengenai susunan panitia pemilihan Kepala Desa tahun 2024.',
                'category' => 'Keputusan Kepala Desa',
            ],
        ];

        foreach ($documents as $doc) {
            VillageDocument::create([
                'village_id' => $village->id,
                'title' => $doc['title'],
                'description' => $doc['description'],
                'category' => $doc['category'],
                'file_path' => 'dummy/sample.pdf', // Assumes you'll have a dummy file here or it won't be clickable
                'download_count' => rand(10, 200),
                'is_active' => true,
            ]);
        }

        // 5 Dummy FAQs
        $faqs = [
            [
                'question' => 'Apa saja syarat membuat Surat Keterangan Usaha (SKU)?',
                'answer' => "Untuk membuat SKU, Anda perlu menyiapkan beberapa dokumen berikut:\n1. Fotokopi KTP dan KK\n2. Surat Pengantar dari RT/RW setempat\n3. Foto tempat usaha\nSilakan bawa dokumen tersebut ke loket pelayanan Kantor Desa pada jam kerja.",
                'order' => 1,
            ],
            [
                'question' => 'Kapan jadwal pelayanan Kantor Desa?',
                'answer' => "Pelayanan Kantor Desa buka setiap hari kerja:\nSenin - Kamis : 08.00 - 15.00 WIB\nJumat : 08.00 - 14.00 WIB\nSabtu, Minggu dan Hari Libur Nasional tutup.",
                'order' => 2,
            ],
            [
                'question' => 'Bagaimana cara mendaftarkan produk UMKM di website desa?',
                'answer' => "Anda dapat mengunduh 'Formulir Pendaftaran UMKM Desa' di menu PPID. Isi formulir tersebut dan serahkan ke bagian pelayanan Kantor Desa beserta sampel foto produk Anda.",
                'order' => 3,
            ],
            [
                'question' => 'Apakah pembuatan surat pengantar dikenakan biaya?',
                'answer' => 'Tidak. Seluruh pelayanan pembuatan surat pengantar di Kantor Desa Pujon Kidul adalah **Gratis (Rp 0)**.',
                'order' => 4,
            ],
            [
                'question' => 'Bagaimana cara melaporkan infrastruktur desa yang rusak?',
                'answer' => "Warga dapat menggunakan fitur 'Pengaduan' yang tersedia di bagian bawah website desa ini. Isi nama, kontak, dan deskripsi kerusakan (sangat disarankan melampirkan foto). Laporan Anda akan masuk ke sistem dan ditindaklanjuti oleh perangkat desa terkait.",
                'order' => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            VillageFaq::create([
                'village_id' => $village->id,
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'order' => $faq['order'],
                'is_active' => true,
            ]);
        }
    }
}
