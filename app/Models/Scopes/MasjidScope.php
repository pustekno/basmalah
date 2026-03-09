<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MasjidScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return;
        }

        $user = auth()->user();

        // Super Admin & Viewer can see all data or switch masjid
        if ($user->hasRole('Super Admin') || $user->hasRole('Viewer')) {
            // Check if there's an active masjid in session
            if (session()->has('active_masjid_id')) {
                $builder->where($model->getTable() . '.masjid_id', session('active_masjid_id'));
            }
            // If no active masjid, they see all data
            return;
        }

        // Other users (Admin, Bendahara) only see their masjid data
        if ($user->masjid_id) {
            $builder->where($model->getTable() . '.masjid_id', $user->masjid_id);
        }
    }
}
