<?php

namespace App\Http\Controllers\Layanan;

use App\Http\Controllers\Controller;
use App\Models\VillageInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidRequestController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $village = $user->village;
        return view('layanan.ppid.create', compact('village', 'user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'agency' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'content' => 'required|string|max:5000',
        ]);

        VillageInformationRequest::create([
            'village_id' => $user->village_id,
            'user_id' => $user->id,
            'name' => $validated['name'],
            'agency' => $validated['agency'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'status' => 'pending',
        ]);

        return redirect()->route('layanan.dashboard')
            ->with('success', 'Permohonan informasi Anda telah berhasil dikirim dan akan segera diproses.');
    }

    public function show($id)
    {
        $user = auth()->user();
        $ppidRequest = VillageInformationRequest::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('layanan.ppid.show', compact('ppidRequest'));
    }

    public function download($id)
    {
        $user = auth()->user();
        $ppidRequest = VillageInformationRequest::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$ppidRequest->admin_reply_file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($ppidRequest->admin_reply_file_path);
    }
}
