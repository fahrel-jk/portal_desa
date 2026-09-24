<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LayoutController extends Controller
{
    /**
     * Show layout manager page for perwakilan desa.
     */
    public function index(): View
    {
        $user = auth()->user();
        $village = $user->village;

        if (! $village) {
            abort(404, 'Desa tidak ditemukan');
        }

        $sections = $village->getOrderedLayoutSections();

        return view('desa.layout', compact('village', 'sections'));
    }

    /**
     * Update section order and visibility settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $village = $user->village;

        if (! $village) {
            abort(404, 'Desa tidak ditemukan');
        }

        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|string',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.enabled' => 'nullable|boolean',
        ]);

        $formattedSections = [];
        $validIds = collect(Village::defaultLayoutSections())->pluck('id')->all();

        foreach ($validated['sections'] as $sec) {
            if (in_array($sec['id'], $validIds)) {
                $formattedSections[] = [
                    'id' => $sec['id'],
                    'title' => $sec['title'] ?? null,
                    'enabled' => isset($sec['enabled']) ? (bool) $sec['enabled'] : false,
                ];
            }
        }

        $village->update([
            'layout_settings' => $formattedSections,
        ]);

        return redirect()->route('desa.layout.index')
            ->with('success', 'Pengaturan tata letak (layout) desa berhasil diperbarui!');
    }
}
