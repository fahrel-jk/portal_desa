<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Template::create([
            'name' => 'Klasik',
            'slug' => 'klasik',
            'thumbnail_path' => null,
            'is_active' => true,
        ]);
    }

    public function test_public_can_submit_feedback(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'message' => 'Ini pesan masukan dari warga.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('feedback', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'is_read' => false,
        ]);
    }

    public function test_feedback_requires_name_email_message(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    public function test_feedback_requires_valid_email(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test',
            'email' => 'bukan-email',
            'message' => 'Test pesan',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_admin_can_view_feedback_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin_provinsi']);

        $response = $this->actingAs($admin)->get(route('admin.feedback.index'));
        $response->assertOk();
    }

    public function test_non_admin_cannot_view_feedback_page(): void
    {
        $village = Village::create([
            'name' => 'Desa Test',
            'slug' => 'desa-test',
            'kecamatan' => 'Kec Test',
            'kabupaten' => 'Kab Test',
            'template_id' => Template::first()->id,
            'status' => 'published',
        ]);
        $user = User::factory()->create([
            'role' => 'perwakilan_desa',
            'village_id' => $village->id,
        ]);

        $response = $this->actingAs($user)->get(route('admin.feedback.index'));
        $response->assertForbidden();
    }

    public function test_admin_can_mark_feedback_as_read(): void
    {
        $admin = User::factory()->create(['role' => 'admin_provinsi']);
        $feedback = Feedback::create([
            'name' => 'Warga',
            'email' => 'warga@example.com',
            'message' => 'Masukan penting.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.feedback.read', $feedback));
        $response->assertRedirect();

        $this->assertTrue($feedback->fresh()->is_read);
    }
}
