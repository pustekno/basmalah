<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
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
}
