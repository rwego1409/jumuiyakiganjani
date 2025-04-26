<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jumuiya Kiganjani') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- DataTables Styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    
    <style>
        :root {
            --color-primary: 79 70 229;
            --color-secondary: 99 102 241;
            --color-text: 17 24 39;
            --color-bg: 255 255 255;
            --color-border: 229 231 235;
        }

        .dark {
            --color-text: 249 250 251;
            --color-bg: 17 24 39;
            --color-border: 55 65 81;
            --color-primary: 165 180 252;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            @apply text-[rgb(var(--color-text))] transition-colors duration-300;
        }

        /* Search Input Styling */
        .dataTables_wrapper .dataTables_filter {
            @apply mb-4 float-left mr-4;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply bg-[rgb(var(--color-bg))] border border-[rgb(var(--color-border))] 
                   rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-[rgb(var(--color-primary))] 
                   transition-all duration-200 dark:placeholder-gray-400;
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_paginate {
            @apply flex items-center gap-1.5 mt-4 justify-center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3.5 py-1.5 rounded-md border border-[rgb(var(--color-border))] 
                   hover:bg-[rgba(var(--color-primary),0.1)] transition-colors
                   hover:border-[rgba(var(--color-primary),0.3)] min-w-[2.75rem] text-center
                   text-sm font-medium text-[rgb(var(--color-text))];
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-[rgba(var(--color-primary),0.2)] border-[rgba(var(--color-primary),0.3)] 
                   text-[rgb(var(--color-primary))] font-semibold;
        }

        .dataTables_wrapper .dataTables_paginate .ellipsis {
            @apply px-2 py-1 text-[rgba(var(--color-text),0.5)] font-medium;
        }

        /* Dark Mode Overrides */
        .dark .dataTables_wrapper .dataTables_filter input {
            @apply bg-gray-800 border-gray-700 text-white;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply border-gray-600 text-gray-300;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-800/20 text-blue-400 border-blue-600/30;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[rgb(var(--color-bg))] text-[rgb(var(--color-text))] transition-colors duration-300">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('admin.partials.navigation')

        <!-- Theme Toggle -->
        <div class="border-b border-[rgb(var(--color-border))]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex justify-end">
                <button id="themeToggle" class="p-2 rounded-lg hover:bg-[rgba(var(--color-primary),0.1)] transition-colors">
                    <span class="sr-only">Toggle theme</span>
                    <svg class="hidden dark:block w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                    </svg>
                    <svg class="block dark:hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            @if (isset($header))
                <header class="border-b border-[rgb(var(--color-border))]">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1">
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="border-t border-[rgb(var(--color-border))] mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-sm text-[rgba(var(--color-text),0.7)]">
                &copy; {{ date('Y') }} {{ config('app.name', 'Jumuiya Kiganjani') }}. All rights reserved.
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @livewireScripts

    <script>
        // Theme Management
        (function() {
            const html = document.documentElement;
            const themeKey = 'theme';
            
            function initTheme() {
                const savedTheme = localStorage.getItem(themeKey);
                const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
                    html.classList.add('dark');
                }
            }
            
            document.getElementById('themeToggle').addEventListener('click', () => {
                html.classList.toggle('dark');
                localStorage.setItem(themeKey, html.classList.contains('dark') ? 'dark' : 'light');
                refreshDataTables();
            });
            
            initTheme();
        })();

        // DataTables Management
        (function() {
            let dataTablesInstances = [];
            
            function initDataTables() {
                document.querySelectorAll('.datatable').forEach(table => {
                    if (!$.fn.DataTable.isDataTable(table)) {
                        const dt = $(table).DataTable({
                            responsive: true,
                            pagingType: "full_numbers",
                            dom: "<'flex justify-between items-center mb-4'<'mr-4'l><'ml-4'f>>" +
                                 "<'overflow-x-auto'tr>" +
                                 "<'flex justify-between items-center mt-4'<'text-sm'i>p>",
                            language: {
                                search: "",
                                searchPlaceholder: "Search records...",
                                lengthMenu: "Show _MENU_ entries",
                                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                paginate: {
                                    previous: "‹ Prev",
                                    next: "Next ›",
                                    first: "«",
                                    last: "»"
                                }
                            }
                        });
                        dataTablesInstances.push(dt);
                    }
                });
            }
            
            function refreshDataTables() {
                dataTablesInstances.forEach(dt => {
                    dt.destroy();
                    $(dt.table().node()).removeAttr('style').removeData();
                });
                dataTablesInstances = [];
                initDataTables();
            }
            
            initDataTables();
            document.addEventListener('livewire:load', initDataTables);
            document.addEventListener('livewire:navigating', () => {
                dataTablesInstances.forEach(dt => dt.destroy());
                dataTablesInstances = [];
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>