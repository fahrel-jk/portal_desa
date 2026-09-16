<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\VillageFaq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the faqs.
     */
    public function index()
    {
        $village = auth()->user()->village;
        $faqs = $village->faqs()->orderBy('order')->paginate(10);
        return view('desa.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new faq.
     */
    public function create()
    {
        return view('desa.faqs.create');
    }

    /**
     * Store a newly created faq in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $village = auth()->user()->village;

        $village->faqs()->create([
            'question' => $request->question,
            'answer' => $request->answer,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('desa.faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified faq.
     */
    public function edit(VillageFaq $faq)
    {
        if ($faq->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        return view('desa.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified faq in storage.
     */
    public function update(Request $request, VillageFaq $faq)
    {
        if ($faq->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('desa.faqs.index')
            ->with('success', 'FAQ berhasil diperbarui.');
    }

    /**
     * Remove the specified faq from storage.
     */
    public function destroy(VillageFaq $faq)
    {
        if ($faq->village_id !== auth()->user()->village_id) {
            abort(403);
        }

        $faq->delete();

        return redirect()->route('desa.faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}
