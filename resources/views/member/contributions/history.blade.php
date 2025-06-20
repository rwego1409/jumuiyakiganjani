@extends('layouts.member')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Contribution History</h1>
        <div class="mb-4">
            <strong>Contribution ID:</strong> {{ $contribution->id }}<br>
            <strong>Amount:</strong> {{ number_format($contribution->amount, 2) }}<br>
            <strong>Date:</strong> {{ $contribution->contribution_date ? $contribution->contribution_date->format('F j, Y') : '-' }}<br>
            <strong>Status:</strong> {{ ucfirst($contribution->status) }}<br>
            <strong>Jumuiya:</strong> {{ $contribution->jumuiya->name ?? '-' }}<br>
            <strong>Recorded By:</strong> {{ $contribution->user->name ?? '-' }}<br>
            <strong>Purpose:</strong> {{ $contribution->purpose ?? '-' }}<br>
            <strong>Receipt Number:</strong> {{ $contribution->receipt_number ?? '-' }}<br>
        </div>
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Payment Progress</h2>
            @php
                $totalPaid = $contribution->payments->sum('amount');
                $progress = $contribution->amount > 0 ? min(100, round(($totalPaid / $contribution->amount) * 100, 2)) : 0;
                $balance = $contribution->amount - $totalPaid;
            @endphp
            <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $progress }}%"></div>
            </div>
            <div class="flex justify-between text-sm">
                <span>Paid: {{ number_format($totalPaid, 2) }} TZS</span>
                <span>Total: {{ number_format($contribution->amount, 2) }} TZS</span>
                <span>Balance: {{ number_format($balance, 2) }} TZS</span>
                <span>{{ $progress }}% Complete</span>
            </div>
        </div>
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Payment History</h2>
            @if($contribution->payments->isEmpty())
                <p class="text-gray-500">No payments made yet.</p>
            @else
                <table class="min-w-full text-sm border">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-4 py-2">Date</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Method</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contribution->payments as $payment)
                        <tr>
                            <td class="px-4 py-2">{{ $payment->created_at->format('F j, Y') }}</td>
                            <td class="px-4 py-2">{{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-2">{{ ucfirst($payment->payment_method) }}</td>
                            <td class="px-4 py-2">{{ ucfirst($payment->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <a href="{{ route('member.contributions.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">&larr; Back to Contributions</a>
    </div>
</div>
@endsection
