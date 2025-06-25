

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-pink-100 dark:from-gray-900 dark:to-indigo-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8 bg-white/80 dark:bg-gray-800/80 rounded-2xl shadow-2xl p-8 backdrop-blur-md">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-extrabold text-indigo-700 dark:text-indigo-300 mb-2 flex items-center justify-center">
                <i class="fas fa-users-cog mr-2 text-pink-500"></i> Create a New Jumuiya
            </h2>
            <p class="text-gray-600 dark:text-gray-300">Fill in the details below to register your Jumuiya and get started.</p>
        </div>
        <form method="POST" action="<?php echo e(route('subscription.store')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="jumuiya_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumuiya Name</label>
                    <input type="text" name="jumuiya_name" id="jumuiya_name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Region</label>
                    <input type="text" name="region" id="region" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-200">District</label>
                    <input type="text" name="district" id="district" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="ward" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ward</label>
                    <input type="text" name="ward" id="ward" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Street</label>
                    <input type="text" name="street" id="street" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                    <input type="text" name="address" id="address" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                <textarea name="description" id="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="submitter_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Your Name</label>
                    <input type="text" name="submitter_name" id="submitter_name" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
                <div>
                    <label for="submitter_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Your Contact (Phone/Email)</label>
                    <input type="text" name="submitter_contact" id="submitter_contact" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-900 dark:text-white" />
                </div>
            </div>
            <div>
                <button type="submit" class="w-full py-3 px-6 rounded-lg bg-gradient-to-r from-pink-500 to-indigo-500 text-white font-bold shadow-lg hover:from-pink-600 hover:to-indigo-600 transition-all duration-200">
                    Register Jumuiya
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/subscription/create.blade.php ENDPATH**/ ?>