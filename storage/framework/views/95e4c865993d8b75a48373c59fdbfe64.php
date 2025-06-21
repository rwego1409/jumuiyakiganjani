<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="<?php echo e(route('chairperson.events.index')); ?>" class="text-primary-500 hover:text-primary-700">
            <i class="fas fa-arrow-left mr-2"></i><?php echo e(__('Back to Events')); ?>

        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <!-- Event Header -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        <?php echo e($event->name); ?>

                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        <?php echo e(__('Created')); ?> <?php echo e($event->created_at->diffForHumans()); ?>

                    </p>
                </div>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                    <?php if($event->status === 'upcoming'): ?> bg-blue-100 text-blue-800
                    <?php elseif($event->status === 'ongoing'): ?> bg-green-100 text-green-800
                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                    <?php echo e(ucfirst($event->status)); ?>

                </span>
            </div>

            <!-- Event Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow border border-gray-100 dark:border-gray-800">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('Start Date & Time')); ?></h3>
                    <p class="text-lg font-medium text-gray-900 dark:text-white"><?php echo e($event->start_time->format('M d, Y H:i')); ?></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow border border-gray-100 dark:border-gray-800">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('End Date & Time')); ?></h3>
                    <p class="text-lg font-medium text-gray-900 dark:text-white"><?php echo e($event->end_time->format('M d, Y H:i')); ?></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow border border-gray-100 dark:border-gray-800 md:col-span-2">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('Location')); ?></h3>
                    <p class="text-lg font-medium text-gray-900 dark:text-white"><?php echo e($event->location); ?></p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 shadow border border-gray-100 dark:border-gray-800 md:col-span-2">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1"><?php echo e(__('Description')); ?></h3>
                    <div class="text-lg text-gray-900 dark:text-white prose dark:prose-invert max-w-none"><?php echo e($event->description); ?></div>
                </div>
            </div>

            <!-- Actions -->
            <?php if($event->created_by === auth()->id()): ?>
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                <a href="<?php echo e(route('chairperson.events.edit', $event->id)); ?>" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md shadow transition duration-200">
                    <i class="fas fa-edit mr-2"></i><?php echo e(__('Edit Event')); ?>

                </a>
                <form action="<?php echo e(route('chairperson.events.destroy', $event->id)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow transition duration-200"
                            onclick="return confirm('<?php echo e(__('Are you sure you want to delete this event?')); ?>')">
                        <i class="fas fa-trash mr-2"></i><?php echo e(__('Delete Event')); ?>

                    </button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/events/show.blade.php ENDPATH**/ ?>