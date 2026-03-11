<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ImpersonationPermissions
{
    /**
     * Handle an incoming request.
     * 
     * This middleware applies the impersonated user's permissions when Super Admin
     * is in impersonation mode, while keeping the Super Admin role intact.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and in impersonation mode
        if (!Auth::check() || !session('is_impersonating')) {
            return $next($request);
        }

        // Get impersonated user's permissions from session
        $impersonatingPermissions = session('impersonating_permissions', []);
        
        // Get current user's (Super Admin) permissions
        $currentUser = Auth::user();
        $currentPermissions = $currentUser->getAllPermissions()->pluck('name')->toArray();

        // Merge impersonated user's permissions with Super Admin's permissions
        // This allows Super Admin to see what the impersonated user can see
        $mergedPermissions = array_unique(array_merge($currentPermissions, $impersonatingPermissions));

        // Store merged permissions in session for easy access
        session(['merged_permissions' => $mergedPermissions]);

        // The Super Admin keeps their role, but now also has the impersonated user's permissions
        // This is handled in the HasPermissionHelpers trait

        return $next($request);
    }
}
