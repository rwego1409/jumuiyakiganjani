@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-pink-100 dark:from-pink-900 dark:via-gray-800 dark:to-pink-900 py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/50 dark:border-pink-900/50 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-pink-700 dark:text-pink-300 flex items-center">
                    <svg class="w-8 h-8 mr-2 text-pink-500 dark:text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Activity Details
                </h2>
                <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center px-4 py-2 btn-indigo rounded-lg shadow transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-pink-400">
                    <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Activities
                </a>
            </div>
            <div class="space-y-6">
                <div class="bg-pink-50 dark:bg-pink-900/30 rounded-xl p-6 border border-pink-200 dark:border-pink-900">
                    <h3 class="text-lg font-semibold text-pink-700 dark:text-pink-300 mb-2">Description</h3>
                    <p class="text-gray-900 dark:text-gray-100">{{ $activity->description }}</p>
                </div>
                <div class="bg-pink-50 dark:bg-pink-900/30 rounded-xl p-6 border border-pink-200 dark:border-pink-900">
                    <h3 class="text-lg font-semibold text-pink-700 dark:text-pink-300 mb-2">Details</h3>
                    <pre class="text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{{ $activity->details ?? '-' }}</pre>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-pink-50 dark:bg-pink-900/30 rounded-xl p-6 border border-pink-200 dark:border-pink-900">
                        <h3 class="text-lg font-semibold text-pink-700 dark:text-pink-300 mb-2">User</h3>
                        <p class="text-gray-900 dark:text-gray-100 font-semibold">{{ $activity->causer->name ?? 'System' }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $activity->causer->email ?? '' }}</p>
                    </div>
                    <div class="bg-pink-50 dark:bg-pink-900/30 rounded-xl p-6 border border-pink-200 dark:border-pink-900">
                        <h3 class="text-lg font-semibold text-pink-700 dark:text-pink-300 mb-2">Date</h3>
                        <p class="text-gray-900 dark:text-gray-100 font-semibold">{{ $activity->created_at->format('M d, Y h:i A') }}</p>
                        <span class="inline-block mt-2 px-3 py-1 rounded-full bg-pink-200 text-pink-800 dark:bg-pink-900/50 dark:text-pink-200 text-xs font-bold">{{ ucfirst($activity->log_name) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
