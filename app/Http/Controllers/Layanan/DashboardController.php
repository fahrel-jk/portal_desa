<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use App\Models\VillageService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $village = $user->village;

        if (! $village) {
            abort(403, 'Akun Warga Layanan Anda belum terhubung ke desa manapun.');
        }

        $services = VillageService::where('village_id', $village->id)->get();
        $requests = ServiceRequest::with('service')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('layanan.dashboard', compact('village', 'services', 'requests'));
    }
}
