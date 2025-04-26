<!DOCTYPE html>
<html>
<head>
    <title>Members Report</title>
    <style>
        /* Add your PDF styling here */
        .report-header { text-align: center; margin-bottom: 30px; }
        .report-table { width: 100%; border-collapse: collapse; }
        .report-table th, .report-table td { border: 1px solid #ddd; padding: 8px; }
        .report-table th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>Members Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Jumuiya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->user->name }}</td>
                    <td>{{ $member->user->email }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>{{ $member->jumuiya->name }}</td>
                    <td>{{ $member->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="report-summary">
        <h3>Summary</h3>
        <p>Total Members: {{ $members->count() }}</p>
        <p>Active Members: {{ $members->where('status', 'active')->count() }}</p>
    </div>
</body>
</html>