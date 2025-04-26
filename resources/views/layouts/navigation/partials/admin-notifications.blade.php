<div class="max-h-60 overflow-y-auto">
    @php
        $dummyNotifications = [
            ['message' => 'New member registration', 'time' => '2 minutes ago', 'type' => 'info'],
            ['message' => 'System update required', 'time' => '30 minutes ago', 'type' => 'warning'],
            ['message' => 'Backup completed successfully', 'time' => '1 hour ago', 'type' => 'success'],
            ['message' => 'High traffic alert', 'time' => '2 hours ago', 'type' => 'error']
        ];
    @endphp

    @forelse($dummyNotifications as $notification)
        <div class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ $notification['message'] }}
            </p>
            <p class="text-xs text-gray-400 mt-1">
                {{ $notification['time'] }}
            </p>
        </div>
    @empty
        <div class="px-4 py-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('No new notifications') }}
            </p>
        </div>
    @endforelse
</div>
