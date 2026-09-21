<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLayanan;
use App\Models\PengajuanLayananDokumen;
use App\Models\VillageInformationRequest;
use App\Models\VillageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (! $user->village) {
            abort(403, 'Akun Warga Layanan Anda belum terhubung ke desa manapun.');
        }

        // Tampilkan layanan yang tersedia (sebagai grid ajukan layanan baru)
        $services = VillageService::where('village_id', $user->village->id)->get();

        // Tampilkan riwayat pengajuan user ini
        $pengajuan = PengajuanLayanan::where('user_id', $user->id)
            ->with('layanan')
            ->latest()
            ->paginate(10);

        // Tampilkan riwayat permohonan PPID user ini
        $ppidRequests = VillageInformationRequest::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('layanan.pengajuan.index', compact('services', 'pengajuan', 'ppidRequests'));
    }

    public function create(VillageService $layanan)
    {
        $user = auth()->user();
        if ($layanan->village_id !== $user->village_id) {
            abort(403, 'Layanan ini bukan milik desa Anda.');
        }

        return view('layanan.pengajuan.create', compact('layanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:village_services,id',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'keperluan' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,png,jpeg|max:2048',
            'dokumen_kk' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        $user = auth()->user();

        $pengajuan = PengajuanLayanan::create([
            'user_id' => $user->id,
            'layanan_id' => $request->layanan_id,
            'desa_id' => $user->village_id,
            'data_pemohon' => [
                'nama' => $request->nama,
                'nik' => $request->nik,
                'alamat' => $request->alamat,
                'keperluan' => $request->keperluan,
            ],
            'status' => 'diajukan',
        ]);

        $baseDir = "pengajuan-layanan/{$pengajuan->kode_tracking}";

        if ($request->hasFile('dokumen_ktp')) {
            $path = $request->file('dokumen_ktp')->store($baseDir, 'public');
            PengajuanLayananDokumen::create([
                'pengajuan_layanan_id' => $pengajuan->id,
                'nama_file' => 'KTP',
                'path_file' => $path,
                'tipe_dokumen' => 'KTP',
            ]);
        }

        if ($request->hasFile('dokumen_kk')) {
            $path = $request->file('dokumen_kk')->store($baseDir, 'public');
            PengajuanLayananDokumen::create([
                'pengajuan_layanan_id' => $pengajuan->id,
                'nama_file' => 'Kartu Keluarga',
                'path_file' => $path,
                'tipe_dokumen' => 'KK',
            ]);
        }

        return redirect()->route('layanan.pengajuan.show', $pengajuan->kode_tracking)
            ->with('success', 'Pengajuan layanan berhasil disubmit.');
    }

    public function show($kode_tracking)
    {
        $pengajuan = PengajuanLayanan::where('kode_tracking', $kode_tracking)->with(['layanan', 'dokumen'])->firstOrFail();

        // Otorisasi sederhana: pastikan milik user ini
        if ($pengajuan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('layanan.pengajuan.show', compact('pengajuan'));
    }

    public function downloadResult($kode_tracking)
    {
        $pengajuan = PengajuanLayanan::where('kode_tracking', $kode_tracking)->firstOrFail();

        if ($pengajuan->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($pengajuan->status !== 'selesai' || ! $pengajuan->file_surat_hasil) {
            abort(404, 'Surat hasil belum tersedia.');
        }

        return Storage::disk('public')->download($pengajuan->file_surat_hasil);
    }
}
