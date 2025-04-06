<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Page Not Found
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <!-- Error icon -->
                    <div class="mx-auto h-24 w-24 text-red-500 dark:text-red-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <!-- Error title -->
                    <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-4">404</h1>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Page Not Found</h2>
                    
                    <!-- Error message -->
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                        The page you're looking for doesn't exist or has been moved.
                    </p>
                    
                    <!-- Action buttons -->
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ url('/') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition-colors duration-200">
                            Return to Homepage
                        </a>
                        <a href="javascript:history.back()" class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            Go Back
                        </a>
                    </div>
                    
                    <!-- Additional help -->
                    <div class="mt-10 text-sm text-gray-500 dark:text-gray-400">
                        <p>If you believe this is an error, please <a href="mailto:support@example.com" class="text-blue-600 dark:text-blue-400 hover:underline">contact support</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>