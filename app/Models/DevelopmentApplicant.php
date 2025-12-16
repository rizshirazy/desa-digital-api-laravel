<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'development_id',
        'user_id',
        'status',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
