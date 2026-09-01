<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->template = Template::create(['name' => 'Klasik', 'slug' => 'klasik', 'is_active' => true]);

    $this->admin = User::factory()->create([
        'role' => 'admin_provinsi',
        'village_id' => null,
    ]);

    $this->village = Village::create([
        'name' => 'Desa Test',
        'slug' => 'desa-test',
        'kecamatan' => 'Kec. Test',
        'kabupaten' => 'Kab. Test',
        'template_id' => $this->template->id,
        'status' => 'pending_review',
        'submitted_at' => now(),
    ]);

    $this->perwakilanDesa = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->village->id,
    ]);
});

test('admin can approve a pending village', function () {
    $response = $this->actingAs($this->admin)
        ->patch(route('admin.approve', $this->village));

    $response->assertRedirect(route('admin.dashboard'));

    $this->village->refresh();
    expect($this->village->status)->toBe('published')
        ->and($this->village->approved_at)->not->toBeNull()
        ->and($this->village->approved_by)->toBe($this->admin->id);
});

test('admin can reject a pending village with reason', function () {
    $response = $this->actingAs($this->admin)
        ->patch(route('admin.reject', $this->village), [
            'rejection_reason' => 'Data perangkat desa belum lengkap.',
        ]);

    $response->assertRedirect(route('admin.dashboard'));

    $this->village->refresh();
    expect($this->village->status)->toBe('rejected')
        ->and($this->village->rejection_reason)->toBe('Data perangkat desa belum lengkap.');
});

test('reject requires rejection reason', function () {
    $response = $this->actingAs($this->admin)
        ->patch(route('admin.reject', $this->village), [
            'rejection_reason' => '',
        ]);

    $response->assertSessionHasErrors('rejection_reason');
});

test('non-admin cannot approve a village', function () {
    $response = $this->actingAs($this->perwakilanDesa)
        ->patch(route('admin.approve', $this->village));

    $response->assertForbidden();
});

test('non-admin cannot reject a village', function () {
    $response = $this->actingAs($this->perwakilanDesa)
        ->patch(route('admin.reject', $this->village), [
            'rejection_reason' => 'alasan',
        ]);

    $response->assertForbidden();
});

test('admin can view dashboard', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('Antrean Menunggu Review');
});

test('non-admin cannot access admin dashboard', function () {
    $response = $this->actingAs($this->perwakilanDesa)
        ->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin can access preview route', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.preview', $this->village));

    $response->assertOk();
});

test('non-admin and guest cannot access preview route', function () {
    // Guest
    $response = $this->get(route('admin.preview', $this->village));
    $response->assertRedirect(route('login'));

    // Perwakilan Desa
    $response = $this->actingAs($this->perwakilanDesa)
        ->get(route('admin.preview', $this->village));
    $response->assertForbidden();
});
