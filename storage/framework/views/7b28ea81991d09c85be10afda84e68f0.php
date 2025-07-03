<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Create Notification
            </h2>

            <?php if(session('success')): ?>
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                <?php echo e(session('success')); ?>

            </div>
            <?php endif; ?>

            <?php if(isset($noJumuiya) && $noJumuiya): ?>
                <div class="max-w-2xl mx-auto mt-8 p-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
                    <strong>Notice:</strong> You are not currently assigned to a Jumuiya. Please contact your system administrator to be assigned before sending notifications.
                </div>
            <?php else: ?>
            <form action="<?php echo e(route('chairperson.notifications.store')); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Title
                    </label>
                    <input type="text" name="title" id="title" value="<?php echo e(old('title')); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                           required autofocus placeholder="Enter notification title">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Message
                    </label>
                    <textarea name="message" id="message" rows="5"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                              required placeholder="Enter detailed notification message"><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Type
                    </label>
                    <select name="type" id="type"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="general" <?php echo e(old('type') == 'general' ? 'selected' : ''); ?>>General Notification</option>
                        <option value="alert" <?php echo e(old('type') == 'alert' ? 'selected' : ''); ?>>Alert</option>
                        <option value="reminder" <?php echo e(old('type') == 'reminder' ? 'selected' : ''); ?>>Reminder</option>
                        <option value="update" <?php echo e(old('type') == 'update' ? 'selected' : ''); ?>>System Update</option>
                    </select>
                    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Recipients
                    </label>
                    <div class="mt-2 space-y-4">
                        <div class="flex items-center">
                            <input type="radio" name="recipient_type" id="all" value="all"
                                   <?php echo e(old('recipient_type', 'all') == 'all' ? 'checked' : ''); ?>

                                   class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                            <label for="all" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                All members of my Jumuiya
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" name="recipient_type" id="specific" value="specific"
                                   <?php echo e(old('recipient_type') == 'specific' ? 'checked' : ''); ?>

                                   class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                            <label for="specific" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select specific members
                            </label>
                        </div>
                    </div>
                    <?php $__errorArgs = ['recipient_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div id="member-selection" class="<?php echo e(old('recipient_type') == 'specific' ? '' : 'hidden'); ?>">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Select Members
                    </label>
                    <div class="mt-2 max-h-60 overflow-y-auto space-y-2">
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center">
                                <input type="checkbox" name="member_ids[]" value="<?php echo e($member->id); ?>"
                                       <?php echo e(in_array($member->id, old('member_ids', [])) ? 'checked' : ''); ?>

                                       class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                                <label class="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                    <?php echo e($member->user->name); ?>

                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['member_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="action_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Action Link (optional)
                    </label>
                    <input type="url" name="action_url" id="action_url" value="<?php echo e(old('action_url')); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                           placeholder="https://example.com/action">
                    <p class="mt-1 text-sm text-gray-500">URL to direct users when they click the notification</p>
                    <?php $__errorArgs = ['action_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- <div class="flex items-center">
                    <input type="checkbox" name="whatsapp_reminder" id="whatsapp_reminder" value="1"
                           <?php echo e(old('whatsapp_reminder') ? 'checked' : ''); ?>

                           class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600">
                    <label for="whatsapp_reminder" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Also send as WhatsApp message
                    </label>
                </div> -->

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="<?php echo e(route('chairperson.notifications.index')); ?>"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Send Notification
                    </button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientTypeInputs = document.querySelectorAll('input[name="recipient_type"]');
    const memberSelection = document.getElementById('member-selection');

    function toggleMemberSelection() {
        memberSelection.classList.toggle('hidden', 
            document.querySelector('input[name="recipient_type"]:checked').value !== 'specific');
    }

    recipientTypeInputs.forEach(input => {
        input.addEventListener('change', toggleMemberSelection);
    });

    toggleMemberSelection();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/notifications/create.blade.php ENDPATH**/ ?>