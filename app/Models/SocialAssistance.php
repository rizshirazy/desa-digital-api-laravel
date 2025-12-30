<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'thumbnail',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function recipients(): HasMany
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(
                    [
                        'name',
                        'category',
                        'provider',
                        'description',
                    ],
                    'ILIKE',
                    "%{$search}%"
                );
            });
        });
    }
}
