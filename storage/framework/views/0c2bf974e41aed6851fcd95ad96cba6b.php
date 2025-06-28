<?php $__env->startSection('content'); ?>
<div class="py-8 bg-gradient-to-br from-green-50 via-white to-green-100 dark:from-green-900 dark:via-gray-800 dark:to-green-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="flex items-center mb-6 sm:mb-0">
                        <svg class="h-8 w-8 text-green-500 dark:text-green-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-green-900 dark:text-green-100">Contributions Management</h2>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo e(route('admin.contributions.create')); ?>" 
                           class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New Contribution
                        </a>
                        
                        <!-- Export Button -->
                        <button id="export-btn" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Import Form -->
                <form action="<?php echo e(route('admin.contributions.import')); ?>" method="POST" enctype="multipart/form-data" class="mb-8">
                    <?php echo csrf_field(); ?>
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Import Contributions</h3>
                        
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
                                Import Contributions
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Success and Error Messages -->
                <?php if(session('success')): ?>
                    <div class="bg-green-100 dark:bg-green-200 text-green-800 dark:text-green-900 p-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="bg-red-100 dark:bg-red-200 text-red-800 dark:text-red-900 p-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

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
                                           id="contributions-search" 
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           placeholder="Search contributions...">
                                </div>

                                <!-- Date Range Filter -->
                                <div class="relative flex-1">
                                    <input type="text" 
                                           id="date-range-filter" 
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           placeholder="Date range">
                                </div>

                                <!-- Amount Range Filter -->
                                <div class="relative flex-1">
                                    <input type="text" 
                                           id="amount-range-filter" 
                                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           placeholder="Amount range">
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
                        <table id="contributions-table" class="min-w-full">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Purpose</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__currentLoopData = $contributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150"
                                    data-member="<?php echo e(strtolower(optional(optional($contribution->member)->user)->name ?? 'unknown')); ?>"
                                    data-amount="<?php echo e($contribution->amount); ?>"
                                    data-date="<?php echo e($contribution->created_at->format('Y-m-d')); ?>"
                                    data-purpose="<?php echo e(strtolower($contribution->purpose)); ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php
                                                $user = optional(optional($contribution->member)->user);
                                                $name = optional($user)->name ?? 'Unknown';
                                                $initials = $name != 'Unknown' ? collect(explode(' ', $name))->map(fn($n) => strtoupper($n[0]))->implode('') : 'UK';
                                            ?>

                                            <?php if(optional($user)->profile_photo_url): ?>
                                                <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                                                    src="<?php echo e($user->profile_photo_url); ?>" 
                                                    alt="<?php echo e($name); ?>">
                                            <?php else: ?>
                                                <div class="h-10 w-10 flex items-center justify-center rounded-full bg-primary-600 text-white font-bold">
                                                    <?php echo e($initials); ?>

                                                </div>
                                            <?php endif; ?>

                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900 dark:text-white"><?php echo e($name); ?></div>
                                                <div class="text-gray-500 dark:text-gray-400 text-sm"><?php echo e(optional($user)->email ?? 'No email'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            TSh <?php echo e(number_format($contribution->amount, 2)); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                        <?php echo e($contribution->created_at->format('M j, Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">
                                        <div class="max-w-xs truncate"><?php echo e($contribution->purpose); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-4">
                                            <a href="<?php echo e(route('admin.contributions.show', $contribution->id)); ?>" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 flex items-center transition duration-200">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View
                                            </a>
                                            <a href="<?php echo e(route('admin.contributions.edit', $contribution->id)); ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center transition duration-200">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="<?php echo e(route('admin.contributions.destroy', $contribution->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this contribution?')">
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
                                Showing <span id="showing-start">1</span> to <span id="showing-end"><?php echo e(min(10, $contributions->count())); ?></span> of <span id="total-records"><?php echo e($contributions->count()); ?></span> contributions
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
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl border border-white/20 dark:border-gray-700/50">
        <div class="flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700 dark:text-gray-300 font-medium">Loading contributions...</span>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable with custom configuration
    const table = $('#contributions-table').DataTable({
        paging: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        lengthChange: true,
        searching: true,
        ordering: true,
        info: false,
        autoWidth: false,
        responsive: true,
        dom: 'rt<"flex flex-col sm:flex-row items-center justify-between gap-4 px-6 py-4"ip>',
        language: {
            search: "",
            searchPlaceholder: "Search contributions...",
            paginate: {
                previous: "←",
                next: "→"
            }
        },
        initComplete: function() {
            // Move search input to our custom search box
            $('.dataTables_filter').appendTo('#contributions-search').parent().removeClass('hidden');
            $('.dataTables_filter input').attr('id', 'datatable-search');
            
            // Update counters on initialization
            updateTableCounters();
        },
        drawCallback: function() {
            updateTableCounters();
        },
        columnDefs: [
            { targets: [1], type: 'num-fmt' }, // Amount column
            { targets: [2], type: 'date' },    // Date column
            { 
                targets: [4],                  // Actions column
                orderable: false,
                searchable: false
            }
        ]
    });

    // Custom search implementation
    $('#contributions-search').on('keyup', function() {
        table.search(this.value).draw();
        updateActiveFilters();
    });

    // Initialize date range filter
    const dateRangeFilter = $('#date-range-filter');
    const minDateFilter = new DateTime($('#contributions-table'), {
        format: 'MMMM D, YYYY',
        i18n: {
            previous: '←',
            next: '→'
        }
    });
    const maxDateFilter = new DateTime($('#contributions-table'), {
        format: 'MMMM D, YYYY',
        i18n: {
            previous: '←',
            next: '→'
        }
    });

    // Apply date range filter
    dateRangeFilter.on('apply.daterangepicker', function(ev, picker) {
        minDateFilter.val(picker.startDate.format('YYYY-MM-DD'));
        maxDateFilter.val(picker.endDate.format('YYYY-MM-DD'));
        
        table.draw();
        updateActiveFilters();
    });

    // Initialize amount range filter
    $('#amount-range-filter').on('change', function() {
        const range = this.value.split('-');
        if (range.length === 2) {
            const min = parseFloat(range[0].trim());
            const max = parseFloat(range[1].trim());
            
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const amount = parseFloat(data[1].replace(/[^\d.]/g, ''));
                    return (isNaN(min) || amount >= min) && 
                           (isNaN(max) || amount <= max);
                }
            );
            
            table.draw();
            $.fn.dataTable.ext.search.pop();
            updateActiveFilters();
        }
    });

    // Clear all filters
    $('#clear-filters').on('click', function() {
        $('#contributions-search').val('');
        $('#date-range-filter').val('');
        $('#amount-range-filter').val('');
        minDateFilter.val('');
        maxDateFilter.val('');
        table.search('').columns().search('').draw();
        updateActiveFilters();
    });

    // Export button
    $('#export-btn').on('click', function() {
        // Get current filters
        const params = {
            search: table.search(),
            dateRange: $('#date-range-filter').val(),
            amountRange: $('#amount-range-filter').val()
        };
        
        // Convert to query string
        const queryString = $.param(params);
        
        // Trigger download
        window.location.href = "<?php echo e(route('admin.contributions.export')); ?>?" + queryString;
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
        const searchValue = $('#contributions-search').val();
        const dateRangeValue = $('#date-range-filter').val();
        const amountRangeValue = $('#amount-range-filter').val();

        if (searchValue) {
            filters.push(`Search: "${searchValue}"`);
        }

        if (dateRangeValue) {
            filters.push(`Date: ${dateRangeValue}`);
        }

        if (amountRangeValue) {
            filters.push(`Amount: ${amountRangeValue}`);
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
            $('#contributions-search').val('').trigger('keyup');
        } else if (filterText.startsWith('Date:')) {
            $('#date-range-filter').val('').trigger('change');
        } else if (filterText.startsWith('Amount:')) {
            $('#amount-range-filter').val('').trigger('change');
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
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/admin/contributions/index.blade.php ENDPATH**/ ?>