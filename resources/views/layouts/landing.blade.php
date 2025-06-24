<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jumuiya Kiganjani - Faith Community Management Platform</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --dark-bg: #111827;
            --dark-text: #f9fafb;
            --light-bg: #ffffff;
            --light-text: #111827;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --indigo-100: #e0e7ff;
            --indigo-200: #c7d2fe;
            --indigo-300: #a5b4fc;
            --indigo-600: #4f46e5;
            --indigo-700: #4338ca;
            --purple-800: #5b21b6;
            --green-500: #10b981;
            --red-500: #ef4444;
            --yellow-500: #f59e0b;
        }
        
        .bg-jumuiya-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zM7 40c0-3.866-3.134-7-7-7s-7 3.134-7 7 3.134 7 7 7 7-3.134 7-7zm-5-15c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40-8c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zm18 24c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zM11 38c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8z' fill='%230ea5e9' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        /* Theme transitions */
        :root {
            transition: color-scheme 0.3s ease;
        }
        
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        html.dark {
            background-color: var(--dark-bg);
            color: var(--dark-text);
            color-scheme: dark;
        }

        html.light {
            background-color: var(--light-bg);
            color: var(--light-text);
            color-scheme: light;
        }
        
        body {
            font-family: 'Figtree', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--gray-100);
            color: var(--gray-900);
        }
        
        .dark .btn-secondary {
            background-color: var(--gray-800);
            color: var(--gray-200);
        }
        
        .btn-secondary:hover {
            background-color: var(--gray-200);
        }
        
        .dark .btn-secondary:hover {
            background-color: var(--gray-700);
        }
        
        .stat-item {
            background: rgba(79, 70, 229, 0.05);
            border-radius: 16px;
            padding: 24px 16px;
        }
        
        .dark .stat-item {
            background: rgba(79, 70, 229, 0.1);
        }
        
        .swiper-button-next, 
        .swiper-button-prev {
            color: var(--gray-900);
        }
        
        .dark .swiper-button-next,
        .dark .swiper-button-prev {
            color: var(--gray-300);
        }
        
        .testimonial-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .dashboard-preview {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .dark .dashboard-preview {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .footer-link {
            transition: color 0.2s ease;
        }
        
        .footer-link:hover {
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .hero-heading {
                font-size: 2.5rem;
            }
            
            .dashboard-preview {
                border-radius: 16px;
            }
        }
    </style>
    
    <!-- Dark mode initialization -->
    <script>
        // Check for saved user preference, otherwise use system preference
        const darkMode = localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Dark Mode Toggle Button -->
    <div class="fixed top-4 right-4 z-50">
        <button 
            onclick="toggleTheme()"
            id="themeToggle" 
            class="p-3 rounded-lg bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-lg border border-gray-200 dark:border-gray-700 transition-all duration-200"
            aria-label="Toggle dark mode"
        >
            <!-- Sun icon -->
            <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <!-- Moon icon -->
            <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex justify-between items-center">
        <div class="flex items-center">
            <div class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-church text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">Jumuiya Kiganjani</h1>
                <p class="text-xs opacity-80">Faith Community Management Platform</p>
            </div>
        </div>
        
        <div class="hidden md:flex space-x-8">
            <a href="#features" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Features</a>
            <a href="#testimonials" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Testimonials</a>
            <a href="#pricing" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Pricing</a>
            <a href="#team" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Team</a>
        </div>
        
        <div class="flex items-center space-x-4">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                Login
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition">
                Register
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Jumuiya Kiganjani</h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">Empowering faith communities with modern management tools.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Quick Links</h3>
                    <ul class="mt-4 space-y-4">
                        <li>
                            <a href="#features" class="footer-link text-base text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Features
                            </a>
                        </li>
                        <li>
                            <a href="#testimonials" class="footer-link text-base text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Testimonials
                            </a>
                        </li>
                        <li>
                            <a href="#" class="footer-link text-base text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Authentication Links -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Account</h3>
                    <ul class="mt-4 space-y-4">
                        <li>
                            <a href="{{ route('login') }}" class="footer-link text-base text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="footer-link text-base text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                                Register
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <p class="text-base text-gray-500 dark:text-gray-400 text-center">
                    &copy; 2023 Jumuiya Kiganjani. University of Dar es Salaam Final Year Project. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Theme toggle function
        function toggleTheme() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.theme = html.classList.contains('dark') ? 'dark' : 'light';
        }
        
        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
    </script>
</body>
</html>