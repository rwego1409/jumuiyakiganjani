<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Welcome')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- In <head> -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <!-- Before closing </body> -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-jumuiya-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zM7 40c0-3.866-3.134-7-7-7s-7 3.134-7 7 3.134 7 7 7 7-3.134 7-7zm-5-15c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40-8c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zm18 24c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zM11 38c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8z' fill='%230ea5e9' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        /* Force dark mode */
        :root {
            color-scheme: dark;
        }
        
        html {
            background-color: #111827; /* dark gray-900 */
            color: #f9fafb; /* gray-50 */
        }
    </style>

    @stack('styles')
    
    <!-- Force dark mode -->
    <script>
        // Immediately set dark mode
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    </script>
</head>

<!-- 
DARK MODE TOGGLE FUNCTIONALITY
Uncomment this script when you're ready to implement the dark mode toggle

<script>
document.querySelectorAll('[data-dark-toggle]').forEach(btn => {
    btn.addEventListener('click', function() {
        document.documentElement.classList.toggle('dark');
        // Optional: persist preference in localStorage
        if(document.documentElement.classList.contains('dark')){
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
});
// On page load, set theme from localStorage
if(localStorage.getItem('theme') === 'light'){
    document.documentElement.classList.remove('dark');
} else {
    document.documentElement.classList.add('dark');
}
</script>
-->

<body class="font-sans antialiased bg-gray-900 text-gray-50 transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        @include('partials.logo')
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- 
                        DARK MODE TOGGLE BUTTON
                        Uncomment this button when you're ready to implement the dark mode toggle
                        
                        <button data-dark-toggle 
                                class="p-2 rounded-md text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 
                                       transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">Toggle dark mode</span>
                            <svg class="hidden dark:block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                            </svg>
                            <svg class="block dark:hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                        -->
                        
                        <!-- Auth Links -->
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-300 bg-primary-500 hover:bg-primary-600 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 transition-colors">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.footer')
    </div>

    @stack('scripts')
</body>
</html>