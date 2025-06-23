@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900 dark:to-pink-800 transition-colors duration-300 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-pink-900/80 rounded-xl border border-pink-200 dark:border-pink-700 shadow-lg overflow-hidden">
            <div class="p-6 border-b border-pink-200 dark:border-pink-700 flex items-center justify-between">
                <a href="{{ route('super_admin.activities.index') }}" class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-bold rounded-lg shadow transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Activities
                </a>
                <h2 class="text-2xl font-bold text-pink-700 dark:text-pink-200 flex items-center ml-2">
                    <svg class="w-7 h-7 mr-2 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Activity Details
                </h2>
            </div>
            <div class="p-8">
                <dl class="divide-y divide-pink-200 dark:divide-pink-700">
                    <div class="py-4">
                        <dt class="text-sm font-medium text-pink-500 dark:text-pink-300">User</dt>
                        <dd class="mt-1 text-pink-900 dark:text-pink-100 font-semibold">{{ $activity->user->name ?? 'System' }}</dd>
                    </div>
                    <div class="py-4">
                        <dt class="text-sm font-medium text-pink-500 dark:text-pink-300">Action</dt>
                        <dd class="mt-1 text-pink-900 dark:text-pink-100 font-semibold">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-pink-100 text-pink-800 dark:bg-pink-700/30 dark:text-pink-200">
                                <i class="fas fa-{{ $activity->getActivityIcon() }} mr-1"></i> {{ ucfirst($activity->action) }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-4">
                        <dt class="text-sm font-medium text-pink-500 dark:text-pink-300">Description</dt>
                        <dd class="mt-1 text-pink-900 dark:text-pink-100">{{ $activity->description }}</dd>
                    </div>
                    <div class="py-4">
                        <dt class="text-sm font-medium text-pink-500 dark:text-pink-300">Date</dt>
                        <dd class="mt-1 text-pink-900 dark:text-pink-100">{{ $activity->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    @if(!empty($activity->properties))
                    <div class="py-4">
                        <dt class="text-sm font-medium text-pink-500 dark:text-pink-300">Properties</dt>
                        <dd class="mt-1 text-pink-900 dark:text-pink-100">
                            <pre class="bg-pink-50 dark:bg-pink-800/50 rounded p-3 text-xs overflow-x-auto">{{ json_encode($activity->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
