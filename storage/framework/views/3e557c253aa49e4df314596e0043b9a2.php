<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">
                    <svg class="w-8 h-8 text-pink-500 dark:text-pink-300 inline-block mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifications
                </h2>
                <a href="<?php echo e(route('chairperson.notifications.create')); ?>" class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-red-100 text-red-700 border border-red-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-red-200 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-400 transition">
                    <i class="fas fa-plus mr-2 text-red-500"></i> <?php echo e(__('Add Notification')); ?>

                </a>
            </div>

            <?php if(session('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full divide-y divide-pink-200 dark:divide-purple-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('Title')); ?>

                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('Message')); ?>

                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('Type')); ?>

                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('Recipients')); ?>

                            </th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                                <?php echo e(__('Date')); ?>

                            </th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-200 dark:divide-purple-700">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                <?php echo e($notification->data['title'] ?? 'Notification'); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                <?php echo e($notification->data['message'] ?? 'No message content'); ?>

                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                <span class="px-2 py-0.5 text-xs rounded-full <?php echo e($notification->type === 'sent' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'); ?>">
                                    <?php echo e($notification->type === 'sent' ? 'Sent' : 'Received'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                <?php if(isset($notification->data['recipient_type'])): ?>
                                    <?php echo e($notification->data['recipient_type'] === 'all' ? 'All Members' : 
                                       (isset($notification->data['member_ids']) ? count($notification->data['member_ids']) . ' Members' : '0 Members')); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                <?php echo e(\Carbon\Carbon::parse($notification->created_at)->diffForHumans()); ?>

                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="<?php echo e(route('chairperson.notifications.show', $notification->id)); ?>" class="flex items-center justify-center w-8 h-8 rounded bg-white border border-gray-200 hover:bg-gray-100 text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition">
                                        <i class="fas fa-eye text-red-500"></i>
                                    </a>
                                    <a href="<?php echo e(route('chairperson.notifications.edit', $notification->id)); ?>" class="flex items-center justify-center w-8 h-8 rounded bg-white border border-gray-200 hover:bg-gray-100 text-red-700 hover:text-red-900 transition">
                                        <i class="fas fa-edit text-red-500"></i>
                                    </a>
                                    <form action="<?php echo e(route('chairperson.notifications.destroy', $notification->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="flex items-center justify-center w-8 h-8 rounded bg-white border border-gray-200 hover:bg-gray-100 text-red-700 hover:text-red-900 transition">
                                            <i class="fas fa-trash text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                No notifications sent yet.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <?php if(($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator || $notifications instanceof \Illuminate\Pagination\Paginator) && $notifications->hasPages()): ?>
                    <?php echo e($notifications->links()); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/notifications/index.blade.php ENDPATH**/ ?>