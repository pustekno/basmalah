<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Scopes\MasjidScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([MasjidScope::class])]
class Goal extends Model
{
    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'current_amount',
        'progress_percentage',
        'start_date',
        'end_date',
        'status',
        'category',
        'created_by',
        'masjid_id',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'progress_percentage' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return max($this->target_amount - $this->current_amount, 0);
    }
}
