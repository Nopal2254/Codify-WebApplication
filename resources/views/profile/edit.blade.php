@extends('layouts.app')

@section('title', __('messages.dash.profile') . ' | Codify')

@section('extra-css')
<style>
    .profile-container {
        padding: 100px 0 60px;
    }
    .profile-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: var(--radius-lg, 18px);
        padding: 32px;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
    }
    .profile-card-header {
        margin-bottom: 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        padding-bottom: 16px;
    }
    .profile-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }
    .profile-card-subtitle {
        font-size: 13px;
        color: var(--text-muted, #64748b);
    }
    .avatar-preview-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (min-width: 640px) {
        .avatar-preview-container {
            flex-direction: row;
            align-items: center;
            gap: 20px;
        }
    }
    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        background: rgba(255, 255, 255, 0.04);
        border: 2px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: #fff;
    }
    .alert-error {
        background: rgba(244, 63, 94, 0.12);
        color: #f43f5e;
        border: 1px solid rgba(244, 63, 94, 0.2);
        padding: 12px 16px;
        border-radius: var(--radius-sm, 4px);
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.12);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.2);
        padding: 12px 16px;
        border-radius: var(--radius-sm, 4px);
        margin-bottom: 20px;
        font-size: 14px;
    }
    .form-text {
        font-size: 12px;
        color: var(--text-muted, #64748b);
        margin-top: 4px;
    }
    .btn-danger {
        background: #e11d48;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-danger:hover {
        background: #be123c;
        transform: translateY(-1px);
    }
    .modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1050;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .modal-backdrop.show {
        display: flex;
    }
    .modal-window {
        background: rgba(15, 23, 42, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg, 16px);
        width: 100%;
        max-width: 500px;
        padding: 32px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        position: relative;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .form-control {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
        border-radius: 12px !important;
        padding: 12px 16px !important;
        transition: all 0.2s ease !important;
        width: 100%;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.05) !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
        outline: none !important;
    }
    .profile-form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (min-width: 768px) {
        .profile-form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group {
        margin-bottom: 0;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 8px;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full profile-container">
    @include('student.layouts.nav')

    @if(session('status') === 'profile-updated')
        <div class="alert alert-success">{{ __('Profile updated successfully.') }}</div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="alert alert-success">{{ __('Password updated successfully.') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Card 1: Profile Information -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">{{ __('Profile Information') }}</h3>
            <p class="profile-card-subtitle">{{ __("Update your account's profile information, avatar, bio, and email address.") }}</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Avatar Upload -->
            <div class="avatar-preview-container">
                <div style="position: relative;">
                    @if(auth()->user()->avatar)
                        <img class="avatar-preview" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                        <div class="avatar-preview">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    @endif
                    @if(auth()->user()->is_premium)
                        <div style="position: absolute; bottom: -5px; right: -5px; background: linear-gradient(135deg, #fbbf24, #f59e0b); border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border: 2px solid #0f172a; box-shadow: 0 2px 5px rgba(0,0,0,0.5);" title="Premium Status">
                            <i class="fas fa-crown text-white" style="font-size: 10px;"></i>
                        </div>
                    @endif
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <span style="font-size: 18px; font-weight: 700; color: #fff;">{{ auth()->user()->name }}</span>
                        @if(auth()->user()->is_premium)
                            <span style="display: inline-flex; align-items: center; gap: 6px; padding: 2px 10px; border-radius: 9999px; font-size: 11px; font-weight: 600; background: rgba(251, 191, 36, 0.15); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3);">
                                <i class="fas fa-crown text-amber-400"></i> Premium
                            </span>
                        @endif
                    </div>
                    <label class="form-label" for="avatar" style="margin-bottom: 4px; display: block; font-size: 13px; color: #cbd5e1;">{{ __('Profile Picture') }}</label>
                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                    <p class="form-text">{{ __('Upload an image up to 2MB (JPEG, PNG, etc.).') }}</p>
                    @error('avatar')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="profile-form-grid">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required autocomplete="name">
                    @error('name')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">
                    @error('email')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">{{ __('Phone') }}</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+1 (555) 000-0000">
                    @error('phone')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telegram -->
                <div class="form-group">
                    <label for="telegram">{{ __('Telegram') }}</label>
                    <input type="text" id="telegram" name="telegram" class="form-control" value="{{ old('telegram', auth()->user()->telegram) }}" placeholder="@username">
                    @error('telegram')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birthday -->
                <div class="form-group">
                    <label for="birthday">{{ __('Date of Birth') }}</label>
                    <input type="date" id="birthday" name="birthday" class="form-control" value="{{ old('birthday', auth()->user()->birthday ? (\Carbon\Carbon::parse(auth()->user()->birthday)->format('Y-m-d')) : '') }}">
                    @error('birthday')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birthplace -->
                <div class="form-group">
                    <label for="birthplace">{{ __('Place of Birth') }}</label>
                    <input type="text" id="birthplace" name="birthplace" class="form-control" value="{{ old('birthplace', auth()->user()->birthplace) }}" placeholder="e.g. New York, USA">
                    @error('birthplace')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Profession -->
                <div class="form-group">
                    <label for="profession">{{ __('Profession') }}</label>
                    <input type="text" id="profession" name="profession" class="form-control" value="{{ old('profession', auth()->user()->profession) }}" placeholder="e.g. Software Engineer">
                    @error('profession')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biography -->
                <div class="form-group full-width">
                    <label for="biography">{{ __('Biography') }}</label>
                    <textarea id="biography" name="biography" class="form-control" rows="4" placeholder="{{ __('Tell us about yourself...') }}">{{ old('biography', auth()->user()->biography) }}</textarea>
                    <p class="form-text">{{ __('Brief description for your instructor or student profile page.') }}</p>
                    @error('biography')
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-gradient">{{ __('Save Changes') }}</button>
        </form>
    </div>

    <!-- Card 2: Update Password -->
    <div class="profile-card">
        <div class="profile-card-header">
            <h3 class="profile-card-title">{{ __('Update Password') }}</h3>
            <p class="profile-card-subtitle">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <div class="profile-form-grid">
                <!-- Current Password -->
                <div class="form-group">
                    <label class="form-label" for="current_password">{{ __('Current Password') }}</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    @if($errors->updatePassword->has('current_password'))
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label class="form-label" for="password">{{ __('New Password') }}</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                    @if($errors->updatePassword->has('password'))
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $errors->updatePassword->first('password') }}</p>
                    @endif
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                    @if($errors->updatePassword->has('password_confirmation'))
                        <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $errors->updatePassword->first('password_confirmation') }}</p>
                    @endif
                </div>
            </div>

            <button type="submit" class="btn btn-gradient">{{ __('Update Password') }}</button>
        </form>
    </div>

    <!-- Card 3: Delete Account -->
    @if(!auth()->user()->isAdmin())
        <div class="profile-card" style="border-color: rgba(220, 53, 69, 0.2);">
            <div class="profile-card-header" style="border-bottom-color: rgba(220, 53, 69, 0.1);">
                <h3 class="profile-card-title" style="color: var(--danger);">{{ __('Delete Account') }}</h3>
                <p class="profile-card-subtitle">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
            </div>

            <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 24px;">
                {{ __('Please download any data or information that you wish to retain before permanently deleting your account.') }}
            </p>

            <button type="button" class="btn btn-danger" onclick="toggleDeleteModal(true)">{{ __('Delete Account') }}</button>
        </div>
    @endif
</div>

<!-- Delete Account Confirmation Modal -->
<div class="modal-backdrop" id="deleteAccountModal">
    <div class="modal-window">
        <h3 class="profile-card-title" style="margin-bottom: 12px;">{{ __('Are you sure you want to delete your account?') }}</h3>
        <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 24px; line-height: 1.6;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label class="form-label" for="delete_password">{{ __('Password') }}</label>
                <input type="password" id="delete_password" name="password" class="form-control" placeholder="••••••••" required>
                @if($errors->userDeletion->has('password'))
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            toggleDeleteModal(true);
                        });
                    </script>
                    <p style="color:var(--danger); font-size: 13px; margin-top: 4px;">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div style="display:flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn" style="color: #cbd5e1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 24px; font-weight: 600;" onclick="toggleDeleteModal(false)">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDeleteModal(show) {
        const modal = document.getElementById('deleteAccountModal');
        if (show) {
            modal.classList.add('show');
        } else {
            modal.classList.remove('show');
        }
    }
</script>
@endsection