<?php

use App\Models\Village;

$v = Village::where('slug', 'sumberan')->first();
if (! $v) {
    echo "NOT FOUND\n";

    return;
}

echo "=== SUMBERAN DATA CHECK ===\n";
echo 'visi: '.($v->visi ? 'YES ('.strlen($v->visi).' chars)' : 'NO')."\n";
echo 'misi: '.($v->misi ? 'YES ('.strlen($v->misi).' chars)' : 'NO')."\n";
echo 'history: '.($v->history ? 'YES ('.strlen($v->history).' chars)' : 'NO')."\n";
echo 'bagan_struktur_path: '.($v->bagan_struktur_path ? 'YES' : 'NO')."\n";
echo 'demographics: '.$v->demographics()->count()."\n";
echo 'faqs: '.$v->faqs()->count()."\n";
echo 'officials: '.$v->officials()->count()."\n";
echo 'latitude: '.($v->latitude ?: 'NO')."\n";
echo 'longitude: '.($v->longitude ?: 'NO')."\n";
echo 'theme_color: '.($v->theme_color ?: 'NO')."\n";
