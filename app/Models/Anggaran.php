<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggaran extends Model
{
    use HasFactory;

    /**
     * Kategori anggaran APBDes.
     */
    public const KATEGORI_OPTIONS = [
        'pendapatan' => 'Pendapatan',
        'belanja' => 'Belanja',
        'pembiayaan' => 'Pembiayaan',
    ];

    /**
     * Bidang belanja sesuai struktur APBDes resmi.
     */
    public const BIDANG_OPTIONS = [
        'Penyelenggaraan Pemerintahan Desa',
        'Pelaksanaan Pembangunan Desa',
        'Pembinaan Kemasyarakatan',
        'Pemberdayaan Masyarakat',
        'Penanggulangan Bencana/Darurat/Mendesak',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'village_id',
        'tahun_anggaran',
        'kategori',
        'bidang',
        'uraian',
        'jumlah_anggaran',
        'jumlah_realisasi',
        'keterangan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jumlah_anggaran' => 'decimal:2',
            'jumlah_realisasi' => 'decimal:2',
            'tahun_anggaran' => 'integer',
        ];
    }

    /**
     * Get the village this anggaran belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Scope a query to filter by tahun anggaran.
     */
    public function scopeForYear(Builder $query, int $year): Builder
    {
        return $query->where('tahun_anggaran', $year);
    }
}
