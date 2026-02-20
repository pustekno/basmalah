<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-extrabold text-xl text-gray-900 dark:text-white leading-tight">
                        {{ __('Edit User Roles') }}
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage user roles and permissions</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 overflow-hidden">
                <!-- User Info -->
                <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.assign-role', $user) }}" class="p-6">
                    @csrf
                    
                    <!-- Assign Roles -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Assign Roles
                        </label>
                        
                        <div class="space-y-3">
                            @foreach($roles as $role)
                                <label class="relative flex items-center p-4 rounded-xl border-2 transition-all cursor-pointer" :class="$user->hasRole('{{ $role->name }}') ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300'">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->name }}"
                                        id="role-{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                        class="sr-only"
                                        @change="handleRoleChange($el, '{{ $role->name }}')"
                                    >
                                    <div class="flex items-center justify-between w-full">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $role->name }}</span>
                                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all" :class="$user->hasRole('{{ $role->name }}') ? 'border-emerald-500 bg-emerald-500' : 'border-gray-300'">
                                            <svg x-show="$user.hasRole('{{ $role->name }}')" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('roles')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Permissions -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-slate-700 rounded-xl">
                        <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-3">Current Permissions</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($user->getAllPermissions() as $permission)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-xs font-semibold">
                                    {{ $permission->name }}
                                </span>
                            @empty
                                <span class="text-gray-500 text-sm">No permissions</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 bg-white dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 hover:text-gray-900 dark:hover:text-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition-colors shadow-lg hover:shadow-xl">
                            Update Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleRoleChange(checkbox, roleName) {
            // Visual feedback is handled by Alpine.js reactivity
        }
    </script>
</x-app-layout>
