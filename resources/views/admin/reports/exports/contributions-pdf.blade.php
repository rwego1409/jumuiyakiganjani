<!DOCTYPE html>
<html>
<head>
    <title>Contributions Report</title>
    <style>
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Contributions Report</h1>
        @if($startDate && $endDate)
        <p>Date Range: {{ $startDate }} to {{ $endDate }}</p>
        @endif
        <p>Generated: {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Member</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Payment Method</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contributions as $contribution)
            <tr>
                <td>{{ $contribution->member->name }}</td>
                <td>TZS {{ number_format($contribution->amount) }}</td>
                <td>{{ $contribution->contribution_date->format('M d, Y') }}</td>
                <td>{{ ucfirst($contribution->payment_method) }}</td>
                <td>{{ $contribution->reference_number }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Contributions:</td>
                <td>TZS {{ number_format($contributions->sum('amount')) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>