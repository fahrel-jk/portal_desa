<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Village extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'kecamatan',
        'kabupaten',
        'description',
        'logo_path',
        'hero_image_path',
        'contact_phone',
        'contact_email',
        'office_hours',
        'address',
        'latitude',
        'longitude',
        'template_id',
        'geojson_batas_wilayah',
        'status',
        'is_featured',
        'rejection_reason',
        'submitted_at',
        'approved_at',
        'approved_by',
        'theme_color',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'is_featured' => 'boolean',
            'geojson_batas_wilayah' => 'array',
        ];
    }

    /**
     * Get the template used by this village.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the user (perwakilan desa) managing this village.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'village_id');
    }

    /**
     * Get the admin who approved this village.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the officials of this village.
     */
    public function officials(): HasMany
    {
        return $this->hasMany(VillageOfficial::class)->orderBy('order');
    }

    /**
     * Get the news articles of this village.
     */
    public function news(): HasMany
    {
        return $this->hasMany(VillageNews::class)->latest('published_at');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(VillageGallery::class)->latest();
    }

    /**
     * Get the services of this village.
     */
    public function services(): HasMany
    {
        return $this->hasMany(VillageService::class);
    }

    /**
     * Get the anggaran (APBDes) records of this village.
     */
    public function anggarans(): HasMany
    {
        return $this->hasMany(Anggaran::class);
    }

    /**
     * Get the location points (titik lokasi) of this village.
     */
    public function titikLokasis(): HasMany
    {
        return $this->hasMany(TitikLokasi::class);
    }

    /**
     * Scope a query to only include published villages.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include villages pending review.
     */
    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('status', 'pending_review');
    }

    /**
     * Check if the village is published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the village is pending review.
     */
    public function isPendingReview(): bool
    {
        return $this->status === 'pending_review';
    }
}
