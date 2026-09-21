<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(Request $request): View
    {
        $stats = [
            'total_villages' => Village::where('status', 'published')->count(),
            'total_districts' => Village::where('status', 'published')->distinct('kecamatan')->count('kecamatan'),
        ];

        // Filter data
        $kecamatans = Village::where('status', 'published')->distinct()->pluck('kecamatan')->filter()->sort();
        $kabupatens = Village::where('status', 'published')->distinct()->pluck('kabupaten')->filter()->sort();

        // Search parameters
        $q = $request->get('q');
        $kecamatan = $request->get('kecamatan');
        $kabupaten = $request->get('kabupaten');

        $isSearching = $q || $kecamatan || $kabupaten;

        $showcaseVillages = collect();
        $searchResults = null;

        if ($isSearching) {
            $query = Village::with('template')->where('status', 'published');

            if ($q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('kecamatan', 'like', "%{$q}%")
                        ->orWhere('kabupaten', 'like', "%{$q}%");
                });
            }

            if ($kecamatan) {
                $query->where('kecamatan', $kecamatan);
            }

            if ($kabupaten) {
                $query->where('kabupaten', $kabupaten);
            }

            $searchResults = $query->latest('approved_at')->paginate(9)->withQueryString();
        } else {
            // Get featured villages for showcase
            $showcaseVillages = Village::with('template')
                ->where('status', 'published')
                ->where('is_featured', true)
                ->latest('approved_at')
                ->take(6)
                ->get();
        }

        return view('welcome', compact('stats', 'showcaseVillages', 'searchResults', 'isSearching', 'kecamatans', 'kabupatens'));
    }
}
