<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'occupation',
        'marital_status',
        'relation',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(
                    [
                        'identity_number',
                        'gender',
                        'phone_number',
                        'occupation',
                        'marital_status',
                        'relation',
                    ],
                    'ILIKE',
                    "%{$search}%"
                )->orWhereHas('user', function (Builder $query) use ($search) {
                    $query->whereAny(['name', 'email'], 'ILIKE', "%{$search}%");
                })->orWhereHas('headOfFamily.user', function (Builder $query) use ($search) {
                    $query->whereAny(['name', 'email'], 'ILIKE', "%{$search}%");
                });
            });
        });
    }
}
