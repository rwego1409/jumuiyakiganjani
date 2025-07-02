@extends('layouts.chairperson')
@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">All Member Contributions (Cash & Digital)</h2>
    
    <div class="mt-6 flex justify-end mb-4">
        <a href="{{ route('chairperson.contributions.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg font-semibold shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
            <i class="fas fa-plus mr-2"></i> Record Cash Contribution
        </a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Member</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contributions as $contribution)
                <tr>
                    <td class="px-4 py-2">{{ $contribution->contribution_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $contribution->member->user->name }}</td>
                    <td class="px-4 py-2">TZS {{ number_format($contribution->amount, 2) }}</td>
                    <td class="px-4 py-2">{{ ucfirst($contribution->payment_method) }}</td>
                    <td class="px-4 py-2">
                        @if($contribution->status == 'confirmed')
                            <span class="status-completed">Confirmed</span>
                        @elseif($contribution->status == 'pending')
                            <span class="status-pending">Pending</span>
                        @else
                            <span class="status-failed">Rejected</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3">
            {{ $contributions->links() }}
        </div>
    </div>
</div>
@endsection
