@extends('layouts.app')

@section('title', __('My certificates | Codify'))
@section('page-title', __('My certificates'))

@section('extra-css')
<style>
    .certificates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .certificate-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
    }

    .certificate-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-4px);
    }

    /* CSS-based premium certificate preview */
    .certificate-preview {
        height: 220px;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 24px;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: #fff;
        border-bottom: 4px solid var(--brand);
    }

    .certificate-preview::before {
        content: '';
        position: absolute;
        inset: 12px;
        border: 1.5px solid rgba(255,255,255,0.08);
        pointer-events: none;
    }

    .cert-badge {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(217, 119, 6, 0.4);
        margin: 0 auto 10px;
    }

    .cert-badge i {
        color: #fff;
        font-size: 20px;
    }

    .cert-preview-body {
        text-align: center;
        z-index: 1;
    }

    .cert-preview-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255,255,255,0.4);
        margin-bottom: 6px;
    }

    .cert-student-name {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        font-family: serif;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .cert-course-title {
        font-size: 12px;
        color: var(--brand-mid);
        font-weight: 500;
        max-width: 240px;
        margin: 0 auto;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cert-footer {
        display: flex;
        justify-content: space-between;
        font-size: 8px;
        color: rgba(255,255,255,0.3);
        z-index: 1;
    }

    .certificate-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .certificate-title-text {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
        line-height: 1.4;
    }

    .certificate-meta {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        border: 1px dashed var(--border-md);
    }
</style>
@endsection

@section('content')
<div style="max-width: 1280px; margin: 0 auto; padding-top: 20px;">
    @include('student.layouts.nav')
@if(count($certificates) > 0)
    <div class="certificates-grid">
        @foreach($certificates as $cert)
        <div class="certificate-card">
            {{-- CSS Certificate Design --}}
            <div class="certificate-preview">
                <div class="cert-badge">
                    <i class="fas fa-award"></i>
                </div>

                <div class="cert-preview-body">
                    <div class="cert-preview-title">{{ __('Certificate of completion') }}</div>
                    <div class="cert-student-name">{{ $cert->user->name }}</div>
                    <div class="cert-course-title">{{ $cert->course->title }}</div>
                </div>

                <div class="cert-footer">
                    <span>ID: {{ $cert->code }}</span>
                    <span>Codify</span>
                </div>
            </div>

            <div class="certificate-body">
                <div>
                    <div class="certificate-title-text">{{ $cert->course->title }}</div>
                    <div class="certificate-meta">
                        <span><i class="fas fa-calendar-alt" style="margin-right: 4px;"></i> {{ __('Issued') }}: {{ $cert->issued_at->format('d.m.Y') }}</span>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('certificates.show', $cert->code) }}" class="btn btn-primary" style="flex: 1; text-align: center; justify-content: center; font-size:13px; padding: 10px;">
                        <i class="fas fa-eye"></i> {{ __('Open') }}
                    </a>
                    <a href="{{ route('certificates.download', $cert->code) }}" class="btn btn-outline" style="flex: 1; text-align: center; justify-content: center; font-size:13px; padding: 10px;">
                        <i class="fas fa-download"></i> PDF
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-award" style="font-size: 64px; color: var(--border-md); margin-bottom: 20px;"></i>
        <h2 style="font-size: 20px; font-weight: 700; color: var(--text-primary); margin-bottom: 10px;">{{ __('No certificates available') }}</h2>
        <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto 24px;">{{ __('Complete all lessons in any course on') }} 100%, {{ __('and your personalized certificate of completion with your name will automatically appear here') }}!</p>
        <a href="{{ route('my-learning') }}" class="btn btn-primary">{{ __('My training') }}</a>
    </div>
@endif
</div>
@endsection