<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\MasjidScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([MasjidScope::class])]
class Deposit extends Model
{
    protected $fillable = [
        'goal_id',
        'donor_name',
        'amount',
        'notes',
        'deposit_date',
        'payment_method',
        'recorded_by',
        'masjid_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'deposit_date' => 'date',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
