@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8 p-6 bg-white rounded-lg shadow-md">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Report Details</h1>

        <!-- Report Overview -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Report Overview</h2>
            <div class="text-lg text-gray-600 mt-2">
                <!-- Check if $report is an object and access its properties safely -->
                @if(is_object($report))
                    <p><strong>Report ID:</strong> {{ $report->id ?? 'N/A' }}</p>
                    <p><strong>Report Name:</strong> {{ $report->name ?? 'No name provided' }}</p>
                    <p><strong>Created At:</strong> {{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}</p>
                @elseif(is_array($report))
                    <p><strong>Report ID:</strong> {{ $report['id'] ?? 'N/A' }}</p>
                    <p><strong>Report Name:</strong> {{ $report['name'] ?? 'No name provided' }}</p>
                    <p><strong>Created At:</strong> {{ isset($report['created_at']) ? \Carbon\Carbon::parse($report['created_at'])->format('M d, Y') : 'N/A' }}</p>
                @endif
                <p><strong>Description:</strong> {{ $report->description ?? 'No description provided' }}</p>
            </div>
        </div>

        <!-- Report Data Table (if any) -->
        <div class="mb-4">
            <h3 class="text-xl font-semibold text-gray-700">Report Data</h3>
            @if(!is_object($report) || (is_object($report) && $report->members->isEmpty()) || (is_array($report) && empty($report['members'])))
                <p class="text-gray-600">No members found for this report.</p>
            @else
                <table class="min-w-full table-auto mt-4">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left text-gray-600">#</th>
                            <th class="py-2 px-4 text-left text-gray-600">Member Name</th>
                            <th class="py-2 px-4 text-left text-gray-600">Contribution Amount</th>
                            <th class="py-2 px-4 text-left text-gray-600">Event Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->members ?? [] as $index => $member)
                            <tr class="border-b">
                                <td class="py-2 px-4 text-gray-700">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 text-gray-700">{{ $member->name }}</td>
                                <td class="py-2 px-4 text-gray-700">{{ $member->pivot->amount ?? 'N/A' }}</td>
                                <td class="py-2 px-4 text-gray-700">
                                    {{ $member->pivot->event_date ? \Carbon\Carbon::parse($member->pivot->event_date)->format('M d, Y') : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- PDF and Excel Export Buttons -->
        <div class="flex justify-between items-center">
            <a href="{{ route('reports.export', [
                    'id' => optional($report)->id, // Safely retrieve the ID using optional()
                    'format' => 'pdf'
                ]) }}"
               class="bg-primary-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-700 transition duration-200">
               Export as PDF
            </a>
            <a href="{{ route('reports.export', [
                    'id' => optional($report)->id, // Safely retrieve the ID using optional()
                    'format' => 'excel'
                ]) }}"
               class="bg-primary-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-700 transition duration-200">
               Export as Excel
            </a>
        </div>
    </div>
@endsection
