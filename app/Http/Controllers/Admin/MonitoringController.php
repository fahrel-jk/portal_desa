<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Carbon\Carbon;

class MonitoringController extends Controller
{
    /**
     * Display the adoption monitoring dashboard.
     */
    public function index()
    {
        // Aggregate Stats
        $stats = [
            'total' => Village::count(),
            'published' => Village::where('status', 'published')->count(),
            'pending' => Village::where('status', 'pending_review')->count(),
            'rejected' => Village::where('status', 'rejected')->count(),
        ];

        // Monthly Registrations Data (last 6 months)
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        $monthlyData = Village::where('created_at', '>=', $sixMonthsAgo)
            ->get()
            ->groupBy(function ($village) {
                return $village->created_at->format('Y-m');
            })
            ->map(function ($group) {
                return (object) ['count' => $group->count()];
            });

        // Prepare chart data (labels and series)
        // Ensure all last 6 months are represented even if 0
        $chartLabels = [];
        $chartValues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('Y-m');
            $monthLabel = Carbon::now()->subMonths($i)->translatedFormat('M Y');

            $found = isset($monthlyData[$month]) ? $monthlyData[$month] : null;

            $chartLabels[] = $monthLabel;
            $chartValues[] = $found ? $found->count : 0;
        }

        // Inactive Villages
        // Criteria: published AND (no news OR last news created > 30 days ago)
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $inactiveVillages = Village::where('status', 'published')
            ->where(function ($query) use ($thirtyDaysAgo) {
                $query->whereDoesntHave('news')
                    ->orWhereHas('news', function ($q) {
                        // Note: if ALL news are older than 30 days
                    }, '=', 0) // No news in the last 30 days
                    ->orWhereDoesntHave('news', function ($q) use ($thirtyDaysAgo) {
                        $q->where('created_at', '>=', $thirtyDaysAgo);
                    });
            })
            ->with('user')
            ->get()
            ->map(function ($village) {
                $lastNews = $village->news()->latest()->first();
                $village->last_activity_days = $lastNews ? $lastNews->created_at->diffInDays(Carbon::now()) : 'Belum pernah';

                return $village;
            })
            ->sortByDesc(function ($village) {
                return $village->last_activity_days === 'Belum pernah' ? 9999 : $village->last_activity_days;
            })
            ->values();

        return view('admin.monitoring', compact('stats', 'chartLabels', 'chartValues', 'inactiveVillages'));
    }
}
