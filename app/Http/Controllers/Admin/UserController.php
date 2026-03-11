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
    public function index()
    {
        $users = User::with('roles', 'masjid')->paginate(15);
        return view('admin.users.index', compact('users'));
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
}
