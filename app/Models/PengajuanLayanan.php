<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_tracking',
        'user_id',
        'layanan_id',
        'desa_id',
        'data_pemohon',
        'status',
        'alasan_ditolak',
        'file_surat_hasil',
        'catatan_operator',
    ];

    protected $casts = [
        'data_pemohon' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_tracking)) {
                $model->kode_tracking = 'PL-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(VillageService::class, 'layanan_id');
    }

    public function desa()
    {
        return $this->belongsTo(Village::class, 'desa_id');
    }

    public function dokumen()
    {
        return $this->hasMany(PengajuanLayananDokumen::class);
    }
}
