<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'parent_id',
        'description',
        'icon',
        'color',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the sub-categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /**
     * Get all transactions for this category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category', 'name');
    }

    /**
     * Get all budgets for this category.
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Scope to get only parent categories.
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get only active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get categories by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if category has children.
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get full category path (for sub-categories).
     */
    public function getFullNameAttribute()
    {
        if ($this->parent) {
            return $this->parent->name . ' > ' . $this->name;
        }
        return $this->name;
    }
}
