<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Template::create([
            'name' => 'Klasik',
            'slug' => 'klasik',
            'thumbnail_path' => null,
            'is_active' => true,
        ]);

        Template::create([
            'name' => 'Modern',
            'slug' => 'modern',
            'thumbnail_path' => null,
            'is_active' => true,
        ]);
    }
}
