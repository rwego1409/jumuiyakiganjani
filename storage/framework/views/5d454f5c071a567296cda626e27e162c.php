<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit Jumuiya</h1>
    <form method="POST" action="<?php echo e(route('super_admin.jumuiyas.update', $jumuiya)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input type="text" name="name" class="form-input w-full" value="<?php echo e(old('name', $jumuiya->name)); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Location</label>
            <input type="text" name="location" class="form-input w-full" value="<?php echo e(old('location', $jumuiya->location)); ?>" required>
            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Description</label>
            <textarea name="description" class="form-input w-full"><?php echo e(old('description', $jumuiya->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Chairperson Name</label>
            <input type="text" name="chairperson_name" class="form-input w-full" value="<?php echo e(old('chairperson_name', $jumuiya->chairperson->name ?? '')); ?>" required>
            <?php $__errorArgs = ['chairperson_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Update Jumuiya</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/jumuiyas/edit.blade.php ENDPATH**/ ?>