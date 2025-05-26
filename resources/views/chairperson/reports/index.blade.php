@extends('layouts.chairperson')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Reports') }}
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Members Report Card -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('Members Report') }}
                    </h3>
                    <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('Generate detailed reports about members, including their status and contributions.') }}
                </p>
                <div class="space-y-4">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'members', 'format' => 'pdf']) }}" 
                       class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'members', 'format' => 'xlsx']) }}" 
                       class="inline-flex items-center text-sm text-green-600 hover:text-green-700">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Events Report Card -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('Events Report') }}
                    </h3>
                    <i class="fas fa-calendar text-2xl text-purple-500"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('Generate reports about events, including attendance and status.') }}
                </p>
                <div class="space-y-4">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'events', 'format' => 'pdf']) }}" 
                       class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'events', 'format' => 'xlsx']) }}" 
                       class="inline-flex items-center text-sm text-green-600 hover:text-green-700">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Resources Report Card -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('Resources Report') }}
                    </h3>
                    <i class="fas fa-book text-2xl text-yellow-500"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('Generate reports about resources usage and status.') }}
                </p>
                <div class="space-y-4">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'resources', 'format' => 'pdf']) }}" 
                       class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'resources', 'format' => 'xlsx']) }}" 
                       class="inline-flex items-center text-sm text-green-600 hover:text-green-700">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Report Generator -->
    <div class="mt-8 bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('Custom Report') }}
            </h3>
            <form action="{{ route('chairperson.reports.generate', ['type' => 'members']) }}" method="GET" class="space-y-6" id="reportForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Report Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Report Type') }}
                        </label>
                        <select name="type" id="type" required
                                onchange="updateFormAction(this.value)"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="">{{ __('Select Type') }}</option>
                            <option value="members">{{ __('Members') }}</option>
                            <option value="events">{{ __('Events') }}</option>
                            <option value="resources">{{ __('Resources') }}</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Start Date') }}
                        </label>
                        <input type="date" name="start_date" id="start_date"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('End Date') }}
                        </label>
                        <input type="date" name="end_date" id="end_date"
                               class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Format -->
                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Format') }}
                        </label>
                        <select name="format" id="format" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="pdf">{{ __('PDF') }}</option>
                            <option value="xlsx">{{ __('Excel') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                        <i class="fas fa-download mr-2"></i>{{ __('Generate Report') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
