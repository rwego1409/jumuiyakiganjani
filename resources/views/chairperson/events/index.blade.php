@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('Events Management') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Manage and organize your events efficiently
                </p>
            </div>
            <a href="{{ route('chairperson.events.create') }}" 
               class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 transition font-semibold">
                <i class="fas fa-plus mr-2 text-indigo-200"></i> Add Event
            </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Events Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Events</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $events->count() }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Events Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Upcoming</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $events->where('status', 'upcoming')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- Ongoing Events Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Ongoing</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $events->where('status', 'ongoing')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <i class="fas fa-play text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- Completed Events Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Completed</p>
                        <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">
                            {{ $events->where('status', 'completed')->count() }}
                        </p>
                    </div>
                    <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <i class="fas fa-check text-gray-600 dark:text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Controls -->
        <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <!-- View Toggle -->
            <label class="inline-flex items-center cursor-pointer">
                <input id="viewToggle" type="checkbox" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Card / Table View</span>
            </label>
            
            <!-- Search Input -->
            <div class="w-full sm:w-1/3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <input id="searchInput" type="text" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                           placeholder="Search events...">
                </div>
            </div>
        </div>

        <!-- Card View -->
        <div id="cardView">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="event-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-xl border border-purple-100 dark:border-purple-900 hover:shadow-2xl hover:scale-105 transition-all duration-200 ease-out relative overflow-hidden">
                    <div class="absolute inset-0 pointer-events-none bg-gradient-to-br from-purple-100/40 to-indigo-200/20 dark:from-purple-900/30 dark:to-indigo-900/10"></div>
                    <div class="relative p-6">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-500 flex items-center justify-center shadow text-white mr-3">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $event->title ?? $event->name }}</h3>
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                            <span class="font-medium">Date:</span>
                            {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('M d, Y h:i A') : '' }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                            <span class="font-medium">Location:</span> {{ $event->location }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                            <span class="font-medium">Status:</span> {{ ucfirst($event->status) }}
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="space-x-2">
                                <a href="{{ route('chairperson.events.edit', $event->id) }}"
                                   class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 hover:text-indigo-900 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800 dark:hover:text-indigo-100 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                                    Edit
                                </a>
                                <form action="{{ route('chairperson.events.destroy', $event->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800 dark:hover:text-red-100 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-red-400 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>

        <!-- Table View -->
        <div id="tableView" class="hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($events as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $event->name }}</td>
                            <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ Str::limit($event->description, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-300">
                                {{ $event->start_time->format('M d, Y h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                                    : ($event->status === 'ongoing' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                    : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('chairperson.events.edit', $event->id) }}"
                                   class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 hover:text-indigo-900 dark:bg-indigo-900 dark:text-indigo-300 dark:hover:bg-indigo-800 dark:hover:text-indigo-100 mr-3">
                                    Edit
                                </a>
                                <form action="{{ route('chairperson.events.destroy', $event->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-900 dark:bg-red-900 dark:text-red-300 dark:hover:bg-red-800 dark:hover:text-red-100">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>

<script>
$(document).ready(function() {
    let tableInitialized = false;
    const $cardView = $('#cardView');
    const $tableView = $('#tableView');
    const $toggle = $('#viewToggle');
    const $searchInput = $('#searchInput');

    // Restore toggle state from localStorage (optional, for better UX)
    if(localStorage.getItem('eventsViewMode') === 'table') {
        $toggle.prop('checked', true);
        $cardView.hide();
        $tableView.show();
    } else {
        $toggle.prop('checked', false);
        $tableView.hide();
        $cardView.show();
    }

    let table;
    function initTable() {
        if (!tableInitialized) {
            table = $('#tableView table').DataTable({
                responsive: true,
                paging: false,
                searching: false, // We use our custom search
                info: false
            });
            tableInitialized = true;
        }
    }

    // View toggle functionality
    $toggle.change(function() {
        if(this.checked) {
            $cardView.hide();
            $tableView.show();
            initTable();
            if(table) table.columns.adjust().responsive.recalc();
            localStorage.setItem('eventsViewMode', 'table');
        } else {
            $tableView.hide();
            $cardView.show();
            localStorage.setItem('eventsViewMode', 'card');
        }
    });

    // Search functionality
    $searchInput.on('input', function() {
        const term = $(this).val().toLowerCase();
        if($toggle.is(':checked')) {
            // Search in table view
            if(tableInitialized) table.search(term).draw();
        } else {
            // Search in card view
            $('.event-card').each(function() {
                const cardText = $(this).text().toLowerCase();
                $(this).toggle(cardText.includes(term));
                // Highlight matches
                $(this).unmark();
                if(term.length > 2) {
                    $(this).mark(term);
                }
            });
        }
    });

    // Dark mode detection for DataTables
    new MutationObserver(() => {
        if(tableInitialized) table.draw(false);
    }).observe(document.documentElement, { 
        attributes: true, 
        attributeFilter: ['class'] 
    });
});
</script>
@endpush
@endsection