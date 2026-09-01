<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageNews;
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
});

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

test('user cannot edit news belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->get(route('desa.news.edit', $this->otherNews));

    $response->assertForbidden();
});

test('user cannot delete news belonging to another village', function () {
    $response = $this->actingAs($this->myUser)
        ->delete(route('desa.news.destroy', $this->otherNews));

    $response->assertForbidden();
});
