@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-4">Financial Report</h2>

                <div class="mb-8">
                    <form action="{{ route('admin.reports.financial') }}" method="GET" class="space-y-4">
                        <!-- Date Range Picker -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <button type="submit" name="format" value="pdf" class="btn-primary">
                                Generate PDF
                            </button>
                            <button type="submit" name="format" value="excel" class="btn-secondary">
                                Export Excel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Financial Summary -->
                @if(isset($summary))
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded shadow">
                                <div class="text-sm text-gray-500">Total Income</div>
                                <div class="text-2xl font-bold">TZS {{ number_format($summary->total_income) }}</div>
                            </div>
                            <div class="bg-white p-4 rounded shadow">
                                <div class="text-sm text-gray-500">Total Expenses</div>
                                <div class="text-2xl font-bold">TZS {{ number_format($summary->total_expenses) }}</div>
                            </div>
                            <div class="bg-white p-4 rounded shadow">
                                <div class="text-sm text-gray-500">Net Balance</div>
                                <div class="text-2xl font-bold">TZS {{ number_format($summary->net_balance) }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection