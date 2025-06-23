<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resources Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Jumuiya Resources Report</h2>
    <table>
        <thead>
            <tr>
                <th>Resource Name</th>
                <th>Type</th>
                <th>Status</th>
                <th>Issued To</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
                <tr>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->type }}</td>
                    <td>{{ $resource->status }}</td>
                    <td>{{ $resource->issued_to ? $resource->issued_to->name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
