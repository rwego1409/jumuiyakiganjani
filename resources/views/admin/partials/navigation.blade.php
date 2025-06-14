<nav x-data="{ mobileMenuOpen: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
     class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <!-- Left Section -->
            <div class="flex items-center">
                <!-- Branding -->
                <div class="flex-shrink-0">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center group focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <svg class="h-6 w-6 text-primary-600 group-hover:text-primary-700 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Jumuiya Kiganjani
                        </span>
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <i class="fas fa-tachometer-alt mr-1 text-primary-500 text-xs"></i>
                        <span class="text-sm">Dashboard</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.jumuiyas.index')" :active="request()->routeIs('admin.jumuiyas.*')">
                        <i class="fas fa-users-cog mr-1 text-orange-500 text-xs"></i>
                        <span class="text-sm">Jumuiyas</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.chairpersons.index')" :active="request()->routeIs('admin.chairpersons.*')">
                        <i class="fas fa-user-tie mr-1 text-pink-500 text-xs"></i>
                        <span class="text-sm">Chairs</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                        <i class="fas fa-users mr-1 text-blue-500 text-xs"></i>
                        <span class="text-sm">Members</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.*')">
                        <i class="fas fa-hand-holding-usd mr-1 text-green-500 text-xs"></i>
                        <span class="text-sm">Contrib</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                        <i class="fas fa-calendar-alt mr-1 text-purple-500 text-xs"></i>
                        <span class="text-sm">Events</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.resources.index')" :active="request()->routeIs('admin.resources.*')">
                        <i class="fas fa-file-alt mr-1 text-yellow-500 text-xs"></i>
                        <span class="text-sm">Resources</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.notifications.index')" :active="request()->routeIs('admin.notifications.*')">
                        <i class="fas fa-bell mr-1 text-yellow-500 text-xs"></i>
                        <span class="text-sm">Notify</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                        <i class="fas fa-cog mr-1 text-gray-500 text-xs"></i>
                        <span class="text-sm">Settings</span>
                    </x-nav-link>
                </div>
            </div>
            <!-- Right Section -->
            <div class="hidden sm:flex sm:items-center sm:ml-4 space-x-3">
                <!-- Dark Mode Toggle -->
                @if(isset($showDarkModeToggle) && $showDarkModeToggle)
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', darkMode)"
                            class="p-1.5 text-gray-600 hover:text-primary-500 rounded-full dark:text-gray-300 dark:hover:text-primary-500">
                        <svg x-show="!darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z" />
                        </svg>
                    </button>
                @endif
                <!-- Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center space-x-1 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-primary-600 focus:outline-none transition-colors">
                            <div class="w-7 h-7 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold text-sm">
                                {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:inline text-sm">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-cog mr-2 text-gray-400 text-xs"></i>
                            Profile Settings
                        </x-dropdown-link>
                        <div class="border-t border-gray-200 my-1"></div>
                        <x-dropdown-link :href="route('admin.settings')">
                            <i class="fas fa-cog mr-2 text-gray-400 text-xs"></i>
                            System Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                              onclick="event.preventDefault(); this.closest('form').submit();"
                                              class="text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2 text-xs"></i>
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div class="sm:hidden" x-show="mobileMenuOpen" x-cloak x-collapse>
        <div class="pt-1 pb-2 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <i class="fas fa-tachometer-alt mr-2 text-primary-500 text-xs"></i>
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.jumuiyas.index')" :active="request()->routeIs('admin.jumuiyas.*')">
                <i class="fas fa-users-cog mr-2 text-orange-500 text-xs"></i>
                Jumuiyas
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.chairpersons.index')" :active="request()->routeIs('admin.chairpersons.*')">
                <i class="fas fa-user-tie mr-2 text-pink-500 text-xs"></i>
                Chairpersons
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')">
                <i class="fas fa-users mr-2 text-blue-500 text-xs"></i>
                Members
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.*')">
                <i class="fas fa-hand-holding-usd mr-2 text-green-500 text-xs"></i>
                Contributions
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                <i class="fas fa-calendar-alt mr-2 text-purple-500 text-xs"></i>
                Events
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.resources.index')" :active="request()->routeIs('admin.resources.*')">
                <i class="fas fa-file-alt mr-2 text-yellow-500 text-xs"></i>
                Resources
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.settings')" :active="request()->routeIs('admin.settings')">
                <i class="fas fa-cog mr-2 text-gray-500 text-xs"></i>
                Settings
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.notifications.index')" :active="request()->routeIs('admin.notifications.*')">
                <i class="fas fa-bell mr-2 text-yellow-500 text-xs"></i>
                Notifications
            </x-responsive-nav-link>
        </div>

        <!-- Mobile User Menu -->
        <div class="pt-2 pb-2 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold text-sm">
                    {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs font-medium text-gray-500">Administrator</div>
                </div>
            </div>

            <div class="mt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fas fa-user-cog mr-2 text-gray-400 text-xs"></i>
                    Profile Settings
                </x-responsive-nav-link>
                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2 text-xs"></i>
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>