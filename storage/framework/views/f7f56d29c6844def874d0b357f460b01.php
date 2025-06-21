<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <?php echo e(__('Resources Management')); ?>

        </h2>
        <a href="<?php echo e(route('chairperson.resources.create')); ?>" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
            <i class="fas fa-plus mr-2"></i><?php echo e(__('Add Resource')); ?>

        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <?php echo $__env->make('chairperson.resources.includes.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if($resources->isEmpty()): ?>
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                <?php echo e(__('No resources found')); ?>

            </div>
        <?php else: ?>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="resource-card bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 group transition transform hover:scale-105 hover:shadow-xl cursor-pointer flex flex-col justify-between">
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-700 dark:group-hover:text-primary-300"><?php echo e($resource->title ?? $resource->name); ?></h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                <?php if($resource->status === 'active'): ?> bg-green-100 text-green-800
                                <?php elseif($resource->status === 'inactive'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                <?php echo e(ucfirst($resource->status)); ?>

                            </span>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-2">
                            <span class="font-medium mr-2"><?php echo e(ucfirst($resource->type)); ?></span>
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 text-sm mb-4 line-clamp-3"><?php echo e(Str::limit($resource->description, 100)); ?></div>
                        <div class="mt-auto">
                            <a href="<?php echo e(route('chairperson.resources.show', $resource->id)); ?>"
                               class="inline-flex items-center w-full justify-center px-4 py-2 text-sm rounded-md bg-primary-600 hover:bg-primary-700 text-white dark:bg-primary-700 dark:hover:bg-primary-600 transition-colors">
                                <?php echo e(__('View Details')); ?>

                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="px-6 py-4">
                <?php echo e($resources->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/resources/index.blade.php ENDPATH**/ ?>