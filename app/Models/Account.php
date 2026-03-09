<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\MasjidScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([MasjidScope::class])]
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
        'masjid_id',
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
     * Get the masjid that owns the account.
     */
    public function masjid(): BelongsTo
    {
        return $this->belongsTo(Masjid::class);
    }

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
