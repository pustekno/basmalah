<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'amount',
        'period',
        'start_date',
        'end_date',
        'description',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category for this budget.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get total spent for this budget.
     */
    public function getTotalSpentAttribute()
    {
        return Transaction::where('category', $this->category->name)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$this->start_date, $this->end_date])
            ->sum('amount');
    }

    /**
     * Get remaining budget.
     */
    public function getRemainingAttribute()
    {
        return $this->amount - $this->total_spent;
    }

    /**
     * Get percentage used.
     */
    public function getPercentageUsedAttribute()
    {
        if ($this->amount == 0) {
            return 0;
        }
        return round(($this->total_spent / $this->amount) * 100, 2);
    }

    /**
     * Check if budget is exceeded.
     */
    public function isExceeded()
    {
        return $this->total_spent > $this->amount;
    }

    /**
     * Check if budget is active for current date.
     */
    public function isActiveNow()
    {
        $now = Carbon::now();
        return $this->is_active 
            && $now->between($this->start_date, $this->end_date);
    }

    /**
     * Scope to get only active budgets.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get current budgets.
     */
    public function scopeCurrent($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get formatted spent.
     */
    public function getFormattedSpentAttribute()
    {
        return 'Rp ' . number_format($this->total_spent, 0, ',', '.');
    }

    /**
     * Get formatted remaining.
     */
    public function getFormattedRemainingAttribute()
    {
        return 'Rp ' . number_format($this->remaining, 0, ',', '.');
    }
}
