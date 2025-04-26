@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-4">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Reports</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.reports.generate', ['type' => 'members', 'format' => 'pdf']) }}" 
               class="p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <h3 class="font-semibold text-lg">Members Report</h3>
                <p class="text-gray-600 dark:text-gray-400">Generate members list report</p>
            </a>

            <a href="{{ route('admin.reports.generate', ['type' => 'contributions', 'format' => 'pdf']) }}" 
               class="p-4 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                <h3 class="font-semibold text-lg">Contributions Report</h3>
                <p class="text-gray-600 dark:text-gray-400">Generate contributions report</p>
            </a>
        </div>
    </div>
</div>
@endsection