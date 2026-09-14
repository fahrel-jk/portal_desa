<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\View\View;

class VillagePageController extends Controller
{
    /**
     * Render the public village page.
     * Only published villages are accessible.
     */
    public function show(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template', 'officials', 'news', 'services', 'galleries', 'titikLokasis');

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik';
        }

        return view($viewName, compact('village'));
    }
}
