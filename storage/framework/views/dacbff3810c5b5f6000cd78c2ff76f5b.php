<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto px-2 sm:px-4 py-4 sm:py-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Chairperson Details</h1>
    <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <span class="font-semibold">Name:</span> <?php echo e($chairperson->name); ?>

        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <span class="font-semibold">Email:</span> <?php echo e($chairperson->email); ?>

        </div>
        <div class="mb-2 sm:mb-4 text-xs sm:text-sm">
            <span class="font-semibold">Phone:</span> <?php echo e($chairperson->phone); ?>

        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-0 sm:space-x-2 mt-4 sm:mt-6">
            <a href="<?php echo e(route('super_admin.chairpersons.edit', $chairperson)); ?>" class="btn btn-warning w-full sm:w-auto">Edit</a>
            <form action="<?php echo e(route('super_admin.chairpersons.destroy', $chairperson)); ?>" method="POST" class="w-full sm:w-auto">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger w-full sm:w-auto" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="<?php echo e(route('super_admin.chairpersons.index')); ?>" class="btn btn-secondary w-full sm:w-auto">Back</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/chairpersons/show.blade.php ENDPATH**/ ?>