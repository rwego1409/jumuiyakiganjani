@extends('layouts.super_admin')

@section('content')
<div class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-8">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-2 sm:gap-0">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate">
            {{ __('Jumuiyas') }}
        </h2>
        <a href="{{ route('super_admin.jumuiyas.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i>{{ __('Add New Jumuiya') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded relative text-xs sm:text-sm" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-700 rounded relative text-xs sm:text-sm" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        {{ __('Name') }}
                    </th>
                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        {{ __('Location') }}
                    </th>
                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        {{ __('Chairperson') }}
                    </th>
                    <th scope="col" class="px-2 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        {{ __('Created') }}
                    </th>
                    <th scope="col" class="px-2 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($jumuiyas as $jumuiya)
                    <tr>
                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap max-w-[120px] sm:max-w-none">
                            <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">{{ $jumuiya->name }}</div>
                        </td>
                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white break-words">{{ $jumuiya->location ?? '-' }}</div>
                        </td>
                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-xs sm:text-sm text-gray-900 dark:text-white break-words">{{ $jumuiya->chairperson->name ?? '-' }}</div>
                            @if($jumuiya->chairperson)
                                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $jumuiya->chairperson->email }}</div>
                            @endif
                        </td>
                        <td class="px-2 sm:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            {{ $jumuiya->created_at->format('M d, Y') }}
                            <div class="text-xs">{{ $jumuiya->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex items-center space-x-3 justify-end">
                                <a href="{{ route('super_admin.jumuiyas.show', $jumuiya) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors duration-150 text-xs sm:text-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    <span>View</span>
                                </a>
                                <a href="{{ route('super_admin.jumuiyas.edit', $jumuiya) }}" 
                                   class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md hover:bg-yellow-200 transition-colors duration-150 text-xs sm:text-sm">
                                    <i class="fas fa-edit mr-1"></i>
                                    <span>Edit</span>
                                </a>
                                <form action="{{ route('super_admin.jumuiyas.destroy', $jumuiya) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this jumuiya?')"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors duration-150 text-xs sm:text-sm">
                                        <i class="fas fa-trash mr-1"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No jumuiyas found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
            </table>
        </div>
        @if($jumuiyas->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $jumuiyas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
