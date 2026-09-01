<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Services\VillageRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new VillageRegistrationService;
    Template::create(['name' => 'Klasik', 'slug' => 'klasik', 'is_active' => true]);
});

test('generates slug from village name', function () {
    $slug = $this->service->generateUniqueSlug('Ladang Panjang');
    expect($slug)->toBe('ladang-panjang');
});

test('generates unique slug on collision', function () {
    // Create first village with slug 'ladang-panjang'
    Village::create([
        'name' => 'Ladang Panjang',
        'slug' => 'ladang-panjang',
        'kecamatan' => 'Kec. Sukolilo',
        'kabupaten' => 'Kab. Pasuruan',
        'template_id' => Template::first()->id,
        'status' => 'draft',
    ]);

    // Second village with same name should get '-2' suffix
    $slug = $this->service->generateUniqueSlug('Ladang Panjang');
    expect($slug)->toBe('ladang-panjang-2');
});

test('generates incrementing slugs on multiple collisions', function () {
    $template = Template::first();

    Village::create([
        'name' => 'Ladang Panjang',
        'slug' => 'ladang-panjang',
        'kecamatan' => 'Kec. Sukolilo',
        'kabupaten' => 'Kab. Pasuruan',
        'template_id' => $template->id,
        'status' => 'draft',
    ]);

    Village::create([
        'name' => 'Ladang Panjang 2',
        'slug' => 'ladang-panjang-2',
        'kecamatan' => 'Kec. Sukolilo',
        'kabupaten' => 'Kab. Pasuruan',
        'template_id' => $template->id,
        'status' => 'draft',
    ]);

    // Third should get '-3'
    $slug = $this->service->generateUniqueSlug('Ladang Panjang');
    expect($slug)->toBe('ladang-panjang-3');
});

test('commit registration creates village with pending_review status', function () {
    $user = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => null,
    ]);

    $sessionData = [
        'name' => 'Desa Baru',
        'kecamatan' => 'Kec. Test',
        'kabupaten' => 'Kab. Test',
        'address' => 'Jl. Test No. 1',
        'template_id' => Template::first()->id,
        'description' => 'Deskripsi desa baru',
        'contact_phone' => '08123456789',
        'contact_email' => 'desa@test.com',
        'office_hours' => 'Senin-Jumat 08:00-15:00',
        'officials' => [
            ['name' => 'Pak Kades', 'position' => 'Kepala Desa'],
            ['name' => 'Bu Sekdes', 'position' => 'Sekretaris Desa'],
        ],
    ];

    $village = $this->service->commitRegistration($sessionData, $user);

    expect($village->status)->toBe('pending_review')
        ->and($village->slug)->toBe('desa-baru')
        ->and($village->submitted_at)->not->toBeNull()
        ->and($village->officials)->toHaveCount(2);

    // User should be linked to village
    $user->refresh();
    expect($user->village_id)->toBe($village->id);
});
