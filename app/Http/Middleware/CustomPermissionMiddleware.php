<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CustomPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Checks permissions with support for impersonation mode.
     * During impersonation, permissions are merged from both the Super Admin
     * and the impersonated user.
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (app()->auth->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        // Check if user has any of the required permissions
        foreach ($permissions as $permission) {
            // First check using standard Spatie method
            if (app()->auth->user()->can($permission)) {
                return $next($request);
            }
            
            // If in impersonation mode, also check merged permissions
            if (session('is_impersonating')) {
                $mergedPermissions = session('merged_permissions', []);
                if (in_array($permission, $mergedPermissions)) {
                    return $next($request);
                }
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
}
