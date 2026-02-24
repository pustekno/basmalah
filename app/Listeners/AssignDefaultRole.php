<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;

class AssignDefaultRole
{
    public function handle(Registered $event): void
    {
        $user = $event->user;
        
        // Assign default 'Viewer' role to new users
        if (!$user->hasAnyRole(['Super Admin', 'Admin', 'Bendahara', 'Viewer'])) {
            $user->assignRole('Viewer');
        }
    }
}
