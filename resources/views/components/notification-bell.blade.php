<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="relative p-1 text-gray-400 hover:text-gray-500 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
        @endif
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
         role="menu" 
         aria-orientation="vertical" 
         aria-labelledby="notifications-menu">
        <div class="py-1" role="none">
            @forelse($notifications as $notification)
                <a href="{{ route('notifications.show', $notification) }}" 
                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <div class="flex justify-between">
                        <p class="font-medium">{{ $notification->data['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-500 truncate">{{ $notification->data['message'] }}</p>
                </a>
            @empty
                <div class="px-4 py-2 text-sm text-gray-500">No new notifications</div>
            @endforelse

            @if($notifications->isNotEmpty())
                <div class="border-t border-gray-100"></div>
                <a href="{{ route('notifications.index') }}" 
                   class="block px-4 py-2 text-sm text-indigo-600 hover:bg-gray-100">
                    View all notifications
                </a>
            @endif
        </div>
    </div>
</div>
