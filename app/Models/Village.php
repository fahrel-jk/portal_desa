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
        'history',
        'logo_path',
        'hero_image_path',
        'contact_phone',
        'contact_email',
        'office_hours',
        'address',
        'visi',
        'misi',
        'bagan_struktur_path',
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
        'layout_settings',
        'navigation_settings',
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
            'layout_settings' => 'array',
            'navigation_settings' => 'array',
        ];
    }

    /**
     * Default list of layout sections.
     */
    public static function defaultLayoutSections(): array
    {
        return [
            ['id' => 'hero', 'title' => 'Banner Utama / Hero', 'enabled' => true],
            ['id' => 'statistics', 'title' => 'Statistik Ringkas', 'enabled' => true],
            ['id' => 'profile', 'title' => 'Profil & Aparatur Desa', 'enabled' => true],
            ['id' => 'services', 'title' => 'Layanan Utama Warga', 'enabled' => true],
            ['id' => 'news', 'title' => 'Kabar & Berita Desa', 'enabled' => true],
            ['id' => 'agenda', 'title' => 'Kalender & Agenda Desa', 'enabled' => true],
            ['id' => 'galleries', 'title' => 'Galeri Foto & Dokumentasi', 'enabled' => true],
            ['id' => 'products', 'title' => 'Produk UMKM Desa', 'enabled' => true],
            ['id' => 'complaint_banner', 'title' => 'Laporan & Pengaduan Warga', 'enabled' => true],
            ['id' => 'map', 'title' => 'Peta & Lokasi Desa', 'enabled' => true],
            ['id' => 'faq', 'title' => 'Pertanyaan Umum (FAQ)', 'enabled' => true],
        ];
    }

    /**
     * Get ordered layout sections for homepage rendering.
     */
    public function getOrderedLayoutSections(): array
    {
        $defaults = self::defaultLayoutSections();
        $saved = $this->layout_settings;

        if (empty($saved) || ! is_array($saved)) {
            return $defaults;
        }

        $defaultMap = collect($defaults)->keyBy('id');
        $result = [];

        foreach ($saved as $item) {
            if (! isset($item['id']) || ! $defaultMap->has($item['id'])) {
                continue;
            }

            $default = $defaultMap->get($item['id']);
            $result[] = [
                'id' => $item['id'],
                'title' => ! empty($item['title']) ? $item['title'] : $default['title'],
                'enabled' => isset($item['enabled']) ? (bool) $item['enabled'] : true,
            ];

            $defaultMap->forget($item['id']);
        }

        foreach ($defaultMap as $missingDefault) {
            $result[] = $missingDefault;
        }

        return $result;
    }

    /**
     * Default list of navigation menu items.
     */
    public static function defaultNavSections(): array
    {
        return [
            ['id' => 'home', 'label' => 'Beranda', 'type' => 'route', 'target' => 'village.show', 'placement' => 'main', 'enabled' => true],
            ['id' => 'profile', 'label' => 'Profil', 'type' => 'route', 'target' => 'village.profile', 'placement' => 'main', 'enabled' => true],
            ['id' => 'services', 'label' => 'Layanan', 'type' => 'route', 'target' => 'village.services', 'placement' => 'main', 'enabled' => true],
            ['id' => 'news', 'label' => 'Berita', 'type' => 'hash', 'target' => '#berita', 'placement' => 'main', 'enabled' => true],
            ['id' => 'agenda', 'label' => 'Agenda', 'type' => 'route', 'target' => 'village.agenda', 'placement' => 'main', 'enabled' => true],
            ['id' => 'apbdes', 'label' => 'APBDes', 'type' => 'route', 'target' => 'village.apbdes', 'placement' => 'main', 'enabled' => true],
            ['id' => 'ppid', 'label' => 'PPID', 'type' => 'route', 'target' => 'village.ppid', 'placement' => 'dropdown', 'enabled' => true],
            ['id' => 'galleries', 'label' => 'Galeri', 'type' => 'hash', 'target' => '#galeri', 'placement' => 'dropdown', 'enabled' => true],
            ['id' => 'products', 'label' => 'Produk UMKM', 'type' => 'hash', 'target' => '#produk', 'placement' => 'dropdown', 'enabled' => true],
            ['id' => 'map', 'label' => 'Lokasi', 'type' => 'hash', 'target' => '#lokasi', 'placement' => 'dropdown', 'enabled' => true],
            ['id' => 'contact', 'label' => 'Kontak', 'type' => 'hash', 'target' => '#kontak', 'placement' => 'dropdown', 'enabled' => true],
        ];
    }

    /**
     * Get ordered navigation menu items for header rendering.
     */
    public function getOrderedNavSections(): array
    {
        $defaults = self::defaultNavSections();
        $saved = $this->navigation_settings;

        if (empty($saved) || ! is_array($saved)) {
            return $defaults;
        }

        $defaultMap = collect($defaults)->keyBy('id');
        $result = [];

        foreach ($saved as $item) {
            if (! isset($item['id'])) {
                continue;
            }

            if ($defaultMap->has($item['id'])) {
                $default = $defaultMap->get($item['id']);
                $result[] = [
                    'id' => $item['id'],
                    'label' => ! empty($item['label']) ? $item['label'] : $default['label'],
                    'type' => $default['type'],
                    'target' => $default['target'],
                    'placement' => isset($item['placement']) && in_array($item['placement'], ['main', 'dropdown']) ? $item['placement'] : $default['placement'],
                    'enabled' => isset($item['enabled']) ? (bool) $item['enabled'] : true,
                ];
                $defaultMap->forget($item['id']);
            } elseif (isset($item['type']) && $item['type'] === 'custom') {
                $result[] = [
                    'id' => $item['id'],
                    'label' => ! empty($item['label']) ? $item['label'] : 'Custom Link',
                    'type' => 'custom',
                    'target' => $item['target'] ?? '#',
                    'placement' => isset($item['placement']) && in_array($item['placement'], ['main', 'dropdown']) ? $item['placement'] : 'main',
                    'enabled' => isset($item['enabled']) ? (bool) $item['enabled'] : true,
                ];
            }
        }

        foreach ($defaultMap as $missingDefault) {
            $result[] = $missingDefault;
        }

        return $result;
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

    /**
     * Get the demographics data for this village.
     */
    public function demographics(): HasMany
    {
        return $this->hasMany(VillageDemographic::class);
    }

    /**
     * Get the complaints for this village.
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(VillageComplaint::class)->latest();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(VillageDocument::class)->latest();
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(VillageFaq::class)->orderBy('order')->latest();
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
     * Get the information requests of this village.
     */
    public function informationRequests(): HasMany
    {
        return $this->hasMany(VillageInformationRequest::class)->latest();
    }

    /**
     * Get the location points (titik lokasi) of this village.
     */
    public function titikLokasis(): HasMany
    {
        return $this->hasMany(TitikLokasi::class);
    }

    /**
     * Get the products (UMKM) of this village.
     */
    public function products(): HasMany
    {
        return $this->hasMany(VillageProduct::class)->latest();
    }

    /**
     * Get the agenda events of this village.
     */
    public function agendas(): HasMany
    {
        return $this->hasMany(VillageAgenda::class)->orderBy('event_date');
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
