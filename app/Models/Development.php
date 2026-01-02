<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Development extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'name',
        'thumbnail',
        'description',
        'person_in_charge',
        'start_date',
        'end_date',
        'amount',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date',
    ];

    public function applicants(): HasMany
    {
        return $this->hasMany(DevelopmentApplicant::class);
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(['name', 'description', 'person_in_charge', 'status'], 'ILIKE', "%{$search}%");
            });
        });
    }
}
