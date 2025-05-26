@extends('layouts.chairperson')

@section('content')
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="mb-6">
                <a href="{{ route('chairperson.notifications.index') }}" 
                   class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                    ← Back to Notifications
                </a>
            </div>

            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $notification->title }}
                    </h2>
                    <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
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
                       class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200"
                       target="_blank">
                        View Details
                        <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                @endif

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recipients</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        @if($notification->recipient_type === 'all')
                            <p class="text-gray-600 dark:text-gray-300">
                                Sent to all members of {{ auth()->user()->jumuiya->name }}
                            </p>
                        @else
                            <div class="space-y-2">
                                @foreach($notification->members as $member)
                                    <div class="flex items-center text-gray-600 dark:text-gray-300">
                                        <span class="w-4 h-4 mr-2 flex items-center justify-center">
                                            @if($member->user && $member->user->notifications()->where('data->notification_id', $notification->id)->whereNotNull('read_at')->exists())
                                                <svg class="text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg class="text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                        </span>
                                        {{ $member->user->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
