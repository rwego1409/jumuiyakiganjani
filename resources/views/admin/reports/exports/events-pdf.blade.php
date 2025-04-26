{{-- resources/views/admin/reports/exports/events-pdf.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .report-table th {
            background-color: #f4f4f4;
        }
        .stats-box {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
        }
    </style>
</head>
<body>

    <div class="report-header">
        <h1>Events Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        @if($startDate && $endDate)
            <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        @endif
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Event Title</th>
                <th>Date</th>
                <th>Location</th>
                <th>Attendees</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->start_time->format('M d, Y H:i') }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->attendees_count }}</td>
                    <td>{{ ucfirst($event->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="stats-box">
        <h3>Summary Statistics</h3>
        <p>Total Events: {{ $events->count() }}</p>
        <p>Total Attendees: {{ $events->sum('attendees_count') }}</p>
        <p>Average Attendance: {{ round($events->avg('attendees_count'), 2) }}</p>
    </div>

</body>
</html>
