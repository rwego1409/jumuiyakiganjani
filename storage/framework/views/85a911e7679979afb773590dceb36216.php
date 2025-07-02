<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50/80 to-blue-100/60 dark:from-gray-900/80 dark:to-blue-900/60 py-8 px-2">
    <div class="glass-card max-w-lg w-full mx-auto p-8">
        <div class="mb-8 flex flex-col items-center">
            <div class="bg-gradient-to-r from-pink-500 to-indigo-500 p-3 rounded-full mb-3 shadow-lg">
                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow-lg">Edit Admin</h1>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">Update admin details below</p>
        </div>
        <form method="POST" action="<?php echo e(route('super_admin.users.update', $user)); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <!-- Name Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Full Name</label>
                <div class="relative">
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3"
                        placeholder="Full name">
                </div>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Email Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3"
                        placeholder="Email address">
                </div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Phone Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Phone Number</label>
                <div class="relative">
                    <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" required
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3"
                        placeholder="Phone number">
                </div>
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Password Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Password <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(leave blank to keep current)</span>
                </label>
                <div class="relative">
                    <input type="password" name="password"
                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3"
                        placeholder="••••••••">
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Assigned Jumuiya (Single) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Assigned Jumuiya</label>
                <div class="bg-slate-100 dark:bg-gray-800 rounded-md px-4 py-2 text-base text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700">
                    <?php echo e($assignedJumuiyaName ?? 'N/A'); ?>

                </div>
            </div>
            <!-- Role Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Role</label>
                <select name="role" class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3">
                    <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="super_admin" <?php echo e(old('role', $user->role) == 'super_admin' ? 'selected' : ''); ?>>Super Admin</option>
                    <option value="user" <?php echo e(old('role', $user->role) == 'user' ? 'selected' : ''); ?>>User</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Status Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Account Status</label>
                <select name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white/80 dark:bg-gray-900/80 shadow-sm focus:border-violet-500 focus:ring-violet-500 sm:text-sm py-2 text-gray-900 dark:text-white px-3">
                    <option value="active" <?php echo e(old('status', $user->status ?? 'active') == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(old('status', $user->status ?? 'active') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <!-- Submit Button -->
            <div class="pt-4">
                <div class="flex justify-end space-x-3">
                    <a href="<?php echo e(route('super_admin.users.index')); ?>" class="inline-flex justify-center items-center py-2.5 px-4 rounded-2xl font-bold text-gray-700 dark:text-white bg-gradient-to-r from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-700 shadow-xl hover:from-gray-200 hover:to-gray-400 dark:hover:from-gray-700 dark:hover:to-gray-900 focus:outline-none focus:ring-2 focus:ring-violet-400 transition-all duration-300">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center items-center py-2.5 px-4 rounded-2xl font-bold text-white bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 shadow-xl shadow-violet-500/10 dark:shadow-violet-500/20 hover:from-violet-700 hover:via-purple-700 hover:to-indigo-700 dark:from-violet-500 dark:via-purple-500 dark:to-indigo-500 dark:hover:from-violet-600 dark:hover:via-purple-600 dark:hover:to-indigo-600 transition-all duration-300 hover:scale-105 hover:shadow-2xl focus:outline-none focus:ring-2 focus:ring-violet-400">
                        <svg class="-ml-1 mr-2 h-5 w-5 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Glassmorphism utility removed for white background -->
<style>
    .glass-card {
        background: #fff !important;
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
        border: 1px solid #f3f4f6;
    }
    /* Force white background in all modes */
    @media (prefers-color-scheme: dark) {
        .glass-card {
            background: #fff !important;
            border: 1px solid #f3f4f6;
        }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.super_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/admins/edit.blade.php ENDPATH**/ ?>