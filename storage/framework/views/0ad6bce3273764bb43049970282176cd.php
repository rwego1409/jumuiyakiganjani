<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#ffffff" class="dark:content-[#1a1a1a]">

    <!-- <title>Jumuiya Kiganjani - <?php echo e($title ?? 'Community Management'); ?></title> -->

    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .bg-jumuiya-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zM7 40c0-3.866-3.134-7-7-7s-7 3.134-7 7 3.134 7 7 7 7-3.134 7-7zm-5-15c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40-8c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zm18 24c0-4.418-3.582-8-8-8s-8 3.582-8 8 3.582 8 8 8 8-3.582 8-8zM11 38c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8-3.582-8-8-8zm38-8c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7z' fill='%230ea5e9' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>

    <script>
        // Alpine.js dark mode sync
        document.addEventListener('alpine:init', () => {
            Alpine.data('darkMode', () => ({
                darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
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
    </script>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <div class="min-h-full">
        <!-- Role-based Navigation (fixed at top) -->
        <div class="fixed w-full z-30 top-0 left-0">
            <?php if(auth()->guard()->check()): ?>
               
                    <?php echo $__env->make('super_admin.partials.navigation', ['showDarkModeToggle' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <?php endif; ?>
        </div>
        <!-- Add top padding to main content to prevent overlap with fixed navbar -->
        <main class="py-6 transition-colors duration-300 pt-24 min-h-[calc(100vh-6rem-5.5rem)]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-green-700 font-medium"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-red-500 mr-3" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-700 font-medium"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <!-- Footer -->
        <!-- <footer class="bg-white border-t border-gray-200 dark:border-gray-700 mt-auto w-full fixed bottom-0 left-0 z-20 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex items-center justify-center md:justify-start">
                        <svg class="h-8 w-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-2 text-xl font-semibold text-gray-900 dark:text-gray-100">Jumuiya Kiganjani</span>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 md:text-right">
                            &copy; <?php echo e(date('Y')); ?> Jumuiya Kiganjani. All rights reserved.
                        </p>
                        <div class="flex items-center justify-center md:justify-end mt-2">
                            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500 mr-1" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Your community data is secure</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer> -->
        <!-- End Sticky Footer -->
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/layouts/app.blade.php ENDPATH**/ ?>