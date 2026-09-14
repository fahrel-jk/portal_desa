<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanLayananDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengajuan_layanan_id',
        'nama_file',
        'path_file',
        'tipe_dokumen',
    ];

    public function pengajuanLayanan()
    {
        return $this->belongsTo(PengajuanLayanan::class);
    }
}
