<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $village = auth()->user()->village;

        $requests = ServiceRequest::with(['user', 'service'])
            ->where('village_id', $village->id)
            ->latest()
            ->paginate(15);

        return view('desa.service_requests.index', compact('requests', 'village'));
    }

    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        // Ensure request belongs to this village
        if ($serviceRequest->village_id !== auth()->user()->village_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:processed,completed,rejected',
            'response_message' => 'nullable|string|max:1000',
        ]);

        $serviceRequest->update([
            'status' => $validated['status'],
            'response_message' => $validated['response_message'],
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
