<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use HasFactory, SoftDeletes, UUID;

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

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['status'], 'ILIKE', "%{$search}%")
                    ->orWhereHas('development', function (Builder $query) use ($search) {
                        $query->whereAny(['name', 'description', 'person_in_charge'], 'ILIKE', "%{$search}%");
                    })->orWhereHas('user', function (Builder $query) use ($search) {
                        $query->whereAny(['name', 'email'], 'ILIKE', "%{$search}%");
                    });
            });
        });
    }
}
