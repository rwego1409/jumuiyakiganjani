@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50/80 to-blue-100/60 dark:from-gray-900/80 dark:to-blue-900/60 px-2 sm:px-4 py-4 sm:py-8">
    <div class="container mx-auto px-0 sm:px-4 py-4 sm:py-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-8 gap-2 sm:gap-0">
            <div>
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow-lg mb-1 sm:mb-2">
                    Admins
                </h1>
                <p class="text-xs sm:text-base text-gray-600 dark:text-gray-400">Manage and view all admin records</p>
            </div>
            <a href="{{ route('super_admin.admins.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-pink-500 to-indigo-500 hover:from-pink-600 hover:to-indigo-600 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl transform hover:-translate-y-0.5 w-full sm:w-auto">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Admin
            </a>
        </div>
        @if(session('success'))
            <div class="mb-6 bg-green-50/80 dark:bg-green-900/30 border-l-4 border-green-400 dark:border-green-700 p-4 rounded-xl shadow-lg backdrop-blur-md">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-3 text-sm text-green-700 dark:text-green-200 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        <div class="glass-card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-pink-50/80 to-indigo-50/80 dark:from-pink-900/60 dark:to-indigo-900/60 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-6 h-6 text-pink-500 dark:text-pink-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        All Admins
                    </h3>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        {{ $admins->total() }} Total
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-2 sm:px-4 py-2 text-left text-gray-700 dark:text-gray-200">Name</th>
                            <th class="px-2 sm:px-4 py-2 text-left text-gray-700 dark:text-gray-200">Email</th>
                            <th class="px-2 sm:px-4 py-2 text-left text-gray-700 dark:text-gray-200">Phone</th>
                            <th class="px-2 sm:px-4 py-2 text-left text-gray-700 dark:text-gray-200">Status</th>
                            <th class="px-2 sm:px-4 py-2 text-left text-gray-700 dark:text-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr class="bg-white/80 dark:bg-gray-900/80">
                                <td class="px-2 sm:px-4 py-2 break-words max-w-[120px] sm:max-w-none text-gray-900 dark:text-white">{{ $admin->name }}</td>
                                <td class="px-2 sm:px-4 py-2 break-words text-gray-900 dark:text-white">{{ $admin->email }}</td>
                                <td class="px-2 sm:px-4 py-2 break-words text-gray-900 dark:text-white">{{ $admin->phone }}</td>
                                <td class="px-2 sm:px-4 py-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $admin->status == 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : ($admin->status == 'inactive' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400') }}">
                                        {{ ucfirst($admin->status ?? 'active') }}
                                    </span>
                                </td>
                                <td class="px-2 sm:px-4 py-2 flex flex-col sm:flex-row gap-2 sm:space-x-2 w-full sm:w-auto">
                                    <a href="{{ route('super_admin.admins.show', $admin) }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg font-semibold bg-gradient-to-r from-indigo-500 to-blue-500 text-white shadow-md hover:from-indigo-600 hover:to-blue-600 transition w-full sm:w-auto">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('super_admin.admins.edit', $admin) }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg font-semibold bg-gradient-to-r from-yellow-400 to-amber-500 text-white shadow-md hover:from-yellow-500 hover:to-amber-600 transition w-full sm:w-auto">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1 0v14m-7-7h14" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" class="inline w-full sm:w-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg font-semibold bg-gradient-to-r from-rose-500 to-red-500 text-white shadow-md hover:from-rose-600 hover:to-red-600 transition w-full sm:w-auto" onclick="return confirm('Are you sure?')">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-2 sm:px-4 py-2 text-center text-xs sm:text-sm text-gray-700 dark:text-gray-200">No admins found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $admins->links() }}</div>
    </div>
</div>
<!-- Glassmorphism utility -->
<style>
    .glass-card {
        background: rgba(255,255,255,0.65);
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        border: 1px solid rgba(255,255,255,0.18);
        backdrop-filter: blur(8px);
    }
    @media (prefers-color-scheme: dark) {
        .glass-card {
            background: rgba(30,41,59,0.65);
            border: 1px solid rgba(51,65,85,0.18);
        }
    }
</style>
@endsection