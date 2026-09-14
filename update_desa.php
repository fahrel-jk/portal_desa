<?php
// Script to update "Ladang Panjang" to "Pujon Kidul"
$v = \App\Models\Village::where('slug', 'ladang-panjang')->first();
if ($v) {
    $v->name = 'Pujon Kidul';
    $v->slug = 'pujon-kidul';
    $v->kecamatan = 'Pujon';
    $v->kabupaten = 'Malang';
    $v->description = 'Desa Pujon Kidul terletak di kawasan dataran tinggi dengan pemandangan alam yang asri, dikenal sebagai salah satu Desa Wisata unggulan di Jawa Timur. Masyarakatnya bertani dan beternak sapi perah.';
    $v->address = 'Jl. Krajan, Desa Pujon Kidul, Kec. Pujon, Kab. Malang, Jawa Timur';
    $v->save();
    echo "Village updated.\n";
    
    $u = \App\Models\User::where('village_id', $v->id)->first();
    if ($u) {
        $u->name = 'Admin Pujon Kidul';
        $u->email = 'admin@pujonkidul.desa.id';
        $u->save();
        echo "User updated: email is now admin@pujonkidul.desa.id.\n";
    }
} else {
    echo "Village ladang-panjang not found.\n";
}
