@extends('layouts.chairperson')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-purple-100 dark:from-pink-900 dark:via-gray-800 dark:to-purple-900 py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
        <div class="mb-6">
            <a href="{{ route('chairperson.notifications.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl shadow font-semibold text-white bg-gradient-to-r from-pink-600 to-purple-500 hover:from-pink-700 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                ← Back to Notifications
            </a>
        </div>
        <div class="bg-white/80 dark:bg-purple-900/80 backdrop-blur-md shadow-2xl rounded-2xl border border-pink-200/60 dark:border-purple-700/60 p-8">
            <div class="space-y-6">
                <div>
                    <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent drop-shadow-lg">
                        {{ $notification->title }}
                    </h2>
                    <div class="mt-2 flex items-center text-sm text-pink-500 dark:text-pink-300">
                        <span>{{ $notification->created_at->format('F j, Y g:i A') }}</span>
                        <span class="mx-2">•</span>
                        <span class="capitalize">{{ $notification->type }}</span>
                    </div>
                </div>
                <div class="prose dark:prose-invert max-w-none">
                    <p>{{ $notification->message }}</p>
                </div>
                @if($notification->action_url)
                <div class="mt-4">
                    <a href="{{ $notification->action_url }}" 
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-pink-600 to-purple-500 text-white rounded-xl shadow hover:from-pink-700 hover:to-purple-600 transition-all"
                       target="_blank">
                        View Details
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
