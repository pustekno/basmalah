<section>
    <form method="post" action="<?php echo e(route('profile.update')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Name
            </label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required autofocus autocomplete="name"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Email
            </label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-600 dark:bg-slate-900 dark:text-gray-300 text-gray-900 focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500/30 transition-all">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2 text-sm text-red-500"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-200 dark:border-yellow-800/30">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        Your email address is unverified.
                        <button form="send-verification" class="underline font-medium hover:text-yellow-900 dark:hover:text-yellow-100">
                            Click here to re-send the verification email.
                        </button>
                    </p>
                    <?php if(session('status') === 'verification-link-sent'): ?>
                        <p class="mt-2 text-sm font-medium text-yellow-600 dark:text-yellow-400">
                            A new verification link has been sent to your email address.
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-6 py-3 font-medium text-white bg-yellow-600 hover:bg-yellow-700 rounded-xl transition-all">
                Save Changes
            </button>

            <?php if(session('status') === 'profile-updated'): ?>
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-medium text-yellow-600 dark:text-yellow-400"
                >Saved!</p>
            <?php endif; ?>
        </div>
    </form>

    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>" class="hidden">
        <?php echo csrf_field(); ?>
    </form>
</section>
<?php /**PATH D:\laragon\www\project-basmalah\basmallah\resources\views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>