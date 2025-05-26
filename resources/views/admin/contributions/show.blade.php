@extends('layouts.admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Contribution Details</h2>
                    <div class="space-x-4">
                        <a href="{{ route('admin.contributions.edit', $contribution) }}" class="btn-primary">
                            Edit Contribution
                        </a>
                        <form action="{{ route('admin.contributions.sendNotification', $contribution) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="btn-success">
                                Send Reminder
                            </button>
                        </form>
                        <div class="inline-block relative">
                            <button type="button" class="btn-secondary" onclick="toggleExportDropdown()">
                                Export
                            </button>
                            <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ route('admin.contributions.export.pdf', ['id' => $contribution->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export as PDF</a>
                                    <a href="{{ route('admin.contributions.export.excel', ['id' => $contribution->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export as Excel</a>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.contributions.index') }}" class="btn-secondary">
                            Back to List
                        </a>
                    </div>
                </div>

                @push('scripts')
                <script>
                    function toggleExportDropdown() {
                        const dropdown = document.getElementById('exportDropdown');
                        dropdown.classList.toggle('hidden');
                    }

                    // Close dropdown when clicking outside
                    window.addEventListener('click', function(e) {
                        const dropdown = document.getElementById('exportDropdown');
                        if (!e.target.closest('.relative') && !dropdown.classList.contains('hidden')) {
                            dropdown.classList.add('hidden');
                        }
                    });
                </script>
                @endpush

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Contribution Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->member->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount</dt>
                                <dd class="mt-1 text-gray-900">TZS {{ number_format($contribution->amount) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->contribution_date->format('M d, Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium mb-4">Payment Details</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                                <dd class="mt-1 text-gray-900">{{ ucfirst($contribution->payment_method) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Purpose</dt>
                                <dd class="mt-1 text-gray-900">{{ $contribution->purpose ?? 'General Contribution' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mt-6">Scheduled Reminders</h3>
                @if($contribution->notifications && $contribution->notifications->isNotEmpty())
    <ul class="mt-4 space-y-2">
        @foreach($contribution->notifications as $notification)
            <li class="flex justify-between items-center bg-gray-50 p-4 rounded-lg shadow">
                <span class="text-sm text-gray-700">
                    Reminder scheduled for {{ $notification->reminder_date->format('M d, Y h:i A') }}
                </span>
                <span class="text-xs font-medium {{ $notification->status === 'sent' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($notification->status) }}
                </span>
            </li>
        @endforeach
    </ul>
@else
    <p class="text-sm text-gray-500">No reminders scheduled for this contribution.</p>
@endif
         <a href="{{ route('admin.contributions.scheduleReminder', $contribution) }}" 
                   class="mt-4 inline-block text-sm text-indigo-600 hover:text-indigo-800">
                    Schedule a new reminder →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection