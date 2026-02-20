<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'decimal:4',
    ];

    /**
     * Get the transactions for the account.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the account type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'cash' => 'Cash',
            'bank' => 'Bank Account',
            'e-wallet' => 'E-Wallet',
            'credit_card' => 'Credit Card',
            default => $this->type,
        };
    }
}
