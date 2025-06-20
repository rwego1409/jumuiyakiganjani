<!DOCTYPE html>
<html>
<head>    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            padding: 0;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">        <h1>{{ $title }}</h1>
    </div>

    <div class="info">
        <p><strong>Jumuiya:</strong> {{ $jumuiya->name }}</p>
        <p><strong>Generated:</strong> {{ now()->format('F d, Y h:i A') }}</p>
        @if($startDate || $endDate)
            <p><strong>Period:</strong> 
                {{ $startDate ? $startDate->format('M d, Y') : 'All' }} 
                to 
                {{ $endDate ? $endDate->format('M d, Y') : 'Present' }}
            </p>
        @endif

        @if(!empty($stats))
            <div class="stats">
                @foreach($stats as $key => $value)
                    @if(is_array($value))
                        <p><strong>{{ Str::title(str_replace('_', ' ', $key)) }}:</strong></p>
                        <ul>
                            @foreach($value as $subKey => $subValue)
                                <li>{{ Str::title($subKey) }}: {{ $subValue }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p><strong>{{ Str::title(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>            @if(!empty($data))
                @foreach($data as $row)
                    <tr>
                        @foreach($row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="{{ count($headers) }}" style="text-align: center;">No data found</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>Generated from Jumuiya Kiganjani System</p>
        <p>{{ now()->format('Y') }} © All Rights Reserved</p>
    </div>
</body>
</html>
