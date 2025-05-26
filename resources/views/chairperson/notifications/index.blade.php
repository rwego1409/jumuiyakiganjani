@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Notifications</h2>
                <a href="{{ route('chairperson.notifications.create') }}" 
                   class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200">
                    Create Notification
                </a>
            </div>

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <div class="space-y-4">
                @forelse($notifications as $notification)
                    <div class="p-4 bg-white dark:bg-gray-700 rounded-lg shadow border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ $notification->title }}
                                </h3>
                                <p class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $notification->message }}
                                </p>
                                <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <span class="mr-3">{{ $notification->created_at->diffForHumans() }}</span>
                                    <span class="mr-3">•</span>
                                    <span class="capitalize">{{ $notification->type }}</span>
                                    <span class="mr-3">•</span>
                                    <span>
                                        {{ $notification->recipient_type === 'all' ? 'All Members' : count($notification->member_ids) . ' Members' }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('chairperson.notifications.show', $notification->id) }}" 
                               class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                View Details →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No notifications sent yet.
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
