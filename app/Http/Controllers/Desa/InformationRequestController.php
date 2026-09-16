<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Village;
use App\Models\VillageInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InformationRequestController extends Controller
{
    /**
     * Store a new information request from the public side.
     */
    public function store(Request $request, string $slug)
    {
        $village = Village::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:5000',
        ]);

        $village->informationRequests()->create($validated);

        return redirect()->route('village.ppid.request', $village->slug)
            ->with('success', 'Permohonan informasi Anda telah berhasil dikirim dan akan segera diproses oleh admin desa.');
    }

    /**
     * Admin: Display a listing of the information requests.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->village_id) {
            abort(403);
        }

        $requests = VillageInformationRequest::where('village_id', $user->village_id)
            ->latest()
            ->paginate(15);

        return view('desa.information_requests.index', compact('requests'));
    }

    /**
     * Admin: Update the specified information request's status.
     */
    public function update(Request $request, VillageInformationRequest $informationRequest)
    {
        $user = Auth::user();
        
        // Ensure user belongs to the same village as the request
        if ($user->village_id !== $informationRequest->village_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processed', 'completed', 'rejected'])],
            'admin_reply' => ['nullable', 'string'],
            'admin_reply_file' => ['nullable', 'file', 'max:2048', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($request->has('admin_reply')) {
            $updateData['admin_reply'] = $validated['admin_reply'];
        }

        if ($request->hasFile('admin_reply_file')) {
            $path = $request->file('admin_reply_file')->store("ppid-replies/{$informationRequest->id}", 'public');
            $updateData['admin_reply_file_path'] = $path;
        }

        $informationRequest->update($updateData);

        return back()->with('success', 'Status dan balasan permohonan informasi berhasil diperbarui.');
    }
}
