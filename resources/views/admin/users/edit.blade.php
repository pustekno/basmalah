<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.users.assign-role', $user) }}">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Assign Roles</label>
                            
                            @foreach($roles as $role)
                                <div class="flex items-center mb-3">
                                    <input 
                                        type="checkbox" 
                                        name="roles[]" 
                                        value="{{ $role->name }}"
                                        id="role-{{ $role->id }}"
                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                    >
                                    <label for="role-{{ $role->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach

                            @error('roles')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold mb-2">Current Permissions</h4>
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->getAllPermissions() as $permission)
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded text-xs">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 text-sm">No permissions</span>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Update Roles') }}
                            </x-primary-button>

                            <a href="{{ route('admin.users.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
