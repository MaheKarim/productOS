<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume['name'] ?? 'Resume' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #1a1a1a;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4338ca;
            padding-bottom: 20px;
        }

        .name {
            font-size: 28pt;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .contact-info {
            font-size: 10pt;
            color: #4b5563;
        }

        .contact-info span {
            margin: 0 8px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 12pt;
            font-weight: 700;
            color: #4338ca;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .summary {
            font-size: 10pt;
            color: #374151;
        }

        .experience-item {
            margin-bottom: 18px;
        }

        .experience-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 4px;
        }

        .job-title {
            font-size: 11pt;
            font-weight: 700;
            color: #1e1b4b;
        }

        .company {
            font-size: 10pt;
            color: #6366f1;
            font-weight: 500;
        }

        .duration {
            font-size: 9pt;
            color: #6b7280;
            font-style: italic;
        }

        .description {
            font-size: 10pt;
            color: #374151;
            margin-top: 6px;
        }

        .skills-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .skill-tag {
            background-color: #eef2ff;
            color: #4338ca;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: 500;
        }

        .education-item {
            margin-bottom: 12px;
        }

        .degree {
            font-weight: 700;
            color: #1e1b4b;
        }

        .institution {
            color: #6366f1;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="name">{{ $resume['name'] ?? 'Your Name' }}</div>
        <div class="contact-info">
            @if (!empty($resume['email']))
                <span>{{ $resume['email'] }}</span>
            @endif
            @if (!empty($resume['phone']))
                <span>|</span>
                <span>{{ $resume['phone'] }}</span>
            @endif
            @if (!empty($resume['location']))
                <span>|</span>
                <span>{{ $resume['location'] }}</span>
            @endif
        </div>
    </div>

    <!-- Summary Section -->
    @if (!empty($resume['summary']))
        <div class="section">
            <div class="section-title">Professional Summary</div>
            <div class="summary">{{ $resume['summary'] }}</div>
        </div>
    @endif

    <!-- Experience Section -->
    @if (!empty($resume['experience']))
        <div class="section">
            <div class="section-title">Experience</div>
            @foreach ($resume['experience'] as $exp)
                <div class="experience-item">
                    <div class="job-title">{{ $exp['title'] ?? 'Position' }}</div>
                    <div class="company">{{ $exp['company'] ?? 'Company' }}</div>
                    <div class="duration">{{ $exp['duration'] ?? '' }}</div>
                    @if (!empty($exp['description']))
                        <div class="description">{{ $exp['description'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Education Section -->
    @if (!empty($resume['education']))
        <div class="section">
            <div class="section-title">Education</div>
            @foreach ($resume['education'] as $edu)
                <div class="education-item">
                    <div class="degree">{{ $edu['degree'] ?? ($edu['title'] ?? 'Degree') }}</div>
                    <div class="institution">{{ $edu['institution'] ?? ($edu['school'] ?? '') }}</div>
                    @if (!empty($edu['year']))
                        <div class="duration">{{ $edu['year'] }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- Skills Section -->
    @if (!empty($resume['skills']))
        <div class="section">
            <div class="section-title">Skills</div>
            <div class="skills-list">
                @if (is_array($resume['skills']))
                    @foreach ($resume['skills'] as $skill)
                        <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                @else
                    <span class="skill-tag">{{ $resume['skills'] }}</span>
                @endif
            </div>
        </div>
    @endif
</body>

</html>
