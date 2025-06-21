<?php $__env->startSection('content'); ?>
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <form method="POST" action="<?php echo e(route('admin.settings.update')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">System Settings</h1>

                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">General</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">App Name</label>
                                <input type="text" name="app_name" value="<?php echo e(setting('app_name')); ?>" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">App URL</label>
                                <input type="url" name="app_url" value="<?php echo e(setting('app_url')); ?>" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Contact & Support</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Support Email</label>
                                <input type="email" name="support_email" value="<?php echo e(setting('support_email')); ?>" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                                <input type="text" name="phone" value="<?php echo e(setting('phone')); ?>" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Appearance</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
                                <input type="file" name="app_logo" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Theme</label>
                                <select name="theme" class="mt-1 block w-full rounded-md dark:bg-gray-700 dark:text-white border-gray-300">
                                    <option value="light" <?php echo e(setting('theme') === 'light' ? 'selected' : ''); ?>>Light</option>
                                    <option value="dark" <?php echo e(setting('theme') === 'dark' ? 'selected' : ''); ?>>Dark</option>
                                    <option value="system" <?php echo e(setting('theme') === 'system' ? 'selected' : ''); ?>>System Default</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Notifications</h2>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="email_notifications" name="email_notifications" type="checkbox" class="text-indigo-600 border-gray-300 rounded" <?php echo e(setting('email_notifications') ? 'checked' : ''); ?>>
                                <label for="email_notifications" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Enable Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6">
                        <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded hover:bg-primary-700">
                            Save Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/settings.blade.php ENDPATH**/ ?>