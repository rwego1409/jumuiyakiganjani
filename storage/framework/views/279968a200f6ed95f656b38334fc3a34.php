<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
    <!-- Subtle animated background elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-20 w-96 h-96 bg-blue-100 dark:bg-blue-900/20 rounded-full filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute top-2/3 right-0 w-80 h-80 bg-purple-100 dark:bg-purple-900/20 rounded-full filter blur-3xl opacity-20 animate-float animation-delay-2000"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Chairperson Welcome Header -->
        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-xl opacity-10 group-hover:opacity-20 transition duration-500 blur-sm"></div>
            <div class=" backdrop-blur-sm rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <div class="flex items-center gap-5">
                            <div class="relative">
                                <div class="absolute -inset-2 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-xl opacity-20 blur-sm"></div>
                                <div class="relative bg-gradient-to-br from-blue-500 to-indigo-600 p-3 rounded-xl shadow-sm">
                                    <!-- <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg> -->
                                </div>
                            </div>
                            <div>
                                <h1 class="text-3xl md:text-4xl font-semibold text-slate-800 dark:text-white">
                                    Welcome, Chairperson <?php echo e(auth()->user()->name); ?>

                                </h1>
                                <p class="text-slate-500 dark:text-slate-400 mt-1">This is your community management dashboard</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="<?php echo e(route('chairperson.events.create')); ?>" class="inline-flex items-center px-5 py-3 btn-blue rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Event
                            </a>
                            <a href="<?php echo e(route('chairperson.notifications.create')); ?>" class="inline-flex items-center px-5 py-3 btn-amber rounded-lg shadow-lg transition-all duration-300 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-amber-400">
                                <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 7.165 6 9.388 6 12v2.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Create Notification
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clean Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Total Members Card -->
            <div class="relative bg-white/95 dark:bg-slate-800/95 rounded-xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg stat-card">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 opacity-40"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-600 dark:bg-blue-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white dark:bg-blue-400 dark:text-slate-900">
                            +12%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Total Members</p>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white"><?php echo e($stats['total_members']); ?></p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">Active community members</p>
                    </div>
                </div>
            </div>
            <!-- Total Contributions Card -->
            <div class="relative bg-white/95 dark:bg-slate-800/95 rounded-xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg stat-card">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 opacity-40"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-600 dark:bg-purple-500 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-600 text-white dark:bg-purple-400 dark:text-slate-900">
                            +8%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Total Contributions</p>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white">TZS <?php echo e(number_format($stats['total_contributions'])); ?></p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">This month's contributions</p>
                    </div>
                </div>
            </div>
            <!-- Upcoming Events Card -->
            <div class="relative bg-white/95 dark:bg-slate-800/95 rounded-xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg stat-card">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-800/30 opacity-40"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-amber-500 dark:bg-amber-400 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white dark:text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500 text-white dark:bg-amber-300 dark:text-amber-900">
                            This week
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Upcoming Events</p>
                        <p class="text-3xl font-extrabold text-slate-900 dark:text-white"><?php echo e(isset($stats['upcoming_events_list']) ? count($stats['upcoming_events_list']) : 0); ?></p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">Events scheduled ahead</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="bg-white/95 dark:bg-slate-800/95 rounded-xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between section-header">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Upcoming Events
                </h3>
                <a href="<?php echo e(route('chairperson.events.index')); ?>" class="text-sm font-bold text-blue-700 dark:text-blue-300 hover:text-blue-900 dark:hover:text-white transition-colors duration-200">View All</a>
            </div>
            <div class="divide-y divide-slate-200 dark:divide-slate-700">
                <?php
                    $upcomingEvents = $stats['upcoming_events_list'] ?? [];
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600 dark:bg-blue-400 rounded-lg flex items-center justify-center text-white dark:text-blue-900 font-bold">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 dark:text-white"><?php echo e($event->name); ?></h4>
                            <p class="text-sm text-slate-700 dark:text-slate-300 mt-1">
                                <?php echo e(\Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-2 md:mt-0">
                        <a href="<?php echo e(route('chairperson.events.show', $event->id)); ?>" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded shadow focus:ring-2 focus:ring-blue-400">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="<?php echo e(route('chairperson.events.edit', $event->id)); ?>" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded shadow focus:ring-2 focus:ring-indigo-400">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="<?php echo e(route('chairperson.events.destroy', $event->id)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded shadow focus:ring-2 focus:ring-red-400">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-600 dark:text-slate-300">No upcoming events</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modern Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <!-- Contributions Chart -->
            <div class="bg-white/95 dark:bg-slate-800/95 rounded-xl border border-blue-400 dark:border-blue-500 shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl stat-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-extrabold text-blue-700 dark:text-blue-300 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17v-2a4 4 0 014-4h10a4 4 0 014 4v2"/>
                            </svg>
                            Monthly Contributions
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-bold text-blue-600 dark:text-blue-300">Trend Analysis</span>
                        </div>
                    </div>
                    <?php if (isset($component)) { $__componentOriginal5cc340ec5b66b77df6b5e066cf58ad9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5cc340ec5b66b77df6b5e066cf58ad9d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.charts.line-chart','data' => ['id' => 'contributionTrends','title' => 'Monthly Contributions Trend','labels' => $stats['contribution_trends']['labels'],'data' => $stats['contribution_trends']['data'],'colors' => ['#6366f1', '#f59e42', '#10b981', '#ef4444'],'options' => ['backgroundColor' => 'rgba(99,102,241,0.08)', 'borderWidth' => 4, 'pointBackgroundColor' => '#f59e42', 'pointRadius' => 6, 'tension' => 0.4]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('charts.line-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'contributionTrends','title' => 'Monthly Contributions Trend','labels' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['contribution_trends']['labels']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['contribution_trends']['data']),'colors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['#6366f1', '#f59e42', '#10b981', '#ef4444']),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['backgroundColor' => 'rgba(99,102,241,0.08)', 'borderWidth' => 4, 'pointBackgroundColor' => '#f59e42', 'pointRadius' => 6, 'tension' => 0.4])]); ?>
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
                </div>
            </div>
            <!-- Event Attendance Chart -->
            <div class="bg-white/95 dark:bg-slate-800/95 rounded-xl border border-amber-400 dark:border-amber-500 shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl stat-card">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-extrabold text-amber-600 dark:text-amber-300 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2"/>
                            </svg>
                            Event Attendance
                        </h3>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-bold text-amber-600 dark:text-amber-300">Engagement</span>
                        </div>
                    </div>
                    <?php if (isset($component)) { $__componentOriginal3b1c98fd5838bef115bb63bc8a617d6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b1c98fd5838bef115bb63bc8a617d6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.charts.bar-chart','data' => ['id' => 'eventAttendance','title' => 'Event Attendance','labels' => $stats['event_stats']['labels'],'data' => $stats['event_stats']['data'],'colors' => ['#f59e42', '#6366f1', '#10b981', '#ef4444'],'options' => ['backgroundColor' => ['#f59e42', '#6366f1', '#10b981', '#ef4444'], 'borderRadius' => 8, 'borderWidth' => 2]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('charts.bar-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'eventAttendance','title' => 'Event Attendance','labels' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['event_stats']['labels']),'data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats['event_stats']['data']),'colors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['#f59e42', '#6366f1', '#10b981', '#ef4444']),'options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['backgroundColor' => ['#f59e42', '#6366f1', '#10b981', '#ef4444'], 'borderRadius' => 8, 'borderWidth' => 2])]); ?>
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
            </div>
        </div>

        <!-- Recent Activities Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Recent Contributions</h3>
                    <a href="<?php echo e(route('chairperson.contributions.index')); ?>" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200">
                        View All
                    </a>
                </div>
            </div>
            
            <div class="divide-y divide-slate-200 dark:divide-slate-700">
                <?php $__empty_1 = true; $__currentLoopData = $stats['recent_contributions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="<?php echo e(route('chairperson.contributions.show', $contribution)); ?>" class="block hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400 font-medium">
                                        <?php echo e(substr($contribution->member->user->name, 0, 1)); ?>

                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white dark:border-slate-800"></div>
                                </div>
                                <div>
                                    <h4 class="font-medium text-slate-800 dark:text-white"><?php echo e($contribution->member->user->name); ?></h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        <?php echo e(\Carbon\Carbon::parse($contribution->contribution_date)->format('M d, Y')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-slate-800 dark:text-white">
                                    TZS <?php echo e(number_format($contribution->amount)); ?>

                                </p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($contribution->status === 'confirmed' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-200' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-200'); ?>">
                                    <?php echo e(ucfirst($contribution->status)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">No recent contributions</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Activity will appear here when members contribute</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent System Activity Section -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Recent System Activity
                    </h3>
                    <a href="<?php echo e(route('chairperson.activities.index')); ?>" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors duration-200">
                        View All
                    </a>
                </div>
            </div>
            <div class="divide-y divide-slate-200 dark:divide-slate-700">
                <?php $__empty_1 = true; $__currentLoopData = $stats['recent_activities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-6 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-gradient-to-br from-indigo-100 to-blue-100 dark:from-indigo-900/30 dark:to-blue-900/30">
                        <i class="fas fa-<?php echo $activity->getActivityIcon(); ?> text-<?php echo e($activity->getActionColor()); ?>-600 dark:text-<?php echo e($activity->getActionColor()); ?>-400 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div>
                                <span class="font-bold text-slate-800 dark:text-white"><?php echo e($activity->user->name ?? 'System'); ?></span>
                                <span class="mx-2 text-xs font-semibold px-2 py-0.5 rounded bg-<?php echo e($activity->getActionColor()); ?>-100 text-<?php echo e($activity->getActionColor()); ?>-800 dark:bg-<?php echo e($activity->getActionColor()); ?>-900/30 dark:text-<?php echo e($activity->getActionColor()); ?>-200">
                                    <?php echo e(ucfirst($activity->action)); ?>

                                </span>
                                <span class="text-slate-600 dark:text-slate-300"><?php echo e($activity->description); ?></span>
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-2 md:mt-0 md:ml-4">
                                <?php echo e($activity->created_at->diffForHumans()); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">No recent system activity</p>
                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Actions by members will appear here</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Smooth animations */
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

/* Improved dark mode transitions */
@media (prefers-color-scheme: dark) {
    .dark\:bg-slate-800\/80 {
        background-color: rgba(30, 41, 59, 0.8);
    }
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(241, 245, 249, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.3);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.5);
}

/* Better focus states */
button:focus-visible,
a:focus-visible,
input:focus-visible {
    outline: 2px solid rgba(59,130,246,0.5);
    outline-offset: 2px;
    border-radius: 0.375rem;
}

/* Make dark mode fully dark and light mode fully light */

.bg-white\/95 { background-color: #fff !important; }
.dark .bg-white\/95, .dark.bg-white\/95 { background-color: #0f172a !important; }

.stat-card {
    background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%);
    box-shadow: 0 4px 24px 0 rgba(59,130,246,0.10), 0 1.5px 4px 0 rgba(99,102,241,0.10);
}
.dark .stat-card, .dark.stat-card {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    box-shadow: 0 4px 24px 0 rgba(99,102,241,0.15), 0 1.5px 4px 0 rgba(16,185,129,0.10);
}

.section-header {
    background: linear-gradient(90deg, #6366f1 0%, #f59e42 100%);
    color: #fff;
    border-radius: 0.75rem;
    padding: 0.5rem 1.5rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px 0 rgba(99,102,241,0.10);
}
.dark .section-header, .dark.section-header {
    background: linear-gradient(90deg, #f59e42 0%, #6366f1 100%);
    color: #fff;
}

.card-accent {
    border-left: 6px solid #6366f1;
}
.dark .card-accent, .dark.card-accent {
    border-left: 6px solid #f59e42;
}

.btn-blue { background: linear-gradient(90deg,#2563eb,#6366f1); color:#fff; font-weight:700; }
.btn-blue:hover { background: linear-gradient(90deg,#1d4ed8,#4f46e5); }
.btn-indigo { background: linear-gradient(90deg,#a21caf,#6366f1); color:#fff; font-weight:700; }
.btn-indigo:hover { background: linear-gradient(90deg,#7c3aed,#6366f1); }
.btn-amber { background: linear-gradient(90deg,#f59e42,#fbbf24); color:#fff; font-weight:700; }
.btn-amber:hover { background: linear-gradient(90deg,#f59e42,#f59e42); }
.btn-red { background: linear-gradient(90deg,#ef4444,#f59e42); color:#fff; font-weight:700; }
.btn-red:hover { background: linear-gradient(90deg,#b91c1c,#f59e42); }

.badge-blue { background:#2563eb; color:#fff; font-weight:700; }
.badge-indigo { background:#6366f1; color:#fff; font-weight:700; }
.badge-amber { background:#f59e42; color:#fff; font-weight:700; }
.badge-red { background:#ef4444; color:#fff; font-weight:700; }

/* Ensure all text and backgrounds are high-contrast in both modes */
body, .min-h-screen, .bg-gradient-to-br {
    background: #fff !important;
    color: #0f172a !important;
}
.dark body, .dark .min-h-screen, .dark .bg-gradient-to-br {
    background: #0f172a !important;
    color: #fff !important;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/dashboard.blade.php ENDPATH**/ ?>