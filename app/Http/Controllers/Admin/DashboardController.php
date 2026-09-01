<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Notifications\VillageApprovedNotification;
use App\Notifications\VillageRejectedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with summary and pending queue.
     */
    public function index(): View
    {
        $stats = [
            'pending' => Village::where('status', 'pending_review')->count(),
            'published' => Village::where('status', 'published')->count(),
            'rejected' => Village::where('status', 'rejected')->count(),
            'total' => Village::count(),
        ];

        $pendingVillages = Village::with('template', 'user')
            ->where('status', 'pending_review')
            ->latest('submitted_at')
            ->get();

        $allVillages = Village::with('template', 'user')
            ->latest('submitted_at')
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingVillages', 'allVillages'));
    }

    /**
     * Show detail review page for a village.
     */
    public function show(Village $village): View
    {
        $village->load('template', 'user', 'officials', 'news', 'services');

        return view('admin.review', compact('village'));
    }

    /**
     * Preview the village public page without publishing it.
     */
    public function preview(Village $village): View
    {
        $village->load('template', 'user', 'officials', 'news', 'services');

        $templateView = 'village.templates.'.$village->template->slug;

        if (! view()->exists($templateView)) {
            $templateView = 'village.templates.klasik';
        }

        return view($templateView, compact('village'));
    }

    /**
     * Approve a village registration.
     */
    public function approve(Village $village): RedirectResponse
    {
        if ($village->status !== 'pending_review') {
            return back()->with('error', 'Hanya desa dengan status "Menunggu Review" yang dapat disetujui.');
        }

        $village->update([
            'status' => 'published',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        $village->user->notify(new VillageApprovedNotification($village));

        return redirect()->route('admin.dashboard')
            ->with('success', "Desa \"{$village->name}\" berhasil disetujui dan sudah tayang di /desa/{$village->slug}");
    }

    /**
     * Reject a village registration.
     */
    public function reject(Request $request, Village $village): RedirectResponse
    {
        if ($village->status !== 'pending_review') {
            return back()->with('error', 'Hanya desa dengan status "Menunggu Review" yang dapat ditolak.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $village->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        $village->user->notify(new VillageRejectedNotification($village));

        return redirect()->route('admin.dashboard')
            ->with('success', "Desa \"{$village->name}\" telah ditolak.");
    }
}
