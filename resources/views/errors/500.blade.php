<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — {{ __('Server error') }} | Codify</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Okta Neue', sans-serif;
            background: linear-gradient(135deg, #1a0a0a 0%, #2d1a1a 50%, #1a0a0a 100%);
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
            background: linear-gradient(135deg, #EF4444, #F59E0B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -6px;
        }
        .error-title { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        .error-desc { font-size: 16px; color: rgba(255,255,255,0.6); line-height: 1.6; margin-bottom: 36px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px; border-radius: 12px; font-size: 15px;
            font-weight: 600; text-decoration: none; transition: all 0.2s ease;
            background: #EF4444; color: #fff; border: 2px solid #EF4444;
        }
        .btn:hover { background: #DC2626; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-code">500</div>
        <h1 class="error-title">{{ __('Server error') }}</h1>
        <p class="error-desc">
            {{ __('An internal server error occurred') }}. {{ __('We are already working to eliminate it') }}.
            {{ __('Please') }}, {{ __('try again later') }}.
        </p>
        <a href="{{ url('/') }}" class="btn"><i class="fas fa-home"></i> {{ __('Home') }}</a>
    </div>
</body>
</html>