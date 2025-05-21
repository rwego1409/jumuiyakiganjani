@props([
    'notifications' => collect(),
    'unreadCount' => 0,
    'viewAllRoute' => null,
])
@php
    $defaultRoute = auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()
        ? route('admin.notifications.index')
        : route('notifications.index');
    $routeToViewAll = $viewAllRoute ?? $defaultRoute;
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
        class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg overflow-hidden z-50 border border-gray-200 dark:border-gray-700"
        style="display: none;">
        
        <div class="py-2">
            <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                <div class="flex justify-between items-center">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Notifications</h3>
                    @if($unreadCount > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                            {{ $unreadCount }} new
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="max-h-60 overflow-y-auto">
                @forelse($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $isAdmin = isset($data['admin']) && $data['admin'] === true;
                        $url = $data['url'] ?? '#';
                        $creator = $isAdmin ? 'Admin' : 'User';
                        $model = $data['model'] ?? 'item';
                        $action = $data['action'] ?? 'created';
                        $title = "{$creator} {$action} {$model}";
                        $isRead = !is_null($notification->read_at);
                    @endphp
                    <a href="{{ $url }}"
                        class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600 {{ $isRead ? '' : 'bg-blue-50 dark:bg-blue-900/20' }}"
                        wire:click.prevent="markAsRead('{{ $notification->id }}')">
                        <div class="flex justify-between">
                            <div class="w-0 flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $title }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 truncate">{{ $data['message'] ?? '' }}</p>
                                @isset($data['admin_name'])
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">From: {{ $data['admin_name'] }}</p>
                                @endisset
                            </div>
                            <div class="ml-3 flex-shrink-0 flex flex-col items-end">
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                @if(!$isRead)
                                <span class="mt-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    New
                                </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No new notifications</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        @if($notifications->count() > 0)
            <!-- View All Notifications Link -->
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-center border-t border-gray-100 dark:border-gray-600">
                <a href="{{ $routeToViewAll }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                    View all notifications
                </a>
            </div>
        @endif
    </div>
</div>