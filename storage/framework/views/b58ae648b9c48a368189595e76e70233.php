<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <?php echo e(__('Admin Details')); ?>

        </h2>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('super_admin.admins.edit', $admin->id)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-edit mr-2"></i><?php echo e(__('Edit')); ?>

            </a>
            <form action="<?php echo e(route('super_admin.admins.destroy', $admin->id)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" onclick="return confirm('<?php echo e(__('Are you sure you want to delete this admin?')); ?>')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-trash mr-2"></i><?php echo e(__('Delete')); ?>

                </button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4"><?php echo e(__('Basic Information')); ?></h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Name')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($admin->name); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Email')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($admin->email); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Phone')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($admin->phone); ?></dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4"><?php echo e(__('Account Details')); ?></h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Role')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e(ucfirst($admin->role)); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Status')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($admin->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'); ?>">
                                    <?php echo e(ucfirst($admin->status ?? 'active')); ?>

                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Joined Date')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($admin->created_at->format('M d, Y')); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Managed Jumuiyas -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4"><?php echo e(__('Managed Jumuiyas')); ?></h3>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg">
                    <?php if($jumuiyas->count() > 0): ?>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__currentLoopData = $jumuiyas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumuiya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="p-4 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-150">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($jumuiya->name); ?></h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <?php echo e($jumuiya->members_count ?? 0); ?> <?php echo e(__('members')); ?>

                                        </p>
                                    </div>                                    <a href="<?php echo e(route('super_admin.jumuiyas.edit', $jumuiya->id)); ?>"
                                       class="inline-flex items-center px-3 py-1 text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        <i class="fas fa-edit mr-1"></i> <?php echo e(__('Edit Jumuiya')); ?>

                                    </a>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php else: ?>
                        <p class="p-4 text-sm text-gray-500 dark:text-gray-400"><?php echo e(__('No Jumuiyas assigned yet.')); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Statistics -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4"><?php echo e(__('Overview')); ?></h3>
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="px-4 py-5 bg-gray-50 dark:bg-gray-900 shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                <?php echo e(__('Total Members')); ?>

                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                <?php echo e($totalMembers); ?>

                            </dd>
                        </div>

                        <div class="px-4 py-5 bg-gray-50 dark:bg-gray-900 shadow rounded-lg overflow-hidden sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                <?php echo e(__('Managed Jumuiyas')); ?>

                            </dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                <?php echo e($jumuiyas->count()); ?>

                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="flex space-x-2">
        <a href="<?php echo e(route('super_admin.admins.edit', $admin)); ?>" class="btn btn-warning">Edit</a>
        <form action="<?php echo e(route('super_admin.admins.destroy', $admin)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <a href="<?php echo e(route('super_admin.admins.index')); ?>" class="btn btn-secondary">Back</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/super/admins/show.blade.php ENDPATH**/ ?>