<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $stats = [
            'total_villages' => Village::where('status', 'published')->count(),
            'total_districts' => Village::where('status', 'published')->distinct('kecamatan')->count('kecamatan'),
        ];

        // Get 3 recently published villages for showcase
        $showcaseVillages = Village::with('template')
            ->where('status', 'published')
            ->latest('approved_at')
            ->take(3)
            ->get();

        return view('welcome', compact('stats', 'showcaseVillages'));
    }
}
