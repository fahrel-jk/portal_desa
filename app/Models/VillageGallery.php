<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'image_path',
        'caption',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
