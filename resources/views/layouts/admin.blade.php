<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ darkMode: (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) }" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jumuiya Kiganjani') }} - Admin Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- DataTables Styles -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    
    <style>
        :root {
            --color-primary: 165 180 252;
            --color-secondary: 99 102 241;
            --color-text: 249 250 251;
            --color-bg: 17 24 39;
            --color-border: 55 65 81;
        }

        .dataTables_wrapper {
            @apply text-[rgb(var(--color-text))] transition-colors duration-300;
        }

        .dataTables_wrapper .dataTables_filter {
            @apply mb-2 float-left mr-2;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply bg-gray-800 border-gray-700 text-white
                   rounded-lg px-3 py-1.5 w-64 focus:ring-2 focus:ring-[rgb(var(--color-primary))] 
                   transition-all duration-200 placeholder-gray-400;
        }

        .dataTables_wrapper .dataTables_paginate {
            @apply flex items-center gap-1 mt-2 justify-center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-2.5 py-1 rounded-md border-gray-600 text-gray-300
                   hover:bg-[rgba(var(--color-primary),0.1)] transition-colors
                   hover:border-[rgba(var(--color-primary),0.3)] min-w-[2.5rem] text-center
                   text-sm font-medium;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-800/20 text-blue-400 border-blue-600/30 font-semibold;
        }

        .dataTables_wrapper .dataTables_paginate .ellipsis {
            @apply px-1.5 py-1 text-[rgba(var(--color-text),0.5)] font-medium;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" 
      x-init="document.documentElement.classList.toggle('dark', darkMode)">
    
    <div class="min-h-screen">
        @include('admin.partials.navigation', ['showDarkModeToggle' => true])

        <!-- Page Content -->
        <main class="pt-2">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if (session('success'))
                    <div class="mb-3 px-3 py-2 bg-green-100 border border-green-200 text-green-700 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-3 px-3 py-2 bg-red-100 border border-red-200 text-red-700 rounded text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => ({
                darkMode: (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)),
                init() {
                    this.$watch('darkMode', val => {
                        document.documentElement.classList.toggle('dark', val);
                        localStorage.theme = val ? 'dark' : 'light';
                    });
                    document.documentElement.classList.toggle('dark', this.darkMode);
                },
                toggle() {
                    this.darkMode = !this.darkMode;
                }
            }));
        });

        // DataTables Management
        (function() {
            let dataTablesInstances = [];
            
            function initDataTables() {
                document.querySelectorAll('.datatable').forEach(table => {
                    if (!$.fn.DataTable.isDataTable(table)) {
                        const dt = $(table).DataTable({
                            responsive: true,
                            pagingType: "full_numbers",
                            dom: "<'flex justify-between items-center mb-2'<'mr-2'l><'ml-2'f>>" +
                                 "<'overflow-x-auto'tr>" +
                                 "<'flex justify-between items-center mt-2'<'text-sm'i>p>",
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
            
            initDataTables();
            document.addEventListener('livewire:load', initDataTables);
            document.addEventListener('livewire:navigating', () => {
                dataTablesInstances.forEach(dt => dt.destroy());
                dataTablesInstances = [];
            });
        })();
    </script>
</body>
</html>