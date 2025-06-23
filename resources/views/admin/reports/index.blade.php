@extends('layouts.admin')

@section('content')
<div class="py-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-blue-900 dark:via-gray-800 dark:to-blue-900 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Header Section -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                    <div class="flex items-center mb-6 sm:mb-0">
                        <svg class="h-8 w-8 text-blue-500 dark:text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 4h6a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-blue-900 dark:text-blue-100">Reports</h2>
                    </div>
                </div>
                <!-- End Header Section -->

                <!-- Reports Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <a href="{{ route('admin.reports.generate', ['type' => 'members', 'format' => 'pdf']) }}" 
                       class="p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-xs sm:text-sm">
                        <h3 class="font-semibold text-base sm:text-lg text-blue-900 dark:text-blue-100">Members Report</h3>
                        <p class="text-gray-600 dark:text-gray-400">Generate members list report</p>
                    </a>
                    <a href="{{ route('admin.reports.generate', ['type' => 'contributions', 'format' => 'pdf']) }}" 
                       class="p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-xs sm:text-sm">
                        <h3 class="font-semibold text-base sm:text-lg text-blue-900 dark:text-blue-100">Contributions Report</h3>
                        <p class="text-gray-600 dark:text-gray-400">Generate contributions report</p>
                    </a>
                </div>
                <!-- End Reports Section -->
            </div>
        </div>
    </div>
</div>
@endsection