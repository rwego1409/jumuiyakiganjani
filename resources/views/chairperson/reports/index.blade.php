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
                <div class="space-y-3">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'members', 'format' => 'pdf']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors duration-200">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'members', 'format' => 'xlsx']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors duration-200">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'members', 'format' => 'csv']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors duration-200">
                        <i class="fas fa-file-csv mr-2"></i>{{ __('Download CSV') }}
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
                <div class="space-y-3">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'events', 'format' => 'pdf']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors duration-200">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'events', 'format' => 'xlsx']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors duration-200">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'events', 'format' => 'csv']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors duration-200">
                        <i class="fas fa-file-csv mr-2"></i>{{ __('Download CSV') }}
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
                <div class="space-y-3">
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'resources', 'format' => 'pdf']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-red-50 text-red-600 hover:bg-red-100 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 transition-colors duration-200">
                        <i class="fas fa-file-pdf mr-2"></i>{{ __('Download PDF') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'resources', 'format' => 'xlsx']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 transition-colors duration-200">
                        <i class="fas fa-file-excel mr-2"></i>{{ __('Download Excel') }}
                    </a>
                    <a href="{{ route('chairperson.reports.generate', ['type' => 'resources', 'format' => 'csv']) }}"
                       class="block w-full py-2 px-4 text-sm text-center rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-colors duration-200">
                        <i class="fas fa-file-csv mr-2"></i>{{ __('Download CSV') }}
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
            <form action="{{ url('chairperson/reports/generate/members/pdf') }}" method="GET" class="space-y-6" id="reportForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Report Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Report Type') }}
                        </label>
                        <select name="type" id="type" required
                                onchange="updateFormAction()"
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
                                onchange="updateFormAction()"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 
                                       dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500">
                            <option value="pdf">{{ __('PDF') }}</option>
                            <option value="xlsx">{{ __('Excel') }}</option>
                            <option value="csv">{{ __('CSV') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" id="submitBtn"
                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md" disabled>
                        <i class="fas fa-download mr-2"></i>{{ __('Generate Report') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateFormAction() {
    var form = document.getElementById('reportForm');
    var submitBtn = document.getElementById('submitBtn');
    var type = document.getElementById('type').value;
    var format = document.getElementById('format').value;
    if (type && format) {
        form.action = "{{ url('chairperson/reports/generate') }}/" + type + "/" + format;
        submitBtn.disabled = false;
    } else {
        form.action = "#";
        submitBtn.disabled = true;
    }
}
window.addEventListener('DOMContentLoaded', function() {
    updateFormAction();
});
</script>
@endpush
