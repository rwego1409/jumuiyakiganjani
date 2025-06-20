@extends('layouts.member')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('My Notifications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">Notifications</h3>
                        <div class="flex items-center space-x-4">
                            @if($role === 'chairperson')
                                <a href="{{ route('chairperson.notifications.create') }}" 
                                   class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors duration-200">
                                    Create Notification
                                </a>
                            @endif
                            <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition duration-150">
                                    Mark all as read
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Notification List -->
                    <div class="space-y-4">
                        @forelse($notifications as $notification)
                            @php
                                $isUnread = $notification->unread();
                                $bgColor = $isUnread
                                    ? 'bg-blue-50 border-blue-200 dark:bg-blue-900 dark:border-blue-700'
                                    : 'bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700';

                                $sender = 'System';
                                if (isset($notification->data['admin'])) {
                                    $admin = $notification->data['admin'];
                                    $sender = is_array($admin) ? ($admin['name'] ?? 'Admin') : $admin;
                                } elseif (isset($notification->data['user'])) {
                                    $user = $notification->data['user'];
                                    $sender = is_array($user) ? ($user['name'] ?? 'User') : $user;
                                }
                            @endphp

                            <div class="p-4 border rounded-lg {{ $bgColor }}">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-100">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">
                                            {{ $notification->data['message'] ?? 'No message content' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                            From: {{ $sender }}
                                        </p>
                                    </div>

                                    <div class="text-right whitespace-nowrap">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->format('M d, Y h:i A') }}
                                        </p>
                                        @if($isUnread)
                                            <span
                                                class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100 rounded-full">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                You have no notifications
                            </p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
