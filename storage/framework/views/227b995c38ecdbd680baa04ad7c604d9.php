<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Manage Jumuiyas</h2>
        </div>

        <!-- Jumuiyas List -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden" x-data="{
            search: '',
            sortKey: '',
            sortAsc: true,
            get filtered() {
                let data = [...this.$refs.tbody.querySelectorAll('tr[data-name]')];
                if (this.search) {
                    data = data.filter(row =>
                        row.dataset.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        row.dataset.location.toLowerCase().includes(this.search.toLowerCase()) ||
                        row.dataset.chairperson.toLowerCase().includes(this.search.toLowerCase())
                    );
                }
                if (this.sortKey) {
                    data.sort((a, b) => {
                        let aVal = a.dataset[this.sortKey] || '';
                        let bVal = b.dataset[this.sortKey] || '';
                        if (aVal < bVal) return this.sortAsc ? -1 : 1;
                        if (aVal > bVal) return this.sortAsc ? 1 : -1;
                        return 0;
                    });
                }
                return data;
            },
            sortBy(key) {
                if (this.sortKey === key) {
                    this.sortAsc = !this.sortAsc;
                } else {
                    this.sortKey = key;
                    this.sortAsc = true;
                }
            }
        }">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Jumuiyas</h3>
                <div class="flex items-center gap-2">
                    <input x-model="search" type="text" placeholder="Search..." class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th @click="sortBy('name')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">
                                Name
                                <span x-show="sortKey === 'name'">
                                    <svg x-show="sortAsc" class="inline w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                    <svg x-show="!sortAsc" class="inline w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </span>
                            </th>
                            <th @click="sortBy('location')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">Location</th>
                            <th @click="sortBy('chairperson')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">Chairperson</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Members</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody x-ref="tbody" class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $jumuiyas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumuiya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr x-show="filtered.includes($el)" data-name="<?php echo e(strtolower($jumuiya->name)); ?>" data-location="<?php echo e(strtolower($jumuiya->location)); ?>" data-chairperson="<?php echo e(strtolower($jumuiya->chairperson->name)); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <?php echo e($jumuiya->name); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($jumuiya->location); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($jumuiya->chairperson->name); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <?php echo e($jumuiya->members->count()); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2">
                                    <a href="<?php echo e(route('admin.jumuiyas.show', $jumuiya)); ?>" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 rounded-md transition-colors duration-150" title="View Jumuiya">View</a>
                                    <a href="<?php echo e(route('admin.jumuiyas.edit', $jumuiya)); ?>" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 rounded-md transition-colors duration-150" title="Edit Jumuiya">Edit</a>
                                    <?php if($jumuiya->members->count() === 0): ?>
                                        <form action="<?php echo e(route('admin.jumuiyas.destroy', $jumuiya)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this Jumuiya?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 hover:text-red-900 bg-red-100 hover:bg-red-200 rounded-md transition-colors duration-150" title="Delete Jumuiya">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                    No Jumuiyas found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/jumuiyas/index.blade.php ENDPATH**/ ?>