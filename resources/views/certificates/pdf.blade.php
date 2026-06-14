<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Certificate') }} {{ $certificate->code }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
            color: #1e293b;
        }
        .container {
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            padding: 20px;
            background: #fbfbfd;
        }
        .border-outer {
            border: 15px solid #1e293b;
            height: 100%;
            box-sizing: border-box;
            padding: 10px;
            position: relative;
        }
        .border-inner {
            border: 3px double #d97706;
            height: 100%;
            background: #ffffff;
            box-sizing: border-box;
            padding: 30px 45px;
            text-align: center;
        }
        .logo {
            font-size: 20px;
            font-weight: bold;
            color: #FF6B35;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .logo span {
            color: #1e293b;
        }
        .title {
            font-size: 32px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: 2px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #6b7280;
            margin-bottom: 25px;
        }
        .award-text {
            font-size: 14px;
            color: #4b5563;
            font-style: italic;
            margin-bottom: 10px;
        }
        .recipient {
            font-size: 28px;
            font-weight: bold;
            color: #d97706;
            border-bottom: 2px solid #e5e7eb;
            display: inline-block;
            padding: 0 30px 5px;
            margin-bottom: 20px;
        }
        .course-text {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 10px;
        }
        .course-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 30px;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
        }
        .details-table td {
            width: 33%;
            text-align: center;
            vertical-align: bottom;
        }
        .signature-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e293b;
        }
        .signature-line {
            border-top: 1px solid #d1d5db;
            margin-top: 5px;
            padding-top: 5px;
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .seal {
            width: 70px;
            height: 70px;
            border: 2px dashed #d97706;
            border-radius: 50%;
            display: inline-block;
            line-height: 70px;
            font-size: 10px;
            font-weight: bold;
            color: #d97706;
        }
        .issued-date {
            font-size: 14px;
            font-weight: bold;
            color: #1e293b;
        }
        .footer-text {
            font-size: 9px;
            color: #9ca3af;
            margin-top: 25px;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="border-outer">
            <div class="border-inner">
                <div class="logo">Edu<span>Platform</span></div>

                <div class="title">{{ __('Certificate') }}</div>
                <div class="subtitle">{{ __('of Completion') }}</div>

                <div class="award-text">{{ __('This is to certify that') }}</div>
                <div class="recipient">{{ $certificate->user->name }}</div>

                <div class="course-text">{{ __('has successfully completed the course') }}:</div>
                <div class="course-name">"{{ $certificate->course->title }}"</div>

                <table class="details-table">
                    <tr>
                        <td>
                            <div class="signature-name">{{ $certificate->course->user->name }}</div>
                            <div class="signature-line">{{ __('Instructor') }}</div>
                        </td>
                        <td>
                            <div class="seal">
                                APPROVED
                            </div>
                        </td>
                        <td>
                            <div class="issued-date">{{ $certificate->issued_at->format('d.m.Y') }}</div>
                            <div class="signature-line">{{ __('Date of Issue') }}</div>
                        </td>
                    </tr>
                </table>

                <div class="footer-text">{{ __('Certificate ID') }}: {{ $certificate->code }} • codify.com</div>
            </div>
        </div>
    </div>
</body>
</html>