@extends('layouts.admin')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 px-4">
        <div class="bg-white shadow-md rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-gray-900 bg-gradient-to-r from-indigo-600 to-blue-500 bg-clip-text text-transparent">
                        Generate Contributions Report
                    </h1>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.reports.generate') }}" method="GET" class="space-y-6">
                    @csrf
                    
                    <!-- Date Range Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date
                            </label>
                            <input type="date" name="start_date" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                End Date
                            </label>
                            <input type="date" name="end_date" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>
                    </div>

                    <!-- Report Format Selection -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Select Report Format
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="format" value="pdf" class="h-4 w-4 text-indigo-600" checked>
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-gray-700">PDF Format</span>
                                    <span class="block text-sm text-gray-500">Best for printing</span>
                                </span>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="format" value="excel" class="h-4 w-4 text-indigo-600">
                                <span class="ml-3">
                                    <span class="block text-sm font-medium text-gray-700">Excel Format</span>
                                    <span class="block text-sm text-gray-500">Best for data analysis</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Submission Button -->
                    <div class="mt-8">
                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition-colors flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection