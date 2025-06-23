<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Jumuiya Events Report</h2>
    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Status</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->status }}</td>
                    <td>{{ $event->location }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
