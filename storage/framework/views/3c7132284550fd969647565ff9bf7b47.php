<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Admins</h1>
        <a href="<?php echo e(route('super_admin.admins.create')); ?>" class="btn btn-primary">Add Admin</a>
    </div>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-2"><?php echo e($admin->name); ?></td>
                        <td class="px-4 py-2"><?php echo e($admin->email); ?></td>
                        <td class="px-4 py-2"><?php echo e($admin->phone); ?></td>
                        <td class="px-4 py-2"><?php echo e(ucfirst($admin->status ?? 'active')); ?></td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="<?php echo e(route('super_admin.admins.show', $admin)); ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?php echo e(route('super_admin.admins.edit', $admin)); ?>" class="btn btn-sm btn-warning">Edit</a>
                            <form action="<?php echo e(route('super_admin.admins.destroy', $admin)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No admins found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($admins->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/super/admins/index.blade.php ENDPATH**/ ?>