@extends('layouts.member')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">{{ __('Notifications') }}</h2>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @if($notifications->count())
            <ul>
                @foreach($notifications as $notification)
                    <li class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-semibold text-gray-800 dark:text-gray-100">{{ $notification->data['title'] ?? 'Notification' }}</span>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">{{ $notification->data['body'] ?? '' }}</p>
                                <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('member.notifications.show', $notification->id) }}" class="text-primary-600 hover:underline text-sm">{{ __('View') }}</a>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">{{ __('You have no notifications.') }}</p>
        @endif
    </div>
</div>
@endsection
