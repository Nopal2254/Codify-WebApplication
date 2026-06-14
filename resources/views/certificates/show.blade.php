@extends('layouts.app')

@section('title', __('Certificate of Completion'))

@section('extra-css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&family=Alex+Brush&display=swap');

    .cert-page-container {
        max-width: 960px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .cert-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 16px 24px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    /* Dynamic certificate frame using template design */
    .certificate-frame {
        background: {{ $design['background_color'] }};
        border: 20px solid {{ $design['border_outer_color'] }};
        padding: 40px;
        position: relative;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        border-radius: 4px;
    }

    .certificate-inner {
        border: 4px double {{ $design['border_inner_color'] }};
        padding: 48px 64px;
        text-align: center;
        background: #ffffff;
        position: relative;
    }

    /* Corner ornaments using template accent color */
    .certificate-corner-tl { position: absolute; top: 10px; left: 10px; width: 44px; height: 44px; border-top: 3px solid {{ $design['accent_color'] }}; border-left: 3px solid {{ $design['accent_color'] }}; }
    .certificate-corner-tr { position: absolute; top: 10px; right: 10px; width: 44px; height: 44px; border-top: 3px solid {{ $design['accent_color'] }}; border-right: 3px solid {{ $design['accent_color'] }}; }
    .certificate-corner-bl { position: absolute; bottom: 10px; left: 10px; width: 44px; height: 44px; border-bottom: 3px solid {{ $design['accent_color'] }}; border-left: 3px solid {{ $design['accent_color'] }}; }
    .certificate-corner-br { position: absolute; bottom: 10px; right: 10px; width: 44px; height: 44px; border-bottom: 3px solid {{ $design['accent_color'] }}; border-right: 3px solid {{ $design['accent_color'] }}; }

    .cert-logo {
        font-size: 26px;
        font-weight: 900;
        color: {{ $design['logo_color'] }};
        margin-bottom: 28px;
        letter-spacing: 1px;
    }
    .cert-logo span { color: {{ $design['text_color'] }}; }

    .cert-main-title {
        font-family: 'Playfair Display', serif, Georgia;
        font-size: 44px;
        font-weight: 800;
        color: {{ $design['text_color'] }};
        letter-spacing: 3px;
        margin-bottom: 8px;
        text-transform: uppercase;
    }

    .cert-subtitle {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 5px;
        color: #6b7280;
        margin-bottom: 36px;
    }

    .cert-award-text {
        font-size: 15px;
        color: #4b5563;
        font-style: italic;
        margin-bottom: 14px;
    }

    .cert-recipient {
        font-family: 'Playfair Display', serif, Georgia;
        font-size: 38px;
        font-weight: 800;
        color: {{ $design['recipient_color'] }};
        border-bottom: 2px solid #e5e7eb;
        display: inline-block;
        padding: 0 48px 12px;
        margin-bottom: 28px;
    }

    .cert-course-text {
        font-size: 15px;
        color: #4b5563;
        max-width: 600px;
        margin: 0 auto 12px;
        line-height: 1.7;
    }

    .cert-course-name {
        font-size: 22px;
        font-weight: 800;
        color: {{ $design['text_color'] }};
        margin-bottom: 44px;
        letter-spacing: 0.3px;
    }

    .cert-details-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 40px;
        padding: 0 20px;
    }

    .cert-signature-col {
        width: 200px;
        text-align: center;
    }

    .cert-signature-line {
        border-top: 1px solid #d1d5db;
        margin-top: 10px;
        padding-top: 7px;
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .cert-signature-name {
        font-family: 'Alex Brush', cursive, Georgia, serif;
        font-size: 22px;
        color: {{ $design['text_color'] }};
        font-weight: 600;
    }

    /* Seal using template seal color */
    .cert-seal {
        width: 96px;
        height: 96px;
        background: radial-gradient(circle, color-mix(in srgb, {{ $design['seal_color'] }} 70%, white), {{ $design['seal_color'] }});
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 8px 24px {{ $design['seal_color'] }}55;
        border: 4px solid #fff;
    }

    .cert-seal::before {
        content: '';
        position: absolute;
        width: calc(100% - 8px);
        height: calc(100% - 8px);
        border-radius: 50%;
        border: 2px dashed rgba(255,255,255,0.5);
        animation: spin 18s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .cert-seal-inner { text-align: center; color: #fff; }
    .cert-seal-inner i { font-size: 26px; display: block; margin-bottom: 2px; }
    .cert-seal-inner span { font-size: 8px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; }

    .cert-number {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 36px;
        letter-spacing: 1px;
    }

    @media print {
        .cert-actions { display: none; }
        body * { visibility: hidden; }
        .certificate-frame, .certificate-frame * { visibility: visible; }
        .certificate-frame { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; padding: 0; }
    }
</style>
@endsection

@section('content')
<div class="cert-page-container">
    
    <div class="cert-actions">
        <div>
            <h4 style="margin:0; font-weight:700; color:#fff;">{{ __('Certificate of Completion') }}</h4>
            <p style="margin:5px 0 0 0; font-size:13px; color:var(--text-muted);">{{ __('Print or download your certificate as a PDF file') }}</p>
        </div>
        <div style="display:flex; gap:12px;">
            <a href="{{ route('certificates.download', $certificate->code) }}" class="btn btn-outline-primary" style="border-radius:10px; font-weight:600;">
                <i class="fas fa-download me-2"></i> {{ __('Download PDF') }}
            </a>
            <button onclick="window.print()" class="btn btn-outline-light" style="border-radius:10px; font-weight:600; opacity: 0.8;">
                <i class="fas fa-print me-2"></i> {{ __('Print') }}
            </button>
        </div>
    </div>
    
    <div class="certificate-frame">
        <div class="certificate-inner">
            <div class="certificate-corner-tl"></div>
            <div class="certificate-corner-tr"></div>
            <div class="certificate-corner-bl"></div>
            <div class="certificate-corner-br"></div>

            <div class="cert-logo">Edu<span>Platform</span></div>

            <h1 class="cert-main-title">{{ __('Certificate') }}</h1>
            <div class="cert-subtitle">{{ __('of Completion') }}</div>

            <div class="cert-award-text">{{ __('This is to certify that') }}</div>
            <div class="cert-recipient">{{ $certificate->user->name }}</div>

            <div class="cert-course-text">{{ __('has successfully completed the course') }}:</div>
            <div class="cert-course-name">"{{ $certificate->course->title }}"</div>

            <div class="cert-details-row">
                <div class="cert-signature-col">
                    <div class="cert-signature-name">{{ $certificate->course->user->name }}</div>
                    <div class="cert-signature-line">{{ __('Instructor') }}</div>
                </div>
                
                <div class="cert-seal">
                    <div class="cert-seal-inner">
                        <i class="fas fa-graduation-cap"></i>
                        <span>APPROVED</span>
                    </div>
                </div>
                
                <div class="cert-signature-col">
                    <div class="cert-signature-name" style="font-family: inherit; font-size: 16px; font-weight: 700; margin-top: 8px;">
                        {{ $certificate->issued_at->format('M d, Y') }}
                    </div>
                    <div class="cert-signature-line">{{ __('Date of Issue') }}</div>
                </div>
            </div>

            <div class="cert-number">{{ __('Certificate ID') }}: {{ $certificate->code }} • codify.com</div>
        </div>
    </div>
</div>
@endsection
