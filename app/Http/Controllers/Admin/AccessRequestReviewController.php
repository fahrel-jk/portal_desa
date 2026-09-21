<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccessRequestReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = AccessRequest::with('village')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('village_id')) {
            $query->where('desa_id', $request->village_id);
        }

        $requests = $query->paginate(15);
        $villages = Village::orderBy('name')->get();

        return view('admin.access-requests.index', compact('requests', 'villages'));
    }

    public function show(AccessRequest $accessRequest)
    {
        $accessRequest->load(['village', 'reviewer']);

        return view('admin.access-requests.show', compact('accessRequest'));
    }

    public function approve(AccessRequest $accessRequest)
    {
        if ($accessRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah tidak berstatus pending.');
        }

        DB::beginTransaction();
        try {
            // Generate password
            $password = Str::random(10);

            // Create User
            $user = User::create([
                'name' => $accessRequest->nama_lengkap,
                'email' => $accessRequest->email,
                'password' => Hash::make($password),
                'role' => 'warga_layanan',
                'village_id' => $accessRequest->desa_id,
            ]);

            // Update Request
            $accessRequest->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.access-requests.index')
                ->with('success', 'Request disetujui. Akun berhasil dibuat.')
                ->with('generated_password', $password)
                ->with('generated_email', $user->email);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan saat menyetujui request: '.$e->getMessage());
        }
    }

    public function reject(Request $request, AccessRequest $accessRequest)
    {
        if ($accessRequest->status !== 'pending') {
            return back()->with('error', 'Request sudah tidak berstatus pending.');
        }

        $request->validate([
            'alasan_reject' => 'required|string|max:500',
        ]);

        $accessRequest->update([
            'status' => 'rejected',
            'alasan_reject' => $request->alasan_reject,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.access-requests.index')
            ->with('success', 'Request akses berhasil ditolak.');
    }
}
