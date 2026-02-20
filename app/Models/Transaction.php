<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'type',
        'category',
        'amount',
        'description',
        'proof_image',
        'transaction_date',
        'upcoming_flag',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'integer',
        'upcoming_flag' => 'boolean',
    ];

    /**
     * Get the account that owns the transaction.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the transaction type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'income' => 'Income',
            'expense' => 'Expense',
            default => $this->type,
        };
    }

    /**
     * Get the formatted amount in rupiah.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount / 100, 0, ',', '.');
    }
}
