<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Masjid extends Model
{
    protected $table = 'masjids';

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'kota',
        'provinsi',
        'kodepos',
        'deskripsi',
        'logo',
        'website',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get users for this masjid
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get accounts for this masjid
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Get transactions for this masjid
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get categories for this masjid
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get budgets for this masjid
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Get goals for this masjid
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }
}
