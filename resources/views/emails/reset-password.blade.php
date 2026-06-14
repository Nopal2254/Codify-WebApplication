<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.auth.reset.email_subject') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: #060d1a;
            font-family: -apple-system, BlinkMacSystemFont, 'Inter', 'Segoe UI', Roboto, sans-serif;
            padding: 40px 16px;
            color: #f1f5f9;
        }
        .wrapper {
            max-width: 520px;
            margin: 0 auto;
        }
        /* Header with logo */
        .email-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background: rgba(99,102,241,0.12);
            border: 1px solid rgba(99,102,241,0.25);
            border-radius: 50px;
        }
        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-text {
            font-size: 15px;
            font-weight: 700;
            color: #e2e8f0;
            letter-spacing: 0.3px;
        }
        /* Main card */
        .card {
            background: linear-gradient(145deg, #0f172a, #131d31);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.6);
        }
        /* Top accent stripe */
        .card-accent {
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
        }
        .card-body {
            padding: 40px 40px 36px;
            text-align: center;
        }
        /* Shield / security icon */
        .security-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, rgba(99,102,241,0.18), rgba(139,92,246,0.18));
            border: 1px solid rgba(99,102,241,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            font-size: 28px;
        }
        h1 {
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .subtitle {
            font-size: 15px;
            color: #94a3b8;
            line-height: 1.65;
            margin-bottom: 32px;
        }
        .email-highlight {
            color: #a5b4fc;
            font-weight: 600;
        }
        /* CTA Button */
        .btn-wrapper {
            margin-bottom: 32px;
        }
        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 16px;
            font-weight: 700;
            padding: 16px 40px;
            border-radius: 12px;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 24px rgba(99,102,241,0.35);
            transition: all 0.2s;
        }
        /* Expiry note */
        .expiry-note {
            display: inline-block;
            background: rgba(251,191,36,0.08);
            border: 1px solid rgba(251,191,36,0.2);
            color: #fbbf24;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            margin-bottom: 28px;
        }
        .expiry-note span { margin-right: 5px; }
        /* Divider */
        .divider {
            height: 1px;
            background: rgba(255,255,255,0.06);
            margin: 24px 0;
        }
        /* Fallback URL block */
        .fallback {
            font-size: 12.5px;
            color: #64748b;
            line-height: 1.6;
            text-align: left;
        }
        .fallback a {
            color: #818cf8;
            word-break: break-all;
            text-decoration: none;
        }
        /* Security warning */
        .security-warning {
            background: rgba(244,63,94,0.07);
            border: 1px solid rgba(244,63,94,0.18);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #fca5a5;
            text-align: left;
            margin-top: 16px;
            line-height: 1.55;
        }
        .security-warning strong {
            color: #f87171;
        }
        /* Footer */
        .email-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #475569;
            line-height: 1.7;
        }
        .email-footer a { color: #6366f1; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Logo Header -->
    <div class="email-header">
        <div class="logo-badge">
            <div class="logo-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
            <span class="logo-text">Codify</span>
        </div>
    </div>

    <!-- Card -->
    <div class="card">
        <div class="card-accent"></div>
        <div class="card-body">

            <!-- Icon -->
            <div class="security-icon">🔐</div>

            <h1>{{ __('messages.auth.reset.email_title') }}</h1>
            <p class="subtitle">
                {!! __('messages.auth.reset.email_body', ['email' => '<span class="email-highlight">' . e($email) . '</span>']) !!}
            </p>

            <div class="btn-wrapper">
                <a href="{{ $resetUrl }}" class="btn-reset">
                    🔑 &nbsp;{{ __('messages.auth.reset.email_action') }}
                </a>
            </div>

            <div class="expiry-note">
                <span>⏱</span> {{ __('messages.auth.reset.email_expiry') }}
            </div>

            <div class="divider"></div>

            <div class="fallback">
                <strong style="color: #94a3b8;">{{ __('messages.auth.reset.email_fallback_title') }}</strong><br>
                {{ __('messages.auth.reset.email_fallback_desc') }}<br>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </div>

            <div class="security-warning">
                {!! __('messages.auth.reset.email_warning') !!}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p>&copy; {{ date('Y') }} Codify. {{ __('messages.auth.reset.email_copyright') }}</p>
        <p style="margin-top:6px;">
            {{ __('messages.auth.reset.email_automated') }}
        </p>
    </div>
</div>
</body>
</html>
