<?php $__env->startSection('content'); ?>
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-2xl font-semibold mb-6"><?php echo e(__('Jumuiya Dashboard')); ?></h2>

        <?php if(auth()->user()->isChairperson()): ?>
            <a href="<?php echo e(route('chairperson.notifications.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 transition-colors mb-6">
                <i class="fas fa-bell mr-2"></i> Create Notification
            </a>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Members
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        <?php echo e($stats['total_members']); ?>

                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Contributions
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        <?php echo e(number_format($stats['total_contributions'])); ?>

                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Pending Contributions
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        <?php echo e($stats['pending_contributions']); ?>

                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <?php if (isset($component)) { $__componentOriginal5cc340ec5b66b77df6b5e066cf58ad9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5cc340ec5b66b77df6b5e066cf58ad9d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.charts.line-chart','data' => ['id' => 'contributionTrends','title' => 'Monthly Contributions Trend','labels' => $stats['contribution_trends']['labels'],'data' => $stats['contribution_trends']['data']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('charts.line-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'contributionTrends','title' => 'Monthly Contributions Trend','labels' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['contribution_trends']['labels']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['contribution_trends']['data'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5cc340ec5b66b77df6b5e066cf58ad9d)): ?>
<?php $attributes = $__attributesOriginal5cc340ec5b66b77df6b5e066cf58ad9d; ?>
<?php unset($__attributesOriginal5cc340ec5b66b77df6b5e066cf58ad9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5cc340ec5b66b77df6b5e066cf58ad9d)): ?>
<?php $component = $__componentOriginal5cc340ec5b66b77df6b5e066cf58ad9d; ?>
<?php unset($__componentOriginal5cc340ec5b66b77df6b5e066cf58ad9d); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal3b1c98fd5838bef115bb63bc8a617d6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b1c98fd5838bef115bb63bc8a617d6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.charts.bar-chart','data' => ['id' => 'eventAttendance','title' => 'Event Attendance','labels' => $stats['event_stats']['labels'],'data' => $stats['event_stats']['data']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('charts.bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'eventAttendance','title' => 'Event Attendance','labels' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['event_stats']['labels']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['event_stats']['data'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b1c98fd5838bef115bb63bc8a617d6f)): ?>
<?php $attributes = $__attributesOriginal3b1c98fd5838bef115bb63bc8a617d6f; ?>
<?php unset($__attributesOriginal3b1c98fd5838bef115bb63bc8a617d6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b1c98fd5838bef115bb63bc8a617d6f)): ?>
<?php $component = $__componentOriginal3b1c98fd5838bef115bb63bc8a617d6f; ?>
<?php unset($__componentOriginal3b1c98fd5838bef115bb63bc8a617d6f); ?>
<?php endif; ?>
        </div>

        <!-- Recent Activities -->
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Contributions</h3>
            <div class="bg-white dark:bg-gray-700 shadow overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
                    <?php $__empty_1 = true; $__currentLoopData = $stats['recent_contributions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <a href="<?php echo e(route('chairperson.contributions.show', $contribution)); ?>" class="block hover:bg-gray-50 dark:hover:bg-gray-600">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm font-medium text-indigo-600 dark:text-indigo-400 truncate">
                                            <?php echo e($contribution->member->user->name); ?>

                                        </div>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($contribution->status === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'); ?>">
                                                <?php echo e(ucfirst($contribution->status)); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex">
                                            <p class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                TZS <?php echo e(number_format($contribution->amount)); ?>

                                            </p>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                            <p><?php echo e(\Carbon\Carbon::parse($contribution->contribution_date)->format('M d, Y')); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="px-4 py-4 sm:px-6 text-gray-500 dark:text-gray-400 text-center">
                            No recent contributions
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/dashboard.blade.php ENDPATH**/ ?>