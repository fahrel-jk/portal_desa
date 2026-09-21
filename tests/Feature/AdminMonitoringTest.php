<?php

namespace Tests\Feature;

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminMonitoringTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_monitoring_page()
    {
        $admin = User::factory()->create(['role' => 'admin_provinsi']);

        $response = $this->actingAs($admin)->get(route('admin.monitoring'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.monitoring');
        $response->assertViewHasAll(['stats', 'chartLabels', 'chartValues', 'inactiveVillages']);
    }

    public function test_non_admin_cannot_access_monitoring_page()
    {
        // Test perwakilan desa
        $user = User::factory()->create(['role' => 'perwakilan_desa']);
        $response = $this->actingAs($user)->get(route('admin.monitoring'));
        $response->assertForbidden();

        // Test guest
        $this->post('/logout');
        $guestResponse = $this->get(route('admin.monitoring'));
        $guestResponse->assertRedirect(route('login'));
    }

    public function test_monitoring_page_displays_correct_stats()
    {
        $admin = User::factory()->create(['role' => 'admin_provinsi']);

        $template = Template::create([
            'name' => 'Test Template',
            'slug' => 'test-template',
            'is_active' => true,
        ]);

        // Create mixed villages
        $this->createVillage('published', 'Desa 1', $template->id);
        $this->createVillage('published', 'Desa 2', $template->id);
        $this->createVillage('pending_review', 'Desa 3', $template->id);
        $this->createVillage('rejected', 'Desa 4', $template->id);
        $this->createVillage('draft', 'Desa 5', $template->id);

        $response = $this->actingAs($admin)->get(route('admin.monitoring'));

        $stats = $response->viewData('stats');
        $this->assertEquals(5, $stats['total']);
        $this->assertEquals(2, $stats['published']);
        $this->assertEquals(1, $stats['pending']);
        $this->assertEquals(1, $stats['rejected']);
    }

    private function createVillage($status, $name, $templateId)
    {
        return Village::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'kecamatan' => 'Kecamatan Test',
            'kabupaten' => 'Kabupaten Test',
            'description' => 'Desc',
            'status' => $status,
            'template_id' => $templateId,
        ]);
    }
}
