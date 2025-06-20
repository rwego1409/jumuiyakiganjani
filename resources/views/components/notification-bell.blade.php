@php
    $notificationRoute = '';
    $markAllReadRoute = '';
    $unreadNotifications = collect();
    $recentNotifications = collect();

    if (auth()->check()) {
        $user = auth()->user();
        switch($user->role) {
            case 'super_admin':
                $notificationRoute = route('super_admin.notifications.index');
                $markAllReadRoute = route('super_admin.notifications.mark-all-read');
                break;
            case 'admin':
                $notificationRoute = route('admin.notifications.index');
                $markAllReadRoute = route('admin.notifications.mark-all-read');
                break;
            case 'chairperson':
                $notificationRoute = route('chairperson.notifications.index');
                $markAllReadRoute = route('chairperson.notifications.mark-all-read');
                break;
            case 'member':
                $notificationRoute = route('member.notifications.index');
                $markAllReadRoute = route('member.notifications.mark-all-read');
                break;
            default:
                $notificationRoute = route('notifications.index');
                $markAllReadRoute = route('notifications.mark-all-read');
                break;
        }
        $unreadNotifications = $user->notifications()->whereNull('read_at')->get();
        $recentNotifications = $user->notifications()->latest()->take(5)->get();
    }
@endphp
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="p-2 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white focus:outline-none">
        <!-- Bell Icon -->
        <span class="sr-only">Notifications</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <!-- Unread Count Badge -->
        @if($unreadCount > 0)
        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full transform translate-x-1/2 -translate-y-1/2">
            {{ $unreadCount }}
        </span>
        @endif
    </button>
    
    <!-- Dropdown Panel - Dark Mode Optimized -->
    <div x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-2 z-50"
        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50 border border-gray-200 dark:border-gray-700"
        style="display: none;">
        
        <!-- Header with Mark All as Read -->
        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    Notifications ({{ $unreadNotifications->count() }})
                </h3>
                @if($unreadNotifications->count() > 0)
                    <form method="POST" action="{{ $markAllReadRoute }}">
                        @csrf
                        <button type="submit" 
                                class="text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                            Mark all as read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($recentNotifications as $notification)
                <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 {{ $notification->read_at ? 'opacity-75' : '' }}">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                    <div class="mt-2 flex justify-between items-center text-xs">
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if(!$notification->read_at)
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-xs">
                                New
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 text-center">
                    No notifications
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-2">
            <a href="{{ $notificationRoute }}" 
               class="block text-sm text-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300">
                View all notifications
            </a>
        </div>

        @if(auth()->check())
            <div class="px-4 py-2 text-xs text-red-600 bg-yellow-100 rounded mb-2">
                Debug: User role = {{ auth()->user()->role }}
            </div>
        @endif
    </div>
</div>