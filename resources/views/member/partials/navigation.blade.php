<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo Section -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('member.dashboard') }}" class="flex items-center">
                        <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900">Jumuiya Kiganjani</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex sm:ml-10 space-x-8">
                    <x-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')">
                        <i class="fas fa-tachometer-alt mr-2 text-primary-500"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('member.profile.*')">
                        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                        {{ __('Profile') }}
                    </x-nav-link>
                    <x-nav-link :href="route('member.contributions.index')" :active="request()->routeIs('member.contributions.*')">
                        <i class="fas fa-hand-holding-usd mr-2 text-green-500"></i>
                        {{ __('Contributions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('member.events.index')" :active="request()->routeIs('member.events.*')">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>
                        {{ __('Events') }}
                    </x-nav-link>
                    <x-nav-link :href="route('member.resources.index')" :active="request()->routeIs('member.resources.*')">
                        <i class="fas fa-file-alt mr-2 text-yellow-500"></i>
                        {{ __('Resources') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- User Dropdown - Desktop -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 focus:outline-none transition">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold mr-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            </div>
                            <svg class="ml-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fas fa-user-cog mr-2"></i> {{ __('Profile Settings') }}
                        </x-dropdown-link>
                        <div class="border-t border-gray-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-primary-600 hover:bg-gray-100 focus:outline-none transition">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'hidden': !open, 'block': open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div class="sm:hidden" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
        <div class="pt-2 pb-3 px-4 space-y-1 bg-white shadow-lg">
            <!-- Mobile Logo -->
            <div class="flex items-center px-2 pb-3 border-b">
                <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="ml-2 text-xl font-semibold text-gray-900">Jumuiya Kiganjani</span>
            </div>

            <!-- Mobile Links -->
            <x-responsive-nav-link :href="route('member.dashboard')" :active="request()->routeIs('member.dashboard')" class="pl-3">
                <i class="fas fa-tachometer-alt mr-3 text-primary-500 w-4 text-center"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('member.profile.*')" class="pl-3">
                <i class="fas fa-user-circle mr-3 text-blue-500 w-4 text-center"></i>
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('member.contributions.index')" :active="request()->routeIs('member.contributions.*')" class="pl-3">
                <i class="fas fa-hand-holding-usd mr-3 text-green-500 w-4 text-center"></i>
                {{ __('Contributions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('member.events.index')" :active="request()->routeIs('member.events.*')" class="pl-3">
                <i class="fas fa-calendar-alt mr-3 text-purple-500 w-4 text-center"></i>
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('member.resources.index')" :active="request()->routeIs('member.resources.*')" class="pl-3">
                <i class="fas fa-file-alt mr-3 text-yellow-500 w-4 text-center"></i>
                {{ __('Resources') }}
            </x-responsive-nav-link>

            <!-- Mobile User Actions -->
            <div class="pt-4 pb-2 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-sm text-gray-500">{{ __('Logged in as') }}</div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="pl-3">
                        <i class="fas fa-cog mr-3 text-gray-400 w-4 text-center"></i>
                        {{ __('Settings') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="pl-3 text-red-600">
                            <i class="fas fa-sign-out-alt mr-3 w-4 text-center"></i>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>