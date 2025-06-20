@extends('layouts.super_admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <h3 class="text-2xl font-semibold text-gray-800">Notification Details</h3>
        @if ($notification)
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b">
                    <p class="text-sm text-gray-600 font-medium">
                        Notification ID: <span class="text-gray-800">{{ $notification->id }}</span>
                    </p>
                </div>
                <div class="px-6 py-5">
                    <h5 class="text-xl font-bold text-gray-900 mb-2">{{ $notification->title }}</h5>
                    <p class="text-gray-700 mb-4">{{ $notification->message }}</p>
                    <p class="text-sm text-gray-500">
                        <strong>Created At:</strong> {{ $notification->created_at->format('F d, Y h:i A') }}
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('super_admin.notifications.index') }}"
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-150">
                            Back to Notifications
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                Notification not found!
            </div>
        @endif
    </div>
</div>
@endsection
