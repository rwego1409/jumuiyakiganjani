@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Events Management</h2>
                    <a href="{{ route('admin.events.create') }}" class="btn-primary dark:bg-indigo-600 dark:hover:bg-indigo-700">
                        Create New Event
                    </a>
                </div>

                <!-- View Toggle and Search -->
                <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none">
                            <input type="checkbox" name="viewToggle" id="viewToggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                            <label for="viewToggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-300">Card/Table View</span>
                    </div>
                    
                    <!-- Search Box - Visible in both views -->
                    <div class="w-full sm:w-auto">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm" placeholder="Search events...">
                        </div>
                    </div>
                </div>

                <!-- Card View (Default) -->
                <div id="cardView">
                    <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($events as $event)
                        <div class="event-card bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-100 dark:border-gray-600">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">{{ $event->title }}</h3>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                    <span class="font-medium">Date:</span> 
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                    {{ Str::limit($event->description, 100) }}
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                           ($event->status === 'ongoing' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                           'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                    <div class="space-x-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Edit</a>
                                        <form class="inline-block" action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination for Card View -->
                    <div class="mt-4">
                        @if($events->isEmpty())
                            <div class="text-center text-gray-600 dark:text-gray-300">
                                No events available.
                            </div>
                        @else
                            {{ $events->links() }}
                        @endif
                    </div>
                </div>

                <!-- Table View (Hidden by default) -->
                <div id="tableView" class="hidden">
                    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" x-data="{
    search: '',
    sortKey: '',
    sortAsc: true,
    get filtered() {
        let data = [...this.$refs.tbody.querySelectorAll('tr[data-title]')];
        if (this.search) {
            data = data.filter(row =>
                row.dataset.title.toLowerCase().includes(this.search.toLowerCase()) ||
                row.dataset.status.toLowerCase().includes(this.search.toLowerCase())
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
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Events</h3>
        <div class="flex items-center gap-2">
            <input x-model="search" type="text" placeholder="Search..." class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>
                <th @click="sortBy('title')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">Title</th>
                <th @click="sortBy('status')" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer select-none">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody x-ref="tbody">
            @foreach($events as $event)
            <tr x-show="filtered.includes($el)" data-title="{{ strtolower($event->title) }}" data-status="{{ strtolower($event->status) }}">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $event->title }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                        {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                           ($event->status === 'ongoing' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500 dark:text-gray-300">
                        {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">Edit</a>
                    <form class="inline-block" action="{{ route('admin.events.destroy', $event->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS with dark mode support -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<style>
    /* Custom toggle switch */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #4f46e5;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #4f46e5;
    }
    
    /* Dark mode styles for DataTables */
    .dark .dataTables_wrapper .dataTables_length,
    .dark .dataTables_wrapper .dataTables_filter,
    .dark .dataTables_wrapper .dataTables_info,
    .dark .dataTables_wrapper .dataTables_processing,
    .dark .dataTables_wrapper .dataTables_paginate {
        color: #d1d5db !important;
    }
    .dark .dataTables_wrapper .dataTables_filter input {
        background-color: #374151;
        color: #f3f4f6;
        border-color: #4b5563;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #d1d5db !important;
    }
    .dark table.dataTable tbody tr {
        background-color: #1f2937;
    }
    .dark table.dataTable thead th {
        border-bottom-color: #4b5563;
    }
    .dark table.dataTable.no-footer {
        border-bottom-color: #4b5563;
    }
    
    /* Highlight for search results */
    .highlight {
        background-color: #FFEB3B;
        color: #000;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        let table = $('#eventsTable').DataTable({
            responsive: true,
            dom: '<"flex justify-between items-center mb-4"<"flex"lB>><"my-4"t><"flex justify-between items-center"ip>',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200',
                    exportOptions: {
                        columns: [0, 1, 2, 3] // Exclude actions column
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search events...",
            },
            columnDefs: [
                { responsivePriority: 1, targets: 0 }, // Title
                { responsivePriority: 2, targets: -1 }, // Actions
                { responsivePriority: 3, targets: 2 }, // Date
                { responsivePriority: 4, targets: 3 }, // Status
                { responsivePriority: 5, targets: 1 }  // Description
            ],
            order: [[2, 'asc']] // Default sort by date ascending
        });

        // View toggle functionality
        $('#viewToggle').change(function() {
            if(this.checked) {
                $('#cardView').addClass('hidden');
                $('#tableView').removeClass('hidden');
                table.columns.adjust().responsive.recalc();
            } else {
                $('#tableView').addClass('hidden');
                $('#cardView').removeClass('hidden');
            }
        });

        // Search functionality for card view
        const $cards = $('.event-card');
        const $cardContainer = $('#cardContainer');
        const $searchInput = $('#searchInput');
        
        $searchInput.on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            if ($('#viewToggle').is(':checked')) {
                // Table view search - handled by DataTables
                table.search(searchTerm).draw();
            } else {
                // Card view search
                let hasResults = false;
                
                $cards.each(function() {
                    const $card = $(this);
                    const cardText = $card.text().toLowerCase();
                    
                    if (cardText.includes(searchTerm)) {
                        $card.show();
                        hasResults = true;
                        
                        // Highlight matching text
                        $card.unmark();
                        if (searchTerm.length > 2) {
                            $card.mark(searchTerm, {
                                className: 'highlight',
                                separateWordSearch: false
                            });
                        }
                    } else {
                        $card.hide();
                    }
                });
                
                // Show message if no results
                if (!hasResults && searchTerm.length > 0) {
                    $cardContainer.append(
                        `<div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                            No events found matching "${searchTerm}"
                        </div>`
                    );
                } else {
                    $cardContainer.find('.col-span-full').remove();
                }
            }
        });

        // Dark mode detection and adjustment
        const observer = new MutationObserver(() => {
            if (document.documentElement.classList.contains('dark')) {
                $('.dataTables_wrapper').addClass('dark');
                table.draw();
            } else {
                $('.dataTables_wrapper').removeClass('dark');
                table.draw();
            }
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
    });
</script>
@endpush