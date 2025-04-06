<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jumuiya Kiganjani') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Additional dashboard styles -->
    <style>
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .activity-item:hover {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        @include('admin.partials.navigation')

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Jumuiya Kiganjani. All rights reserved.
            </div>
        </footer>
    </div>

    @livewireScripts
    
    <!-- Dashboard-specific scripts -->
    <script>
        // Refresh dashboard data every 60 seconds
        setInterval(() => {
            window.livewire.emit('refreshDashboard');
        }, 60000);
    </script>
</body>
</html>