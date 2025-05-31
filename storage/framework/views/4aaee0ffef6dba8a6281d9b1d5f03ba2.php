<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Jumuiya')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        
        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" x-init="darkMode = localStorage.getItem('darkMode') === 'true'">
        <div class="min-h-screen">
            <?php echo $__env->make('layouts.navigation.chairperson', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- Page Content -->
            <main class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <?php if(session('success')): ?>
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-200 text-green-700 rounded">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-200 text-red-700 rounded">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>

        <?php echo $__env->yieldPushContent('scripts'); ?>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('darkMode', () => ({
                    darkMode: false,
                    init() {
                        this.darkMode = localStorage.getItem('darkMode') === 'true';
                        this.$watch('darkMode', val => localStorage.setItem('darkMode', val))
                    }
                }))
            });
        </script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/layouts/chairperson.blade.php ENDPATH**/ ?>