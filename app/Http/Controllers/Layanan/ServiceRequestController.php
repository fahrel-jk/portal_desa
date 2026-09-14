<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VillageService;
use App\Models\ServiceRequest as AppServiceRequest;

class ServiceRequestController extends Controller
{
    public function create(VillageService $service)
    {
        $user = auth()->user();
        
        // Pastikan service milik desa dari warga tersebut
        if ($service->village_id !== $user->village_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('layanan.create', compact('service'));
    }

    public function store(Request $request, VillageService $service)
    {
        $user = auth()->user();
        
        if ($service->village_id !== $user->village_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('service-requests', 'public');
        }

        AppServiceRequest::create([
            'user_id' => $user->id,
            'village_id' => $user->village_id,
            'village_service_id' => $service->id,
            'notes' => $validated['notes'],
            'attachment_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('layanan.dashboard')
            ->with('success', 'Pengajuan layanan berhasil dikirim.');
    }
}
