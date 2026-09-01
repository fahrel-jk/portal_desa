<?php

namespace Tests\Feature;

use App\Models\Template;
use App\Models\User;
use App\Models\Village;
use App\Notifications\VillageApprovedNotification;
use App\Notifications\VillageRegisteredNotification;
use App\Notifications\VillageRegistrationSubmittedNotification;
use App\Notifications\VillageRejectedNotification;
use App\Services\VillageRegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->template = Template::create([
            'name' => 'Klasik',
            'slug' => 'klasik',
            'is_active' => true,
        ]);

        $this->admin = User::factory()->create([
            'role' => 'admin_provinsi',
        ]);

        $this->user = User::factory()->create([
            'role' => 'perwakilan_desa',
        ]);
    }

    public function test_notifications_sent_on_registration_submit()
    {
        Notification::fake();

        $service = new VillageRegistrationService;
        $service->commitRegistration([
            'name' => 'Desa Notif',
            'kecamatan' => 'Kec',
            'kabupaten' => 'Kab',
            'template_id' => $this->template->id,
            'description' => 'Test',
            'contact_phone' => '123',
            'contact_email' => 'test@test.com',
            'office_hours' => '1-5',
            'address' => 'Addr',
            'officials' => [],
        ], $this->user);

        Notification::assertSentTo(
            $this->user,
            VillageRegistrationSubmittedNotification::class
        );

        Notification::assertSentTo(
            $this->admin,
            VillageRegisteredNotification::class
        );
    }

    public function test_notification_sent_on_admin_approve()
    {
        Notification::fake();

        $village = Village::create([
            'name' => 'Desa Approve',
            'slug' => 'desa-approve',
            'kecamatan' => 'Kec',
            'kabupaten' => 'Kab',
            'template_id' => $this->template->id,
            'status' => 'pending_review',
        ]);

        $this->user->update(['village_id' => $village->id]);

        $this->actingAs($this->admin)
            ->patch(route('admin.approve', $village));

        Notification::assertSentTo(
            $this->user,
            VillageApprovedNotification::class
        );
    }

    public function test_notification_sent_on_admin_reject()
    {
        Notification::fake();

        $village = Village::create([
            'name' => 'Desa Reject',
            'slug' => 'desa-reject',
            'kecamatan' => 'Kec',
            'kabupaten' => 'Kab',
            'template_id' => $this->template->id,
            'status' => 'pending_review',
        ]);

        $this->user->update(['village_id' => $village->id]);

        $this->actingAs($this->admin)
            ->patch(route('admin.reject', $village), [
                'rejection_reason' => 'Data tidak valid',
            ]);

        Notification::assertSentTo(
            $this->user,
            VillageRejectedNotification::class
        );
    }
}
