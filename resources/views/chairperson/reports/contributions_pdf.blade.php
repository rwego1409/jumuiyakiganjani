<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contributions Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Contributions Report</h2>
    <table>
        <thead>
            <tr>
                <th>Member Name</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th>Status</th>
                <th>Transaction ID</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contributions as $contribution)
            <tr>
                <td>{{ $contribution->member->user->name ?? '-' }}</td>
                <td>{{ number_format($contribution->amount, 2) }}</td>
                <td>{{ ucfirst($contribution->payment_method) }}</td>
                <td>{{ $contribution->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ ucfirst($contribution->status) }}</td>
                <td>{{ $contribution->transaction_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
