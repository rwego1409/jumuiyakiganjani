<div class="max-h-60 overflow-y-auto">
    @php
        $dummyNotifications = [
            ['message' => 'Your contribution was received', 'time' => '5 minutes ago', 'type' => 'success'],
            ['message' => 'Upcoming event: Community meeting', 'time' => '1 hour ago', 'type' => 'info'],
            ['message' => 'Payment reminder: Monthly contribution', 'time' => '2 hours ago', 'type' => 'warning']
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
