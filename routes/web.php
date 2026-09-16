<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\ApbdesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Desa\AgendaController;
use App\Http\Controllers\Desa\AnggaranController;
use App\Http\Controllers\Desa\ComplaintController;
use App\Http\Controllers\Desa\DemographicController;
use App\Http\Controllers\Desa\DashboardController as DesaDashboardController;
use App\Http\Controllers\Desa\ProductController;
use App\Http\Controllers\Desa\TitikLokasiController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VillagePageController;
use App\Http\Controllers\WizardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('welcome');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    // Warga layanan
    if ($user->isWargaLayanan()) {
        return redirect()->route('layanan.dashboard');
    }

    // Perwakilan desa — check if they have a village
    if ($user->village_id) {
        $village = $user->village;

        return view('dashboard', compact('village'));
    }

    // No village yet — redirect to wizard
    return redirect()->route('wizard.step1');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Wizard routes (perwakilan desa only)
Route::middleware(['auth', 'perwakilan_desa'])->prefix('wizard')->name('wizard.')->group(function () {
    Route::get('/step-1', [WizardController::class, 'step1'])->name('step1');
    Route::post('/step-1', [WizardController::class, 'storeStep1'])->name('store-step1');
    Route::get('/step-2', [WizardController::class, 'step2'])->name('step2');
    Route::post('/step-2', [WizardController::class, 'storeStep2'])->name('store-step2');
    Route::get('/step-3', [WizardController::class, 'step3'])->name('step3');
    Route::post('/step-3', [WizardController::class, 'storeStep3'])->name('store-step3');
    Route::get('/step-4', [WizardController::class, 'step4'])->name('step4');
    Route::post('/step-4', [WizardController::class, 'storeStep4'])->name('store-step4');
    Route::get('/review', [WizardController::class, 'review'])->name('review');
    Route::post('/submit', [WizardController::class, 'submit'])->name('submit');
});

