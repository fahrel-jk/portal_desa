<?php

namespace App\Services;

use App\Models\PengajuanLayanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SuratGeneratorService
{
    /**
     * Generate PDF untuk surat hasil layanan dan menyimpannya.
     *
     * @param PengajuanLayanan $pengajuan
     * @return string Path file yang disimpan.
     */
    public function generate(PengajuanLayanan $pengajuan)
    {
        $pengajuan->load(['desa', 'layanan']);
        
        $nomorSurat = '470/' . rand(100, 999) . '/DS-' . strtoupper(substr($pengajuan->desa->slug, 0, 3)) . '/' . date('Y');
        
        $data = [
            'pengajuan' => $pengajuan,
            'desa' => $pengajuan->desa,
            'layanan' => $pengajuan->layanan,
            'data_pemohon' => $pengajuan->data_pemohon,
            'nomor_surat' => $nomorSurat,
            'tanggal' => now()->translatedFormat('d F Y'),
        ];

        // Pilih view berdasarkan jenis layanan (fallback ke surat-keterangan default)
        // Jika butuh template beda-beda per layanan, bisa dicek ID atau namanya di sini.
        $view = 'pdf.surat-keterangan';

        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', 'portrait');

        $fileName = $pengajuan->kode_tracking . '.pdf';
        $directory = 'surat-hasil';
        
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $path = $directory . '/' . $fileName;
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }
}
