@extends('layouts.admin')

@section('content')
<div class="py-8 bg-gradient-to-br from-orange-50 via-white to-orange-100 dark:from-orange-900 dark:via-gray-800 dark:to-orange-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="flex items-center mb-6 sm:mb-0">
                        <svg class="h-8 w-8 text-orange-500 dark:text-orange-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-orange-900 dark:text-orange-100">Jumuiyas Management</h2>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <div class="flex items-center space-x-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-300" id="total-count">
                                {{ $jumuiyas->count() }} Records
                            </span>
                        </div>
                        <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Container -->
        <div class="backdrop-blur-xl bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-2xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
            
            <!-- Table Controls -->
            <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-gray-50/50 to-blue-50/50 dark:from-gray-800/50 dark:to-gray-700/50">
                <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                    
                    <!-- Search and Filters Left Side -->
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <!-- Global Search -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="global-search" 
                                   class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                   placeholder="Search jumuiyas, locations, chairpersons...">
                        </div>

                        <!-- Location Filter -->
                        <div class="relative">
                            <select id="location-filter" 
                                    class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">All Locations</option>
                                @foreach($jumuiyas->pluck('location')->unique()->filter() as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Members Count Filter -->
                        <div class="relative">
                            <select id="members-filter" 
                                    class="block w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Any Size</option>
                                <option value="0">No Members</option>
                                <option value="1-10">1-10 Members</option>
                                <option value="11-50">11-50 Members</option>
                                <option value="50+">50+ Members</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table Controls Right Side -->
                    <div class="flex items-center gap-3">
                        <!-- Entries per page -->
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600 dark:text-gray-400">Show:</label>
                            <select id="entries-per-page" 
                                    class="px-3 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white/80 dark:bg-gray-700/80 text-gray-900 dark:text-gray-100 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <!-- Export Button -->
                        <button class="inline-flex items-center px-3 py-2 bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:hover:bg-green-800/50 text-green-700 dark:text-green-300 text-sm font-medium rounded-lg transition-all duration-300 hover:scale-105">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>

                        <!-- Clear Filters -->
                        <button id="clear-filters" 
                                class="inline-flex items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-all duration-300">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </button>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div id="active-filters" class="mt-4 flex flex-wrap gap-2 hidden">
                    <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Active filters:</span>
                </div>
            </div>

            <!-- Data Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full" id="jumuiyas-table">
                    <thead>
                        <tr class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700/50 dark:to-gray-800/50 border-b border-gray-200/50 dark:border-gray-600/50">
                            <th class="px-6 py-4 text-left cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-600/50 transition-colors duration-200" data-sort="name">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Name</span>
                                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                                    </div>
                                    <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-600/50 transition-colors duration-200" data-sort="location">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Location</span>
                                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-600/50 transition-colors duration-200" data-sort="chairperson">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Chairperson</span>
                                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                                    </div>
                                    <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left cursor-pointer group hover:bg-blue-100 dark:hover:bg-gray-600/50 transition-colors duration-200" data-sort="members">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Members</span>
                                        <div class="w-1 h-1 bg-orange-500 rounded-full"></div>
                                    </div>
                                    <div class="flex flex-col opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-gray-200/30 dark:divide-gray-700/30">
                        @forelse($jumuiyas as $jumuiya)
                            <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 dark:hover:from-gray-700/20 dark:hover:to-gray-600/20 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10" 
                                data-name="{{ strtolower($jumuiya->name) }}"
                                data-location="{{ strtolower($jumuiya->location ?? '') }}"
                                data-chairperson="{{ strtolower($jumuiya->chairperson->name ?? '') }}"
                                data-members="{{ $jumuiya->members->count() }}">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                            <span class="text-white font-bold text-sm">
                                                {{ strtoupper(substr($jumuiya->name, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                                {{ $jumuiya->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                ID: #{{ $jumuiya->id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300">
                                                {{ $jumuiya->location ?: 'Not specified' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                            <span class="text-white font-bold text-xs">
                                                {{ strtoupper(substr($jumuiya->chairperson->name ?? 'N', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 transition-colors duration-300">
                                                {{ $jumuiya->chairperson->name ?? 'Not assigned' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        @php
                                            $memberCount = $jumuiya->members->count();
                                            $badgeColor = $memberCount === 0 ? 'from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-600' : 
                                                         ($memberCount <= 10 ? 'from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 text-yellow-700 dark:text-yellow-300 border-yellow-200 dark:border-yellow-700' : 
                                                         ($memberCount <= 50 ? 'from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700' : 
                                                         'from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700'));
                                        @endphp
                                        <div class="px-3 py-1 bg-gradient-to-r {{ $badgeColor }} rounded-full border">
                                            <span class="text-sm font-semibold">
                                                {{ $memberCount }}
                                            </span>
                                        </div>
                                        <div class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                            {{ $memberCount === 1 ? 'member' : 'members' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.jumuiyas.show', $jumuiya) }}" 
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-800/50 text-blue-700 dark:text-blue-300 transition-all duration-300 hover:scale-105 hover:shadow-md"
                                           title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.jumuiyas.edit', $jumuiya) }}" 
                                           class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900/30 dark:hover:bg-indigo-800/50 text-indigo-700 dark:text-indigo-300 transition-all duration-300 hover:scale-105 hover:shadow-md"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        @if($jumuiya->members->count() === 0)
                                            <form action="{{ route('admin.jumuiyas.destroy', $jumuiya) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-800/50 text-red-700 dark:text-red-300 transition-all duration-300 hover:scale-105 hover:shadow-md"
                                                        onclick="return confirm('Are you sure you want to delete this Jumuiya?')"
                                                        title="Delete (No members)">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center px-3 py-2 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                                                  title="Cannot delete - has members">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-results-row">
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1">No Jumuiyas Found</h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Table Footer with Pagination Info -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50/50 to-blue-50/50 dark:from-gray-800/50 dark:to-gray-700/50 border-t border-gray-200/50 dark:border-gray-600/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span>Showing <span id="showing-start">1</span> to <span id="showing-end">{{ min(25, $jumuiyas->count()) }}</span> of <span id="total-records">{{ $jumuiyas->count() }}</span> results</span>
                    </div>
                    
                    @if($jumuiyas instanceof \Illuminate\Pagination\LengthAwarePaginator && $jumuiyas->hasPages())
                        <div class="pagination-wrapper">
                            {{ $jumuiyas->links() }}
                        </div>
                    @else
                        <!-- Custom Pagination for Client-side -->
                        <div class="flex items-center space-x-2" id="custom-pagination">
                            <button id="prev-page" class="px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                Previous
                            </button>
                            <div id="page-numbers" class="flex items-center space-x-1">
                                <!-- Page numbers will be generated by JavaScript -->
                            </div>
                            <button id="next-page" class="px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                Next
                            </button>
                        </div>
                    @endif
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
            <span class="text-gray-700 dark:text-gray-300 font-medium">Processing...</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data Table Implementation
    class JumuiyasDataTable {
        constructor() {
            this.currentPage = 1;
            this.entriesPerPage = 25;
            this.sortColumn = 'name';
            this.sortDirection = 'asc';
            this.searchTerm = '';
            this.locationFilter = '';
            this.membersFilter = '';
            this.allRows = [];
            this.filteredRows = [];
            
            this.init();
        }
        
        init() {
            this.cacheElements();
            this.bindEvents();
            this.cacheTableData();
            this.updateDisplay();
        }
        
        cacheElements() {
            this.globalSearch = document.getElementById('global-search');
            this.locationFilter = document.getElementById('location-filter');
            this.membersFilter = document.getElementById('members-filter');
            this.entriesSelect = document.getElementById('entries-per-page');
            this.clearFiltersBtn = document.getElementById('clear-filters');
            this.tableBody = document.getElementById('table-body');
            this.totalCountSpan = document.getElementById('total-count');
            this.showingStart = document.getElementById('showing-start');
            this.showingEnd = document.getElementById('showing-end');
            this.totalRecords = document.getElementById('total-records');
            this.activeFilters = document.getElementById('active-filters');
            this.loadingOverlay = document.getElementById('loading-overlay');
            this.prevPageBtn = document.getElementById('prev-page');
            this.nextPageBtn = document.getElementById('next-page');
            this.pageNumbers = document.getElementById('page-numbers');
            this.noResultsRow = document.getElementById('no-results-row');
        }
        
        bindEvents() {
            // Search and filter events
            this.globalSearch.addEventListener('input', debounce(() => this.handleSearch(), 300));
            this.locationFilter.addEventListener('change', () => this.handleLocationFilter());
            this.membersFilter.addEventListener('change', () => this.handleMembersFilter());
            this.entriesSelect.addEventListener('change', () => this.handleEntriesChange());
            this.clearFiltersBtn.addEventListener('click', () => this.clearAllFilters());
            
            // Sorting events
            document.querySelectorAll('[data-sort]').forEach(header => {
                header.addEventListener('click', () => this.handleSort(header.dataset.sort));
            });
            
            // Pagination events
            this.prevPageBtn.addEventListener('click', () => this.goToPage(this.currentPage - 1));
            this.nextPageBtn.addEventListener('click', () => this.goToPage(this.currentPage + 1));
        }
        
        cacheTableData() {
            const rows = document.querySelectorAll('#table-body tr:not(#no-results-row)');
            this.allRows = Array.from(rows).map(row => ({
                element: row,
                name: row.dataset.name || '',
                location: row.dataset.location || '',
                chairperson: row.dataset.chairperson || '',
                members: parseInt(row.dataset.members) || 0,
                html: row.outerHTML
            }));
            this.filteredRows = [...this.allRows];
        }
        
        handleSearch() {
            this.searchTerm = this.globalSearch.value.toLowerCase().trim();
            this.currentPage = 1;
            this.applyFilters();
        }
        
        handleLocationFilter() {
            this.locationFilter = this.locationFilter.value.toLowerCase();
            this.currentPage = 1;
            this.applyFilters();
        }
        
        handleMembersFilter() {
            this.membersFilter = this.membersFilter.value;
            this.currentPage = 1;
            this.applyFilters();
        }
        
        handleEntriesChange() {
            this.entriesPerPage = parseInt(this.entriesSelect.value);
            this.currentPage = 1;
            this.updateDisplay();
        }
        
        handleSort(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
            
            this.sortData();
            this.updateDisplay();
            this.updateSortIndicators();
        }
        
        applyFilters() {
            this.showLoading();
            
            setTimeout(() => {
                this.filteredRows = this.allRows.filter(row => {
                    // Global search
                    if (this.searchTerm) {
                        const searchable = `${row.name} ${row.location} ${row.chairperson}`.toLowerCase();
                        if (!searchable.includes(this.searchTerm)) return false;
                    }
                    
                    // Location filter
                    if (this.locationFilter && row.location !== this.locationFilter) {
                        return false;
                    }
                    
                    // Members filter
                    if (this.membersFilter) {
                        switch (this.membersFilter) {
                            case '0':
                                if (row.members !== 0) return false;
                                break;
                            case '1-10':
                                if (row.members < 1 || row.members > 10) return false;
                                break;
                            case '11-50':
                                if (row.members < 11 || row.members > 50) return false;
                                break;
                            case '50+':
                                if (row.members <= 50) return false;
                                break;
                        }
                    }
                    
                    return true;
                });
                
                this.sortData();
                this.updateDisplay();
                this.updateActiveFilters();
                this.hideLoading();
            }, 150);
        }
        
        sortData() {
            this.filteredRows.sort((a, b) => {
                let aVal = a[this.sortColumn];
                let bVal = b[this.sortColumn];
                
                // Handle string comparison
                if (typeof aVal === 'string') {
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }
                
                if (aVal < bVal) return this.sortDirection === 'asc' ? -1 : 1;
                if (aVal > bVal) return this.sortDirection === 'asc' ? 1 : -1;
                return 0;
            });
        }
        
        updateDisplay() {
            const startIndex = (this.currentPage - 1) * this.entriesPerPage;
            const endIndex = startIndex + this.entriesPerPage;
            const pageRows = this.filteredRows.slice(startIndex, endIndex);
            
            // Update table body
            if (pageRows.length === 0) {
                this.tableBody.innerHTML = this.noResultsRow.outerHTML;
            } else {
                this.tableBody.innerHTML = pageRows.map(row => row.html).join('');
            }
            
            // Update counters
            this.updateCounters();
            
            // Update pagination
            this.updatePagination();
        }
        
        updateCounters() {
            const total = this.filteredRows.length;
            const start = total === 0 ? 0 : (this.currentPage - 1) * this.entriesPerPage + 1;
            const end = Math.min(this.currentPage * this.entriesPerPage, total);
            
            this.totalCountSpan.textContent = `${total} Records`;
            this.showingStart.textContent = start;
            this.showingEnd.textContent = end;
            this.totalRecords.textContent = total;
        }
        
        updatePagination() {
            const totalPages = Math.ceil(this.filteredRows.length / this.entriesPerPage);
            
            // Update prev/next buttons
            this.prevPageBtn.disabled = this.currentPage <= 1;
            this.nextPageBtn.disabled = this.currentPage >= totalPages;
            
            // Generate page numbers
            this.generatePageNumbers(totalPages);
        }
        
        generatePageNumbers(totalPages) {
            let html = '';
            const maxVisible = 5;
            let startPage = Math.max(1, this.currentPage - 2);
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);
            
            if (endPage - startPage < maxVisible - 1) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const isActive = i === this.currentPage;
                html += `
                    <button class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 ${
                        isActive 
                        ? 'bg-blue-600 text-white shadow-lg' 
                        : 'text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20'
                    }" onclick="dataTable.goToPage(${i})">
                        ${i}
                    </button>
                `;
            }
            
            this.pageNumbers.innerHTML = html;
        }
        
        goToPage(page) {
            const totalPages = Math.ceil(this.filteredRows.length / this.entriesPerPage);
            if (page >= 1 && page <= totalPages) {
                this.currentPage = page;
                this.updateDisplay();
            }
        }
        
        updateActiveFilters() {
            const filters = [];
            
            if (this.searchTerm) {
                filters.push(`Search: "${this.searchTerm}"`);
            }
            
            if (this.locationFilter) {
                const locationText = this.locationFilter.charAt(0).toUpperCase() + this.locationFilter.slice(1);
                filters.push(`Location: ${locationText}`);
            }
            
            if (this.membersFilter) {
                const memberText = this.membersFilter === '0' ? 'No Members' : 
                                 this.membersFilter === '50+' ? '50+ Members' : 
                                 `${this.membersFilter} Members`;
                filters.push(`Size: ${memberText}`);
            }
            
            if (filters.length > 0) {
                this.activeFilters.classList.remove('hidden');
                const filterHtml = filters.map(filter => 
                    `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                        ${filter}
                        <button class="ml-1 hover:text-blue-900 dark:hover:text-blue-100" onclick="dataTable.removeFilter('${filter}')">×</button>
                    </span>`
                ).join('');
                
                this.activeFilters.innerHTML = `
                    <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Active filters:</span>
                    ${filterHtml}
                `;
            } else {
                this.activeFilters.classList.add('hidden');
            }
        }
        
        updateSortIndicators() {
            // Reset all indicators
            document.querySelectorAll('[data-sort]').forEach(header => {
                const indicator = header.querySelector('svg');
                indicator.style.transform = 'rotate(0deg)';
                indicator.style.color = '#9CA3AF';
            });
            
            // Update active sort indicator
            const activeHeader = document.querySelector(`[data-sort="${this.sortColumn}"]`);
            if (activeHeader) {
                const indicator = activeHeader.querySelector('svg');
                indicator.style.transform = this.sortDirection === 'desc' ? 'rotate(180deg)' : 'rotate(0deg)';
                indicator.style.color = '#3B82F6';
            }
        }
        
        clearAllFilters() {
            this.globalSearch.value = '';
            this.locationFilter.value = '';
            this.membersFilter.value = '';
            this.searchTerm = '';
            this.locationFilter = '';
            this.membersFilter = '';
            this.currentPage = 1;
            
            this.filteredRows = [...this.allRows];
            this.updateDisplay();
            this.updateActiveFilters();
        }
        
        showLoading() {
            this.loadingOverlay.classList.remove('hidden');
            this.loadingOverlay.classList.add('flex');
        }
        
        hideLoading() {
            this.loadingOverlay.classList.add('hidden');
            this.loadingOverlay.classList.remove('flex');
        }
    }
    
    // Utility function for debouncing
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        }
    }
    
    // Initialize the data table
    window.dataTable = new JumuiyasDataTable();
});
</script>

<style>
/* Enhanced Pagination Styles */
.pagination-wrapper .pagination {
    @apply flex items-center space-x-1;
}

.pagination-wrapper .pagination li {
    @apply list-none;
}

.pagination-wrapper .pagination a,
.pagination-wrapper .pagination span {
    @apply px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200;
}

.pagination-wrapper .pagination a {
    @apply text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:scale-105;
}

.pagination-wrapper .pagination .active span {
    @apply bg-blue-600 text-white shadow-lg transform scale-105;
}

.pagination-wrapper .pagination .disabled span {
    @apply text-gray-400 dark:text-gray-600 cursor-not-allowed opacity-50;
}

/* Custom Scrollbar */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    @apply bg-gray-100 dark:bg-gray-700 rounded-full;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    @apply bg-blue-300 dark:bg-blue-600 rounded-full;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    @apply bg-blue-400 dark:bg-blue-500;
}

/* Loading Animation */
@keyframes fadeInOut {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 1; }
}

.animate-pulse-custom {
    animation: fadeInOut 2s infinite;
}

/* Sort Indicator Animation */
[data-sort] svg {
    transition: all 0.3s ease;
}

/* Hover Effects for Table Rows */
tbody tr:hover {
    transform: translateY(-1px);
}

/* Filter Badge Animation */
.inline-flex.items-center.px-3.py-1.rounded-full {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-10px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Table */
@media (max-width: 768px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
    }
    
    table {
        min-width: 800px;
    }
}
</style>
@endsection