// Desa content management routes (perwakilan desa only)
Route::middleware(['auth', 'perwakilan_desa'])->prefix('desa/kelola')->name('desa.')->group(function () {
    Route::get('/profil', [DesaDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profil', [DesaDashboardController::class, 'updateProfile'])->name('profile.update');

    // Officials
    Route::get('/officials', [DesaDashboardController::class, 'officialsIndex'])->name('officials.index');
    Route::get('/officials/create', [DesaDashboardController::class, 'officialsCreate'])->name('officials.create');
    Route::post('/officials', [DesaDashboardController::class, 'officialsStore'])->name('officials.store');
    Route::get('/officials/{official}/edit', [DesaDashboardController::class, 'officialsEdit'])->name('officials.edit');
    Route::patch('/officials/{official}', [DesaDashboardController::class, 'officialsUpdate'])->name('officials.update');
    Route::delete('/officials/{official}', [DesaDashboardController::class, 'officialsDestroy'])->name('officials.destroy');

    // News
    Route::get('/news', [DesaDashboardController::class, 'newsIndex'])->name('news.index');
    Route::get('/news/create', [DesaDashboardController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [DesaDashboardController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{news}/edit', [DesaDashboardController::class, 'newsEdit'])->name('news.edit');
    Route::patch('/news/{news}', [DesaDashboardController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{news}', [DesaDashboardController::class, 'newsDestroy'])->name('news.destroy');

    // Services
    Route::get('/services', [DesaDashboardController::class, 'servicesIndex'])->name('services.index');
    Route::get('/services/create', [DesaDashboardController::class, 'servicesCreate'])->name('services.create');
    Route::post('/services', [DesaDashboardController::class, 'servicesStore'])->name('services.store');
    Route::get('/services/{service}/edit', [DesaDashboardController::class, 'servicesEdit'])->name('services.edit');
    Route::patch('/services/{service}', [DesaDashboardController::class, 'servicesUpdate'])->name('services.update');
    Route::delete('/services/{service}', [DesaDashboardController::class, 'servicesDestroy'])->name('services.destroy');

    // Galleries
    Route::get('/galleries', [\App\Http\Controllers\Desa\GalleryController::class, 'index'])->name('galleries.index');
    Route::get('/galleries/create', [\App\Http\Controllers\Desa\GalleryController::class, 'create'])->name('galleries.create');
    Route::post('/galleries', [\App\Http\Controllers\Desa\GalleryController::class, 'store'])->name('galleries.store');
    Route::delete('/galleries/{gallery}', [\App\Http\Controllers\Desa\GalleryController::class, 'destroy'])->name('galleries.destroy');

    // Titik Lokasi (Peta Interaktif)
    Route::get('/titik-lokasi', [TitikLokasiController::class, 'index'])->name('titik-lokasi.index');
    Route::get('/titik-lokasi/create', [TitikLokasiController::class, 'create'])->name('titik-lokasi.create');
    Route::post('/titik-lokasi', [TitikLokasiController::class, 'store'])->name('titik-lokasi.store');
    Route::get('/titik-lokasi/{titikLokasi}/edit', [TitikLokasiController::class, 'edit'])->name('titik-lokasi.edit');
    Route::patch('/titik-lokasi/{titikLokasi}', [TitikLokasiController::class, 'update'])->name('titik-lokasi.update');
    Route::delete('/titik-lokasi/{titikLokasi}', [TitikLokasiController::class, 'destroy'])->name('titik-lokasi.destroy');
    
    // Operators
    Route::get('/operators', [\App\Http\Controllers\Desa\OperatorController::class, 'index'])->name('operators.index');
    Route::get('/operators/create', [\App\Http\Controllers\Desa\OperatorController::class, 'create'])->name('operators.create');
    Route::post('/operators', [\App\Http\Controllers\Desa\OperatorController::class, 'store'])->name('operators.store');
    Route::delete('/operators/{operator}', [\App\Http\Controllers\Desa\OperatorController::class, 'destroy'])->name('operators.destroy');

    // Pengajuan Masuk
    Route::get('/pengajuan-masuk', [\App\Http\Controllers\Desa\PengajuanMasukController::class, 'index'])->name('pengajuan-masuk.index');
    Route::get('/pengajuan-masuk/{id}', [\App\Http\Controllers\Desa\PengajuanMasukController::class, 'show'])->name('pengajuan-masuk.show');
    Route::patch('/pengajuan-masuk/{id}', [\App\Http\Controllers\Desa\PengajuanMasukController::class, 'update'])->name('pengajuan-masuk.update');

    // Anggaran (APBDes)
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::get('/anggaran/create', [AnggaranController::class, 'create'])->name('anggaran.create');
    Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::get('/anggaran/{anggaran}/edit', [AnggaranController::class, 'edit'])->name('anggaran.edit');
    Route::patch('/anggaran/{anggaran}', [AnggaranController::class, 'update'])->name('anggaran.update');
    Route::delete('/anggaran/{anggaran}', [AnggaranController::class, 'destroy'])->name('anggaran.destroy');

    // Produk UMKM
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Agenda Desa
    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/create', [AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/agenda', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/agenda/{agenda}/edit', [AgendaController::class, 'edit'])->name('agenda.edit');
    Route::patch('/agenda/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/agenda/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');

    // Dokumen PPID
    Route::get('/documents', [\App\Http\Controllers\Desa\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [\App\Http\Controllers\Desa\DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [\App\Http\Controllers\Desa\DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/edit', [\App\Http\Controllers\Desa\DocumentController::class, 'edit'])->name('documents.edit');
    Route::patch('/documents/{document}', [\App\Http\Controllers\Desa\DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [\App\Http\Controllers\Desa\DocumentController::class, 'destroy'])->name('documents.destroy');

    // FAQ
    Route::get('/faqs', [\App\Http\Controllers\Desa\FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [\App\Http\Controllers\Desa\FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs', [\App\Http\Controllers\Desa\FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{faq}/edit', [\App\Http\Controllers\Desa\FaqController::class, 'edit'])->name('faqs.edit');
    Route::patch('/faqs/{faq}', [\App\Http\Controllers\Desa\FaqController::class, 'update'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [\App\Http\Controllers\Desa\FaqController::class, 'destroy'])->name('faqs.destroy');

    // Demographics
    Route::get('/demographics', [DemographicController::class, 'index'])->name('demographics.index');
    Route::get('/demographics/create', [DemographicController::class, 'create'])->name('demographics.create');
    Route::post('/demographics', [DemographicController::class, 'store'])->name('demographics.store');
    Route::get('/demographics/{demographic}/edit', [DemographicController::class, 'edit'])->name('demographics.edit');
    Route::patch('/demographics/{demographic}', [DemographicController::class, 'update'])->name('demographics.update');
    Route::delete('/demographics/{demographic}', [DemographicController::class, 'destroy'])->name('demographics.destroy');

    // Complaints
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.update_status');

    // Information Requests (Permohonan Informasi)
    Route::get('/permohonan-informasi', [\App\Http\Controllers\Desa\InformationRequestController::class, 'index'])->name('information-requests.index');
    Route::patch('/permohonan-informasi/{informationRequest}', [\App\Http\Controllers\Desa\InformationRequestController::class, 'update'])->name('information-requests.update');
});

// Admin routes (admin_provinsi only)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/villages/{village}', [AdminDashboardController::class, 'show'])->name('review');
    Route::get('/villages/{village}/preview', [AdminDashboardController::class, 'preview'])->name('preview');
    Route::patch('/villages/{village}/approve', [AdminDashboardController::class, 'approve'])->name('approve');
    Route::patch('/villages/{village}/reject', [AdminDashboardController::class, 'reject'])->name('reject');
    Route::patch('/villages/{village}/toggle-featured', [AdminDashboardController::class, 'toggleFeatured'])->name('toggle-featured');
    Route::delete('/villages/{village}', [AdminDashboardController::class, 'destroy'])->name('destroy');

    // Monitoring
    Route::get('/monitoring', [\App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('monitoring');

    // Feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::patch('/feedback/{feedback}/read', [FeedbackController::class, 'markAsRead'])->name('feedback.read');
    
    // Access Requests Review
    Route::get('/access-requests', [\App\Http\Controllers\Admin\AccessRequestReviewController::class, 'index'])->name('access-requests.index');
    Route::get('/access-requests/{accessRequest}', [\App\Http\Controllers\Admin\AccessRequestReviewController::class, 'show'])->name('access-requests.show');
    Route::patch('/access-requests/{accessRequest}/approve', [\App\Http\Controllers\Admin\AccessRequestReviewController::class, 'approve'])->name('access-requests.approve');
    Route::patch('/access-requests/{accessRequest}/reject', [\App\Http\Controllers\Admin\AccessRequestReviewController::class, 'reject'])->name('access-requests.reject');
});

// Warga layanan routes
Route::prefix('layanan')->middleware(['auth', 'warga_layanan'])->name('layanan.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Layanan\PengajuanController::class, 'index'])->name('dashboard'); // fallback dashboard
    Route::get('/riwayat', [\App\Http\Controllers\Layanan\PengajuanController::class, 'index'])->name('pengajuan.index');
    // PPID routes for Warga
    Route::get('/ppid/ajukan', [\App\Http\Controllers\Layanan\PpidRequestController::class, 'create'])->name('ppid.create');
    Route::post('/ppid/ajukan', [\App\Http\Controllers\Layanan\PpidRequestController::class, 'store'])->name('ppid.store');
    Route::get('/ppid/{id}', [\App\Http\Controllers\Layanan\PpidRequestController::class, 'show'])->name('ppid.show');
    Route::get('/ppid/{id}/download', [\App\Http\Controllers\Layanan\PpidRequestController::class, 'download'])->name('ppid.download');

    // Pengajuan Layanan
    Route::get('/ajukan/{layanan}', [\App\Http\Controllers\Layanan\PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/ajukan', [\App\Http\Controllers\Layanan\PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/{kode_tracking}', [\App\Http\Controllers\Layanan\PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/{kode_tracking}/download', [\App\Http\Controllers\Layanan\PengajuanController::class, 'downloadResult'])->name('pengajuan.download');
});

// Public Village Pages
Route::get('/desa/{slug}/request-akses', [\App\Http\Controllers\AccessRequestController::class, 'create'])->name('desa.request-akses.create');
Route::post('/desa/{slug}/request-akses', [\App\Http\Controllers\AccessRequestController::class, 'store'])->name('desa.request-akses.store');
Route::get('/desa/{slug}/profil', [VillagePageController::class, 'profile'])->name('village.profile');
Route::get('/desa/{slug}/apbdes', [ApbdesController::class, 'show'])->name('village.apbdes');
Route::get('/desa/{slug}/apbdes/pdf', [ApbdesController::class, 'exportPdf'])->name('village.apbdes.pdf');
Route::get('/desa/{slug}/berita', [VillagePageController::class, 'newsIndex'])->name('village.news');
Route::get('/desa/{slug}/berita/{newsSlug}', [VillagePageController::class, 'newsShow'])->name('village.news.show');
Route::get('/desa/{slug}/produk', [VillagePageController::class, 'productIndex'])->name('village.products');
Route::get('/desa/{slug}/produk/{productSlug}', [VillagePageController::class, 'productShow'])->name('village.product.show');
Route::get('/desa/{slug}/pengaduan', [VillagePageController::class, 'complaintCreate'])->name('village.complaint.create');
Route::post('/desa/{slug}/pengaduan', [VillagePageController::class, 'complaintStore'])->name('village.complaint.store');
Route::get('/desa/{slug}/agenda/api', [VillagePageController::class, 'agendaApi'])->name('village.agenda.api');
Route::get('/desa/{slug}/agenda', [VillagePageController::class, 'agendaIndex'])->name('village.agenda');
Route::get('/desa/{slug}/layanan', [VillagePageController::class, 'serviceIndex'])->name('village.services');
Route::get('/desa/{slug}/layanan/{serviceSlug}', [VillagePageController::class, 'serviceShow'])->name('village.service.show');
Route::get('/desa/{slug}/ppid', [VillagePageController::class, 'ppidIndex'])->name('village.ppid');
Route::get('/desa/{slug}/ppid/permohonan', [VillagePageController::class, 'ppidRequest'])->name('village.ppid.request');
Route::post('/desa/{slug}/ppid/permohonan', [\App\Http\Controllers\Desa\InformationRequestController::class, 'store'])->name('village.ppid.request.store');
Route::get('/desa/{slug}/ppid/download/{id}', [VillagePageController::class, 'documentDownload'])->name('village.ppid.download');
Route::get('/desa/{slug}', [VillagePageController::class, 'show'])->name('village.show');

require __DIR__.'/auth.php';
