<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggaranController extends Controller
{
    /**
     * List village anggaran records, filterable by year.
     */
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        // Get distinct years for dropdown
        $years = $village->anggarans()
            ->selectRaw('DISTINCT tahun_anggaran')
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $selectedYear = $request->input('tahun', $years->first());

        $anggarans = collect();
        $totals = ['pendapatan' => 0, 'belanja' => 0, 'pembiayaan' => 0];

        if ($selectedYear) {
            $anggarans = $village->anggarans()
                ->forYear($selectedYear)
                ->orderByRaw("FIELD(kategori, 'pendapatan', 'belanja', 'pembiayaan')")
                ->orderBy('bidang')
                ->orderBy('uraian')
                ->get();

            foreach ($anggarans as $item) {
                $totals[$item->kategori] += $item->jumlah_anggaran;
            }
        }

        return view('desa.anggaran.index', compact('village', 'anggarans', 'years', 'selectedYear', 'totals'));
    }

    /**
     * Show create anggaran form.
     */
    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.anggaran.create', compact('village'));
    }

    /**
     * Store new anggaran record.
     */
    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'tahun_anggaran' => 'required|integer|min:2020|max:2030',
            'kategori' => 'required|in:pendapatan,belanja,pembiayaan',
            'bidang' => 'nullable|required_if:kategori,belanja|string|max:255',
            'uraian' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric|min:0',
            'jumlah_realisasi' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        Anggaran::create([
            'village_id' => $village->id,
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'kategori' => $validated['kategori'],
            'bidang' => $validated['kategori'] === 'belanja' ? $validated['bidang'] : null,
            'uraian' => $validated['uraian'],
            'jumlah_anggaran' => $validated['jumlah_anggaran'],
            'jumlah_realisasi' => $validated['jumlah_realisasi'] ?? 0,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('desa.anggaran.index', ['tahun' => $validated['tahun_anggaran']])
            ->with('success', 'Data anggaran berhasil ditambahkan.');
    }

    /**
     * Show edit anggaran form.
     */
    public function edit(Request $request, Anggaran $anggaran): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $anggaran->village_id === $village->id, 403);

        return view('desa.anggaran.edit', compact('village', 'anggaran'));
    }

    /**
     * Update anggaran record.
     */
    public function update(Request $request, Anggaran $anggaran): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $anggaran->village_id === $village->id, 403);

        $validated = $request->validate([
            'tahun_anggaran' => 'required|integer|min:2020|max:2030',
            'kategori' => 'required|in:pendapatan,belanja,pembiayaan',
            'bidang' => 'nullable|required_if:kategori,belanja|string|max:255',
            'uraian' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric|min:0',
            'jumlah_realisasi' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $anggaran->update([
            'tahun_anggaran' => $validated['tahun_anggaran'],
            'kategori' => $validated['kategori'],
            'bidang' => $validated['kategori'] === 'belanja' ? $validated['bidang'] : null,
            'uraian' => $validated['uraian'],
            'jumlah_anggaran' => $validated['jumlah_anggaran'],
            'jumlah_realisasi' => $validated['jumlah_realisasi'] ?? 0,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('desa.anggaran.index', ['tahun' => $validated['tahun_anggaran']])
            ->with('success', 'Data anggaran berhasil diperbarui.');
    }

    /**
     * Delete anggaran record.
     */
    public function destroy(Request $request, Anggaran $anggaran): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $anggaran->village_id === $village->id, 403);

        $tahun = $anggaran->tahun_anggaran;
        $anggaran->delete();

        return redirect()->route('desa.anggaran.index', ['tahun' => $tahun])
            ->with('success', 'Data anggaran berhasil dihapus.');
    }
}
