<?php

namespace App\Traits;

trait HasPermissionHelpers
{
    /**
     * Check if user has permission, considering impersonation mode.
     * During impersonation, checks both original user and impersonated user's permissions.
     */
    public function canWithImpersonation(string $permission): bool
    {
        // First check if user has the permission directly
        if ($this->can($permission)) {
            return true;
        }

        // If in impersonation mode, also check merged permissions
        if (session('is_impersonating')) {
            $mergedPermissions = session('merged_permissions', []);
            return in_array($permission, $mergedPermissions);
        }

        return false;
    }

    /**
     * Get all effective permissions (original + impersonated).
     */
    public function getEffectivePermissions(): array
    {
        $permissions = $this->getAllPermissions()->pluck('name')->toArray();
        
        // If in impersonation mode, merge with impersonated user's permissions
        if (session('is_impersonating')) {
            $mergedPermissions = session('merged_permissions', []);
            $permissions = array_unique(array_merge($permissions, $mergedPermissions));
        }

        return $permissions;
    }

    /**
     * Check if user is in impersonation mode.
     */
    public function isImpersonating(): bool
    {
        return session('is_impersonating') === true;
    }

    /**
     * Get impersonation info.
     */
    public function getImpersonationInfo(): ?array
    {
        if (!$this->isImpersonating()) {
            return null;
        }

        return [
            'original_user_id' => session('original_user_id'),
            'original_user_name' => session('original_user_name'),
            'impersonating_user_id' => session('impersonating_user_id'),
            'impersonating_user_name' => session('impersonating_user_name'),
            'impersonating_masjid_id' => session('impersonating_masjid_id'),
            'impersonating_permissions' => session('impersonating_permissions', []),
            'impersonating_roles' => session('impersonating_roles', []),
        ];
    }

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
