<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <?php echo e(__('Jumuiyas')); ?>

        </h2>
        <a href="<?php echo e(route('super_admin.jumuiyas.create')); ?>" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <i class="fas fa-plus mr-2"></i><?php echo e(__('Add New Jumuiya')); ?>

        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <?php echo e(__('Name')); ?>

                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <?php echo e(__('Location')); ?>

                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <?php echo e(__('Chairperson')); ?>

                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <?php echo e(__('Created')); ?>

                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <?php echo e(__('Actions')); ?>

                        </th>
                    </tr>
                </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jumuiyas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumuiya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($jumuiya->name); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white"><?php echo e($jumuiya->location ?? '-'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white"><?php echo e($jumuiya->chairperson->name ?? '-'); ?></div>
                            <?php if($jumuiya->chairperson): ?>
                                <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($jumuiya->chairperson->email); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <?php echo e($jumuiya->created_at->format('M d, Y')); ?>

                            <div class="text-xs"><?php echo e($jumuiya->created_at->diffForHumans()); ?></div>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex items-center space-x-3 justify-end">
                                <a href="<?php echo e(route('super_admin.jumuiyas.show', $jumuiya)); ?>" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors duration-150">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>View</span>
                                </a>
                                <a href="<?php echo e(route('super_admin.jumuiyas.edit', $jumuiya)); ?>" 
                                   class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 transition-colors duration-150">
                                    <i class="fas fa-edit mr-1"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="<?php echo e(route('super_admin.jumuiyas.destroy', $jumuiya)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this jumuiya?')"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors duration-150">
                                        <i class="fas fa-trash mr-1"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No jumuiyas found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
            </table>
        </div>
        <?php if($jumuiyas->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <?php echo e($jumuiyas->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/jumuiyas/index.blade.php ENDPATH**/ ?>