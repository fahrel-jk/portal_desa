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
     * Show layout & navigation manager page for perwakilan desa.
     */
    public function index(): View
    {
        $user = auth()->user();
        $village = $user->village;

        if (! $village) {
            abort(404, 'Desa tidak ditemukan');
        }

        $sections = $village->getOrderedLayoutSections();
        $navSections = $village->getOrderedNavSections();

        return view('desa.layout', compact('village', 'sections', 'navSections'));
    }

    /**
     * Update section order, navigation menu, and visibility settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $village = $user->village;

        if (! $village) {
            abort(404, 'Desa tidak ditemukan');
        }

        $validated = $request->validate([
            'sections' => 'nullable|array',
            'sections.*.id' => 'required_with:sections|string',
            'sections.*.title' => 'nullable|string|max:255',
            'sections.*.enabled' => 'nullable|boolean',

            'nav_sections' => 'nullable|array',
            'nav_sections.*.id' => 'required_with:nav_sections|string',
            'nav_sections.*.label' => 'required_with:nav_sections|string|max:255',
            'nav_sections.*.placement' => 'nullable|string|in:main,dropdown',
            'nav_sections.*.enabled' => 'nullable|boolean',
            'nav_sections.*.type' => 'nullable|string',
            'nav_sections.*.target' => 'nullable|string|max:255',
        ]);

        $updateData = [];

        if (isset($validated['sections'])) {
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
            $updateData['layout_settings'] = $formattedSections;
        }

        if (isset($validated['nav_sections'])) {
            $formattedNav = [];
            $defaultNavMap = collect(Village::defaultNavSections())->keyBy('id');

            foreach ($validated['nav_sections'] as $nav) {
                $id = $nav['id'];
                if ($defaultNavMap->has($id)) {
                    $def = $defaultNavMap->get($id);
                    $formattedNav[] = [
                        'id' => $id,
                        'label' => $nav['label'] ?? $def['label'],
                        'type' => $def['type'],
                        'target' => $def['target'],
                        'placement' => in_array($nav['placement'] ?? 'main', ['main', 'dropdown']) ? $nav['placement'] : 'main',
                        'enabled' => isset($nav['enabled']) ? (bool) $nav['enabled'] : false,
                    ];
                } else {
                    // Custom link
                    $formattedNav[] = [
                        'id' => $id,
                        'label' => $nav['label'] ?? 'Custom Link',
                        'type' => 'custom',
                        'target' => $nav['target'] ?? '#',
                        'placement' => in_array($nav['placement'] ?? 'main', ['main', 'dropdown']) ? $nav['placement'] : 'main',
                        'enabled' => isset($nav['enabled']) ? (bool) $nav['enabled'] : false,
                    ];
                }
            }
            $updateData['navigation_settings'] = $formattedNav;
        }

        if (! empty($updateData)) {
            $village->update($updateData);
        }

        return redirect()->route('desa.layout.index')
            ->with('success', 'Pengaturan tata letak dan menu navigasi berhasil diperbarui!');
    }
}
