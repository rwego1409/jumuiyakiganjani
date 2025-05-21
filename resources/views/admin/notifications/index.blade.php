@extends('layouts.admin')

@section('content')
    <div class="container mx-auto mt-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold text-gray-800">Notifications</h1>
            <a href="{{ route('admin.notifications.create') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                Create New Notification
            </a>
        </div>

        <!-- Display notifications -->
        @if ($notifications->count() > 0)
            <div class="space-y-4">
                @foreach ($notifications as $notification)
                    <div class="flex justify-between items-center p-4 bg-white rounded-lg shadow-md border border-gray-200">
                        <div>
                            <h5 class="text-xl font-semibold text-blue-600">{{ $notification->title }}</h5>
                            <p class="text-sm text-gray-500">{{ Str::limit($notification->message, 100) }}</p>
                            <small class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <a href="{{ route('admin.notifications.show', $notification->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">View</a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination links -->
            <div class="mt-6">
                {{ $notifications->links('pagination::tailwind') }}
            </div>
        @else
            <div class="p-4 text-center bg-yellow-100 text-yellow-800 rounded-lg">
                No notifications found. <a href="{{ route('admin.notifications.create') }}" class="text-blue-600 hover:text-blue-700">Create one now</a>.
            </div>
        @endif
    </div>
@endsection
