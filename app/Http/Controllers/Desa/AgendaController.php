<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageAgenda;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    /**
     * List village agenda events, filterable by month/year.
     */
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $agendas = $village->agendas()
            ->forMonth($year, $month)
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        return view('desa.agenda.index', compact('village', 'agendas', 'year', 'month'));
    }

    /**
     * Show create agenda form.
     */
    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.agenda.create', compact('village'));
    }

    /**
     * Store new agenda event.
     */
    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'category' => 'required|in:' . implode(',', array_keys(VillageAgenda::CATEGORY_OPTIONS)),
            'is_important' => 'boolean',
        ]);

        $village->agendas()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'category' => $validated['category'],
            'is_important' => $validated['is_important'] ?? false,
        ]);

        return redirect()->route('desa.agenda.index', [
            'year' => date('Y', strtotime($validated['event_date'])),
            'month' => date('n', strtotime($validated['event_date'])),
        ])->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Show edit agenda form.
     */
    public function edit(Request $request, VillageAgenda $agenda): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $agenda->village_id === $village->id, 403);

        return view('desa.agenda.edit', compact('village', 'agenda'));
    }

    /**
     * Update agenda event.
     */
    public function update(Request $request, VillageAgenda $agenda): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $agenda->village_id === $village->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'category' => 'required|in:' . implode(',', array_keys(VillageAgenda::CATEGORY_OPTIONS)),
            'is_important' => 'boolean',
        ]);

        $agenda->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'category' => $validated['category'],
            'is_important' => $validated['is_important'] ?? false,
        ]);

        return redirect()->route('desa.agenda.index', [
            'year' => date('Y', strtotime($validated['event_date'])),
            'month' => date('n', strtotime($validated['event_date'])),
        ])->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Delete agenda event.
     */
    public function destroy(Request $request, VillageAgenda $agenda): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $agenda->village_id === $village->id, 403);

        $year = $agenda->event_date->year;
        $month = $agenda->event_date->month;
        $agenda->delete();

        return redirect()->route('desa.agenda.index', [
            'year' => $year,
            'month' => $month,
        ])->with('success', 'Agenda berhasil dihapus.');
    }
}
