<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 pt-16">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
<h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent drop-shadow-lg">
                        <span class="inline-block align-middle">
                            <svg class="w-5 h-5 mr-2 inline-block text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m13-6.13V7a4 4 0 00-3-3.87M6 4.13A4 4 0 019 4h6a4 4 0 013 3.87v2.13M12 14v6m0 0a2 2 0 01-2-2h4a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        Members
                    </h1>
                    <p class="mt-2 text-blue-700 dark:text-blue-200 text-lg font-semibold md:text-xl lg:text-2xl">
                        Manage and oversee all member accounts
                    </p>
                </div>
                <a href="<?php echo e(route('admin.members.create')); ?>"
                   class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    <svg class="relative w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="relative">Add Member</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
        <div class="mb-6 p-4 bg-green-100 rounded-lg border border-green-200 text-green-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4m2 10a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Import Form -->
        <form action="<?php echo e(route('admin.members.import')); ?>" method="POST" enctype="multipart/form-data" class="mb-8">
            <?php echo csrf_field(); ?>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Import Members</h3>
                
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-grow">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Choose a File (CSV/Excel)</label>
                        <input type="file" name="file" id="file" 
                            class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:focus:ring-primary-400 dark:focus:border-primary-400 py-2 px-3" 
                            required>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('file'),'class' => 'mt-2 text-sm text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('file')),'class' => 'mt-2 text-sm text-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>
                    
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        Import Members
                    </button>
                </div>
            </div>
        </form>

        <!-- Data Table Container -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Controls -->
            <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-gray-50 dark:bg-gray-700/30">
                <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                    <!-- Search and Filters -->
                    <div class="flex flex-col sm:flex-row gap-3 flex-1 w-full">
                        <!-- Global Search -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="members-search" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                   placeholder="Search members...">
                        </div>

                        <!-- Status Filter -->
                        <div class="relative">
                            <select id="status-filter" 
                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Jumuiya Filter -->
                        <div class="relative">
                            <select id="jumuiya-filter" 
                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">All Jumuiyas</option>
                                <?php $__currentLoopData = $jumuiyas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jumuiya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($jumuiya->name); ?>"><?php echo e($jumuiya->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div id="active-filters" class="mt-3 flex flex-wrap gap-2 hidden">
                    <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Active filters:</span>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table id="members-table" class="min-w-full">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Member Info</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumuiya</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e($member->status === 'inactive' ? 'opacity-60' : ''); ?> hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150"
                            data-status="<?php echo e($member->status); ?>"
                            data-jumuiya="<?php echo e($member->jumuiya->name); ?>"
                            data-search="<?php echo e(strtolower($member->user->name . ' ' . $member->user->email)); ?>">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <?php
                                        $user = $member->user;
                                        $initials = collect(explode(' ', $user->name))->map(fn($n) => strtoupper($n[0]))->implode('');
                                    ?>

                                    <?php if($user->profile_photo_path): ?>
                                        <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->name); ?>">
                                    <?php else: ?>
                                        <div class="h-10 w-10 flex items-center justify-center rounded-full bg-primary-600 text-white font-bold">
                                            <?php echo e($initials); ?>

                                        </div>
                                    <?php endif; ?>

                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 dark:text-white"><?php echo e($member->user->name); ?></div>
                                        <div class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e($member->user->email); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-600 rounded-full text-sm">
                                    <?php echo e($member->jumuiya->name); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo e($member->status === 'active' 
                                        ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' 
                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900'); ?>">
                                <?php echo e(ucfirst($member->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex space-x-4">
                                    <a href="<?php echo e(route('admin.members.edit', $member->id)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center transition duration-200">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.members.destroy', $member->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 flex items-center transition duration-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-200/50 dark:border-gray-700/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Showing <span id="showing-start">1</span> to <span id="showing-end"><?php echo e(min(10, $members->count())); ?></span> of <span id="total-records"><?php echo e($members->count()); ?></span> members
                    </div>
                    
                    <div class="flex items-center space-x-2" id="pagination-controls">
                        <button id="prev-page" class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Previous
                        </button>
                        <div id="page-numbers" class="flex items-center space-x-1"></div>
                        <button id="next-page" class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl border border-white/20 dark:border-gray-700/50">
        <div class="flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700 dark:text-gray-300 font-medium">Loading members...</span>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable with custom configuration
    const table = $('#members-table').DataTable({
        paging: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        lengthChange: true,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: false,
        responsive: true,
        dom: 'lrt<"flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4"ip>',
        language: {
            search: "",
            searchPlaceholder: "Search members...",
            lengthMenu: "Show _MENU_ entries",
            paginate: {
                previous: "←",
                next: "→"
            }
        },
        initComplete: function() {
            // Style the search input
            $('.dataTables_filter input').addClass(
                'block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300'
            );
            // Style the length select
            $('.dataTables_length select').addClass(
                'block w-24 pl-3 pr-8 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300'
            );
            // Move search input to our custom search box
            $('.dataTables_filter').appendTo('#members-search').parent().removeClass('hidden');
            $('.dataTables_filter input').attr('id', 'datatable-search');
            // Move length menu to top right
            $('.dataTables_length').appendTo('.dataTables_length').parent().removeClass('hidden');
            // Update counters on initialization
            updateTableCounters();
        },
        drawCallback: function() {
            updateTableCounters();
        }
    });

    // Custom search implementation
    $('#members-search').on('keyup', function() {
        table.search(this.value).draw();
        updateActiveFilters();
    });

    // Status filter
    $('#status-filter').on('change', function() {
        const value = $(this).val();
        if (value) {
            table.column(2).search(value, true, false).draw();
        } else {
            table.column(2).search('').draw();
        }
        updateActiveFilters();
    });

    // Jumuiya filter
    $('#jumuiya-filter').on('change', function() {
        const value = $(this).val();
        if (value) {
            table.column(1).search(value, true, false).draw();
        } else {
            table.column(1).search('').draw();
        }
        updateActiveFilters();
    });

    // Clear all filters
    $('#clear-filters').on('click', function() {
        $('#members-search').val('');
        $('#status-filter').val('');
        $('#jumuiya-filter').val('');
        table.search('').columns().search('').draw();
        updateActiveFilters();
    });

    // Export button
    $('#export-btn').on('click', function() {
        // Implement export functionality here
        // Could use DataTables Buttons extension or custom solution
        alert('Export functionality would be implemented here');
    });

    // Update table counters
    function updateTableCounters() {
        const info = table.page.info();
        $('#showing-start').text(info.start + 1);
        $('#showing-end').text(info.end);
        $('#total-records').text(info.recordsTotal);
    }

    // Update active filters display
    function updateActiveFilters() {
        const filters = [];
        const searchValue = $('#members-search').val();
        const statusValue = $('#status-filter').val();
        const jumuiyaValue = $('#jumuiya-filter').val();

        if (searchValue) {
            filters.push(`Search: "${searchValue}"`);
        }

        if (statusValue) {
            filters.push(`Status: ${statusValue.charAt(0).toUpperCase() + statusValue.slice(1)}`);
        }

        if (jumuiyaValue) {
            filters.push(`Jumuiya: ${jumuiyaValue}`);
        }

        const activeFiltersContainer = $('#active-filters');
        if (filters.length > 0) {
            activeFiltersContainer.empty().append(
                '<span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Active filters:</span>'
            );
            
            filters.forEach(filter => {
                activeFiltersContainer.append(
                    `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 mr-2 mb-2">
                        ${filter}
                        <button class="ml-1 hover:text-blue-900 dark:hover:text-blue-100" onclick="removeFilter('${filter}')">×</button>
                    </span>`
                );
            });
            
            activeFiltersContainer.removeClass('hidden');
        } else {
            activeFiltersContainer.addClass('hidden');
        }
    }

    // Remove specific filter
    window.removeFilter = function(filterText) {
        if (filterText.startsWith('Search:')) {
            $('#members-search').val('').trigger('keyup');
        } else if (filterText.startsWith('Status:')) {
            $('#status-filter').val('').trigger('change');
        } else if (filterText.startsWith('Jumuiya:')) {
            $('#jumuiya-filter').val('').trigger('change');
        }
    };

    // Custom pagination controls
    $('#prev-page').on('click', function() {
        table.page('previous').draw('page');
    });

    $('#next-page').on('click', function() {
        table.page('next').draw('page');
    });

    // Disable/enable pagination buttons based on current page
    table.on('draw', function() {
        const info = table.page.info();
        $('#prev-page').prop('disabled', info.page === 0);
        $('#next-page').prop('disabled', info.page + 1 === info.pages);
        
        // Generate page numbers
        const pageNumbers = $('#page-numbers');
        pageNumbers.empty();
        
        const startPage = Math.max(0, info.page - 2);
        const endPage = Math.min(info.pages - 1, startPage + 4);
        
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = $(`<button class="px-3 py-1.5 rounded-lg mx-1 ${info.page === i ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600'}">${i + 1}</button>`);
            pageBtn.on('click', function() {
                table.page(i).draw('page');
            });
            pageNumbers.append(pageBtn);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/members/index.blade.php ENDPATH**/ ?>