@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Header Section with improved spacing and alignment -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="flex items-center mb-6 sm:mb-0">
                        <svg class="h-8 w-8 text-primary-600 dark:text-primary-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Contributions Management</h2>
                    </div>

                    <a href="{{ route('admin.contributions.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Contribution
                    </a>
                </div>

                <!-- Import Form with improved styling -->
                <form action="{{ route('admin.contributions.import') }}" method="POST" enctype="multipart/form-data" class="mb-8">
                    @csrf
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Import Contributions</h3>
                        
                        <div class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="flex-grow">
                                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Choose a File (CSV/Excel)</label>
                                <input type="file" name="file" id="file" 
                                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:focus:ring-primary-400 dark:focus:border-primary-400 py-2 px-3" 
                                    required>
                                <x-input-error :messages="$errors->get('file')" class="mt-2 text-sm text-red-600" />
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
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-200 text-green-800 dark:text-green-900 p-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-200 text-red-800 dark:text-red-900 p-4 rounded-lg mb-6 flex items-center shadow-sm">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Data Table with improved styling -->
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700" x-data="{
                    search: '',
                    sortKey: '',
                    sortAsc: true,
                    get filtered() {
                        let data = [...this.$refs.tbody.querySelectorAll('tr[data-member]')];
                        if (this.search) {
                            data = data.filter(row =>
                                row.dataset.member.toLowerCase().includes(this.search.toLowerCase()) ||
                                row.dataset.purpose.toLowerCase().includes(this.search.toLowerCase())
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
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Contributions</h3>
                        <div class="flex items-center gap-2">
                            <input x-model="search" type="text" placeholder="Search..." class="px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                        </div>
                    </div>
                    <table id="contributions-table" class="stripe hover display nowrap w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th @click="sortBy('member')" class="px-6 py-4 font-semibold cursor-pointer select-none">Member</th>
                                <th class="px-6 py-4 font-semibold">Amount</th>
                                <th class="px-6 py-4 font-semibold">Date</th>
                                <th @click="sortBy('purpose')" class="px-6 py-4 font-semibold cursor-pointer select-none">Purpose</th>
                                <th class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody x-ref="tbody" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($contributions as $contribution)
                            <tr x-show="filtered.includes($el)" data-member="{{ strtolower($contribution->member->user->name ?? '') }}" data-purpose="{{ strtolower($contribution->purpose ?? '') }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php
                                            $user = optional(optional($contribution->member)->user);
                                            $name = optional($user)->name ?? 'Unknown';
                                            $initials = $name != 'Unknown' ? collect(explode(' ', $name))->map(fn($n) => strtoupper($n[0]))->implode('') : 'UK';
                                        @endphp

                                        @if(optional($user)->profile_photo_url)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" 
                                                src="{{ $user->profile_photo_url }}" 
                                                alt="{{ $name }}">
                                        @else
                                            <div class="h-10 w-10 flex items-center justify-center rounded-full bg-primary-600 text-white font-bold">
                                                {{ $initials }}
                                            </div>
                                        @endif

                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $name }}</div>
                                            <div class="text-gray-500 dark:text-gray-400 text-sm">{{ optional($user)->email ?? 'No email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        TSh {{ number_format($contribution->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $contribution->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    <div class="max-w-xs truncate">{{ $contribution->purpose }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.contributions.show', $contribution->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 flex items-center transition duration-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a href="{{ route('admin.contributions.edit', $contribution->id) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center transition duration-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <!-- <a href="{{ route('admin.contributions.scheduleReminder', $contribution) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 flex items-center transition duration-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Reminder
                                        </a> -->
                                        <form action="{{ route('admin.contributions.destroy', $contribution->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this contribution?')">
                                            @csrf
                                            @method('DELETE')
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
                            @endforeach

                            @if(count($contributions) === 0)
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="font-medium text-gray-700 dark:text-gray-300">No contributions found</p>
                                        <p class="mt-1">Create a new contribution to get started.</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(method_exists($contributions, 'links') && $contributions->hasPages())
                <div class="mt-6">
                    {{ $contributions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    /* Custom DataTables Styling */
    .dataTables_wrapper .dataTables_length, 
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.25rem 0.5rem;
    }
    
    .dark .dataTables_wrapper .dataTables_length select {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        margin-left: 0.5rem;
    }
    
    .dark .dataTables_wrapper .dataTables_filter input {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 0.25rem;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
        background-color: white;
    }
    
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #4f46e5 !important;
        color: white !important;
        border-color: #4f46e5;
    }
    
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #6366f1 !important;
        border-color: #6366f1;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #f3f4f6 !important;
        color: #111827 !important;
        border-color: #d1d5db;
    }
    
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #4b5563 !important;
        color: #e5e7eb !important;
        border-color: #6b7280;
    }
    
    .dataTables_wrapper .dataTables_info {
        color: #6b7280;
    }
    
    .dark .dataTables_wrapper .dataTables_info {
        color: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('#contributions-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            language: {
                search: "Search contributions:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "← Prev",
                    next: "Next →"
                },
                emptyTable: "No contributions found",
                zeroRecords: "No matching contributions found"
            },
            // Custom styling for DataTables
            initComplete: function() {
                // Style the search input and selects
                $('.dataTables_filter input').addClass('rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50');
                $('.dataTables_length select').addClass('rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50');
                
                // Add spacing to controls
                $('.dataTables_length, .dataTables_filter').addClass('mb-4');
                $('.dataTables_info, .dataTables_paginate').addClass('mt-4 mb-2');
                
                // Style pagination buttons
                $('.paginate_button').addClass('px-3 py-1 rounded-md mx-1 focus:outline-none');
                $('.paginate_button.current').addClass('bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300');
                $('.paginate_button:not(.current)').addClass('text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700');
            }
        });
        
        // Add responsive behavior to file input
        $('input[type="file"]').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $(this).addClass('border-primary-500');
            } else {
                $(this).removeClass('border-primary-500');
            }
        });
    });
</script>
@endpush