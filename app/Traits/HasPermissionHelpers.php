<?php

namespace App\Traits;

trait HasPermissionHelpers
{
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('Super Admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    public function isBendahara(): bool
    {
        return $this->hasRole('Bendahara');
    }

    public function isViewer(): bool
    {
        return $this->hasRole('Viewer');
    }

    public function canManageTransactions(): bool
    {
        return $this->can('create transactions') 
            || $this->can('edit transactions') 
            || $this->can('delete transactions');
    }

    public function canViewFinancials(): bool
    {
        return $this->can('view transactions') 
            || $this->can('view accounts') 
            || $this->can('view reports');
    }
}
