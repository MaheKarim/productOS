<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PM Career Compass Result</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }

        .sub-header {
            color: #64748b;
            font-size: 12px;
        }

        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .impact-score-container {
            text-align: center;
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .impact-score {
            font-size: 48px;
            font-weight: bold;
            color: #2563eb;
            display: block;
        }

        .impact-label {
            font-size: 16px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .score-level {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 10px;
        }

        .level-high {
            background-color: #dcfce7;
            color: #166534;
        }

        .level-medium {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .level-low {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .grid-2 {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 20px 0;
            margin: 0 -20px;
        }

        .col {
            display: table-cell;
            vertical-align: top;
        }

        /* Bar Chart Styles */
        .bar-container {
            margin-bottom: 12px;
        }

        .bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
            font-weight: bold;
            color: #475569;
        }

        .bar-bg {
            background-color: #e2e8f0;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            width: 100%;
        }

        .bar-fill {
            height: 100%;
            background-color: #3b82f6;
            border-radius: 4px;
        }

        .bar-value {
            float: right;
            font-weight: bold;
        }

        /* Recommendations */
        .recommendation {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 12px;
            margin-bottom: 12px;
        }

        .rec-title {
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .rec-desc {
            font-size: 12px;
            color: #475569;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 50px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">ProductOS</div>
        <div class="sub-header">PM Career Compass Assessment Result</div>
        <div class="sub-header">{{ $date }}</div>
    </div>

    <!-- Impact Score -->
    <div class="section">
        <div class="impact-score-container">
            <span class="impact-label">Overall Impact Score</span>
            <span class="impact-score">{{ number_format($assessment->impact_score, 1) }}</span>
            <div
                class="score-level {{ $assessment->impact_score >= 70 ? 'level-high' : ($assessment->impact_score >= 40 ? 'level-medium' : 'level-low') }}">
                {{ $assessment->status_label }}
            </div>
        </div>
    </div>

    <div class="grid-2">
        <!-- Environment Breakdown -->
        <div class="col">
            <div class="section-title">Environment Breakdown</div>
            @foreach ($assessment->environment_scores as $key => $score)
                <div class="bar-container">
                    <div class="bar-label">
                        {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}
                        <span class="bar-value">{{ number_format($score, 1) }}/10</span>
                    </div>
                    <div class="bar-bg">
                        <div class="bar-fill" style="width: {{ ($score / 10) * 100 }}%; background-color: #10b981;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Skills Breakdown -->
        <div class="col">
            <div class="section-title">Skills Breakdown</div>
            @foreach ($assessment->skills_scores as $key => $score)
                <div class="bar-container">
                    <div class="bar-label">
                        {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $key)) }}
                        <span class="bar-value">{{ number_format($score, 1) }}/10</span>
                    </div>
                    <div class="bar-bg">
                        <div class="bar-fill" style="width: {{ ($score / 10) * 100 }}%; background-color: #6366f1;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recommendations -->
    <div class="section">
        <div class="section-title">Key Recommendations</div>
        @foreach ($recommendations as $rec)
            <div class="recommendation"
                style="border-left-color: {{ $rec['type'] === 'critical' ? '#ef4444' : ($rec['type'] === 'strength' ? '#10b981' : '#f59e0b') }}">
                <div class="rec-title">{{ $rec['variable'] }}</div>
                <div class="rec-desc">{{ $rec['text'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="footer">
        Generated by ProductOS Career Compass on {{ $date }}
    </div>
</body>

</html>
