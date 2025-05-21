<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ripoti ya Michango ya Jumuiya ya Kanisa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #6c584c;
            padding-bottom: 20px;
        }
        .church-name {
            color: #6c584c;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 22px;
            color: #86643b;
            margin-bottom: 15px;
        }
        .date-period {
            font-style: italic;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f0e6d9;
            color: #6c584c;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f5f0;
        }
        .total {
            font-weight: bold;
            background-color: #e6dfd3;
        }
        .section {
            margin: 30px 0;
        }
        .section-title {
            color: #86643b;
            border-bottom: 1px solid #e6dfd3;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .summary-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-item {
            flex-basis: 30%;
            text-align: center;
            padding: 15px;
            background-color: #f0e6d9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .summary-label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #6c584c;
        }
        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #86643b;
        }
        .explanation {
            background-color: #f9f5f0;
            padding: 15px;
            border-left: 4px solid #86643b;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #e6dfd3;
            padding-top: 20px;
        }
        .status-pending {
            color: #e67e22;
        }
        .status-confirmed {
            color: #27ae60;
        }
        .status-rejected {
            color: #e74c3c;
        }
        .download-options {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
        }
        .download-btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #6c584c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .download-btn:hover {
            background-color: #86643b;
        }
        .download-btn i {
            margin-right: 5px;
        }
        .excel-btn {
            background-color: #1D6F42;
        }
        .csv-btn {
            background-color: #8C8C8C;
        }
        .pdf-btn {
            background-color: #F40F02;
        }
    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="church-name">Kanisa la Mtakatifu Yohana</div>
            <div class="report-title">Ripoti ya Michango ya Fedha</div>
            <div class="date-period">Tarehe: {{ now()->format('d M, Y') }}</div>
            @if(request('start_date') || request('end_date'))
                <div class="date-period">Kipindi: {{ request('start_date', 'Mwanzo') }} hadi {{ request('end_date', 'Sasa') }}</div>
            @else
                <div class="date-period">Kipindi: Zote</div>
            @endif
        </div>


        <div class="summary-box">
            <div class="summary-item">
                <div class="summary-label">Jumla ya Michango</div>
                <div class="summary-value">TZS {{ number_format($data->sum('amount'), 2) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Wanajumuiya Waliochangia</div>
                <div class="summary-value">{{ $data->pluck('member_id')->unique()->count() }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Wastani wa Michango</div>
                <div class="summary-value">TZS {{ number_format($data->count() > 0 ? $data->sum('amount') / $data->count() : 0, 2) }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Muhtasari wa Ripoti</div>
            <div class="explanation">
                <p>Ndugu Wakristo Wapendwa,</p>
                <p>Ripoti hii inaonyesha michango yote ya fedha iliyofanywa na wanajumuiya wetu. Kama sehemu ya uwazi na uwajibikaji katika usimamizi wa fedha za kanisa, tunashirikisha taarifa hii na jumuiya nzima. Michango hii itatumika katika miradi mbalimbali ya maendeleo ya kanisa letu kama ilivyopitishwa na kamati ya fedha na baraza la kanisa.</p>
                <p>Tunawashukuru wote waliochangia kwa moyo na kutumia rasilimali zao kusaidia kazi ya Mungu na kuendeleza jamii yetu.</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Orodha ya Michango</div>
            <table>
                <thead>
                    <tr>
                        <th>Tarehe</th>
                        <th>Mwanajumuiya</th>
                        <th>Kiasi (TZS)</th>
                        <!-- <th>Hali</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $contribution)
                    <tr>
                        <td>{{ $contribution->created_at->format('Y-m-d') }}</td>
                        <td>{{ $contribution->member && $contribution->member->user ? $contribution->member->user->name : 'Haijulikani' }}</td>
                        <td>{{ number_format($contribution->amount, 2) }}</td>
                        <!-- <td class="status-{{ strtolower($contribution->status) }}">
                            @if($contribution->status == 'confirmed')
                                Imethibitishwa
                            @elseif($contribution->status == 'pending')
                                Inasubiri
                            @elseif($contribution->status == 'rejected')
                                Imekataliwa
                            @else
                                {{ $contribution->status }}
                            @endif
                        </td> -->
                    </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="2">Jumla</td>
                        <td colspan="2">{{ number_format($data->sum('amount'), 2) }} TZS</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Maelezo ya Hali za Michango</div>
            <div class="explanation">
                <p><strong>Imethibitishwa</strong>: Michango ambayo imekamilika na kuthibitishwa na mhasibu wa kanisa.</p>
                <p><strong>Inasubiri</strong>: Michango ambayo imefanywa lakini inasubiri uthibitisho rasmi kwenye mfumo wetu.</p>
                <p><strong>Imekataliwa</strong>: Michango ambayo haikufaulu kutokana na sababu mbalimbali kama vile tatizo la kiufundi au upungufu wa taarifa muhimu.</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Matumizi Yaliyopangwa</div>
            <div class="explanation">
                <p>Michango iliyokusanywa itakuwa na matumizi yafuatayo:</p>
                @php
                    $totalAmount = $data->sum('amount');
                    $churchRepair = $totalAmount * 0.40;
                    $communityProjects = $totalAmount * 0.20;
                    $memberAid = $totalAmount * 0.10;
                    $worshipItems = $totalAmount * 0.10;
                    $emergencyFund = $totalAmount * 0.10;
                    $operationalCosts = $totalAmount * 0.10;
                @endphp
                <ol>
                    <li><strong>Ukarabati wa Jengo la Kanisa</strong> - TZS {{ number_format($churchRepair, 2) }} (40%)</li>
                    <li><strong>Miradi ya Jamii</strong> - TZS {{ number_format($communityProjects, 2) }} (20%)</li>
                    <li><strong>Misaada kwa Wanajumuiya Wahitaji</strong> - TZS {{ number_format($memberAid, 2) }} (10%)</li>
                    <li><strong>Vifaa vya Ibada</strong> - TZS {{ number_format($worshipItems, 2) }} (10%)</li>
                    <li><strong>Akiba ya Dharura</strong> - TZS {{ number_format($emergencyFund, 2) }} (10%)</li>
                    <li><strong>Gharama za Uendeshaji</strong> - TZS {{ number_format($operationalCosts, 2) }} (10%)</li>
                </ol>
                <p>Mipango hii ya matumizi iliidhinishwa katika kikao cha baraza la kanisa. Taarifa kamili ya matumizi itatolewa mwishoni mwa mwaka wa fedha.</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Maoni na Mapendekezo</div>
            <div class="explanation">
                <p>Tunatoa shukrani maalum kwa wanajumuiya wote waliojitolea kwa hali na mali. Michango yenu inasaidia sana katika kuendeleza kanisa letu na jumuiya kwa ujumla.</p>
                <p>Tunapendekeza yafuatayo kwa kipindi kijacho:</p>
                <ul>
                    <li>Kuanzisha mfumo wa michango ya mara kwa mara kwa njia ya simu za mkononi ili kurahisisha mchakato.</li>
                    <li>Kuongeza uwazi zaidi kwa kutoa taarifa za matumizi ya fedha kila robo mwaka.</li>
                    <li>Kuweka malengo mapya ya kukusanya TZS {{ number_format($totalAmount * 1.5, 2) }} kwa ajili ya miradi mbalimbali ya kanisa.</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>Imetolewa na: Kamati ya Fedha, Jumuiya ya Mtakatifu peter</p>
            <p>Imethibitishwa na: Mwenyekiti Dickson Mwantyobe</p>
            <p>Kwa maswali au ufafanuzi, tafadhali wasiliana na ofisi ya kanisa kupitia 0755-123-456 au stpeter@jumuiyakiganjani.co.tz</p>
        </div>
    </div>
</body>
</html>