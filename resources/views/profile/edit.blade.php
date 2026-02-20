<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg shadow-emerald-500/20">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                    {{ __('Profile') }}
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Manage your account settings</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white dark:from-gray-800 dark:to-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Profile Information</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update your account's profile information and email address.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50/80 to-white dark:from-gray-800 dark:to-gray-800/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Password</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ensure your account is using a long, random password.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-red-50/80 to-white dark:from-red-900/20 dark:to-gray-800/50">
                    <h3 class="text-lg font-bold text-red-600 dark:text-red-400">Delete Account</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Permanently delete your account.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
