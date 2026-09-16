<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageInformationRequest extends Model
{
    protected $fillable = [
        'village_id',
        'user_id',
        'name',
        'agency',
        'phone',
        'email',
        'content',
        'status',
        'admin_reply',
        'admin_reply_file_path',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
