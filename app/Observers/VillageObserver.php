<?php

namespace App\Observers;

use App\Models\Village;
use Illuminate\Support\Facades\Artisan;

class VillageObserver
{
    /**
     * Handle the Village "saved" event.
     */
    public function saved(Village $village): void
    {
        // Regenerate sitemap if a village is created/updated and is published
        if ($village->status === 'published') {
            Artisan::call('sitemap:generate');
        }
    }

    /**
     * Handle the Village "deleted" event.
     */
    public function deleted(Village $village): void
    {
        Artisan::call('sitemap:generate');
    }
}
