<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ auth()->user()->name }}</h3>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your Roles:</p>
                        <div class="flex gap-2 mt-2">
                            @forelse(auth()->user()->roles as $role)
                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-500">No roles assigned</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        @can('view transactions')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">Transactions</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Manage financial transactions</p>
                        </div>
                        @endcan

                        @can('view accounts')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">Accounts</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">View and manage accounts</p>
                        </div>
                        @endcan

                        @can('view budgets')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">Budgets</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Budget planning and tracking</p>
                        </div>
                        @endcan

                        @can('view goals')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">Goals</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Financial goals management</p>
                        </div>
                        @endcan

                        @can('view reports')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">Reports</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">View financial reports</p>
                        </div>
                        @endcan

                        @can('manage users')
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="font-semibold">User Management</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Manage users and roles</p>
                            <a href="{{ route('admin.users.index') }}" class="text-blue-600 dark:text-blue-400 text-sm mt-2 inline-block">
                                Go to Users →
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
