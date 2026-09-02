<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Services\VillageRegistrationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WizardController extends Controller
{
    public function __construct(
        private VillageRegistrationService $registrationService,
    ) {}

    /**
     * Show step 1: Data Dasar Desa.
     */
    public function step1(): View
    {
        $data = session('wizard.step1', []);

        return view('wizard.step1', compact('data'));
    }

    /**
     * Store step 1 data in session.
     */
    public function storeStep1(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
        ]);

        // Generate slug preview
        $validated['slug_preview'] = $this->registrationService->generateUniqueSlug($validated['name']);

        session(['wizard.step1' => $validated]);

        return redirect()->route('wizard.step2');
    }

    /**
     * Show step 2: Pilih Template.
     */
    public function step2(): View|RedirectResponse
    {
        if (! session()->has('wizard.step1')) {
            return redirect()->route('wizard.step1');
        }

        $templates = Template::where('is_active', true)->get();
        $data = session('wizard.step2', []);

        return view('wizard.step2', compact('templates', 'data'));
    }

    /**
     * Store step 2 data in session.
     */
    public function storeStep2(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
        ]);

        session(['wizard.step2' => $validated]);

        return redirect()->route('wizard.step3');
    }

    /**
     * Show step 3: Identitas Visual.
     */
    public function step3(): View|RedirectResponse
    {
        if (! session()->has('wizard.step2')) {
            return redirect()->route('wizard.step1');
        }

        $data = session('wizard.step3', []);

        return view('wizard.step3', compact('data'));
    }

    /**
     * Store step 3 data in session (file uploads).
     */
    public function storeStep3(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = session('wizard.step3', []);

        if ($request->hasFile('logo')) {
            // Delete old temp file if exists
            if (! empty($data['logo_path'])) {
                Storage::disk('public')->delete($data['logo_path']);
            }
            $data['logo_path'] = $request->file('logo')->store('temp/logos', 'public');
            $data['logo_name'] = $request->file('logo')->getClientOriginalName();
        }

        if ($request->hasFile('hero_image')) {
            if (! empty($data['hero_image_path'])) {
                Storage::disk('public')->delete($data['hero_image_path']);
            }
            $data['hero_image_path'] = $request->file('hero_image')->store('temp/heroes', 'public');
            $data['hero_image_name'] = $request->file('hero_image')->getClientOriginalName();
        }

        session(['wizard.step3' => $data]);

        return redirect()->route('wizard.step4');
    }

    /**
     * Show step 4: Profil & Struktur Perangkat.
     */
    public function step4(): View|RedirectResponse
    {
        if (! session()->has('wizard.step2')) {
            return redirect()->route('wizard.step1');
        }

        $data = session('wizard.step4', []);

        return view('wizard.step4', compact('data'));
    }

    /**
     * Store step 4 data in session.
     */
    public function storeStep4(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:5000',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'office_hours' => 'nullable|string|max:255',
            'officials' => 'nullable|array',
            'officials.*.name' => 'required|string|max:255',
            'officials.*.position' => 'required|string|max:255',
        ]);

        session(['wizard.step4' => $validated]);

        return redirect()->route('wizard.review');
    }

    /**
     * Show review page before submission.
     */
    public function review(): View|RedirectResponse
    {
        if (! session()->has('wizard.step1') || ! session()->has('wizard.step2')) {
            return redirect()->route('wizard.step1');
        }

        $step1 = session('wizard.step1');
        $step2 = session('wizard.step2');
        $step3 = session('wizard.step3', []);
        $step4 = session('wizard.step4', []);

        $template = Template::find($step2['template_id']);

        return view('wizard.review', compact('step1', 'step2', 'step3', 'step4', 'template'));
    }

    /**
     * Submit the registration — commit all session data to DB.
     */
    public function submit(Request $request): RedirectResponse
    {
        if (! session()->has('wizard.step1') || ! session()->has('wizard.step2')) {
            return redirect()->route('wizard.step1');
        }

        $sessionData = array_merge(
            session('wizard.step1', []),
            session('wizard.step2', []),
            session('wizard.step3', []),
            session('wizard.step4', []),
        );

        $village = $this->registrationService->commitRegistration($sessionData, $request->user());

        // Clear wizard session data
        session()->forget(['wizard.step1', 'wizard.step2', 'wizard.step3', 'wizard.step4']);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran desa berhasil dikirim! Desa Anda sedang menunggu tinjauan dari admin.');
    }
}
