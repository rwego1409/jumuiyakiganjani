<nav x-data="{ mobileMenuOpen: false, notificationsOpen: false }" 
     class="bg-white border-b border-gray-100 shadow-lg"
     aria-label="Admin navigation">
    
    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Branding -->
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center group focus:outline-none focus:ring-2 focus:ring-primary-500"
                       aria-label="Admin Dashboard">
                        <svg class="h-8 w-8 text-primary-600 group-hover:text-primary-700 transition-colors" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900">
                            Jumuiya Kiganjani 
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                    <x-nav-link :href="route('admin.dashboard')" 
                               :active="request()->routeIs('admin.dashboard')"
                               aria-label="Dashboard">
                        <i class="fas fa-tachometer-alt mr-2 text-primary-500"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.members.index')" 
                               :active="request()->routeIs('admin.members.*')"
                               aria-label="Members">
                        <i class="fas fa-users mr-2 text-blue-500"></i>
                        {{ __('Members') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contributions.index')" 
                               :active="request()->routeIs('admin.contributions.*')"
                               aria-label="Contributions">
                        <i class="fas fa-hand-holding-usd mr-2 text-green-500"></i>
                        {{ __('Contributions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.events.index')" 
                               :active="request()->routeIs('admin.events.*')"
                               aria-label="Events">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>
                        {{ __('Events') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.resources.index')" 
                               :active="request()->routeIs('admin.resources.*')"
                               aria-label="Resources">
                        <i class="fas fa-file-alt mr-2 text-yellow-500"></i>
                        {{ __('Resources') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.settings')" 
                               :active="request()->routeIs('admin.settings')"
                               aria-label="Settings">
                        <i class="fas fa-cog mr-2 text-gray-500"></i>
                        {{ __('Settings') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Section -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-6">
                <!-- Notifications -->
                <div class="relative">
                    <button @click="notificationsOpen = !notificationsOpen"
                            @keydown.escape="notificationsOpen = false"
                            class="p-2 text-gray-600 hover:text-primary-500 rounded-full hover:bg-gray-50 transition-colors"
                            aria-label="Notifications"
                            aria-haspopup="true"
                            :aria-expanded="notificationsOpen">
                        <i class="fas fa-bell text-lg"></i>
                        @if($unreadCount = auth()->user()->unreadNotifications->count())

                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                                {{ $unreadCount }}
                                <span class="sr-only">{{ __('Unread notifications') }}</span>
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Panel -->
                    <div x-show="notificationsOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.away="notificationsOpen = false"
                         class="origin-top-right absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                        <div class="p-4 bg-gray-50 border-b flex items-center justify-between">
                            <h3 class="font-semibold text-gray-900">{{ __('Notifications') }}</h3>
                            @if($unreadCount > 0)
                                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="text-sm text-primary-600 hover:text-primary-800"
                                            aria-label="{{ __('Mark all as read') }}">
                                        {{ __('Mark all read') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications->take(10) as $notification)
                                <a href="{{ route('admin.notifications.show', $notification) }}"
                                   class="block px-4 py-3 hover:bg-gray-50 {{ $notification->unread() ? 'bg-blue-50' : '' }}"
                                   role="alert">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 text-{{ $notification->data['type'] ?? 'info' }}-500">
                                            <i class="{{ $notification->data['icon'] ?? 'fas fa-info-circle' }} text-lg"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $notification->data['message'] ?? __('New notification') }}
                                            </p>
                                            <div class="mt-1 flex items-center justify-between">
                                                <time class="text-xs text-gray-500"
                                                      datetime="{{ $notification->created_at->toIso8601String() }}">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </time>
                                                @if($notification->unread())
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                        {{ __('New') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-3 text-sm text-gray-500">
                                    {{ __('No notifications found') }}
                                </div>
                            @endforelse
                        </div>

                        <div class="p-2 border-t bg-gray-50">
                            <a href="{{ route('admin.notifications.index') }}"
                               class="block text-center text-sm font-medium text-primary-600 hover:text-primary-800">
                                {{ __('View all notifications') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-1 text-sm font-medium text-gray-700 hover:text-primary-600 focus:outline-none transition-colors"
                                aria-label="User menu"
                                aria-haspopup="true">
                                @if(Auth::user()->profile_picture)
    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}"
         alt="{{ Auth::user()->name }}"
         class="w-9 h-9 rounded-full object-cover border border-gray-200 shadow-sm">
@else
    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
        {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
    </div>
@endif

                            <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Account') }}
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-cog mr-2 text-gray-400"></i>
                            {{ __('Profile Settings') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.notifications.index')">
                            <i class="fas fa-bell mr-2 text-gray-400"></i>
                            {{ __('Notifications') }}
                            @if($unreadCount > 0)
                                <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-800 text-xs rounded-full">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('admin.settings')">
                            <i class="fas fa-cog mr-2 text-gray-400"></i>
                            {{ __('System Settings') }}
                        </x-dropdown-link>

                        <!-- Logout -->
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden -mr-2">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-primary-600 hover:bg-gray-100 focus:outline-none transition-colors"
                        :aria-expanded="mobileMenuOpen"
                        aria-label="Toggle navigation">
                    <span class="sr-only">{{ __('Open main menu') }}</span>
                    <svg class="h-6 w-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'hidden': !mobileMenuOpen, 'block': mobileMenuOpen }" 
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="sm:hidden" x-show="mobileMenuOpen" x-cloak x-collapse>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" 
                                  :active="request()->routeIs('admin.dashboard')"
                                  aria-label="Mobile Dashboard">
                <i class="fas fa-tachometer-alt mr-3 text-primary-500"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" 
                                  :active="request()->routeIs('admin.members.*')"
                                  aria-label="Mobile Members">
                <i class="fas fa-users mr-3 text-blue-500"></i>
                {{ __('Members') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.contributions.index')" 
                                  :active="request()->routeIs('admin.contributions.*')"
                                  aria-label="Mobile Contributions">
                <i class="fas fa-hand-holding-usd mr-3 text-green-500"></i>
                {{ __('Contributions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.events.index')" 
                                  :active="request()->routeIs('admin.events.*')"
                                  aria-label="Mobile Events">
                <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.resources.index')" 
                                  :active="request()->routeIs('admin.resources.*')"
                                  aria-label="Mobile Resources">
                <i class="fas fa-file-alt mr-3 text-yellow-500"></i>
                {{ __('Resources') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.settings')" 
                                  :active="request()->routeIs('admin.settings')"
                                  aria-label="Mobile Settings">
                <i class="fas fa-cog mr-3 text-gray-500"></i>
                {{ __('Settings') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile User Menu -->
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                    {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">Administrator</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user-cog mr-3 text-gray-400"></i>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.notifications.index')">
                    <i class="fas fa-bell mr-3 text-gray-400"></i>
                    {{ __('Notifications') }}
                    @if($unreadCount > 0)
                        <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-800 text-xs rounded-full">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings')">
                    <i class="fas fa-cog mr-3 text-gray-400"></i>
                    {{ __('System Settings') }}
                </x-responsive-nav-link>
                
                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Required Scripts -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">