<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageService extends Model
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
        'requirements',
        'description',
    ];

    /**
     * Get the village this service belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
