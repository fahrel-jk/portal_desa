<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageDemographic extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'type',
        'label',
        'count',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
