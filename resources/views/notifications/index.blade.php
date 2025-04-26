@php
    $user = auth()->user();
    $role = $user->role;
    if (!in_array($role, ['admin', 'member'])) {
        abort(403, 'Unauthorized role');
    }

    $notifications = $role === 'admin' ? [
        ['message' => 'New member registration', 'time' => '2 minutes ago', 'type' => 'info'],
        ['message' => 'System update required', 'time' => '30 minutes ago', 'type' => 'warning'],
        ['message' => 'Backup completed successfully', 'time' => '1 hour ago', 'type' => 'success'],
        ['message' => 'High traffic alert', 'time' => '2 hours ago', 'type' => 'error']
    ] : [
        ['message' => 'Your contribution was received', 'time' => '5 minutes ago', 'type' => 'success'],
        ['message' => 'Upcoming event: Community meeting', 'time' => '1 hour ago', 'type' => 'info'],
        ['message' => 'Payment reminder: Monthly contribution', 'time' => '2 hours ago', 'type' => 'warning']
    ];
@endphp

@extends($role === 'admin' ? 'layouts.admin' : 'layouts.member')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                {{ $role === 'admin' ? 'Admin Notifications' : 'My Notifications' }}
                <span class="ml-2 text-sm font-medium text-gray-600 dark:text-gray-400">({{ count($notifications) }})</span>
            </h2>
        </div>

        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $notification['message'] }}</p>
                    <p class="mt-1 text-xs text-gray-400">{{ $notification['time'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection