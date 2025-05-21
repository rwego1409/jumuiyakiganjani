<!DOCTYPE html>
<html>
<head>
    <title>Ripoti ya Matukio</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
        th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Ripoti ya Matukio ya Jumuiya</h1>
    
    <p>
        Kipindi cha Ripoti: <strong>{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}</strong> hadi 
        <strong>{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}</strong>
    </p>

    <p>Imetengenezwa na: <strong>ADMIN</strong></p>
    <p>Tarehe ya Kutengeneza: <strong>{{ now()->format('Y-m-d H:i:s') }}</strong></p>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Jina la Tukio</th>
                <th>Jumuiya</th>
                <th>Tarehe</th>
                <th>Idadi ya Washiriki</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $index => $event)
                <tr>
                    <td>{{ $index + 1 }}</td>
                   <td>{{ $event->title }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->jumuiya->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}</td>
                    <td>{{ $event->attendees->count() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Hakuna matukio yaliyopatikana kwa kipindi hiki.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
