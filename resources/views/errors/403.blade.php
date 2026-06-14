<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — {{ __('Access denied') }} | Codify</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Okta Neue', sans-serif;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2f4a 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            text-align: center;
            max-width: 560px;
            padding: 40px 24px;
        }
        .error-code {
            font-size: 160px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #F59E0B, #EF4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -6px;
        }
        .error-title { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .error-desc { font-size: 16px; color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 36px; }
        .error-actions { display: flex; gap: 12px; justify-content: center; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; border-radius: 12px; font-size: 15px;
            font-weight: 600; text-decoration: none; transition: all 0.2s ease;
            background: #F59E0B; color: #fff; border: 2px solid #F59E0B;
        }
        .btn:hover { background: #D97706; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">403</div>
        <h1 class="error-title">{{ __('Access denied') }}</h1>
        <p class="error-desc">
            {{ __('You do not have permission to access this page') }}.
            {{ __('If you think') }}, {{ __('that this is a mistake') }}, {{ __('contact the administrator') }}.
        </p>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn"><i class="fas fa-home"></i> {{ __('Home') }}</a>
        </div>
    </div>
</body>
</html>