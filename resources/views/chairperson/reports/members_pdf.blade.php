<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Members Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Jumuiya Members Report</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Jumuiya</th>
                <th>Joined Date</th>
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
                    <td>{{ $member->created_at->format('Y-m-d') }}</td>
                    <td>{{ $member->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
