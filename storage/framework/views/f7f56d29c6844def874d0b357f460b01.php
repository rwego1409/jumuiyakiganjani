<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">
                    <svg class="w-8 h-8 text-pink-500 dark:text-pink-300 inline-block mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M9 17H7a4 4 0 01-4-4V7a4 4 0 014-4h10a4 4 0 014 4v6a4 4 0 01-4 4h-2M9 17v2a4 4 0 004 4h2a4 4 0 004-4v-2"/>
                    </svg>
                    <?php echo e(__('Resources Management')); ?>

                </h2>
                <a href="<?php echo e(route('chairperson.resources.create')); ?>" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-700 border border-yellow-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-yellow-200 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                    <i class="fas fa-plus mr-2 text-yellow-500"></i> <?php echo e(__('Add Resource')); ?>

                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <?php echo $__env->make('chairperson.resources.includes.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php if($resources->isEmpty()): ?>
                    <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <?php echo e(__('No resources found')); ?>

                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php $__currentLoopData = $resources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white dark:bg-gray-800 shadow rounded-xl border border-pink-100 dark:border-purple-700 p-6 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-pink-700 dark:text-pink-200 mb-2"><?php echo e($resource->title ?? $resource->name); ?></h3>
                                    <div class="mb-2">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-pink-100 text-pink-700 dark:bg-purple-800 dark:text-pink-200">
                                            <?php echo e(ucfirst($resource->type)); ?>

                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4"><?php echo e(Str::limit($resource->description, 100)); ?></p>
                                </div>
                                <div class="flex items-center justify-between mt-4">
                                    <span class="inline-flex px-2 text-xs font-semibold rounded-full
                                        <?php if($resource->status === 'active'): ?> bg-green-100 text-green-800
                                        <?php elseif($resource->status === 'inactive'): ?> bg-red-100 text-red-800
                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($resource->status)); ?>

                                    </span>
                                    <div class="space-x-2">
                                        <a href="<?php echo e(route('chairperson.resources.show', $resource->id)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-500 dark:hover:text-primary-400">
                                            <i class="fas fa-eye text-yellow-500"></i>
                                        </a>
                                        <a href="<?php echo e(route('chairperson.resources.edit', $resource->id)); ?>"
                                           class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 transition mr-2">
                                            <i class="fas fa-edit text-yellow-500"></i>
                                        </a>
                                        <form action="<?php echo e(route('chairperson.resources.destroy', $resource->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 hover:text-yellow-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-yellow-400 transition">
                                                <i class="fas fa-trash text-yellow-500"></i>
                                            </button>
                                        </form>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/resources/index.blade.php ENDPATH**/ ?>