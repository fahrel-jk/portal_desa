<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $village = auth()->user()->village;
        $documents = $village->documents()->paginate(10);
        return view('desa.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        return view('desa.documents.create');
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB PDF
            'is_active' => 'boolean',
        ]);

        $village = auth()->user()->village;

        $path = $request->file('file')->store('village_documents/' . $village->id, 'public');

        $village->documents()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'file_path' => $path,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('desa.documents.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(VillageDocument $document)
    {
        // Check authorization
        if ($document->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        return view('desa.documents.edit', compact('document'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, VillageDocument $document)
    {
        // Check authorization
        if ($document->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB PDF
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            // Store new file
            $data['file_path'] = $request->file('file')->store('village_documents/' . $document->village_id, 'public');
        }

        $document->update($data);

        return redirect()->route('desa.documents.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(VillageDocument $document)
    {
        // Check authorization
        if ($document->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('desa.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}
