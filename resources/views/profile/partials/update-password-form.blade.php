<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Current Password') }}
            </label>
            <input type="password" id="update_password_current_password" name="current_password" autocomplete="current-password"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner"
                placeholder="Enter current password">
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                {{ __('New Password') }}
            </label>
            <input type="password" id="update_password_password" name="password" autocomplete="new-password"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner"
                placeholder="Enter new password">
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Confirm Password') }}
            </label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password"
                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border-0 rounded-xl text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner"
                placeholder="Confirm new password">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl hover:from-emerald-600 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 hover:-translate-y-0.5">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 dark:text-emerald-400 font-semibold"
                >{{ __('Saved!') }}</p>
            @endif
        </div>
    </form>
</section>
