<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'thumbnail',
        'description',
        'price',
        'date',
        'time',
        'is_active',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}
