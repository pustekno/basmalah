<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRoleRequest;
use App\Models\User;
use App\Models\Masjid;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles', 'masjid');
        
        // Filter by masjid if provided
        if ($request->has('masjid_id') && $request->masjid_id != '') {
            $query->where('masjid_id', $request->masjid_id);
        }
        
        // Filter by role if provided
        if ($request->has('role') && $request->role != '') {
            $query->role($request->role);
        }
        
        $users = $query->paginate(5);
        $masjids = Masjid::all();
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'masjids', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $masjids = Masjid::all();
        return view('admin.users.create', compact('roles', 'masjids'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'masjid_id' => ['nullable', 'exists:masjids,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'masjid_id' => $request->masjid_id,
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $masjids = Masjid::all();
        return view('admin.users.edit', compact('user', 'roles', 'masjids'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'roles' => ['required', 'array'],
            'roles.*' => ['string', 'exists:roles,name'],
            'masjid_id' => ['nullable', 'exists:masjids,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'masjid_id' => $request->masjid_id,
        ]);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }

    public function assignRole(AssignRoleRequest $request, User $user)
    {
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index')
            ->with('success', 'Role assigned successfully');
    }

    public function removeRole(Request $request, User $user)
    {
        $user->removeRole($request->role);
        return redirect()->route('admin.users.index')
            ->with('success', 'Role removed successfully');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Login as another user (Super Admin only) - IMPERSONATION MODE
     * 
     * This maintains the Super Admin session while allowing access to 
     * Masjid Admin panel. The original Super Admin session is preserved.
     * Permissions are also merged with the impersonated user's permissions.
     */
    public function loginAs(User $user)
    {
        // Only Super Admin can use this feature
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Cannot login as yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot impersonate yourself');
        }

        // Get impersonated user's permissions
        $impersonatedPermissions = $user->getAllPermissions()->pluck('name')->toArray();
        $impersonatedRoles = $user->getRoleNames()->toArray();

        // Store the original Super Admin session BEFORE any changes
        // This preserves the Super Admin identity
        session([
            'original_user_id' => auth()->id(),
            'original_user_name' => auth()->user()->name,
            'original_user_role' => 'Super Admin',
            'original_permissions' => auth()->user()->getAllPermissions()->pluck('name')->toArray(),
            'impersonating_user_id' => $user->id,
            'impersonating_user_name' => $user->name,
            'impersonating_masjid_id' => $user->masjid_id,
            'impersonating_permissions' => $impersonatedPermissions,
            'impersonating_roles' => $impersonatedRoles,
            'is_impersonating' => true,
        ]);

        // Force refresh roles and permissions cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Reload user with fresh roles and permissions
        auth()->user()->load('roles', 'permissions');

        // Redirect to dashboard without query parameters
        return redirect()->route('dashboard')
            ->with('success', 'You are now viewing ' . $user->name . "'s account. Your Super Admin session is preserved.");
    }

    /**
     * Return to original Super Admin account - END IMPERSONATION
     */
    public function backToAdmin()
    {
        // Check if we're in impersonation mode
        if (!session('is_impersonating') || !session('original_user_id')) {
            return redirect()->route('dashboard')
                ->with('error', 'No impersonation session found');
        }

        $originalUserId = session('original_user_id');
        $originalUserName = session('original_user_name');

        // Clear impersonation session data
        session()->forget([
            'original_user_id',
            'original_user_name',
            'original_user_role',
            'original_permissions',
            'impersonating_user_id',
            'impersonating_user_name',
            'impersonating_masjid_id',
            'impersonating_permissions',
            'impersonating_roles',
            'is_impersonating',
        ]);

        // Force refresh roles and permissions cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Reload user with fresh roles and permissions
        auth()->user()->load('roles', 'permissions');

        return redirect()->route('admin.users.index')
            ->with('success', 'Welcome back, ' . $originalUserName . '! Impersonation ended.');
    }

    /**
     * Check if current user is impersonating another user
     */
    public function isImpersonating()
    {
        return session('is_impersonating') === true;
    }

    /**
     * Get impersonation info for views
     */
    public function getImpersonationInfo()
    {
        if (!$this->isImpersonating()) {
            return null;
        }

        return [
            'is_impersonating' => true,
            'original_user_id' => session('original_user_id'),
            'original_user_name' => session('original_user_name'),
            'impersonating_user_id' => session('impersonating_user_id'),
            'impersonating_user_name' => session('impersonating_user_name'),
            'impersonating_masjid_id' => session('impersonating_masjid_id'),
            'impersonating_permissions' => session('impersonating_permissions', []),
            'impersonating_roles' => session('impersonating_roles', []),
        ];
    }
}
