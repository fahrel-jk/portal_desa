<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\AccessRequest;
use App\Http\Requests\StoreAccessRequestRequest;
use Illuminate\Http\Request;

class AccessRequestController extends Controller
{
    public function create($slug)
    {
        $village = Village::where('slug', $slug)->firstOrFail();
        
        return view('desa.request-akses', compact('village'));
    }

    public function store(StoreAccessRequestRequest $request, $slug)
    {
        $village = Village::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validated();
        
        if ($request->hasFile('dokumen_pendukung')) {
            $path = $request->file('dokumen_pendukung')->store('access-requests', 'public');
            $validated['dokumen_pendukung'] = $path;
        }

        $validated['desa_id'] = $village->id;
        $validated['status'] = 'pending';

        AccessRequest::create($validated);

        return redirect()->route('village.show', $village->slug)
            ->with('success', 'Permintaan akses berhasil dikirim dan sedang menunggu persetujuan admin provinsi.');
    }
}
