<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        /* Add your PDF styling here */
        .report-header { text-align: center; margin-bottom: 30px; }
        .report-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .report-table th, .report-table td { border: 1px solid #ddd; padding: 8px; }
        .report-table th { background-color: #f4f4f4; }
        .stats-box { margin-top: 20px; padding: 15px; background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="report-header">
        <h1>{{ $title }}</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        @if(isset($startDate) && isset($endDate))
            <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        @endif
    </div>

    @isset($stats)
    <div class="stats-box">
        <h3>Summary</h3>
        @foreach($stats as $key => $value)
            <p><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
        @endforeach
    </div>
    @endisset

    <table class="report-table">
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
