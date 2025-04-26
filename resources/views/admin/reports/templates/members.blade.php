<!DOCTYPE html>
<html>
<head>
    <title>Members Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Members Report</h1>
    <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Jumuiya</th>
                <th>Join Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $member)
            <tr>
                <td>{{ $member->user->name }}</td>
                <td>{{ $member->phone ?? $member->user->phone }}</td>
                <td>{{ $member->jumuiya->name }}</td>
                <td>{{ $member->joined_date }}</td>
                <td>{{ $member->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
