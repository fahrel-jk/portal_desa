<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Village;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    /**
     * Show public APBDes transparency page for a village.
     */
    public function show(string $slug, Request $request): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        // Get distinct years available
        $years = $village->anggarans()
            ->selectRaw('DISTINCT tahun_anggaran')
            ->orderByDesc('tahun_anggaran')
            ->pluck('tahun_anggaran');

        $selectedYear = $request->input('tahun', $years->first());

        $anggarans = collect();
        $totals = [
            'pendapatan' => ['anggaran' => 0, 'realisasi' => 0],
            'belanja' => ['anggaran' => 0, 'realisasi' => 0],
            'pembiayaan' => ['anggaran' => 0, 'realisasi' => 0],
        ];
        $chartData = [];

        if ($selectedYear) {
            $anggarans = $village->anggarans()
                ->forYear($selectedYear)
                ->orderByRaw("FIELD(kategori, 'pendapatan', 'belanja', 'pembiayaan')")
                ->orderBy('bidang')
                ->orderBy('uraian')
                ->get();

            // Calculate totals
            foreach ($anggarans as $item) {
                $totals[$item->kategori]['anggaran'] += $item->jumlah_anggaran;
                $totals[$item->kategori]['realisasi'] += $item->jumlah_realisasi;
            }

            // Prepare chart data — group belanja by bidang
            $belanjaBidang = $anggarans->where('kategori', 'belanja')->groupBy('bidang');
            foreach ($belanjaBidang as $bidang => $items) {
                $chartData[] = [
                    'label' => $bidang ?: 'Lainnya',
                    'anggaran' => $items->sum('jumlah_anggaran'),
                    'realisasi' => $items->sum('jumlah_realisasi'),
                ];
            }
        }

        $selisih = $totals['pendapatan']['realisasi'] - $totals['belanja']['realisasi'];

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.apbdes";

        if (! view()->exists($viewName)) {
            $viewName = 'village.apbdes'; // Fallback to old shared view
        }

        return view($viewName, compact(
            'village', 'years', 'selectedYear', 'anggarans', 'totals', 'selisih', 'chartData'
        ));
    }

    /**
     * Export APBDes summary as PDF.
     */
    public function exportPdf(string $slug, Request $request)
    {
        $village = Village::where('slug', $slug)->first();
        abort_unless($village && $village->isPublished(), 404);

        $selectedYear = $request->input('tahun', now()->year);

        $anggarans = $village->anggarans()
            ->forYear($selectedYear)
            ->orderByRaw("FIELD(kategori, 'pendapatan', 'belanja', 'pembiayaan')")
            ->orderBy('bidang')
            ->orderBy('uraian')
            ->get();

        $totals = [
            'pendapatan' => ['anggaran' => 0, 'realisasi' => 0],
            'belanja' => ['anggaran' => 0, 'realisasi' => 0],
            'pembiayaan' => ['anggaran' => 0, 'realisasi' => 0],
        ];

        foreach ($anggarans as $item) {
            $totals[$item->kategori]['anggaran'] += $item->jumlah_anggaran;
            $totals[$item->kategori]['realisasi'] += $item->jumlah_realisasi;
        }

        $selisih = $totals['pendapatan']['realisasi'] - $totals['belanja']['realisasi'];
        $tanggal = now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('pdf.apbdes', compact(
            'village', 'anggarans', 'totals', 'selisih', 'selectedYear', 'tanggal'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download("APBDes-{$village->name}-{$selectedYear}.pdf");
    }
}
