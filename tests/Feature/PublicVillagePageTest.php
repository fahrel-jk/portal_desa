<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;
use App\Models\VillageOfficial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->template = Template::create(['name' => 'Klasik', 'slug' => 'klasik', 'is_active' => true]);

    $this->village = Village::create([
        'name' => 'Desa Test',
        'slug' => 'desa-test',
        'kecamatan' => 'Kec. Test',
        'kabupaten' => 'Kab. Test',
        'template_id' => $this->template->id,
        'status' => 'published',
        'description' => 'Ini deskripsi desa test',
    ]);

    VillageOfficial::create([
        'village_id' => $this->village->id,
        'name' => 'Pak Kades',
        'position' => 'Kepala Desa',
        'order' => 1,
    ]);

    $this->user = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->village->id,
    ]);

    VillageNews::create([
        'village_id' => $this->village->id,
        'title' => 'Berita Pertama',
        'slug' => 'berita-pertama',
        'content' => 'Isi berita pertama',
        'published_at' => now(),
        'created_by' => $this->user->id,
    ]);
});

test('public can view published village page', function () {
    $response = $this->get('/desa/desa-test');

    $response->assertOk()
        ->assertSee('Desa Test')
        ->assertSee('Ini deskripsi desa test')
        ->assertSee('Pak Kades')
        ->assertSee('Berita Pertama');
});

test('public cannot view pending village page', function () {
    $this->village->update(['status' => 'pending_review']);

    $response = $this->get('/desa/desa-test');

    $response->assertOk()
        ->assertSee('Desa Belum Tersedia')
        ->assertDontSee('Ini deskripsi desa test');
});

test('public cannot view rejected village page', function () {
    $this->village->update(['status' => 'rejected']);

    $response = $this->get('/desa/desa-test');

    $response->assertOk()
        ->assertSee('Desa Belum Tersedia');
});

test('village page falls back to klasik template if specified template view is missing', function () {
    $this->template->update(['slug' => 'non-existent-template']);
    $this->village->update(['template_id' => $this->template->id]);

    $response = $this->get('/desa/desa-test');

    // Should render successfully using klasik fallback
    $response->assertOk()
        ->assertSee('Desa Test');
});

test('non-existent village returns unavailable page', function () {
    $response = $this->get('/desa/desa-palsu');

    $response->assertOk()
        ->assertSee('Desa Belum Tersedia');
});
