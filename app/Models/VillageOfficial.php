<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageOfficial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'village_id',
        'name',
        'position',
        'photo_path',
        'order',
    ];

    /**
     * Get the village this official belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
