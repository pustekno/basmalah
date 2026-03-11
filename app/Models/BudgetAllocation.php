<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'account_id',
        'amount',
        'description',
        'created_by',
        'allocated_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'allocated_at' => 'datetime',
    ];

    /**
     * Get the budget for this allocation.
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    /**
     * Get the account for this allocation.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the user who created this allocation.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
