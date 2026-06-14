@extends('layouts.app')

@section('title', __('messages.auth.reset.reset_title') . ' | Codify')

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
    .auth-page::before {
        content: '';
        position: absolute;
        top: -100px;
        left: 50%;
        transform: translateX(-50%);
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99,102,241,0.07) 0%, transparent 70%);
        pointer-events: none;
    }
    .auth-card {
        position: relative;
        background: rgba(15, 23, 42, 0.5);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        width: 100%;
        max-width: 480px;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
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
    .email-badge {
        display: inline-block;
        background: rgba(99,102,241,0.1);
        border: 1px solid rgba(99,102,241,0.25);
        color: #a5b4fc;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    /* Errors */
    .alert-error {
        background: rgba(244,63,94,0.1);
        border: 1px solid rgba(244,63,94,0.25);
        color: #f87171;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13.5px;
        text-align: center;
    }
    /* Password strength meter */
    .strength-bar {
        height: 4px;
        border-radius: 4px;
        background: rgba(255,255,255,0.08);
        margin-top: 8px;
        overflow: hidden;
    }
    .strength-fill {
        height: 100%;
        border-radius: 4px;
        transition: all 0.3s ease;
        width: 0%;
    }
    .strength-fill.weak   { background: #f87171; width: 33%; }
    .strength-fill.medium { background: #fbbf24; width: 66%; }
    .strength-fill.strong { background: #34d399; width: 100%; }
    .strength-label {
        font-size: 12px;
        margin-top: 5px;
        color: var(--text-muted);
        height: 16px;
    }
    /* Input group with show/hide toggle */
    .input-group-pw {
        position: relative;
    }
    .input-group-pw input {
        padding-right: 44px;
    }
    .toggle-pw {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 15px;
        padding: 4px;
        transition: color 0.2s;
    }
    .toggle-pw:hover { color: var(--text-secondary); }
    /* Password requirements checklist */
    .requirements {
        margin-top: 12px;
        font-size: 12.5px;
        color: var(--text-muted);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px 12px;
    }
    .req-item {
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }
    .req-item.met { color: #34d399; }
    .req-item.unmet { color: var(--text-muted); }
    .req-icon { font-size: 11px; }
    /* Submit Button */
    .btn-reset {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px;
        margin-top: 24px;
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
    .btn-reset:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    /* Card footer */
    .card-footer {
        padding: 20px 40px;
        border-top: 1px solid rgba(255,255,255,0.05);
        text-align: center;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        font-size: 14px;
        font-weight: 500;
        color: var(--brand);
        transition: var(--transition);
    }
    .back-link:hover { color: #818cf8; text-decoration: underline; }
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="card-accent-bar"></div>
        <div class="card-inner">

            <div class="icon-wrap">🔐</div>

            <h1>{{ __('messages.auth.reset.reset_title') }}</h1>
            <p class="subtitle">
                {{ __('messages.auth.reset.reset_subtitle') }}
                @if(request('email'))
                    <br><span class="email-badge">{{ request('email') }}</span>
                @endif
            </p>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" id="reset-form">
                @csrf

                {{-- Token --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">
                        {{ __('messages.auth.reset.email_label') }}
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $request->email) }}"
                        readonly
                        style="opacity: 0.7; cursor: not-allowed;"
                    >
                </div>

                {{-- New Password --}}
                <div class="form-group">
                    <label class="form-label" for="password">
                        {{ __('messages.auth.reset.new_password_label') }}
                    </label>
                    <div class="input-group-pw">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="{{ __('messages.auth.reset.password_placeholder') }}"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pw" onclick="togglePw('password', this)" title="{{ __('messages.auth.reset.toggle_pw') }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div class="strength-label" id="strength-label"></div>
                    <div class="requirements" id="requirements">
                        <div class="req-item unmet" id="req-len"><span class="req-icon">○</span> {{ __('messages.auth.reset.req_length') }}</div>
                        <div class="req-item unmet" id="req-upper"><span class="req-icon">○</span> {{ __('messages.auth.reset.req_upper') }}</div>
                        <div class="req-item unmet" id="req-number"><span class="req-icon">○</span> {{ __('messages.auth.reset.req_number') }}</div>
                        <div class="req-item unmet" id="req-special"><span class="req-icon">○</span> {{ __('messages.auth.reset.req_special') }}</div>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        {{ __('messages.auth.reset.confirm_password_label') }}
                    </label>
                    <div class="input-group-pw">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="{{ __('messages.auth.reset.confirm_placeholder') }}"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', this)" title="{{ __('messages.auth.reset.toggle_pw') }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="match-hint" style="font-size: 12px; margin-top: 5px; height: 16px;"></div>
                </div>

                <button type="submit" class="btn-reset" id="submit-btn">
                    <i class="fas fa-shield-alt"></i>
                    {{ __('messages.auth.reset.update_btn') }}
                </button>
            </form>

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
function togglePw(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const pwInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const strengthFill = document.getElementById('strength-fill');
    const strengthLabel = document.getElementById('strength-label');
    const matchHint = document.getElementById('match-hint');
    const submitBtn = document.getElementById('submit-btn');

    const reqLen = document.getElementById('req-len');
    const reqUpper = document.getElementById('req-upper');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');

    function setReq(el, met) {
        el.className = 'req-item ' + (met ? 'met' : 'unmet');
        el.querySelector('.req-icon').textContent = met ? '●' : '○';
    }

    pwInput.addEventListener('input', function () {
        const val = this.value;
        const hasLen     = val.length >= 8;
        const hasUpper   = /[A-Z]/.test(val);
        const hasNumber  = /[0-9]/.test(val);
        const hasSpecial = /[^A-Za-z0-9]/.test(val);

        setReq(reqLen,     hasLen);
        setReq(reqUpper,   hasUpper);
        setReq(reqNumber,  hasNumber);
        setReq(reqSpecial, hasSpecial);

        const score = [hasLen, hasUpper, hasNumber, hasSpecial].filter(Boolean).length;

        strengthFill.className = 'strength-fill';
        if (val.length === 0) {
            strengthFill.style.width = '0%';
            strengthLabel.textContent = '';
        } else if (score <= 1) {
            strengthFill.classList.add('weak');
            strengthLabel.textContent = '{{ __("messages.auth.reset.pw_weak") }}';
            strengthLabel.style.color = '#f87171';
        } else if (score <= 3) {
            strengthFill.classList.add('medium');
            strengthLabel.textContent = '{{ __("messages.auth.reset.pw_medium") }}';
            strengthLabel.style.color = '#fbbf24';
        } else {
            strengthFill.classList.add('strong');
            strengthLabel.textContent = '{{ __("messages.auth.reset.pw_strong") }}';
            strengthLabel.style.color = '#34d399';
        }

        checkMatch();
    });

    confirmInput.addEventListener('input', checkMatch);

    function checkMatch() {
        if (!confirmInput.value) {
            matchHint.textContent = '';
            return;
        }
        if (pwInput.value === confirmInput.value) {
            matchHint.textContent = '✓ {{ __("messages.auth.reset.pw_match") }}';
            matchHint.style.color = '#34d399';
        } else {
            matchHint.textContent = '✗ {{ __("messages.auth.reset.pw_no_match") }}';
            matchHint.style.color = '#f87171';
        }
    }

    const form = document.getElementById('reset-form');
    form.addEventListener('submit', function (e) {
        if (pwInput.value !== confirmInput.value) {
            e.preventDefault();
            matchHint.textContent = '✗ {{ __("messages.auth.reset.pw_no_match") }}';
            matchHint.style.color = '#f87171';
            confirmInput.focus();
            return;
        }
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("messages.auth.reset.updating") }}';
    });
});
</script>
@endsection
