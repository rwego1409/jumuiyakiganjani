@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50/80 to-blue-100/60 dark:from-gray-900/80 dark:to-blue-900/60 py-8 px-2">
    <div class="w-full max-w-3xl mx-auto space-y-8">
        <div class="glass-card p-8">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                <h1 class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow-lg">Admin Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('super_admin.admins.edit', $admin) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-amber-500 hover:from-yellow-500 hover:to-amber-600 text-white text-sm font-bold rounded-lg shadow-md transition-all">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('super_admin.admins.destroy', $admin) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-rose-500 to-red-500 hover:from-rose-600 hover:to-red-600 text-white text-sm font-bold rounded-lg shadow-md transition-all">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="bg-white/70 dark:bg-gray-800/70 rounded-xl shadow-inner p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $admin->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $admin->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $admin->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                        <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $admin->status === 'active' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                            {{ ucfirst($admin->status ?? 'active') }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $admin->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</p>
                        <p class="mt-1 text-lg font-bold text-gray-900 dark:text-white">{{ $admin->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="glass-card p-8">
            <div class="mb-4">
                <h3 class="text-lg font-semibold bg-gradient-to-r from-pink-600 to-indigo-500 bg-clip-text text-transparent drop-shadow">Assigned Jumuiyas</h3>
            </div>
            @if($admin->managedJumuiyas->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($admin->managedJumuiyas as $jumuiya)
                        <div class="bg-white/80 dark:bg-gray-700/80 p-4 rounded-lg shadow flex flex-col">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $jumuiya->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Created: {{ $jumuiya->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">No jumuiyas assigned</p>
            @endif
        </div>
        <div class="flex justify-end">
            <a href="{{ route('super_admin.admins.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg font-bold text-gray-700 dark:text-white bg-gradient-to-r from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-700 shadow hover:from-gray-200 hover:to-gray-400 dark:hover:from-gray-700 dark:hover:to-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-400 transition-all">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Admins
            </a>
        </div>
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