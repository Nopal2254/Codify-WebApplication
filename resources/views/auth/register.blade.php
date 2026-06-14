@extends('layouts.app')

@section('title', 'Kayıt Ol | Codify')

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
    .form-row-half { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .terms {
        font-size: 12px;
        color: var(--text-muted);
        text-align: center;
        margin-top: 20px;
        line-height: 1.6;
    }
    .terms a { color: var(--brand); font-weight: 500; }
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
        .role-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 6px;
        margin-bottom: 20px;
    }
    .role-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 12px;
        background: rgba(255, 255, 255, 0.03);
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        cursor: pointer;
        transition: var(--transition);
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 14px;
    }
    .role-option:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 255, 255, 0.15);
        color: var(--text-primary);
    }
    .role-option.active {
        background: rgba(99, 102, 241, 0.15);
        border-color: var(--brand);
        color: #fff;
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.2);
    }
    .role-option i {
        font-size: 20px;
        color: var(--brand);
        transition: var(--transition);
    }
    .role-option.active i {
        color: #fff;
    }
    
</style>
@endsection

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <h1>Yeni Hesap Oluşturun</h1>
        <p class="subtitle">Zaten Codify üyesi misiniz? <a href="{{ url('/login') }}">Giriş yapın</a></p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Adınız Soyadınız</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Adınız Soyadınız" value="{{ old('name') ?? trim(old('first_name') . ' ' . old('last_name')) }}" required>
                @error('first_name')
                    <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('last_name')
                    <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">E-posta Adresiniz</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="isim@ornek.com" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Şifreniz</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="En az 6 karakterli bir şifre oluşturun" required minlength="6">
                @error('password')
                    <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kayıt türünü seçin</label>
                <div class="role-selector">
                    <label class="role-option {{ old('role', 'student') === 'student' ? 'active' : '' }}" data-role="student">
                        <input type="radio" name="role" value="student" {{ old('role', 'student') === 'student' ? 'checked' : '' }} style="display: none;">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Öğrenci</span>
                    </label>
                    <label class="role-option {{ old('role') === 'instructor' ? 'active' : '' }}" data-role="instructor">
                        <input type="radio" name="role" value="instructor" {{ old('role') === 'instructor' ? 'checked' : '' }} style="display: none;">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Öğretmen</span>
                    </label>
                </div>
                @error('role')
                    <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Kayıt Ol</button>
        </form>

        <div class="divider">veya</div>

        <div class="social-btns">
            <a href="/auth/google" id="google-signup-btn" class="relative z-10 w-full flex items-center justify-center gap-3 py-3 px-4 border border-slate-700/50 bg-slate-900/20 text-white rounded-xl font-medium hover:bg-slate-900/60 transition duration-200 cursor-pointer" style="text-decoration: none;">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.54 15.01 1 12 1 7.24 1 3.22 3.73 1.25 7.72l3.87 3a7 7 0 0 1 6.88-5.68z"/>
                    <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.43h6.45a5.52 5.52 0 0 1-2.4 3.62l3.72 2.89c2.18-2.01 3.72-4.96 3.72-8.6z"/>
                    <path fill="#FBBC05" d="M5.12 14.72a7 7 0 0 1 0-5.44l-3.87-3A11.94 11.94 0 0 0 0 12c0 2.06.52 4 1.25 5.72l3.87-3z"/>
                    <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.72-2.89a6.95 6.95 0 0 1-4.24 1.21 7 7 0 0 1-6.88-5.68l-3.87 3A11.94 11.94 0 0 0 12 23z"/>
                </svg>
                <span>Google ile Giriş Yap</span>
            </a>
        </div>

        <p class="terms">Kayıt ol butonuna tıklayarak <a href="#">Kullanım Koşulları</a> ve <a href="#">Gizlilik Politikası</a>'nı kabul etmiş olursunuz.</p>
    </div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleOptions = document.querySelectorAll('.role-option');
    const googleBtn = document.getElementById('google-signup-btn');
    const baseUrl = "{{ route('auth.google.redirect') }}";

    const updateGoogleUrl = (role) => {
        if (googleBtn) {
            googleBtn.href = `${baseUrl}?role=${role}`;
        }
    };

    // Initialize Google redirect URL with the default selected role
    const activeRadio = document.querySelector('input[name="role"]:checked');
    if (activeRadio) {
        updateGoogleUrl(activeRadio.value);
    }

    roleOptions.forEach(option => {
        option.addEventListener('click', function() {
            roleOptions.forEach(opt => {
                opt.classList.remove('active');
                const radio = opt.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            this.classList.add('active');
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                updateGoogleUrl(radio.value);
            }
        });
    });
});
</script>
@endsection
