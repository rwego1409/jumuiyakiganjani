<?php $__env->startSection('content'); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            <?php echo e(__('My Notifications')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Notifications</h3>
                        <div class="flex items-center space-x-4">
                            <?php if($role === 'chairperson'): ?>
                                <a href="<?php echo e(route('chairperson.notifications.create')); ?>" 
                                   class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200">
                                    Create Notification
                                </a>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('notifications.mark-all-read')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition duration-150">
                                    Mark all as read
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Notification List -->
                    <div class="space-y-4">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $isUnread = is_null($notification->read_at);
                                $bgColor = $isUnread
                                    ? 'bg-blue-50 border-blue-200 dark:bg-blue-900 dark:border-blue-700'
                                    : 'bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700';

                                $sender = 'System';
                                if (isset($notification->data['admin'])) {
                                    $admin = $notification->data['admin'];
                                    $sender = is_array($admin) ? ($admin['name'] ?? 'Admin') : $admin;
                                } elseif (isset($notification->data['user'])) {
                                    $user = $notification->data['user'];
                                    $sender = is_array($user) ? ($user['name'] ?? 'User') : $user;
                                }
                            ?>

                            <div class="p-4 border rounded-lg <?php echo e($bgColor); ?>">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">
                                            <?php echo e($notification->data['title'] ?? 'Notification'); ?>

                                        </p>
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">
                                            <?php echo e($notification->data['message'] ?? 'No message content'); ?>

                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            From: <?php echo e($sender); ?>

                                        </p>
                                    </div>

                                    <div class="text-right whitespace-nowrap">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e($notification->created_at->format('M d, Y h:i A')); ?>

                                        </p>
                                        <?php if($isUnread): ?>
                                            <span
                                                class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 rounded-full">
                                                New
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                You have no notifications
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        <?php echo e($notifications->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.member', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/notifications/index.blade.php ENDPATH**/ ?>