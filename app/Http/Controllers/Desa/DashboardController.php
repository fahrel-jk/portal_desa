<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageNews;
use App\Models\VillageOfficial;
use App\Models\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Edit village profile.
     */
    public function editProfile(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.profile-edit', compact('village'));
    }

    /**
     * Update village profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'description' => 'nullable|string|max:5000',
            'history' => 'nullable|string|max:10000',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'office_hours' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'theme_color' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'remove_logo' => 'nullable|boolean',
            'remove_hero' => 'nullable|boolean',
            'visi' => 'nullable|string|max:1000',
            'misi' => 'nullable|string|max:5000',
            'bagan_struktur' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'remove_bagan' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            if ($village->logo_path) {
                Storage::disk('public')->delete($village->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('villages/logos', 'public');
        } elseif ($request->boolean('remove_logo') && $village->logo_path) {
            Storage::disk('public')->delete($village->logo_path);
            $validated['logo_path'] = null;
        }

        if ($request->hasFile('hero_image')) {
            if ($village->hero_image_path) {
                Storage::disk('public')->delete($village->hero_image_path);
            }
            $validated['hero_image_path'] = $request->file('hero_image')->store('villages/heroes', 'public');
        } elseif ($request->boolean('remove_hero') && $village->hero_image_path) {
            Storage::disk('public')->delete($village->hero_image_path);
            $validated['hero_image_path'] = null;
        }

        if ($request->hasFile('bagan_struktur')) {
            if ($village->bagan_struktur_path) {
                Storage::disk('public')->delete($village->bagan_struktur_path);
            }
            $validated['bagan_struktur_path'] = $request->file('bagan_struktur')->store('villages/bagan', 'public');
        } elseif ($request->boolean('remove_bagan') && $village->bagan_struktur_path) {
            Storage::disk('public')->delete($village->bagan_struktur_path);
            $validated['bagan_struktur_path'] = null;
        }

        unset($validated['logo']);
        unset($validated['hero_image']);
        unset($validated['bagan_struktur']);
        unset($validated['remove_logo']);
        unset($validated['remove_hero']);
        unset($validated['remove_bagan']);

        $village->update($validated);

        return back()->with('success', 'Profil desa berhasil diperbarui.');
    }

    /**
     * List village officials.
     */
    public function officialsIndex(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $officials = $village->officials;

        return view('desa.officials.index', compact('village', 'officials'));
    }

    /**
     * Show create official form.
     */
    public function officialsCreate(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.officials.create', compact('village'));
    }

    /**
     * Store a new official.
     */
    public function officialsStore(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('villages/officials', 'public');
        }

        VillageOfficial::create([
            'village_id' => $village->id,
            'name' => $validated['name'],
            'position' => $validated['position'],
            'photo_path' => $photoPath,
            'order' => $village->officials()->max('order') + 1,
        ]);

        return redirect()->route('desa.officials.index')->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    /**
     * Show edit official form.
     */
    public function officialsEdit(Request $request, VillageOfficial $official): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $official->village_id === $village->id, 403);

        return view('desa.officials.edit', compact('village', 'official'));
    }

    /**
     * Update an official.
     */
    public function officialsUpdate(Request $request, VillageOfficial $official): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $official->village_id === $village->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($official->photo_path) {
                Storage::disk('public')->delete($official->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('villages/officials', 'public');
        }

        $official->update(array_filter($validated, fn ($key) => $key !== 'photo', ARRAY_FILTER_USE_KEY));

        return redirect()->route('desa.officials.index')->with('success', 'Data perangkat desa berhasil diperbarui.');
    }

    /**
     * Delete an official.
     */
    public function officialsDestroy(Request $request, VillageOfficial $official): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $official->village_id === $village->id, 403);

        if ($official->photo_path) {
            Storage::disk('public')->delete($official->photo_path);
        }
        $official->delete();

        return redirect()->route('desa.officials.index')->with('success', 'Perangkat desa berhasil dihapus.');
    }

    /**
     * List village news.
     */
    public function newsIndex(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $news = $village->news;

        return view('desa.news.index', compact('village', 'news'));
    }

    /**
     * Show create news form.
     */
    public function newsCreate(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.news.create', compact('village'));
    }

    /**
     * Store a news article.
     */
    public function newsStore(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('villages/news', 'public');
        }

        VillageNews::create([
            'village_id' => $village->id,
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'cover_image_path' => $coverPath,
            'published_at' => now(),
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('desa.news.index')->with('success', 'Berita berhasil dipublikasikan.');
    }

    /**
     * Show edit news form.
     */
    public function newsEdit(Request $request, VillageNews $news): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $news->village_id === $village->id, 403);

        return view('desa.news.edit', compact('village', 'news'));
    }

    /**
     * Update a news article.
     */
    public function newsUpdate(Request $request, VillageNews $news): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $news->village_id === $village->id, 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($news->cover_image_path) {
                Storage::disk('public')->delete($news->cover_image_path);
            }
            $validated['cover_image_path'] = $request->file('cover_image')->store('villages/news', 'public');
        }

        $news->update([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'content' => $validated['content'],
            'cover_image_path' => $validated['cover_image_path'] ?? $news->cover_image_path,
        ]);

        return redirect()->route('desa.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Delete a news article.
     */
    public function newsDestroy(Request $request, VillageNews $news): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $news->village_id === $village->id, 403);

        if ($news->cover_image_path) {
            Storage::disk('public')->delete($news->cover_image_path);
        }
        $news->delete();

        return redirect()->route('desa.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    // ========================================
    // VILLAGE SERVICES (Layanan Administrasi)
    // ========================================

    /**
     * List village services.
     */
    public function servicesIndex(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $services = $village->services;

        return view('desa.services.index', compact('village', 'services'));
    }

    /**
     * Show create service form.
     */
    public function servicesCreate(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.services.create', compact('village'));
    }

    /**
     * Store a new service.
     */
    public function servicesStore(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'requirements' => 'nullable|string|max:2000',
            'process_steps' => 'nullable|string|max:3000',
            'estimated_time' => 'nullable|string|max:100',
            'cost' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        VillageService::create([
            'village_id' => $village->id,
            'name' => $validated['name'],
            'slug' => VillageService::generateSlug($validated['name'], $village->id),
            'description' => $validated['description'] ?? null,
            'requirements' => $validated['requirements'] ?? null,
            'process_steps' => $validated['process_steps'] ?? null,
            'estimated_time' => $validated['estimated_time'] ?? null,
            'cost' => $validated['cost'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('desa.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Show edit service form.
     */
    public function servicesEdit(Request $request, VillageService $service): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $service->village_id === $village->id, 403);

        return view('desa.services.edit', compact('village', 'service'));
    }

    /**
     * Update a service.
     */
    public function servicesUpdate(Request $request, VillageService $service): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $service->village_id === $village->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'requirements' => 'nullable|string|max:2000',
            'process_steps' => 'nullable|string|max:3000',
            'estimated_time' => 'nullable|string|max:100',
            'cost' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        // Regenerate slug if name changed
        if ($service->name !== $validated['name'] || !$service->slug) {
            $validated['slug'] = VillageService::generateSlug($validated['name'], $village->id, $service->id);
        }

        $service->update($validated);

        return redirect()->route('desa.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Delete a service.
     */
    public function servicesDestroy(Request $request, VillageService $service): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $service->village_id === $village->id, 403);

        $service->delete();

        return redirect()->route('desa.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
