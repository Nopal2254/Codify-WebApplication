@extends('layouts.app')

@section('title', __('messages.auth.reset.forgot_title') . ' | Codify')

@section('extra-css')
<style>
    .auth-page {
        min-height: calc(100vh - 64px);
        background: var(--bg-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
        position: relative;
        overflow: hidden;
    }
    /* Subtle background orbs */
    .auth-page::before {
        content: '';
        position: absolute;
        top: -120px;
        left: 50%;
        transform: translateX(-50%);
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .auth-card {
        position: relative;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        width: 100%;
        max-width: 460px;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255,255,255,0.06);
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }
    .card-accent-bar {
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
    }
    .card-inner {
        padding: 44px 40px 36px;
    }
    .icon-wrap {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.2));
        border: 1px solid rgba(99,102,241,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 26px;
    }
    .auth-card h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 10px;
        text-align: center;
        line-height: 1.25;
    }
    .auth-card .subtitle {
        font-size: 14px;
        color: var(--text-secondary);
        text-align: center;
        margin-bottom: 32px;
        line-height: 1.65;
    }
    /* Success state */
    .success-box {
        background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(5,150,105,0.07));
        border: 1px solid rgba(16,185,129,0.25);
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        margin-bottom: 24px;
    }
    .success-box .check-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(16,185,129,0.15);
        border: 2px solid rgba(16,185,129,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 22px;
    }
    .success-box h2 {
        font-size: 16px;
        font-weight: 700;
        color: #34d399;
        margin-bottom: 8px;
    }
    .success-box p {
        font-size: 13.5px;
        color: #6ee7b7;
        line-height: 1.6;
    }
    /* Error message */
    .alert-error {
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.25);
        color: #f87171;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        text-align: center;
    }
    /* Back link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 14px;
        font-weight: 500;
        color: var(--brand);
        transition: var(--transition);
    }
    .back-link:hover {
        color: #818cf8;
        text-decoration: underline;
    }
    .card-footer {
        padding: 20px 40px;
        border-top: 1px solid rgba(255,255,255,0.05);
        text-align: center;
    }
    /* Override btn-primary for gradient */
    .btn-reset {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        margin-top: 8px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(99,102,241,0.3);
    }
    .btn-reset:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 28px rgba(99,102,241,0.45);
    }
    .btn-reset:active { transform: translateY(0); }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="card-accent-bar"></div>
        <div class="card-inner">

            <div class="icon-wrap">🔑</div>

            <h1>{{ __('messages.auth.reset.forgot_title') }}</h1>
            <p class="subtitle">{{ __('messages.auth.reset.forgot_subtitle') }}</p>

            {{-- Success Message --}}
            @if (session('status'))
                <div class="success-box">
                    <div class="check-circle">✅</div>
                    <h2>{{ __('messages.auth.reset.sent_title') }}</h2>
                    <p>{{ __('messages.auth.reset.sent_desc') }}</p>
                </div>
            @endif

            {{-- Error --}}
            @if ($errors->has('email'))
                <div class="alert-error">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif

            {{-- Form only shown when no success status --}}
            @if (!session('status'))
                <form action="{{ route('password.email') }}" method="POST" id="forgot-form">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">
                            {{ __('messages.auth.reset.email_label') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="{{ __('messages.auth.reset.email_placeholder') }}"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>

                    <button type="submit" class="btn-reset" id="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        {{ __('messages.auth.reset.send_btn') }}
                    </button>
                </form>
            @endif

        </div>
        <div class="card-footer">
            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                {{ __('messages.auth.reset.back_to_login') }}
            </a>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('forgot-form');
    const btn = document.getElementById('submit-btn');
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("messages.auth.reset.sending") }}';
        });
    }
});
</script>
@endsection
