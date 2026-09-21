<?php

use App\Models\Village;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$villages = Village::all();
foreach ($villages as $v) {
    echo $v->slug.' - '.$v->status."\n";
}
