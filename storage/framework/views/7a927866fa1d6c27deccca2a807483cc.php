<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 md:mb-0">Super Admin Dashboard</h2>
        <?php if(auth()->user()->isChairperson()): ?>
            <a href="<?php echo e(route('chairperson.notifications.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700 transition-colors">
                <i class="fas fa-bell mr-2"></i> Create Notification
            </a>
        <?php endif; ?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="text-3xl font-bold text-primary-600"><?php echo e($totalJumuiyas); ?></div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Total Jumuiyas</div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="text-3xl font-bold text-primary-600"><?php echo e($totalChairpersons); ?></div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Total Chairpersons</div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="text-3xl font-bold text-primary-600"><?php echo e($totalMembers); ?></div>
            <div class="text-gray-700 dark:text-gray-300 mt-2">Total Members</div>
        </div>
    </div>
    <!-- Charts Section -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistics Overview</h3>
        <canvas id="superAdminChart" height="100"></canvas>
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Jumuiyas</h3>
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $recentJumuiyas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumuiya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li class="mb-2">
                    <span class="font-semibold"><?php echo e($jumuiya->name); ?></span>
                    <span class="text-gray-500 ml-2">(<?php echo e($jumuiya->chairperson->name ?? 'No Chairperson'); ?>)</span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="text-gray-500">No recent Jumuiyas found.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('superAdminChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jumuiyas', 'Chairpersons', 'Members'],
            datasets: [{
                label: 'Count',
                data: [<?php echo e($totalJumuiyas); ?>, <?php echo e($totalChairpersons); ?>, <?php echo e($totalMembers); ?>],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.7)',
                    'rgba(236, 72, 153, 0.7)',
                    'rgba(34, 197, 94, 0.7)'
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(34, 197, 94, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.super_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/dashboard.blade.php ENDPATH**/ ?>