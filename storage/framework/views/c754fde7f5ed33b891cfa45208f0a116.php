<div class="p-4 border-b border-gray-200 dark:border-gray-700">
    <form action="<?php echo e(route('chairperson.resources.index')); ?>" method="GET" class="flex flex-wrap gap-4">
        <!-- Search -->
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                   placeholder="<?php echo e(__('Search resources...')); ?>"
                   class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                          dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
        </div>

        <!-- Type Filter -->
        <div class="w-full sm:w-auto">
            <select name="type" 
                    class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                           dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value=""><?php echo e(__('All Types')); ?></option>
                <option value="document" <?php echo e(request('type') === 'document' ? 'selected' : ''); ?>><?php echo e(__('Document')); ?></option>
                <option value="video" <?php echo e(request('type') === 'video' ? 'selected' : ''); ?>><?php echo e(__('Video')); ?></option>
                <option value="audio" <?php echo e(request('type') === 'audio' ? 'selected' : ''); ?>><?php echo e(__('Audio')); ?></option>
                <option value="image" <?php echo e(request('type') === 'image' ? 'selected' : ''); ?>><?php echo e(__('Image')); ?></option>
                <option value="other" <?php echo e(request('type') === 'other' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="w-full sm:w-auto">
            <select name="status" 
                    class="w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                           dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value=""><?php echo e(__('All Statuses')); ?></option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
            </select>
        </div>

        <!-- Submit & Reset -->
        <div class="flex gap-2">
            <button type="submit" 
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search mr-2"></i><?php echo e(__('Filter')); ?>

            </button>
            <a href="<?php echo e(route('chairperson.resources.index')); ?>" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-sync-alt mr-2"></i><?php echo e(__('Reset')); ?>

            </a>
        </div>
    </form>
</div>
<?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/resources/includes/filter.blade.php ENDPATH**/ ?>