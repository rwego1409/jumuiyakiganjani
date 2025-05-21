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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Members Management</h2>
                    </div>

                    <a href="{{ route('admin.members.create') }}" 
                       class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Member
                    </a>
                </div>

                <!-- Import Form with improved styling -->
                <form action="{{ route('admin.members.import') }}" method="POST" enctype="multipart/form-data" class="mb-8">
                    @csrf
                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Import Members</h3>
                        
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
                                Import Members
                            </button>
                        </div>
                    </div>
                </form> 

                <!-- Data Table with improved styling -->
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                    <table id="members-table" class="stripe hover display nowrap w-full text-sm text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Member Info</th>
                                <th class="px-6 py-4 font-semibold">Jumuiya</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($members as $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 {{ $member->status === 'inactive' ? 'opacity-60' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php
                                            $user = $member->user;
                                            $initials = collect(explode(' ', $user->name))->map(fn($n) => strtoupper($n[0]))->implode('');
                                        @endphp

                                        @if ($user->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 flex items-center justify-center rounded-full bg-primary-600 text-white font-bold">
                                                {{ $initials }}
                                            </div>
                                        @endif

                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $member->user->name }}</div>
                                            <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $member->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    <span class="px-3 py-1 bg-gray-100 dark:bg-gray-600 rounded-full text-sm">
                                        {{ $member->jumuiya->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $member->status === 'active' 
                                            ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' 
                                            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-200 dark:text-yellow-900' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.members.edit', $member->id) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 flex items-center transition duration-200">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?')">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#members-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            language: {
                search: "Search members:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "← Prev",
                    next: "Next →"
                }
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
    });
</script>
@endpush