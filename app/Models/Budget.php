<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\MasjidScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Carbon\Carbon;
use Exception;

#[ScopedBy([MasjidScope::class])]
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
        'masjid_id',
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
     * Get the masjid that owns the budget.
     */
    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }

    /**
     * Get allocations for this budget.
     */
    public function allocations()
    {
        return $this->hasMany(BudgetAllocation::class);
    }

    /**
     * Get total spent for this budget.
     */
    public function getTotalSpentAttribute()
    {
        return $this->allocations()->sum('amount');
    }

    /**
     * Allocate funds to this budget from an account.
     */
    public function allocateFunds($accountId, $amount, $description = null, $userId = null)
    {
        // Get account and verify it has enough balance
        $account = Account::find($accountId);
        if (!$account || $account->balance < $amount) {
            throw new Exception('Insufficient account balance');
        }

        // Create allocation record
        $allocation = $this->allocations()->create([
            'budget_id' => $this->id,
            'account_id' => $accountId,
            'amount' => $amount,
            'description' => $description,
            'created_by' => $userId ?: auth()->id(),
            'allocated_at' => now(),
        ]);

        // Create transaction to record this expense
        Transaction::create([
            'account_id' => $accountId,
            'type' => 'expense',
            'category' => $this->category->name,
            'description' => 'Alokasi ke anggaran: ' . $this->name . ($description ? ' - ' . $description : ''),
            'amount' => $amount,
            'transaction_date' => now(),
            'masjid_id' => $this->masjid_id,
        ]);

        // Decrease account balance
        $account->decrement('balance', $amount);

        return $allocation;
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
