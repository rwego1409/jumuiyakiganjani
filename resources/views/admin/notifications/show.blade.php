<!-- resources/views/admin/notifications/show.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/80 dark:bg-blue-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-blue-300/60 dark:border-blue-700/60 p-8">
            <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"/></svg>
                Notification Details
            </h2>
            @if ($notification)
                <div class="bg-white/70 dark:bg-blue-800/70 rounded-xl shadow p-6 border border-blue-100 dark:border-blue-700/30 mb-6">
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-blue-600 dark:text-blue-200">Notification ID</dt>
                            <dd class="mt-1 text-blue-900 dark:text-blue-100 font-semibold">{{ $notification->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-blue-600 dark:text-blue-200">Title</dt>
                            <dd class="mt-1 text-blue-900 dark:text-blue-100 font-semibold">{{ $notification->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-blue-600 dark:text-blue-200">Message</dt>
                            <dd class="mt-1 text-blue-900 dark:text-blue-100 font-semibold">{{ $notification->message }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-blue-600 dark:text-blue-200">Created At</dt>
                            <dd class="mt-1 text-blue-900 dark:text-blue-100 font-semibold">{{ $notification->created_at->format('F d, Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Back to Notifications
                </a>
            @else
                <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    Notification not found!
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
