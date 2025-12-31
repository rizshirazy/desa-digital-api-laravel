<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use HasFactory, SoftDeletes, UUID;

    protected $fillable = [
        'event_id',
        'head_of_family_id',
        'quantity',
        'total_price',
        'payment_status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
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
                    ['payment_status'],
                    'ILIKE',
                    "%{$search}%"
                )->orWhereHas('event', function (Builder $query) use ($search) {
                    $query->whereAny(['name', 'description'], 'ILIKE', "%{$search}%");
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
