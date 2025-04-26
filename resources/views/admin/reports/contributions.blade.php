<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contributions Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .total { font-weight: bold; background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Contributions Report</h1>
    <p>Generated: {{ now()->format('Y-m-d H:i:s') }}</p>
    @if(request('start_date') || request('end_date'))
        <p>Period: {{ request('start_date', 'All time') }} to {{ request('end_date', 'Present') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Member</th>
                <th>Amount (TZS)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $contribution)
            <tr>
                <td>{{ $contribution->created_at->format('Y-m-d') }}</td>
                <td>
    {{ $contribution->member && $contribution->member->user ? $contribution->member->user->name : 'N/A' }}
</td>

                <td>{{ number_format($contribution->amount, 2) }}</td>
                <td>{{ $contribution->status }}</td>
            </tr>
            @endforeach
            <tr class="total">
                <td colspan="2">Total</td>
                <td colspan="2">{{ number_format($data->sum('amount'), 2) }} TZS</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
