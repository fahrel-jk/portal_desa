<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageGallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * List village galleries.
     */
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $galleries = $village->galleries;

        return view('desa.galleries.index', compact('village', 'galleries'));
    }

    /**
     * Show create gallery form.
     */
    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.galleries.create', compact('village'));
    }

    /**
     * Store new gallery images.
     */
    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'caption' => 'nullable|string|max:255',
        ]);

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('villages/galleries', 'public');

            VillageGallery::create([
                'village_id' => $village->id,
                'image_path' => $imagePath,
                'caption' => $request->input('caption'),
            ]);
        }

        return redirect()->route('desa.galleries.index')->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    /**
     * Delete a gallery image.
     */
    public function destroy(Request $request, VillageGallery $gallery): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $gallery->village_id === $village->id, 403);

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        $gallery->delete();

        return redirect()->route('desa.galleries.index')->with('success', 'Foto berhasil dihapus dari galeri.');
    }
}
