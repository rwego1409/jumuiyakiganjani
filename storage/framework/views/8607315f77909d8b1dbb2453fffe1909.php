<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8 max-w-lg px-2 sm:px-4">
    <h1 class="text-2xl font-bold mb-6 text-center sm:text-left">Edit Chairperson</h1>
    <form action="<?php echo e(route('super_admin.chairpersons.update', $chairperson)); ?>" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Name</label>
            <input type="text" name="name" class="form-input w-full text-sm sm:text-base" value="<?php echo e(old('name', $chairperson->name)); ?>" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-500 text-xs sm:text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Email</label>
            <input type="email" name="email" class="form-input w-full text-sm sm:text-base" value="<?php echo e(old('email', $chairperson->email)); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-500 text-xs sm:text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Phone</label>
            <input type="text" name="phone" class="form-input w-full text-sm sm:text-base" value="<?php echo e(old('phone', $chairperson->phone)); ?>" required>
            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-500 text-xs sm:text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Password <span class="text-gray-500 text-xs">(leave blank to keep current)</span></label>
            <input type="password" name="password" class="form-input w-full text-sm sm:text-base">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-500 text-xs sm:text-sm"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-6">
            <label class="block mb-1 font-semibold text-sm sm:text-base">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-input w-full text-sm sm:text-base">
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-0 sm:space-x-2 w-full sm:w-auto">
            <a href="<?php echo e(route('super_admin.chairpersons.index')); ?>" class="btn btn-secondary w-full sm:w-auto">Cancel</a>
            <button type="submit" class="btn btn-primary w-full sm:w-auto">Update</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super_admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/super_admin/chairpersons/edit.blade.php ENDPATH**/ ?>