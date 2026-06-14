<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — {{ __('Page not found') }} | Codify</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Okta Neue', sans-serif;
            background: linear-gradient(135deg, #0d1b2a 0%, #1a2f4a 50%, #0d1b2a 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .error-container {
            text-align: center;
            max-width: 560px;
            padding: 40px 24px;
            position: relative;
            z-index: 1;
        }
        .error-code {
            font-size: 160px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #FF6B35, #FF8C42, #FFB347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -6px;
        }
        .error-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }
        .error-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.6);
            line-height: 1.6;
            margin-bottom: 36px;
        }
        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 2px solid transparent;
            font-family: inherit;
        }
        .btn-primary {
            background: #FF6B35;
            color: #fff;
            border-color: #FF6B35;
            box-shadow: 0 4px 20px rgba(255,107,53,0.3);
        }
        .btn-primary:hover { background: #E55A25; border-color: #E55A25; transform: translateY(-2px); }
        .btn-outline {
            background: transparent;
            color: #fff;
            border-color: rgba(255,255,255,0.3);
        }
        .btn-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.5); }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            opacity: 0.08;
            animation: float 20s infinite;
        }
        .orb:nth-child(1) {
            width: 300px; height: 300px;
            background: #FF6B35;
            top: -100px; right: -100px;
            animation-duration: 15s;
        }
        .orb:nth-child(2) {
            width: 200px; height: 200px;
            background: #764ba2;
            bottom: -50px; left: -50px;
            animation-duration: 20s;
            animation-delay: 5s;
        }
        .orb:nth-child(3) {
            width: 150px; height: 150px;
            background: #667eea;
            top: 50%; left: 50%;
            animation-duration: 25s;
            animation-delay: 10s;
        }
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(20px, 10px) scale(1.05); }
        }
    </style>
</head>
<body>
    <div class="orb"></div>
    <div class="orb"></div>
    <div class="orb"></div>

    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">{{ __('Page not found') }}</h1>
        <p class="error-desc">
            {{ __('Unfortunately') }}, {{ __('page') }}, {{ __('what you are looking for') }}, {{ __('does not exist or has been moved') }}.
            {{ __('Try returning to home or use search') }}.
        </p>
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> {{ __('Home') }}
            </a>
            <a href="{{ url('/search?q=') }}" class="btn btn-outline">
                <i class="fas fa-search"></i> {{ __('Search courses') }}
            </a>
        </div>
    </div>
</body>
</html>