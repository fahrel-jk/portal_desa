<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\TitikLokasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TitikLokasiController extends Controller
{
    /**
     * List all titik lokasi for the authenticated user's village.
     */
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $titikLokasis = $village->titikLokasis()->orderBy('kategori')->orderBy('nama_lokasi')->get();

        return view('desa.titik_lokasi.index', compact('village', 'titikLokasis'));
    }

    /**
     * Show create titik lokasi form with interactive map.
     */
    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.titik_lokasi.create', compact('village'));
    }

    /**
     * Store new titik lokasi.
     */
    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kategori' => 'required|in:pemerintahan,kesehatan,pendidikan,ibadah,lainnya',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('titik-lokasi', 'public');
        }

        TitikLokasi::create([
            'village_id' => $village->id,
            'nama_lokasi' => $validated['nama_lokasi'],
            'kategori' => $validated['kategori'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('desa.titik-lokasi.index')
            ->with('success', 'Titik lokasi berhasil ditambahkan.');
    }

    /**
     * Show edit titik lokasi form with interactive map.
     */
    public function edit(Request $request, TitikLokasi $titikLokasi): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $titikLokasi->village_id === $village->id, 403);

        return view('desa.titik_lokasi.edit', compact('village', 'titikLokasi'));
    }

    /**
     * Update titik lokasi.
     */
    public function update(Request $request, TitikLokasi $titikLokasi): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $titikLokasi->village_id === $village->id, 403);

        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'kategori' => 'required|in:pemerintahan,kesehatan,pendidikan,ibadah,lainnya',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'deskripsi' => 'nullable|string|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $fotoPath = $titikLokasi->foto;
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($titikLokasi->foto) {
                Storage::disk('public')->delete($titikLokasi->foto);
            }
            $fotoPath = $request->file('foto')->store('titik-lokasi', 'public');
        }

        $titikLokasi->update([
            'nama_lokasi' => $validated['nama_lokasi'],
            'kategori' => $validated['kategori'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('desa.titik-lokasi.index')
            ->with('success', 'Titik lokasi berhasil diperbarui.');
    }

    /**
     * Delete titik lokasi.
     */
    public function destroy(Request $request, TitikLokasi $titikLokasi): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $titikLokasi->village_id === $village->id, 403);

        if ($titikLokasi->foto) {
            Storage::disk('public')->delete($titikLokasi->foto);
        }

        $titikLokasi->delete();

        return redirect()->route('desa.titik-lokasi.index')
            ->with('success', 'Titik lokasi berhasil dihapus.');
    }
}
