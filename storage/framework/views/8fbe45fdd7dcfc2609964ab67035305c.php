<?php $__env->startSection('content'); ?>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold"><?php echo e($event->title); ?></h2>
                    <div class="space-x-4">
                        <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="btn-primary">Edit Event</a>
                        <a href="<?php echo e(route('admin.events.index')); ?>" class="btn-secondary">Back to Events</a>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium">Description</h3>
                            <p class="text-gray-600"><?php echo e($event->description); ?></p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium">Date & Time</h3>
                            <p class="text-gray-600"><?php echo e($event->start_time->format('F j, Y g:i A')); ?></p>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium">Location</h3>
                            <p class="text-gray-600"><?php echo e($event->location); ?></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium">Attendees (<?php echo e($event->attendees->count()); ?>)</h3>
                            <div class="mt-2 space-y-2">
                                <?php $__currentLoopData = $event->attendees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900"><?php echo e($attendee->name); ?></p>
                                                <p class="text-sm text-gray-500"><?php echo e($attendee->email); ?></p>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500"><?php echo e($attendee->pivot->created_at->diffForHumans()); ?></span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/events/show.blade.php ENDPATH**/ ?>