<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update on Your Feedback</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #3B82F6;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            margin: 20px 0;
        }

        .feedback-info {
            background-color: #f9fafb;
            border-left: 4px solid #3B82F6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .feedback-info p {
            margin: 8px 0;
        }

        .feedback-info strong {
            color: #1f2937;
        }

        .admin-comment {
            background-color: #ecfdf5;
            border-left: 4px solid #10B981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .admin-comment p {
            margin: 0;
            color: #065f46;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3B82F6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }

        .button:hover {
            background-color: #2563eb;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .footer a {
            color: #3B82F6;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Update on Your Feedback</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            <p>Your feedback has been updated!</p>

            <div class="feedback-info">
                <p><strong>Feedback ID:</strong> {{ $feedback->feedback_id }}</p>
                <p><strong>Title:</strong> {{ $feedback->title }}</p>
                <p><strong>New Status:</strong> {{ $feedback->status_label }}</p>
            </div>

            <div class="status-badge"
                style="background-color: {{ $feedback->status_color }}20; color: {{ $feedback->status_color }}">
                {{ $feedback->status_label }}
            </div>

            @if ($statusHistory && $statusHistory->admin_comment)
                <div class="admin-comment">
                    <p><strong>Our team's update:</strong></p>
                    <p>{{ $statusHistory->admin_comment }}</p>
                </div>
            @endif

            <p>{{ $feedback->status_message }}</p>

            <a href="{{ route('feedback.show', $feedback->feedback_id) }}" class="button">View Full Details</a>

            <p>You can view all your feedback and track their status in your dashboard.</p>

            <p>Thank you for helping us improve!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>
                <a href="{{ url('/') }}">Visit our website</a> |
                <a href="{{ route('feedback.dashboard') }}">View your feedback</a>
            </p>
        </div>
    </div>
</body>

</html>
