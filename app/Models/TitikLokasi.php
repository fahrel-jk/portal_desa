<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TitikLokasi extends Model
{
    use HasFactory;

    protected $table = 'titik_lokasis';

    protected $fillable = [
        'village_id',
        'nama_lokasi',
        'kategori',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
    ];

    /**
     * Get the village that owns this location point.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Scope a query to filter by kategori.
     */
    public function scopeByKategori(Builder $query, string $kategori): Builder
    {
        return $query->where('kategori', $kategori);
    }
}
