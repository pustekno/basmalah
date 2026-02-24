<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'deposit_date' => 'date',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
