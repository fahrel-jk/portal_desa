<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * List village products.
     */
    public function index(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $products = $village->products;

        return view('desa.products.index', compact('village', 'products'));
    }

    /**
     * Show create product form.
     */
    public function create(Request $request): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        return view('desa.products.create', compact('village'));
    }

    /**
     * Store a new product.
     */
    public function store(Request $request): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'contact_whatsapp' => 'nullable|string|max:20',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('villages/products', 'public');
        }

        VillageProduct::create([
            'village_id' => $village->id,
            'name' => $validated['name'],
            'slug' => VillageProduct::generateSlug($validated['name'], $village->id),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'category' => $validated['category'] ?? null,
            'image_path' => $imagePath,
            'contact_whatsapp' => $validated['contact_whatsapp'] ?? null,
            'is_active' => true,
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('desa.products.index')->with('success', 'Produk UMKM berhasil ditambahkan.');
    }

    /**
     * Show edit product form.
     */
    public function edit(Request $request, VillageProduct $product): View
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $product->village_id === $village->id, 403);

        return view('desa.products.edit', compact('village', 'product'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, VillageProduct $product): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $product->village_id === $village->id, 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'contact_whatsapp' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('villages/products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => VillageProduct::generateSlug($validated['name'], $village->id, $product->id),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'category' => $validated['category'] ?? null,
            'image_path' => $validated['image_path'] ?? $product->image_path,
            'contact_whatsapp' => $validated['contact_whatsapp'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('desa.products.index')->with('success', 'Produk UMKM berhasil diperbarui.');
    }

    /**
     * Delete a product.
     */
    public function destroy(Request $request, VillageProduct $product): RedirectResponse
    {
        $village = $request->user()->village;
        abort_unless($village && $village->isPublished() && $product->village_id === $village->id, 403);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('desa.products.index')->with('success', 'Produk UMKM berhasil dihapus.');
    }
}
