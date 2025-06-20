<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            <?php echo e($jumuiya->name); ?>

        </h2>
        <div class="flex space-x-3">
            <a href="<?php echo e(route('super_admin.jumuiyas.edit', $jumuiya)); ?>" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-edit mr-2"></i><?php echo e(__('Edit')); ?>

            </a>
            <form action="<?php echo e(route('super_admin.jumuiyas.destroy', $jumuiya)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to delete this jumuiya?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-trash mr-2"></i><?php echo e(__('Delete')); ?>

                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('Jumuiya Information')); ?>

                    </h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Location')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white"><?php echo e($jumuiya->location); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Status')); ?></dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($jumuiya->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'); ?>">
                                    <?php echo e(ucfirst($jumuiya->status)); ?>

                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Meeting Schedule')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <?php if($jumuiya->meeting_day && $jumuiya->meeting_time): ?>
                                    <?php echo e(ucfirst($jumuiya->meeting_day)); ?>s at <?php echo e(\Carbon\Carbon::parse($jumuiya->meeting_time)->format('h:i A')); ?>

                                <?php else: ?>
                                    <?php echo e(__('Not scheduled')); ?>

                                <?php endif; ?>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Created')); ?></dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                <?php echo e($jumuiya->created_at->format('M d, Y')); ?>

                            </dd>
                        </div>
                    </dl>

                    <?php if($jumuiya->description): ?>
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Description')); ?></dt>
                            <dd class="mt-2 text-sm text-gray-900 dark:text-white whitespace-pre-line"><?php echo e($jumuiya->description); ?></dd>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Members List -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            <?php echo e(__('Members')); ?>

                        </h3>
                        <button type="button" 
                                onclick="window.location.href='<?php echo e(route('super_admin.members.create', ['jumuiya' => $jumuiya->id])); ?>'"
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md text-xs text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-2"></i><?php echo e(__('Add Member')); ?>

                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo e(__('Name')); ?>

                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo e(__('Contact')); ?>

                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo e(__('Status')); ?>

                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo e(__('Joined')); ?>

                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        <?php echo e(__('Actions')); ?>

                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full" src="<?php echo e($member->user->profile_photo_url); ?>" alt="<?php echo e($member->name); ?>">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        <?php echo e($member->name); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white"><?php echo e($member->user->email); ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($member->user->phone); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($member->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'); ?>">
                                                <?php echo e(ucfirst($member->status)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <?php echo e($member->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="<?php echo e(route('super_admin.members.show', $member)); ?>" 
                                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('super_admin.members.edit', $member)); ?>" 
                                               class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            <?php echo e(__('No members found.')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($members->hasPages()): ?>
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            <?php echo e($members->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Chairperson Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('Chairperson')); ?>

                    </h3>
                    <?php if($jumuiya->chairperson): ?>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full" 
                                     src="<?php echo e($jumuiya->chairperson->profile_photo_url); ?>" 
                                     alt="<?php echo e($jumuiya->chairperson->name); ?>">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?php echo e($jumuiya->chairperson->name); ?>

                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($jumuiya->chairperson->email); ?>

                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($jumuiya->chairperson->phone); ?>

                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e(__('No chairperson assigned.')); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        <?php echo e(__('Statistics')); ?>

                    </h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Total Members')); ?></dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white"><?php echo e($memberCount); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Active Members')); ?></dt>
                            <dd class="mt-1 text-3xl font-semibold text-green-600 dark:text-green-400"><?php echo e($activeMembers); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400"><?php echo e(__('Pending Members')); ?></dt>
                            <dd class="mt-1 text-3xl font-semibold text-yellow-600 dark:text-yellow-400"><?php echo e($pendingMembers); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/jumuiyas/show.blade.php ENDPATH**/ ?>