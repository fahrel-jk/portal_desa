<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageDemographic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DemographicController extends Controller
{
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $demographics = $village->demographics;

        $groupedDemographics = $demographics->groupBy('type');

        return view('desa.demographics.index', compact('village', 'groupedDemographics'));
    }

    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.demographics.create', compact('village'));
    }

    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'count' => 'required|integer|min:0',
        ]);

        VillageDemographic::create([
            'village_id' => $village->id,
            'type' => $validated['type'],
            'label' => $validated['label'],
            'count' => $validated['count'],
        ]);

        return redirect()->route('desa.demographics.index')->with('success', 'Data statistik berhasil ditambahkan.');
    }

    public function edit(Request $request, VillageDemographic $demographic): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $demographic->village_id === $village->id, 403);

        return view('desa.demographics.edit', compact('village', 'demographic'));
    }

    public function update(Request $request, VillageDemographic $demographic): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $demographic->village_id === $village->id, 403);

        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'count' => 'required|integer|min:0',
        ]);

        $demographic->update($validated);

        return redirect()->route('desa.demographics.index')->with('success', 'Data statistik berhasil diperbarui.');
    }

    public function destroy(Request $request, VillageDemographic $demographic): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $demographic->village_id === $village->id, 403);

        $demographic->delete();

        return redirect()->route('desa.demographics.index')->with('success', 'Data statistik berhasil dihapus.');
    }
}
