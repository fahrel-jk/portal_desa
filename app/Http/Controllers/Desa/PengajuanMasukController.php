<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLayanan;
use App\Services\SuratGeneratorService;
use Illuminate\Http\Request;

class PengajuanMasukController extends Controller
{
    public function index(Request $request)
    {
        $villageId = auth()->user()->village_id;

        $query = PengajuanLayanan::where('desa_id', $villageId)
            ->with(['user', 'layanan'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->paginate(15);

        return view('desa.pengajuan_masuk.index', compact('pengajuan'));
    }

    public function show($id)
    {
        $villageId = auth()->user()->village_id;
        
        $pengajuan = PengajuanLayanan::where('id', $id)
            ->where('desa_id', $villageId)
            ->with(['user', 'layanan', 'dokumen'])
            ->firstOrFail();

        return view('desa.pengajuan_masuk.show', compact('pengajuan'));
    }

    public function update(Request $request, $id, SuratGeneratorService $suratGenerator)
    {
        $villageId = auth()->user()->village_id;
        
        $pengajuan = PengajuanLayanan::where('id', $id)
            ->where('desa_id', $villageId)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:diproses,selesai,ditolak',
            'alasan_ditolak' => 'required_if:status,ditolak|nullable|string',
            'catatan_operator' => 'nullable|string',
        ]);

        $pengajuan->status = $request->status;
        $pengajuan->catatan_operator = $request->catatan_operator;
        
        if ($request->status === 'ditolak') {
            $pengajuan->alasan_ditolak = $request->alasan_ditolak;
        } else {
            $pengajuan->alasan_ditolak = null;
        }

        // Jika disetujui (selesai), generate PDF surat
        if ($request->status === 'selesai' && empty($pengajuan->file_surat_hasil)) {
            try {
                $path = $suratGenerator->generate($pengajuan);
                $pengajuan->file_surat_hasil = $path;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal men-generate PDF: ' . $e->getMessage());
            }
        }

        $pengajuan->save();

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
