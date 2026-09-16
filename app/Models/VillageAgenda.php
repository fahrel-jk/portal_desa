<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageAgenda extends Model
{
    use HasFactory;

    /**
     * Category options for agenda events.
     */
    public const CATEGORY_OPTIONS = [
        'musyawarah' => 'Musyawarah',
        'kesehatan' => 'Kesehatan',
        'pendidikan' => 'Pendidikan',
        'keagamaan' => 'Keagamaan',
        'gotong_royong' => 'Gotong Royong',
        'sosial' => 'Sosial & Budaya',
        'umum' => 'Umum',
    ];

    /**
     * Category colors for calendar display.
     */
    public const CATEGORY_COLORS = [
        'musyawarah' => '#2563EB',
        'kesehatan' => '#DC2626',
        'pendidikan' => '#F59E0B',
        'keagamaan' => '#059669',
        'gotong_royong' => '#7C3AED',
        'sosial' => '#EC4899',
        'umum' => '#6B7280',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'village_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'category',
        'is_important',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_important' => 'boolean',
        ];
    }

    /**
     * Get the village this agenda belongs to.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    /**
     * Scope to filter agendas for a specific month.
     */
    public function scopeForMonth(Builder $query, int $year, int $month): Builder
    {
        return $query->whereYear('event_date', $year)
            ->whereMonth('event_date', $month);
    }

    /**
     * Scope to get upcoming agendas (from today onward).
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time');
    }

    /**
     * Get the category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORY_OPTIONS[$this->category] ?? $this->category;
    }

    /**
     * Get the category color.
     */
    public function getCategoryColorAttribute(): string
    {
        return self::CATEGORY_COLORS[$this->category] ?? '#6B7280';
    }
}
