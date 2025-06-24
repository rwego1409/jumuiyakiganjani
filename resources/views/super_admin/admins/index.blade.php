@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 dark:from-gray-950 dark:via-gray-900 dark:to-slate-900">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.03),transparent)] dark:bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.08),transparent)]"></div>
    
    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
        <!-- Header Section -->
        <div class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:justify-between sm:items-start mb-8 lg:mb-12">
            <div class="space-y-2">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black bg-gradient-to-r from-violet-600 via-purple-600 to-indigo-600 dark:from-violet-400 dark:via-purple-400 dark:to-indigo-400 bg-clip-text text-transparent">
                    Admin Management
                </h1>
                <p class="text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-400 max-w-md">
                    Manage system administrators and their permissions
                </p>
                <div class="flex items-center space-x-2 text-xs sm:text-sm text-slate-500 dark:text-slate-500">
                    <div class="flex items-center space-x-1">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span>{{ $admins->total() }} Active Admins</span>
                    </div>
                </div>
            </div>
            
            <!-- Add Admin Button -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('super_admin.admins.create') }}" 
                   class="group inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 dark:from-violet-500 dark:to-indigo-500 dark:hover:from-violet-600 dark:hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-violet-500/25 dark:shadow-violet-500/20 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-violet-500/40">
                    <svg class="w-5 h-5 mr-2 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Admin
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-8 p-4 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-emerald-500 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-2xl shadow-xl shadow-black/5 dark:shadow-black/20 border border-white/20 dark:border-gray-800/50 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-slate-50/50 to-white/50 dark:from-gray-800/50 dark:to-gray-900/50 border-b border-slate-200/50 dark:border-gray-700/50">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gradient-to-br from-violet-500 to-indigo-500 rounded-lg shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">
                                System Administrators
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                {{ $admins->total() }} {{ Str::plural('administrator', $admins->total()) }} registered
                            </p>
                        </div>
                    </div>
                    
                    <!-- Stats Badge -->
                    <div class="flex items-center space-x-2">
                        <div class="px-3 py-1.5 bg-gradient-to-r from-violet-100 to-indigo-100 dark:from-violet-900/30 dark:to-indigo-900/30 rounded-full text-xs font-medium text-violet-700 dark:text-violet-300">
                            Total: {{ $admins->total() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-gray-700">
                    <thead class="bg-slate-50/50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Administrator
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Contact
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-4 text-left text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-4 sm:px-6 py-4 text-right text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 dark:bg-gray-900/50 divide-y divide-slate-200 dark:divide-gray-700">
                        @forelse($admins as $admin)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                                <!-- Administrator Info -->
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-violet-500 to-indigo-500 flex items-center justify-center shadow-lg">
                                                <span class="text-sm font-bold text-white">
                                                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                                {{ $admin->name }}
                                            </div>
                                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                                Admin ID: #{{ str_pad($admin->id, 4, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Info -->
                                <td class="px-4 sm:px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-sm text-slate-900 dark:text-white">
                                            <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="truncate max-w-xs">{{ $admin->email }}</span>
                                        </div>
                                        @if($admin->phone)
                                            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                {{ $admin->phone }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 sm:px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'active' => [
                                                'bg' => 'bg-emerald-100 dark:bg-emerald-900/30',
                                                'text' => 'text-emerald-800 dark:text-emerald-300',
                                                'dot' => 'bg-emerald-500'
                                            ],
                                            'inactive' => [
                                                'bg' => 'bg-red-100 dark:bg-red-900/30',
                                                'text' => 'text-red-800 dark:text-red-300',
                                                'dot' => 'bg-red-500'
                                            ],
                                            'pending' => [
                                                'bg' => 'bg-amber-100 dark:bg-amber-900/30',
                                                'text' => 'text-amber-800 dark:text-amber-300',
                                                'dot' => 'bg-amber-500'
                                            ]
                                        ];
                                        $status = $admin->status ?? 'active';
                                        $config = $statusConfig[$status] ?? $statusConfig['active'];
                                    @endphp
                                    
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
                                        <span class="w-2 h-2 {{ $config['dot'] }} rounded-full mr-2 {{ $status === 'active' ? 'animate-pulse' : '' }}"></span>
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 sm:px-6 py-4 text-right">
                                    <div class="flex flex-col sm:flex-row items-end sm:items-center justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('super_admin.admins.show', $admin) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 group">
                                            <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('super_admin.admins.edit', $admin) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 group">
                                            <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white text-xs font-medium rounded-lg shadow-sm hover:shadow-md transition-all duration-200 group" 
                                                    onclick="return confirm('Are you sure you want to delete this administrator? This action cannot be undone.')">
                                                <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 sm:px-6 py-12 text-center">
                                    <div class="flex flex-col items-center space-y-4">
                                        <div class="p-4 bg-slate-100 dark:bg-gray-800 rounded-full">
                                            <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">
                                                No administrators found
                                            </h3>
                                            <p class="text-slate-500 dark:text-slate-400 mb-4">
                                                Get started by creating your first administrator account.
                                            </p>
                                            <a href="{{ route('super_admin.admins.create') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-lg transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add First Admin
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($admins->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-xl shadow-lg shadow-black/5 dark:shadow-black/20 border border-white/20 dark:border-gray-800/50 p-4">
                    {{ $admins->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Enhanced glassmorphism effects */
    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    @media (prefers-color-scheme: dark) {
        .glass-effect {
            background: rgba(17, 24, 39, 0.25);
            border: 1px solid rgba(75, 85, 99, 0.18);
        }
    }
    
    /* Smooth transitions for better UX */
    * {
        transition-property: color, background-color, border-color, opacity, transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }
    
    /* Custom scrollbar for better aesthetics */
    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: rgb(241 245 249 / 0.5);
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: rgb(148 163 184 / 0.5);
        border-radius: 3px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: rgb(100 116 139 / 0.7);
    }
    
    @media (prefers-color-scheme: dark) {
        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgb(30 41 59 / 0.5);
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: rgb(71 85 105 / 0.5);
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: rgb(51 65 85 / 0.7);
        }
    }
</style>
@endsection