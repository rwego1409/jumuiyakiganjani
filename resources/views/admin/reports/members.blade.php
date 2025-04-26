<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Members Report</h1>
    <p>Generated: {{ now()->format('Y-m-d H:i:s') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Jumuiya</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $member)
            <tr>
                <td>{{ $member->user->name }}</td>
                <td>{{ $member->phone }}</td>
                <td>{{ $member->jumuiya->name }}</td>
                <td>{{ $member->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
