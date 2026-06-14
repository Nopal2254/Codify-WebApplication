<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.auth.register.email_verify_subject') }}</title>
    <style>
        body {
            background-color: #0b0f19;
            color: #f1f5f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        h2 {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 8px;
        }
        p {
            font-size: 15px;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .code {
            display: inline-block;
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 6px;
            color: #6366f1;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            padding: 12px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        .footer {
            font-size: 12px;
            color: #64748b;
            margin-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>{{ __('messages.auth.register.email_verify_header') }}</h2>
        <p>{{ __('messages.auth.register.email_verify_body') }}</p>
        <div class="code">{{ $code }}</div>
        <p>{{ __('messages.auth.register.email_verify_ignore') }}</p>
        <div class="footer">
            &copy; {{ date('Y') }} Codify. {{ __('messages.auth.register.email_verify_copyright') }}
        </div>
    </div>
</body>
</html>
