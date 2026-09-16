<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageDocument extends Model
{
    protected $fillable = [
        'village_id',
        'title',
        'description',
        'category',
        'file_path',
        'download_count',
        'is_active',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
