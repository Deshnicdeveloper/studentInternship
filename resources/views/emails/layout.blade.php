<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIMS') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-wrapper {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #4f46e5;
            padding: 24px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 32px 24px;
        }
        .email-body h2 {
            margin-top: 0;
            color: #1f2937;
            font-size: 20px;
        }
        .email-body p {
            margin: 16px 0;
            color: #4b5563;
        }
        .button {
            display: inline-block;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            margin: 16px 0;
        }
        .button:hover {
            background-color: #4338ca;
        }
        .info-box {
            background-color: #f3f4f6;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }
        .info-box p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info-box strong {
            color: #1f2937;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-flagged {
            background-color: #fef3c7;
            color: #92400e;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            margin: 4px 0;
            font-size: 12px;
            color: #6b7280;
        }
        .email-footer a {
            color: #4f46e5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-wrapper">
            <div class="email-header">
                <h1>{{ config('app.name', 'SIMS') }}</h1>
            </div>
            <div class="email-body">
                @yield('content')
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'SIMS') }}. All rights reserved.</p>
                <p>Student Internship Management System</p>
                <p>
                    <a href="{{ url('/') }}">Visit SIMS</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
