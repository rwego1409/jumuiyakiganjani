<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <!-- Increased height -->
            <div class="flex items-center">
                <!-- Logo Section - Enhanced to match welcome page but more prominent -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                        <!-- SVG icon matching welcome page but larger -->
                        <svg class="h-10 w-10 text-primary-600 group-hover:text-primary-700 transition-colors" 
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <!-- Text logo with enhanced typography -->
                        <span class="ml-3 text-2xl font-bold text-gray-800 hidden md:block">
                            <span class="text-primary-600">Jumuiya</span> Kiganjani
                        </span>
                    </a>
                </div>

                <!-- Navigation Links - Improved with icons and hover effects -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="group">
                        <i class="fas fa-tachometer-alt mr-2 text-primary-500 group-hover:text-primary-600 transition-colors"></i>
                        <span class="group-hover:text-primary-600 transition-colors">{{ __('Dashboard') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" class="group">
                        <i class="fas fa-users mr-2 text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                        <span class="group-hover:text-blue-600 transition-colors">{{ __('Members') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.*')" class="group">
                        <i class="fas fa-hand-holding-usd mr-2 text-green-500 group-hover:text-green-600 transition-colors"></i>
                        <span class="group-hover:text-green-600 transition-colors">{{ __('Contributions') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')" class="group">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500 group-hover:text-purple-600 transition-colors"></i>
                        <span class="group-hover:text-purple-600 transition-colors">{{ __('Events') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.resources.index')" :active="request()->routeIs('admin.resources.*')" class="group">
                        <i class="fas fa-file-alt mr-2 text-yellow-500 group-hover:text-yellow-600 transition-colors"></i>
                        <span class="group-hover:text-yellow-600 transition-colors">{{ __('Resources') }}</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown - Enhanced with better styling -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium rounded-full focus:outline-none transition-all duration-300 hover:bg-gray-100 px-4 py-2">
                            <div class="flex items-center">
                                <!-- User avatar with gradient background -->
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="ml-3 text-left">
                                    <div class="text-gray-900 font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->role }}</div>
                                </div>
                            </div>
                            <svg class="ml-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Dropdown items with better spacing -->
                        <div class="py-1">
                            <x-dropdown-link :href="route('profile.edit')" class="group">
                                <i class="fas fa-user-circle mr-3 text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                                <span class="group-hover:text-primary-600 transition-colors">{{ __('Profile Settings') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.settings')" class="group">
                                <i class="fas fa-cog mr-3 text-gray-400 group-hover:text-primary-500 transition-colors"></i>
                                <span class="group-hover:text-primary-600 transition-colors">{{ __('System Settings') }}</span>
                            </x-dropdown-link>
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="group">
                                    <i class="fas fa-sign-out-alt mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                                    <span class="text-red-500 group-hover:text-red-600 transition-colors">{{ __('Log Out') }}</span>
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button - More prominent -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-primary-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 transition duration-150 ease-in-out">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu - Enhanced -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white shadow-xl">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="pl-3 group">
                <i class="fas fa-tachometer-alt mr-3 text-primary-500"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.members.index')" :active="request()->routeIs('admin.members.*')" class="pl-3 group">
                <i class="fas fa-users mr-3 text-blue-500"></i>
                {{ __('Members') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.*')" class="pl-3 group">
                <i class="fas fa-hand-holding-usd mr-3 text-green-500"></i>
                {{ __('Contributions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')" class="pl-3 group">
                <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.resources.index')" :active="request()->routeIs('admin.resources.*')" class="pl-3 group">
                <i class="fas fa-file-alt mr-3 text-yellow-500"></i>
                {{ __('Resources') }}
            </x-responsive-nav-link>
        </div>

        <!-- User section in mobile view - Enhanced -->
        <div class="pt-4 pb-3 border-t border-gray-200 px-4">
            <div class="flex items-center px-3">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-xl shadow-md">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="ml-4">
                    <div class="text-lg font-medium text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')" class="pl-3 group">
                    <i class="fas fa-user-circle mr-3 text-gray-400 group-hover:text-primary-500"></i>
                    {{ __('Profile Settings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.settings')" class="pl-3 group">
                    <i class="fas fa-cog mr-3 text-gray-400 group-hover:text-primary-500"></i>
                    {{ __('System Settings') }}
                </x-responsive-nav-link>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="pl-3 group">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-400 group-hover:text-red-500"></i>
                        <span class="text-red-500 group-hover:text-red-600">{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>