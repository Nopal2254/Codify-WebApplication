@extends('layouts.app')

@section('title', 'Giriş Yap | Codify')

@section('extra-css')
<style>
    .auth-page {
        min-height: calc(100vh - 64px);
        background: var(--bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
    }
    .auth-card {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        width: 100%;
        max-width: 440px;
        border-radius: 24px;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 40px;
    }
        .auth-card h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 8px;
        text-align: center;
    }
    .auth-card .subtitle {
        font-size: 14px;
        color: var(--text-secondary);
        text-align: center;
        margin-bottom: 32px;
    }
    .auth-card .subtitle a { color: var(--brand); font-weight: 600; }
    .auth-card .subtitle a:hover { text-decoration: underline; }
    .form-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: var(--text-secondary);
        cursor: pointer;
    }
    .checkbox-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--brand);
    }
    .forgot-link {
        font-size: 14px;
        color: var(--brand);
        font-weight: 500;
    }
    .forgot-link:hover { text-decoration: underline; }
    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 28px 0;
        color: var(--text-muted);
        font-size: 13px;
    }
    .divider::before, .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: rgba(255, 255, 255, 0.08);
    }
        .social-btns {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 10px 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.03);
        transition: var(--transition);
        cursor: pointer;
    }
    .social-btn:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.15);
    }
        .social-btn img { width: 20px; height: 20px; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Hesabınıza Giriş Yapın</h1>
        <p class="subtitle">Codify'da yeni misiniz? <a href="{{ url('/register') }}">Ücretsiz kayıt olun</a></p>

        <form action="{{ route('login') }}" method="POST">@csrf
            <div class="form-group">
                <label class="form-label" for="email">E-posta Adresiniz</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="isim@ornek.com" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Şifreniz</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Şifrenizi girin" required>
            </div>

            <div class="form-row" style="margin-bottom: 24px;">
                <label class="checkbox-label" for="remember_me">
                    <input type="checkbox" id="remember_me" name="remember" checked> Beni Hatırla
                </label>
                <a href="{{ url('/forgot-password') }}" class="forgot-link">Şifrenizi mi unuttunuz?</a>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Giriş Yap</button>
        </form>

        <div class="divider">veya</div>

        <div class="social-btns">
            <a href="/auth/google" class="relative z-10 w-full flex items-center justify-center gap-3 py-3 px-4 border border-slate-700/50 bg-slate-900/20 text-white rounded-xl font-medium hover:bg-slate-900/60 transition duration-200 cursor-pointer" style="text-decoration: none;">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.54 15.01 1 12 1 7.24 1 3.22 3.73 1.25 7.72l3.87 3a7 7 0 0 1 6.88-5.68z"/>
                    <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.43h6.45a5.52 5.52 0 0 1-2.4 3.62l3.72 2.89c2.18-2.01 3.72-4.96 3.72-8.6z"/>
                    <path fill="#FBBC05" d="M5.12 14.72a7 7 0 0 1 0-5.44l-3.87-3A11.94 11.94 0 0 0 0 12c0 2.06.52 4 1.25 5.72l3.87-3z"/>
                    <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.72-2.89a6.95 6.95 0 0 1-4.24 1.21 7 7 0 0 1-6.88-5.68l-3.87 3A11.94 11.94 0 0 0 12 23z"/>
                </svg>
                <span>Google ile Giriş Yap</span>
            </a>
        </div>
    </div>
</div>
@endsection
