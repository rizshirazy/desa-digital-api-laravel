<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'thumbnail',
        'about',
        'headman',
        'people',
        'agricultural_area',
        'total_area',
    ];

    protected $casts = [
        'people' => 'integer',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProfileImage::class);
    }
}
