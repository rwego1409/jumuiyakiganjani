@include('layouts.shared.notifications-data')

<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('chairperson.dashboard') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ config('app.name', 'Jumuiya') }}</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                    <x-nav-link :href="route('chairperson.dashboard')" :active="request()->routeIs('chairperson.dashboard')">
                        <i class="fas fa-tachometer-alt mr-2 text-indigo-500"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('chairperson.members.index')" :active="request()->routeIs('chairperson.members.*')">
                        <i class="fas fa-users mr-2 text-green-500"></i>
                        {{ __('Members') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('chairperson.contributions.index')" :active="request()->routeIs('chairperson.contributions.*')">
                        <i class="fas fa-hand-holding-usd mr-2 text-blue-500"></i>
                        {{ __('Contributions') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chairperson.events.index')" :active="request()->routeIs('chairperson.events.*')">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>
                        {{ __('Events') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chairperson.resources.index')" :active="request()->routeIs('chairperson.resources.*')">
                        <i class="fas fa-book mr-2 text-yellow-500"></i>
                        {{ __('Resources') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chairperson.reminders.index')" :active="request()->routeIs('chairperson.reminders.*')">
                        <i class="fas fa-bell mr-2 text-red-500"></i>
                        {{ __('Reminders') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chairperson.reports.index')" :active="request()->routeIs('chairperson.reports.*')">
                        <i class="fas fa-chart-bar mr-2 text-teal-500"></i>
                        {{ __('Reports') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" 
                        class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 rounded-lg transition-colors" 
                        :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                    <!-- Sun icon -->
                    <svg x-cloak x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                    </svg>
                    <!-- Moon icon -->
                    <svg x-cloak x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Notifications -->
                <div class="relative">
                    <button @click="notificationsOpen = !notificationsOpen"
                            @keydown.escape="notificationsOpen = false"
                            class="p-2 text-gray-600 dark:text-gray-400 hover:text-primary-500 dark:hover:text-primary-400 rounded-full hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors relative"
                            aria-label="Notifications">
                        <i class="fas fa-bell text-lg"></i>
                        @if(isset($unreadNotifications) && $unreadNotifications > 0)
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                                {{ $unreadNotifications }}
                            </span>
                        @endif
                    </button>

                    <!-- Notifications Panel -->
                    <div x-show="notificationsOpen" 
                         x-cloak
                         @click.away="notificationsOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50 border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                            {{ __('Notifications') }}
                        </div>
                        @if(isset($notifications) && count($notifications) > 0)
                            <div class="max-h-64 overflow-y-auto">
                                @foreach($notifications as $notification)
                                    <div class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-700 px-4 py-2">
                                <a href="{{ route('chairperson.notifications.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                    {{ __('View all notifications') }}
                                </a>
                            </div>
                        @else
                            <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('No notifications') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-150 ease-in-out">
                            <div class="flex items-center space-x-2">
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 dark:text-gray-300"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Chairperson</div>
                                </div>
                                <i class="fas fa-chevron-down text-sm ml-1"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('chairperson.settings')">
                            <i class="fas fa-cog mr-2"></i>
                            {{ __('Settings') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user mr-2"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <div class="border-t border-gray-100 dark:border-gray-700"></div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none"
                        aria-label="Toggle menu">
                    <i class="fas" :class="{'fa-times': open, 'fa-bars': !open}"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('chairperson.dashboard')" :active="request()->routeIs('chairperson.dashboard')">
                <i class="fas fa-tachometer-alt mr-2"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('chairperson.members.index')" :active="request()->routeIs('chairperson.members.*')">
                <i class="fas fa-users mr-2"></i>
                {{ __('Members') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('chairperson.contributions.index')" :active="request()->routeIs('chairperson.contributions.*')">
                <i class="fas fa-hand-holding-usd mr-2"></i>
                {{ __('Contributions') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chairperson.events.index')" :active="request()->routeIs('chairperson.events.*')">
                <i class="fas fa-calendar-alt mr-2"></i>
                {{ __('Events') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chairperson.resources.index')" :active="request()->routeIs('chairperson.resources.*')">
                <i class="fas fa-book mr-2"></i>
                {{ __('Resources') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chairperson.reminders.index')" :active="request()->routeIs('chairperson.reminders.*')">
                <i class="fas fa-bell mr-2"></i>
                {{ __('Reminders') }}
            </x-responsive-nav-link>
        </div>

        <!-- Mobile Profile -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center px-4">
                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mr-3">
                    <i class="fas fa-user text-gray-600 dark:text-gray-300"></i>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('chairperson.settings')">
                    <i class="fas fa-cog mr-2"></i>
                    {{ __('Settings') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user mr-2"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                         onclick="event.preventDefault(); this.closest('form').submit();"
                                         class="text-red-600 dark:text-red-400">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
