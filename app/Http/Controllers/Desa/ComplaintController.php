<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageComplaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $complaints = $village->complaints()->paginate(15);

        return view('desa.complaints.index', compact('village', 'complaints'));
    }

    public function show(Request $request, VillageComplaint $complaint): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $complaint->village_id === $village->id, 403);

        return view('desa.complaints.show', compact('village', 'complaint'));
    }

    public function updateStatus(Request $request, VillageComplaint $complaint): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $complaint->village_id === $village->id, 403);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,resolved,rejected',
        ]);

        $complaint->update(['status' => $validated['status']]);

        return redirect()->route('desa.complaints.show', $complaint)->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
