<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;
use App\Models\VillageOfficial;
use App\Models\VillageService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $template = Template::create(['name' => 'Klasik', 'slug' => 'klasik', 'is_active' => true]);

    $this->myVillage = Village::create([
        'name' => 'Desa Saya',
        'slug' => 'desa-saya',
        'kecamatan' => 'Kec. Saya',
        'kabupaten' => 'Kab. Saya',
        'template_id' => $template->id,
        'status' => 'published',
    ]);

    $this->otherVillage = Village::create([
        'name' => 'Desa Lain',
        'slug' => 'desa-lain',
        'kecamatan' => 'Kec. Lain',
        'kabupaten' => 'Kab. Lain',
        'template_id' => $template->id,
        'status' => 'published',
    ]);

    $this->myUser = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->myVillage->id,
    ]);

    $this->otherUser = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->otherVillage->id,
    ]);

    $this->otherNews = VillageNews::create([
        'village_id' => $this->otherVillage->id,
        'title' => 'Berita Desa Lain',
        'slug' => 'berita-desa-lain',
        'content' => 'Isi berita',
        'published_at' => now(),
        'created_by' => $this->otherUser->id,
    ]);

    $this->otherOfficial = VillageOfficial::create([
        'village_id' => $this->otherVillage->id,
        'name' => 'Kepala Desa Lain',
        'position' => 'Kepala Desa',
        'order' => 1,
    ]);

    $this->otherService = VillageService::create([
        'village_id' => $this->otherVillage->id,
        'name' => 'Layanan Desa Lain',
        'description' => 'Deskripsi layanan',
        'requirements' => 'Persyaratan layanan',
    ]);
});

// ========================================
// BASIC ACCESS
// ========================================

test('user can access their own village dashboard', function () {
    $response = $this->actingAs($this->myUser)
        ->get(route('dashboard'));

    $response->assertOk()
        ->assertSee('Desa Saya');
});

test('user cannot edit profile of unpublished village', function () {
    $this->myVillage->update(['status' => 'pending_review']);

    $response = $this->actingAs($this->myUser)
        ->get(route('desa.profile.edit'));

    $response->assertForbidden();
});

// ========================================
// CROSS-VILLAGE NEWS AUTHORIZATION
// ========================================

test('user cannot edit news belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->get(route('desa.news.edit', $this->otherNews));

    $response->assertForbidden();
});

test('user cannot update news belonging to another village via POST', function () {
    $response = $this->actingAs($this->myUser)
        ->patch(route('desa.news.update', $this->otherNews), [
            'title' => 'Judul Diretas',
            'content' => 'Konten diretas',
        ]);

    $response->assertForbidden();

    // Pastikan data asli tidak berubah
    $this->otherNews->refresh();
    $this->assertEquals('Berita Desa Lain', $this->otherNews->title);
});

test('user cannot delete news belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->delete(route('desa.news.destroy', $this->otherNews));

    $response->assertForbidden();

    // Pastikan berita tidak terhapus
    $this->assertDatabaseHas('village_news', ['id' => $this->otherNews->id]);
});

// ========================================
// CROSS-VILLAGE OFFICIALS AUTHORIZATION
// ========================================

test('user cannot edit official belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->get(route('desa.officials.edit', $this->otherOfficial));

    $response->assertForbidden();
});

test('user cannot update official belonging to another village via POST', function () {
    $response = $this->actingAs($this->myUser)
        ->patch(route('desa.officials.update', $this->otherOfficial), [
            'name' => 'Nama Diretas',
            'position' => 'Jabatan Diretas',
        ]);

    $response->assertForbidden();

    // Pastikan data asli tidak berubah
    $this->otherOfficial->refresh();
    $this->assertEquals('Kepala Desa Lain', $this->otherOfficial->name);
});

test('user cannot delete official belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->delete(route('desa.officials.destroy', $this->otherOfficial));

    $response->assertForbidden();

    // Pastikan data tidak terhapus
    $this->assertDatabaseHas('village_officials', ['id' => $this->otherOfficial->id]);
});

// ========================================
// CROSS-VILLAGE SERVICES AUTHORIZATION
// ========================================

test('user cannot edit service belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->get(route('desa.services.edit', $this->otherService));

    $response->assertForbidden();
});

test('user cannot update service belonging to another village via POST', function () {
    $response = $this->actingAs($this->myUser)
        ->patch(route('desa.services.update', $this->otherService), [
            'name' => 'Layanan Diretas',
        ]);

    $response->assertForbidden();

    // Pastikan data asli tidak berubah
    $this->otherService->refresh();
    $this->assertEquals('Layanan Desa Lain', $this->otherService->name);
});

test('user cannot delete service belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->delete(route('desa.services.destroy', $this->otherService));

    $response->assertForbidden();

    // Pastikan data tidak terhapus
    $this->assertDatabaseHas('village_services', ['id' => $this->otherService->id]);
});
