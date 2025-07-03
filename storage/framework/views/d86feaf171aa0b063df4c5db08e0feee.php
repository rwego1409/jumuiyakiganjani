<?php $__env->startSection('content'); ?>
<div class="py-6 bg-gradient-to-br from-purple-50 via-white to-purple-100 dark:from-purple-900 dark:via-gray-800 dark:to-purple-900 min-h-screen">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-2xl font-semibold text-purple-900 dark:text-purple-100">Events</h2>
        </div>
        <!-- Toggle + Search -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <label class="inline-flex items-center">
            <input id="viewToggle" type="checkbox"
                   class="toggle-checkbox appearance-none w-6 h-6 border-4 rounded-full bg-white dark:bg-gray-700 cursor-pointer">
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Card / Table View</span>
          </label>
          <div class="w-full sm:w-1/3">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
              </div>
              <input id="searchInput" type="text"
                     class="block w-full pl-10 pr-3 py-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                     placeholder="Search events…">
            </div>
          </div>
        </div>
        <!-- Cards -->
        <div id="cardView">
          <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="event-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-xl border border-purple-100 dark:border-purple-900 hover:shadow-2xl hover:scale-105 transition-all duration-200 ease-out relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-purple-100/40 to-indigo-200/20 dark:from-purple-900/30 dark:to-indigo-900/10"></div>
                <div class="relative p-6">
                  <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow text-white mr-3">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($event->title ?? $event->name); ?></h3>
                  </div>
                  <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                    <span class="font-medium">Date:</span>
                    <?php echo e($event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') : ''); ?>

                  </div>
                  <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                    <span class="font-medium">Location:</span> <?php echo e($event->location); ?>

                  </div>
                  <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                    <span class="font-medium">Status:</span> <?php echo e(ucfirst($event->status)); ?>

                  </div>
                  <div class="mt-4">
                    <a href="<?php echo e(route('member.events.show', $event->id)); ?>" class="inline-flex items-center w-full justify-center px-4 py-2 text-sm rounded-md bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-700 dark:hover:bg-blue-600 transition-colors">View Details
                      <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Custom dark mode transitions */
.dark .event-card {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.member', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/member/events/index.blade.php ENDPATH**/ ?>