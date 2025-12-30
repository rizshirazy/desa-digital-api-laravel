<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecipient extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'social_assistance_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'account_number',
        'proof',
        'status',
    ];

    public function socialAssistance(): BelongsTo
    {
        return $this->belongsTo(SocialAssistance::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->whereAny(
                    [
                        'reason',
                        'bank',
                        'account_number',
                        'status',
                    ],
                    'ILIKE',
                    "%{$search}%"
                )->orWhereHas('socialAssistance', function (Builder $query) use ($search) {
                    $query->whereAny(['name', 'category', 'provider'], 'ILIKE', "%{$search}%");
                })->orWhereHas('family', function (Builder $query) use ($search) {
                    $query->whereAny(['identity_number', 'phone_number', 'occupation', 'marital_status'], 'ILIKE', "%{$search}%")
                        ->orWhereHas('user', function (Builder $query) use ($search) {
                            $query->whereAny(['name', 'email'], 'ILIKE', "%{$search}%");
                        });
                });
            });
        });
    }
}
