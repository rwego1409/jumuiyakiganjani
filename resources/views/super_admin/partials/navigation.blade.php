@include('layouts.shared.notifications-data')

<nav x-data="{ 
        mobileMenuOpen: false, 
        notificationsOpen: false,
        darkMode: (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
    }" 
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-lg fixed w-full z-30 top-0 left-0" 
    aria-label="Super Admin navigation">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left Side -->
            <div class="flex items-center space-x-2">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 sm:hidden mr-2"
                        aria-controls="mobile-menu"
                        :aria-expanded="mobileMenuOpen.toString()"
                        aria-label="Toggle navigation">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <!-- Branding -->
                <div class="flex-shrink-0 min-w-0">
                    <a href="{{ route('super_admin.dashboard') }}" class="flex items-center group focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md min-w-0" aria-label="Dashboard">
                        <svg class="h-8 w-8 text-primary-600 group-hover:text-primary-700 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-gray-100 truncate block min-w-0 max-w-[120px] sm:max-w-[180px] md:max-w-[240px] lg:max-w-[320px] xl:max-w-[400px]">
                            Jumuiya Kiganjani
                        </span>
                    </a>
                </div>
                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ml-4 space-x-2">
                    <x-nav-link :href="route('super_admin.dashboard')" :active="request()->routeIs('super_admin.dashboard')">
                        <i class="fas fa-tachometer-alt mr-1 text-primary-500"></i>
                        <span class="hidden md:inline">{{ __('Dashboard') }}</span>
                        <span class="md:hidden">Dash</span>
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.jumuiyas.index')" :active="request()->routeIs('super_admin.jumuiyas.*')">
                        <i class="fas fa-users-cog mr-1 text-orange-500"></i>
                        <span>{{ __('Jumuiyas') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.chairpersons.index')" :active="request()->routeIs('super_admin.chairpersons.*')">
                        <i class="fas fa-user-tie mr-1 text-pink-500"></i>
                        <span class="hidden md:inline xl:inline">{{ __('Chairpersons') }}</span>
                        <span class="hidden md:inline xl:hidden">Chairs</span>
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.users.index')" :active="request()->routeIs('super_admin.users.*')">
                        <i class="fas fa-user-shield mr-1 text-indigo-500"></i>
                        <span class="hidden md:inline xl:inline">{{ __('Users') }}</span>
                        <span class="hidden md:inline xl:hidden">Users</span>
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.notifications.index')" :active="request()->routeIs('super_admin.notifications.*')">
                        <i class="fas fa-bell mr-1 text-yellow-500"></i>
                        <span class="hidden md:inline lg:inline">{{ __('Notifications') }}</span>
                        <span class="hidden md:inline lg:hidden">Notif</span>
                    </x-nav-link>
                </div>
            </div>
            
            <!-- Right Side -->
            <div class="flex items-center space-x-2">
                <!-- Mobile Profile and Dark Mode (visible on small screens) -->
                <div class="flex items-center space-x-2 sm:hidden">
                    <!-- Mobile Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', darkMode)"
                            class="p-2 text-gray-600 hover:text-primary-500 rounded-full dark:text-gray-300 dark:hover:text-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors"
                            aria-label="Toggle dark mode">
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>
                    
                    <!-- Mobile Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md p-1 transition-colors"
                                    aria-label="User menu" aria-haspopup="true">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <svg class="h-4 w-4 text-gray-400 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fas fa-user-cog mr-2 text-gray-400"></i>
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Desktop Profile Dropdown and Dark Mode Toggle (hidden on mobile) -->
                <div class="hidden sm:flex sm:items-center space-x-2">
                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-1 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-md p-1 transition-colors"
                                    aria-label="User menu" aria-haspopup="true">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden lg:inline max-w-xs truncate">{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fas fa-user-cog mr-2 text-gray-400"></i>
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault(); this.closest('form').submit();"
                                                class="text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', darkMode)"
                            class="p-2 text-gray-600 hover:text-primary-500 rounded-full dark:text-gray-300 dark:hover:text-primary-400 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors"
                            aria-label="Toggle dark mode">
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation - Slide in from left -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 shadow-lg sm:hidden overflow-y-auto">
        <!-- Menu Header with Close Button -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Jumuiya Kiganjani
                </span>
            </div>
            <button @click="mobileMenuOpen = false" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Mobile Navigation Links -->
        <div class="px-2 py-3 space-y-1">
            <x-responsive-nav-link :href="route('super_admin.dashboard')" :active="request()->routeIs('super_admin.dashboard')" class="flex items-center min-h-[44px]">
                <i class="fas fa-tachometer-alt mr-3 text-primary-500 w-5 text-center"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.jumuiyas.index')" :active="request()->routeIs('super_admin.jumuiyas.*')" class="flex items-center min-h-[44px]">
                <i class="fas fa-users-cog mr-3 text-orange-500 w-5 text-center"></i>
                {{ __('Jumuiyas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.chairpersons.index')" :active="request()->routeIs('super_admin.chairpersons.*')" class="flex items-center min-h-[44px]">
                <i class="fas fa-user-tie mr-3 text-pink-500 w-5 text-center"></i>
                {{ __('Chairpersons') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.users.index')" :active="request()->routeIs('super_admin.users.*')" class="flex items-center min-h-[44px]">
                <i class="fas fa-user-shield mr-3 text-indigo-500 w-5 text-center"></i>
                {{ __('Users') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.notifications.index')" :active="request()->routeIs('super_admin.notifications.*')" class="flex items-center min-h-[44px]">
                <i class="fas fa-bell mr-3 text-yellow-500 w-5 text-center"></i>
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>
        <!-- Mobile Profile Section -->
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-750">
            <div class="flex items-center">
                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold mr-3">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Super Admin</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center min-h-[44px]">
                    <i class="fas fa-user-cog mr-3 text-gray-400 w-5 text-center"></i>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                          onclick="event.preventDefault(); this.closest('form').submit();"
                                          class="text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center min-h-[44px]">
                        <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    <!-- Overlay for Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-cloak
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 sm:hidden"
         style="display: none;"></div>
</nav>

<!-- Main Content -->
<div class="pt-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto py-6">
        <!-- Your content goes here -->
    </div>
</div>