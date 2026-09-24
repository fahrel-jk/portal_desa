<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->templateKlasik = Template::create(['name' => 'Klasik', 'slug' => 'klasik', 'is_active' => true]);
    $this->templateModern = Template::create(['name' => 'Modern', 'slug' => 'modern', 'is_active' => true]);

    $this->village = Village::create([
        'name' => 'Desa Sukamaju',
        'slug' => 'sukamaju',
        'kecamatan' => 'Kec. Sukamaju',
        'kabupaten' => 'Kab. Sukamaju',
        'template_id' => $this->templateKlasik->id,
        'status' => 'published',
        'description' => 'Profil Desa Sukamaju',
    ]);

    $this->operator = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->village->id,
    ]);

    $this->otherVillage = Village::create([
        'name' => 'Desa Makmur',
        'slug' => 'makmur',
        'kecamatan' => 'Kec. Makmur',
        'kabupaten' => 'Kab. Makmur',
        'template_id' => $this->templateModern->id,
        'status' => 'published',
        'description' => 'Profil Desa Makmur',
    ]);

    $this->otherOperator = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => $this->otherVillage->id,
    ]);
});

test('guest is redirected from layout settings page', function () {
    $response = $this->get(route('desa.layout.index'));

    $response->assertRedirect(route('login'));
});

test('village operator can view layout builder page', function () {
    $response = $this->actingAs($this->operator)->get(route('desa.layout.index'));

    $response->assertOk()
        ->assertSee('Manajer Pengaturan Web Desa (CMS Builder)')
        ->assertSee('Pengaturan Menu Navigasi (Navbar CMS)');
});

test('village operator can update section order and visibility', function () {
    $customLayout = [
        ['id' => 'profile', 'title' => 'Tentang Desa Kami', 'enabled' => true],
        ['id' => 'hero', 'title' => 'Hero Banner', 'enabled' => true],
        ['id' => 'services', 'title' => 'Layanan Utama', 'enabled' => false],
    ];

    $response = $this->actingAs($this->operator)
        ->patch(route('desa.layout.update'), [
            'sections' => $customLayout,
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success', 'Pengaturan tata letak dan menu navigasi berhasil diperbarui!');

    $this->village->refresh();
    $sections = $this->village->getOrderedLayoutSections();

    expect($sections[0]['id'])->toBe('profile');
    expect($sections[0]['title'])->toBe('Tentang Desa Kami');
    expect($sections[2]['id'])->toBe('services');
    expect($sections[2]['enabled'])->toBeFalse();
});

test('public page reflects updated layout custom title and section toggles for Klasik template', function () {
    $customLayout = [
        ['id' => 'hero', 'title' => 'Hero', 'enabled' => true],
        ['id' => 'profile', 'title' => 'Cerita Kampung Kami', 'enabled' => true],
        ['id' => 'services', 'title' => 'Layanan Publik', 'enabled' => false],
    ];

    $this->village->update([
        'layout_settings' => $customLayout,
    ]);

    $response = $this->get('/desa/sukamaju');

    $response->assertOk()
        ->assertSee('Cerita Kampung Kami')
        ->assertDontSee('Layanan Utama');
});

test('public page reflects updated layout custom title and section toggles for Modern template', function () {
    $customLayout = [
        ['id' => 'hero', 'title' => 'Hero', 'enabled' => true],
        ['id' => 'profile', 'title' => 'Mengenal Desa Makmur', 'enabled' => true],
        ['id' => 'complaint_banner', 'title' => 'Kotak Suara Warga', 'enabled' => true],
    ];

    $this->otherVillage->update([
        'layout_settings' => $customLayout,
    ]);

    $response = $this->get('/desa/makmur');

    $response->assertOk()
        ->assertSee('Mengenal Desa Makmur')
        ->assertSee('Kotak Suara Warga');
});

test('layout settings returns not found for perwakilan_desa without assigned village', function () {
    $unassignedOperator = User::factory()->create([
        'role' => 'perwakilan_desa',
        'village_id' => null,
    ]);

    $response = $this->actingAs($unassignedOperator)->get(route('desa.layout.index'));

    $response->assertNotFound();
});

test('village operator can update navigation menu settings and custom links', function () {
    $customNavs = [
        ['id' => 'home', 'label' => 'Home Utama', 'enabled' => true, 'type' => 'route', 'target' => 'village.show', 'placement' => 'main'],
        ['id' => 'custom-link-1', 'label' => 'Portal Wisata', 'enabled' => true, 'type' => 'custom', 'target' => 'https://wisata.example.com', 'placement' => 'main'],
        ['id' => 'agenda', 'label' => 'Jadwal Desa', 'enabled' => false, 'type' => 'route', 'target' => 'village.agenda', 'placement' => 'dropdown'],
    ];

    $response = $this->actingAs($this->operator)
        ->patch(route('desa.layout.update'), [
            'nav_sections' => $customNavs,
        ]);

    $response->assertRedirect()
        ->assertSessionHas('success', 'Pengaturan tata letak dan menu navigasi berhasil diperbarui!');

    $this->village->refresh();
    $navs = $this->village->getOrderedNavSections();

    expect($navs[0]['label'])->toBe('Home Utama');
    expect($navs[1]['label'])->toBe('Portal Wisata');
    expect($navs[1]['target'])->toBe('https://wisata.example.com');
    expect(collect($navs)->firstWhere('id', 'agenda')['enabled'])->toBeFalse();
});

test('public page renders dynamic navigation menu for Klasik and Modern templates', function () {
    $customNavs = [
        ['id' => 'home', 'label' => 'Beranda Utama', 'enabled' => true, 'type' => 'route', 'target' => 'village.show', 'placement' => 'main'],
        ['id' => 'custom-link-1', 'label' => 'Link Kustom Jatim', 'enabled' => true, 'type' => 'custom', 'target' => 'https://jatimprov.go.id', 'placement' => 'main'],
        ['id' => 'agenda', 'label' => 'Agenda Rahasia', 'enabled' => false, 'type' => 'route', 'target' => 'village.agenda', 'placement' => 'main'],
    ];

    $this->village->update(['navigation_settings' => $customNavs]);
    $this->otherVillage->update(['navigation_settings' => $customNavs]);

    $responseKlasik = $this->get('/desa/sukamaju');
    $responseKlasik->assertOk()
        ->assertSee('Beranda Utama')
        ->assertSee('Link Kustom Jatim')
        ->assertDontSee('Agenda Rahasia');

    $responseModern = $this->get('/desa/makmur');
    $responseModern->assertOk()
        ->assertSee('Beranda Utama')
        ->assertSee('Link Kustom Jatim')
        ->assertDontSee('Agenda Rahasia');
});
