<?php $__env->startSection('content'); ?>
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-semibold"><?php echo e(__('View Contribution')); ?></h2>
            
            <div class="flex space-x-3">
                <a href="<?php echo e(route('chairperson.contributions.edit', $contribution)); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    <?php echo e(__('Edit')); ?>

                </a>
                
                <form action="<?php echo e(route('chairperson.contributions.destroy', $contribution)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                            onclick="return confirm('Are you sure you want to delete this contribution?')">
                        <?php echo e(__('Delete')); ?>

                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Contribution Details
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Member Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e($contribution->member->user->name); ?>

                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            TZS <?php echo e(number_format($contribution->amount)); ?>

                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Contribution Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e($contribution->contribution_date->format('M d, Y')); ?>

                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e(ucfirst($contribution->payment_method)); ?>

                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e($contribution->purpose ?: 'Not specified'); ?>

                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($contribution->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($contribution->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                <?php echo e(ucfirst($contribution->status)); ?>

                            </span>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e($contribution->created_at->format('M d, Y H:i:s')); ?>

                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2">
                            <?php echo e($contribution->updated_at->format('M d, Y H:i:s')); ?>

                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-4">
            <a href="<?php echo e(route('chairperson.contributions.index')); ?>" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Contributions
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/contributions/show.blade.php ENDPATH**/ ?>