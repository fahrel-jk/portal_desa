<?php

namespace App\Services;

use App\Models\User;
use App\Models\Village;
use App\Models\VillageOfficial;
use App\Notifications\VillageRegisteredNotification;
use App\Notifications\VillageRegistrationSubmittedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillageRegistrationService
{
    /**
     * Generate a unique slug from a village name.
     * Handles collision by appending -2, -3, etc.
     */
    public function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if (! Village::where('slug', $baseSlug)->exists()) {
            return $baseSlug;
        }

        $counter = 2;
        while (Village::where('slug', "{$baseSlug}-{$counter}")->exists()) {
            $counter++;
        }

        return "{$baseSlug}-{$counter}";
    }

    /**
     * Commit the wizard registration data from session to the database.
     *
     * @param  array  $sessionData  Combined data from all wizard steps
     * @param  User  $user  The authenticated perwakilan_desa user
     */
    public function commitRegistration(array $sessionData, User $user): Village
    {
        return DB::transaction(function () use ($sessionData, $user) {
            // Move uploaded files from temp to permanent storage
            $logoPath = $this->moveUploadedFile($sessionData['logo_path'] ?? null, 'villages/logos');
            $heroPath = $this->moveUploadedFile($sessionData['hero_image_path'] ?? null, 'villages/heroes');

            // Create the village
            $village = Village::create([
                'name' => $sessionData['name'],
                'slug' => $this->generateUniqueSlug($sessionData['name']),
                'kecamatan' => $sessionData['kecamatan'],
                'kabupaten' => $sessionData['kabupaten'],
                'description' => $sessionData['description'] ?? null,
                'logo_path' => $logoPath,
                'hero_image_path' => $heroPath,
                'contact_phone' => $sessionData['contact_phone'] ?? null,
                'contact_email' => $sessionData['contact_email'] ?? null,
                'office_hours' => $sessionData['office_hours'] ?? null,
                'address' => $sessionData['address'] ?? null,
                'template_id' => $sessionData['template_id'],
                'status' => 'pending_review',
                'submitted_at' => now(),
            ]);

            // Create village officials
            if (! empty($sessionData['officials'])) {
                foreach ($sessionData['officials'] as $index => $officialData) {
                    $photoPath = $this->moveUploadedFile(
                        $officialData['photo_path'] ?? null,
                        'villages/officials'
                    );

                    VillageOfficial::create([
                        'village_id' => $village->id,
                        'name' => $officialData['name'],
                        'position' => $officialData['position'],
                        'photo_path' => $photoPath,
                        'order' => $index + 1,
                    ]);
                }
            }

            // Link user to village
            $user->update(['village_id' => $village->id]);

            // Fetch admins to notify
            $admins = User::where('role', 'admin_provinsi')->get();

            // Dispatch notification to user
            $user->notify(new VillageRegistrationSubmittedNotification($village));

            // Dispatch notification to admins
            Notification::send($admins, new VillageRegisteredNotification($village));

            return $village;
        });
    }

    /**
     * Move an uploaded file from temp storage to permanent storage.
     */
    private function moveUploadedFile(?string $tempPath, string $destinationDir): ?string
    {
        if (! $tempPath || ! Storage::disk('local')->exists($tempPath)) {
            return null;
        }

        $filename = basename($tempPath);
        $newPath = "public/{$destinationDir}/{$filename}";

        Storage::disk('local')->move($tempPath, $newPath);

        return "{$destinationDir}/{$filename}";
    }
}
