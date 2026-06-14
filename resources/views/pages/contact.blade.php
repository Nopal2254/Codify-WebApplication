@extends('layouts.app')

@section('title', __('Contacts | Codify'))
@section('page-title', __('Contacts'))

@section('extra-css')
<style>
    .contact-container {
        max-width: 680px;
        margin: 100px auto 60px;
        display: block;
    }

    .contact-info-card {
        background: linear-gradient(135deg, #0d1b2a 0%, #1a2f4a 100%);
        color: #fff;
        border-radius: var(--radius-lg);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .contact-info-card::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: var(--brand);
        opacity: 0.15;
        border-radius: 50%;
        bottom: -50px;
        right: -50px;
    }

    .info-header h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .info-header p {
        font-size: 14px;
        color: rgba(255,255,255,0.7);
        line-height: 1.6;
    }

    .info-list {
        margin: 40px 0;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .info-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        background: rgba(255,255,255,0.1);
        color: var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .info-text {
        font-size: 14px;
    }

    .info-text div:first-child {
        font-weight: 600;
        color: rgba(255,255,255,0.5);
        margin-bottom: 2px;
        font-size: 12px;
    }

    .info-text div:last-child {
        font-weight: 500;
    }

    .social-links {
        display: flex;
        gap: 12px;
    }

    .social-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: var(--transition);
        text-decoration: none;
    }

    .social-icon:hover {
        background: var(--brand);
        color: #fff;
        transform: translateY(-2px);
    }

    .contact-form-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-lg);
        padding: 40px;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
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

    .form-header {
        margin-bottom: 30px;
    }

    .form-header h2 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .form-header p {
        font-size: 14px;
        color: var(--text-muted);
    }

    .alert {
        padding: 14px 20px;
        border-radius: var(--radius-md);
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }

    @media (max-width: 768px) {
        .contact-container {
            grid-template-columns: 1fr;
        }
        .contact-info-card, .contact-form-card {
            padding: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="contact-container">
    
    <div class="contact-form-card">
        <div class="form-header">
            <h2>{{ __('Send message') }}</h2>
            <p>{{ __('Fill out the form below') }}, {{ __('and we will contact you') }}.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">{{ __('your name') }}</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="{{ __('Ivan Ivanov') }}" required>
                @error('name')
                    <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">{{ __('E-mail') }}</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="example@email.com" required>
                @error('email')
                    <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="subject">{{ __('Message Subject') }}</label>
                <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" placeholder="{{ __('Questions about courses or cooperation') }}" required>
                @error('subject')
                    <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="message">{{ __('Message') }}</label>
                <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="{{ __('Enter the text of your message...') }}" required>{{ old('message') }}</textarea>
                @error('message')
                    <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-gradient" style="width: 100%; padding: 12px 24px; border-radius: 12px;">
                <i class="fas fa-paper-plane" style="margin-right:6px;"></i> {{ __('Send message') }}
            </button>
        </form>
    </div>
</div>
@endsection