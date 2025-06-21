<?php $__env->startSection('content'); ?>
    <div class="container mx-auto mt-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Super Admin Notifications</h1>
            <a href="<?php echo e(route($routePrefix . 'create')); ?>" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                Create New Notification
            </a>
        </div>

        <?php if($notifications->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center p-4 bg-white rounded-lg shadow-md border border-gray-200">
                        <div>
                            <h5 class="text-xl font-semibold text-blue-600"><?php echo e($notification->title); ?></h5>
                            <p class="text-sm text-gray-500"><?php echo e(Str::limit($notification->message, 100)); ?></p>
                            <small class="text-xs text-gray-400"><?php echo e($notification->created_at->diffForHumans()); ?></small>
                        </div>
                        <a href="<?php echo e(route($routePrefix . 'show', $notification->id)); ?>" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">View</a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-6">
                <?php echo e($notifications->links('pagination::tailwind')); ?>

            </div>
        <?php else: ?>
            <div class="p-4 text-center bg-yellow-100 text-yellow-800 rounded-lg">
                No notifications found. <a href="<?php echo e(route($routePrefix . 'create')); ?>" class="text-blue-600 hover:text-blue-700">Create one now</a>.
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/notifications/index.blade.php ENDPATH**/ ?>