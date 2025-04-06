<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jumuiya Kiganjani - Community Management</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-jumuiya-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zM7 40c0-3.866-3.134-7-7-7s-7 3.134-7 7 3.134 7 7 7 7-3.134 7-7zm-5-15c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40-8c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zm18 24c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zM11 38c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm38-8c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%230ea5e9' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 bg-jumuiya-pattern">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-jumuiya-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900">Jumuiya Kiganjani</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-primary-600 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-primary-500 hover:bg-primary-600 transition-colors">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block">Welcome to</span>
                        <span class="block text-primary-600">Jumuiya Kiganjani</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-lg text-gray-600 sm:text-xl md:mt-5 md:max-w-3xl">
                        The complete digital solution for managing your faith community
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Member Management -->
                        <div class="card-jumuiya transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100 text-primary-600 mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Member Directory</h3>
                            <p class="mt-2 text-base text-gray-600 text-center">
                                Track all community members with detailed profiles and family relationships.
                            </p>
                        </div>

                        <!-- Contribution Tracking -->
                        <div class="card-jumuiya transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-100 text-jumuiya-green mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Harambee Tracking</h3>
                            <p class="mt-2 text-base text-gray-600 text-center">
                                Manage all community contributions with transparent reporting.
                            </p>
                        </div>

                        <!-- Event Management -->
                        <div class="card-jumuiya transform transition-all duration-300 hover:scale-105">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-100 text-jumuiya-purple mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 text-center">Event Management</h3>
                            <p class="mt-2 text-base text-gray-600 text-center">
                                Organize Jumuiya meetings and church events with attendance tracking.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="mt-16 text-center">
                    <h2 class="text-2xl font-semibold text-gray-900">Ready to strengthen your community?</h2>
                    <div class="mt-6">
                        <a href="{{ route('register') }}" class="btn-jumuiya inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm">
                            Get Started
                        </a>
                        <a href="/features" class="ml-4 inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col items-center sm:flex-row sm:justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="ml-2 text-sm text-gray-500">Your community data is secure</span>
                    </div>
                    <div class="mt-4 sm:mt-0 text-sm text-gray-500">
                        Jumuiya Connect &copy; {{ date('Y') }} - All rights reserved
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>