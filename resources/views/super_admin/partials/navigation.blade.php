<nav x-data="{ mobileMenuOpen: false, darkMode: false }" x-init="darkMode = (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-lg fixed w-full z-30 top-0 left-0" aria-label="Super Admin navigation">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Branding -->
                <div class="flex-shrink-0">
                    <a href="{{ route('super_admin.dashboard') }}" class="flex items-center group focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Super Admin Dashboard">
                        <svg class="h-8 w-8 text-primary-600 group-hover:text-primary-700 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-gray-100">
                            Jumuiya Kiganjani
                        </span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                    <x-nav-link :href="route('super_admin.dashboard')" :active="request()->routeIs('super_admin.dashboard')" aria-label="Dashboard">
                        <i class="fas fa-tachometer-alt mr-2 text-primary-500"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.jumuiyas.index')" :active="request()->routeIs('super_admin.jumuiyas.*')" aria-label="Jumuiyas">
                        <i class="fas fa-users-cog mr-2 text-orange-500"></i>
                        {{ __('Jumuiyas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.chairpersons.index')" :active="request()->routeIs('super_admin.chairpersons.*')" aria-label="Chairpersons">
                        <i class="fas fa-user-tie mr-2 text-pink-500"></i>
                        {{ __('Chairpersons') }}
                    </x-nav-link>
                   
                    <x-nav-link :href="route('super_admin.admins.index')" :active="request()->routeIs('super_admin.admins.*')" aria-label="Admins">
                        <i class="fas fa-user-shield mr-2 text-indigo-500"></i>
                        {{ __('Admins') }}
                    </x-nav-link>
                    <x-nav-link :href="route('super_admin.notifications.index')" :active="request()->routeIs('super_admin.notifications.*')">
                        <i class="fas fa-bell mr-2 text-yellow-500"></i>
                        {{ __('Notifications') }}
                    </x-nav-link>
                </div>
            </div>
            <!-- Right Section -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-6">
                <!-- Dark Mode Toggle -->
                @if(isset($showDarkModeToggle) && $showDarkModeToggle)
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', darkMode)"
                            class="p-2 text-gray-600 hover:text-primary-500 rounded-full dark:text-gray-300 dark:hover:text-primary-500"
                            aria-label="Toggle dark mode">
                        <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <svg x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>
                @endif
                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-1 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 focus:outline-none transition-colors"
                                aria-label="User menu" aria-haspopup="true">
                            <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                                {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
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
        </div>
    </div>
    <!-- Mobile Navigation -->
    <div class="sm:hidden" x-show="mobileMenuOpen" x-cloak x-collapse>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('super_admin.dashboard')" :active="request()->routeIs('super_admin.dashboard')" aria-label="Mobile Dashboard">
                <i class="fas fa-tachometer-alt mr-3 text-primary-500"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.jumuiyas.index')" :active="request()->routeIs('super_admin.jumuiyas.*')" aria-label="Mobile Jumuiyas">
                <i class="fas fa-users-cog mr-3 text-orange-500"></i>
                {{ __('Jumuiyas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.chairpersons.index')" :active="request()->routeIs('super_admin.chairpersons.*')" aria-label="Mobile Chairpersons">
                <i class="fas fa-user-tie mr-3 text-pink-500"></i>
                {{ __('Chairpersons') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.members.index')" :active="request()->routeIs('super_admin.members.*')" aria-label="Mobile Members">
                <i class="fas fa-users mr-3 text-blue-500"></i>
                {{ __('Members') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.admins.index')"
                                   :active="request()->routeIs('super_admin.admins.*')"
                                   aria-label="Mobile Admins">
                <i class="fas fa-user-shield mr-3 text-indigo-500"></i>
                {{ __('Admins') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('super_admin.notifications.index')" :active="request()->routeIs('super_admin.notifications.*')" aria-label="Mobile Notifications">
                <i class="fas fa-bell mr-3 text-yellow-500"></i>
                {{ __('Notifications') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center px-4">
                <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold">
                    {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Super Admin</div>
                </div>
                @if(isset($showDarkModeToggle) && $showDarkModeToggle)
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', darkMode)"
                            class="ml-auto p-2 text-gray-600 hover:text-primary-500 rounded-full dark:text-gray-300 dark:hover:text-primary-500"
                            aria-label="Toggle dark mode">
                        <svg x-show="!darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <svg x-show="darkMode" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>
                @endif
            </div>
            <div class="mt-3 space-y-1 px-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user-cog mr-3 text-gray-400"></i>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>
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
