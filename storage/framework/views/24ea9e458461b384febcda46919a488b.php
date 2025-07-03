<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">All Member Contributions (Cash & Digital)</h2>
    
    <div class="mt-6 flex justify-end mb-4">
        <a href="<?php echo e(route('chairperson.contributions.create')); ?>" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            <i class="fas fa-plus mr-2"></i> Record Cash Contribution
        </a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Member</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $contributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-4 py-2"><?php echo e($contribution->contribution_date->format('d M Y')); ?></td>
                    <td class="px-4 py-2"><?php echo e($contribution->member->user->name); ?></td>
                    <td class="px-4 py-2">TZS <?php echo e(number_format($contribution->amount, 2)); ?></td>
                    <td class="px-4 py-2"><?php echo e(ucfirst($contribution->payment_method)); ?></td>
                    <td class="px-4 py-2">
                        <?php if($contribution->status == 'confirmed'): ?>
                            <span class="status-completed">Confirmed</span>
                        <?php elseif($contribution->status == 'pending'): ?>
                            <span class="status-pending">Pending</span>
                        <?php else: ?>
                            <span class="status-failed">Rejected</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="px-4 py-3">
            <?php echo e($contributions->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/contributions/index.blade.php ENDPATH**/ ?>