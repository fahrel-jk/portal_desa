<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageFaq extends Model
{
    protected $fillable = [
        'village_id',
        'question',
        'answer',
        'order',
        'is_active',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
