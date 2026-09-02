<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$v = \App\Models\Village::where('slug', 'sumberan')->first();
if ($v) {
    echo "logo_path: " . $v->logo_path . "\n";
    echo "hero_image_path: " . $v->hero_image_path . "\n";
    echo "logo file exists: " . (file_exists(storage_path('app/public/' . $v->logo_path)) ? 'yes' : 'no') . "\n";
    echo "hero file exists: " . (file_exists(storage_path('app/public/' . $v->hero_image_path)) ? 'yes' : 'no') . "\n";
}
