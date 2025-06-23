@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-4 sm:p-8">
            <!-- Header Section -->
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-2 sm:gap-3 justify-between">
                <h2 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg text-center sm:text-left w-full">
                    {{ __('Users') }}
                </h2>
                <a href="{{ route('chairperson.users.create') }}" 
                   class="mt-2 sm:mt-0 inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 border border-purple-200 rounded-xl font-semibold text-xs sm:text-sm uppercase tracking-widest shadow hover:bg-purple-200 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-400 transition">
                    + {{ __('Add User') }}
                </a>
            </div>

            <!-- Content Section -->
            <div class="overflow-x-auto rounded-lg">
                <!-- Search and Filter Section -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="w-full sm:w-64">
                            <input type="text" 
                                   name="search" 
                                   placeholder="Search members..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        </div>
                        <div class="flex items-center space-x-4">
                            <select name="status" 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Members Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($members as $member)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($member->profile_picture)
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ Storage::url($member->profile_picture) }}" 
                                                     alt="{{ $member->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center">
                                                    <span class="text-primary-600 font-bold text-lg">
                                                        {{ substr($member->user->name, 0, 1) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $member->user->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">{{ $member->phone }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $member->status === 'active' 
                                            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' 
                                            : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                    {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $member->joined_date ? $member->joined_date->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('chairperson.users.edit', $member->id) }}" 
                                           class="bg-purple-100 text-purple-700 hover:bg-purple-200 hover:text-purple-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-purple-400 transition mr-2"
                                           title="Edit member">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('chairperson.users.destroy', $member->id) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this member?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-purple-100 text-purple-700 hover:bg-purple-200 hover:text-purple-900 px-3 py-1 rounded font-semibold shadow focus:outline-none focus:ring-2 focus:ring-purple-400 transition"
                                                    title="Delete member">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No members found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($members->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $members->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
