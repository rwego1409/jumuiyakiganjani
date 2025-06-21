@extends('layouts.admin')

@section('content')

@if(session('success'))
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded dark:bg-green-800 dark:border-green-600 dark:text-green-200">
        {{ session('success') }}
    </div>
</div>
@endif

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-primary-600 dark:text-primary-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Resources Management</h2>
                    </div>
                    
                    <!-- Controls Section -->
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <!-- View Toggle -->
                        <div class="flex items-center">
                            <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                <input type="checkbox" name="viewToggle" id="viewToggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer dark:bg-gray-600"/>
                                <label for="viewToggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer dark:bg-gray-500"></label>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">Card/Table</span>
                        </div>
                        
                        <!-- Search Input -->
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" class="w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 dark:focus:ring-primary-400 dark:focus:border-primary-400" placeholder="Search resources...">
                        </div>
                        
                        <!-- Upload Button -->
                        <a href="{{ route('admin.resources.create') }}" 
                           class="btn-jumuiya inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-primary-500 dark:hover:bg-primary-600">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Upload New
                        </a>
                    </div>
                </div>

                <!-- Card View -->
                <div id="cardView">
                    @if($resources->isEmpty())
                    <!-- Empty State -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">No resources uploaded yet</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by uploading your first resource</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.resources.create') }}" class="btn-jumuiya inline-flex items-center px-4 py-2 text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:bg-primary-500 dark:hover:bg-primary-600">
                                Upload Resource
                            </a>
                        </div>
                    </div>
                    @else
                    <!-- Resources Grid -->
                    <div id="cardContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($resources as $resource)
                        <div class="resource-card bg-white dark:bg-gray-700 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <!-- Card Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        @switch($resource->type)
                                            @case('document')
                                                <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                @break
                                            @case('video')
                                                <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                                @break
                                            @case('audio')
                                                <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                                </svg>
                                                @break
                                            @default
                                                <svg class="h-6 w-6 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                        @endswitch
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">
                                            {{ strtoupper($resource->type) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $resource->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                
                                <!-- Card Content -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                                    {{ $resource->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                    {{ Str::limit($resource->description, 100) }}
                                </p>
                                
                                <!-- Card Footer -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-600">
                                    <a href="{{ asset('storage/' . $resource->file_path) }}" 
                                       class="inline-flex items-center text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 font-medium text-sm"
                                       download>
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download
                                    </a>
                                    
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.resources.edit', $resource->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 flex items-center text-sm">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 flex items-center text-sm"
                                                    onclick="return confirm('Are you sure?')">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Table View -->
                <div id="tableView" class="hidden">
                    <div class="overflow-x-auto">
                        <table id="resourcesTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($resources as $resource)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-300 bg-gray-100 dark:bg-gray-600 px-2 py-1 rounded">
                                            {{ strtoupper($resource->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100 font-medium">{{ $resource->title }}</td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-300">{{ Str::limit($resource->description, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $resource->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex space-x-4">
                                            <a href="{{ asset('storage/' . $resource->file_path) }}" 
                                               class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                               download>
                                                Download
                                            </a>
                                            <a href="{{ route('admin.resources.edit', $resource->id) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        onclick="return confirm('Are you sure?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
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
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<style>
    /* Toggle Switch Styles */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #4f46e5;
    }
    .toggle-checkbox:checked + .toggle-label {
        background-color: #4f46e5;
    }

    /* DataTables Dark Mode */
    .dark .dataTables_wrapper {
        color: #d1d5db;
    }
    .dark .dataTables_wrapper .dataTables_length select,
    .dark .dataTables_wrapper .dataTables_filter input {
        background-color: #374151;
        color: #f3f4f6;
        border-color: #4b5563;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #d1d5db !important;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #374151 !important;
    }
    .dark table.dataTable thead th {
        border-bottom-color: #4b5563;
    }
    .dark table.dataTable tbody tr {
        background-color: #1f2937;
    }
    .dark table.dataTable tbody td {
        color: #d1d5db;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#resourcesTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                searchPlaceholder: "Search resources...",
                search: ""
            },
            dom: '<"flex justify-between items-center mb-4"<"flex"f>><"my-4"t><"flex justify-between items-center"ip>',
            initComplete: function() {
            }
        });

        // View Toggle Functionality
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

        // Search Functionality
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            if ($('#viewToggle').is(':checked')) {
                // Table view search
                table.search(searchTerm).draw();
            } else {
                // Card view search
                $('.resource-card').each(function() {
                    const cardText = $(this).text().toLowerCase();
                    $(this).toggle(cardText.includes(searchTerm));
                });
            }
        });

        // Dark Mode Detection
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