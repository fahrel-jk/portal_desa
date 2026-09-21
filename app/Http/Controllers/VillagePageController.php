<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Models\VillageComplaint;
use App\Models\VillageNews;
use App\Models\VillageProduct;
use App\Models\VillageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillagePageController extends Controller
{
    /**
     * Render the public village page.
     * Only published villages are accessible.
     */
    public function show(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template', 'officials', 'news', 'services', 'galleries', 'titikLokasis', 'products', 'agendas');

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik';
        }

        return view($viewName, compact('village'));
    }

    /**
     * Show village profile details (Visi, Misi, Bagan Struktur).
     */
    public function profile(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load(['template', 'officials', 'demographics']);

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.profil";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.profil';
        }

        return view($viewName, compact('village'));
    }

    /**
     * Show all news for a village (paginated).
     */
    public function newsIndex(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $news = $village->news()->paginate(12);

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.news-index";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.news-index';
        }

        return view($viewName, compact('village', 'news'));
    }

    /**
     * Show a single news article.
     */
    public function newsShow(string $slug, string $newsSlug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $news = VillageNews::where('village_id', $village->id)
            ->where('slug', $newsSlug)
            ->firstOrFail();

        $relatedNews = VillageNews::where('village_id', $village->id)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.news-detail";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.news-detail';
        }

        return view($viewName, compact('village', 'news', 'relatedNews'));
    }

    /**
     * Show all products for a village (paginated).
     */
    public function productIndex(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $products = $village->products()->active()->paginate(12);

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.product-index";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.product-index';
        }

        return view($viewName, compact('village', 'products'));
    }

    /**
     * Show a single product.
     */
    public function productShow(string $slug, string $productSlug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $product = VillageProduct::where('village_id', $village->id)
            ->where('slug', $productSlug)
            ->active()
            ->firstOrFail();

        $relatedProducts = VillageProduct::where('village_id', $village->id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inRandomOrder()
            ->take(4)
            ->get();

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.product-detail";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.product-detail';
        }

        return view($viewName, compact('village', 'product', 'relatedProducts'));
    }

    /**
     * Show complaint form.
     */
    public function complaintCreate(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.complaint-form";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.complaint-form';
        }

        return view($viewName, compact('village'));
    }

    /**
     * Store complaint.
     */
    public function complaintStore(Request $request, string $slug): RedirectResponse
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('villages/complaints', 'public');
        }

        VillageComplaint::create([
            'village_id' => $village->id,
            'name' => $validated['name'],
            'contact' => $validated['contact'],
            'category' => $validated['category'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('village.complaint.create', $village->slug)
            ->with('success', 'Pengaduan/Aspirasi Anda berhasil dikirim ke perangkat desa.');
    }

    /**
     * Show all agenda events for a village (calendar page).
     */
    public function agendaIndex(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $agendas = $village->agendas()
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        $upcomingAgendas = $village->agendas()
            ->upcoming()
            ->take(5)
            ->get();

        if ($upcomingAgendas->count() < 5) {
            $upcomingAgendas = $village->agendas()
                ->orderBy('event_date')
                ->take(5)
                ->get();
        }

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.agenda";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.agenda';
        }

        return view($viewName, compact('village', 'agendas', 'upcomingAgendas'));
    }

    /**
     * API endpoint: return JSON agenda data for a specific month.
     */
    public function agendaApi(string $slug, Request $request): JsonResponse
    {
        $village = Village::where('slug', $slug)->published()->first();

        if (! $village) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $year = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        $agendas = $village->agendas()
            ->forMonth($year, $month)
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get()
            ->map(fn ($agenda) => [
                'id' => $agenda->id,
                'title' => $agenda->title,
                'description' => $agenda->description,
                'event_date' => $agenda->event_date->format('Y-m-d'),
                'day' => $agenda->event_date->day,
                'start_time' => $agenda->start_time ? substr($agenda->start_time, 0, 5) : null,
                'end_time' => $agenda->end_time ? substr($agenda->end_time, 0, 5) : null,
                'location' => $agenda->location,
                'category' => $agenda->category,
                'category_label' => $agenda->category_label,
                'category_color' => $agenda->category_color,
                'is_important' => $agenda->is_important,
            ]);

        return response()->json([
            'year' => $year,
            'month' => $month,
            'agendas' => $agendas,
        ]);
    }

    /**
     * Show all services for a village.
     */
    public function serviceIndex(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $services = $village->services()->active()->get();

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.service-index";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.service-index';
        }

        return view($viewName, compact('village', 'services'));
    }

    /**
     * Show a single service detail.
     */
    public function serviceShow(string $slug, string $serviceSlug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $service = VillageService::where('village_id', $village->id)
            ->where('slug', $serviceSlug)
            ->active()
            ->firstOrFail();

        $otherServices = VillageService::where('village_id', $village->id)
            ->where('id', '!=', $service->id)
            ->active()
            ->get();

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.service-detail";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.service-detail';
        }

        return view($viewName, compact('village', 'service', 'otherServices'));
    }

    /**
     * Show PPID / Public Documents page.
     */
    public function ppidIndex(Request $request, string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $query = $village->documents()->where('is_active', true);

        if ($request->has('category') && $request->category !== '') {
            $query->where('category', $request->category);
        }

        $documents = $query->paginate(15);
        $categories = $village->documents()->where('is_active', true)->select('category')->distinct()->pluck('category');

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.ppid";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.ppid';
        }

        return view($viewName, compact('village', 'documents', 'categories'));
    }

    /**
     * Show PPID Information Request form.
     */
    public function ppidRequest(string $slug): View
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            return view('village.unavailable', ['slug' => $slug]);
        }

        $village->load('template');

        $templateSlug = $village->template->slug;
        $viewName = "village.templates.{$templateSlug}.ppid-request";

        if (! view()->exists($viewName)) {
            $viewName = 'village.templates.klasik.ppid-request';
        }

        return view($viewName, compact('village'));
    }

    /**
     * Download a public document and increment download counter.
     */
    public function documentDownload(string $slug, int $id)
    {
        $village = Village::where('slug', $slug)->first();

        if (! $village || ! $village->isPublished()) {
            abort(404);
        }

        $document = $village->documents()->where('is_active', true)->findOrFail($id);

        $document->increment('download_count');

        $filePath = storage_path('app/public/'.$document->file_path);

        if (! file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath, $document->title.'.pdf');
    }
}
