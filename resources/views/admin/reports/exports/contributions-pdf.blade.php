<!DOCTYPE html>
<html>
<head>
    <title>Contributions Report</title>
    <style>
        .report-header { text-align: center; margin-bottom: 30px; }
        .report-table { width: 100%; border-collapse: collapse; }
        .report-table th, .report-table td { border: 1px solid #ddd; padding: 8px; }
        .report-table th { background-color: #f4f4f4; }
        .summary-box { margin-top: 20px; padding: 15px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>Contributions Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contributions as $contribution)
                <tr>
                    <td>{{ $contribution->member->user->name }}</td>
                    <td>TZS {{ number_format($contribution->amount) }}</td>
                    <td>{{ ucfirst($contribution->payment_method) }}</td>
                    <td>{{ $contribution->created_at->format('M d, Y') }}</td>
                    <td>{{ ucfirst($contribution->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <h3>Summary</h3>
        <p>Total Contributions: {{ $contributions->count() }}</p>
        <p>Total Amount: TZS {{ number_format($contributions->sum('amount')) }}</p>
        <p>Average Contribution: TZS {{ number_format($contributions->avg('amount')) }}</p>
    </div>
</body>
</html>