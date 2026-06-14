<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Models\SiteSetting::get('site_name', 'EduPlatform') . ' - Learn Without Limits')</title>
    <meta name="description" content="{{ \App\Models\SiteSetting::get('site_description', 'Build skills with courses, certificates, and degrees online from world-class universities and companies.') }}">
    @if($faviconPath = \App\Models\SiteSetting::get('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $faviconPath) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false,
            }
        }
    </script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Dark premium theme */
            --brand: #6366f1;
            --brand-dark: #4f46e5;
            --brand-deeper: #3730a3;
            --brand-light: rgba(99, 102, 241, 0.12);
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --bg-primary: #05070f;
            --bg-secondary: #0f172a;
            --border-color: rgba(99, 102, 241,0.2);
            --border-light: rgba(255,255,255,0.07);
            --success: #10b981;
            --warning: #fbbf24;
            --danger: #f43f5e;
            --star: #fbbf24;
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 18px;
            --radius-full: 9999px;
            --shadow-card: 0 4px 20px rgba(0,0,0,0.3);
            --shadow-hover: 0 12px 40px rgba(0,0,0,0.4);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.3);
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background: #05070f;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            position: relative;
            min-height: 100vh;
        }

        #page-bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(99, 102, 241,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99, 102, 241,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        #glow1 {
            position: fixed; top: -200px; left: -200px;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(139,92,246,0.22) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none; z-index: 0;
        }
        #glow2 {
            position: fixed; top: 100px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,0.18) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none; z-index: 0;
        }
        #glow3 {
            position: fixed; bottom: -100px; left: 30%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99, 102, 241,0.15) 0%, transparent 70%);
            filter: blur(80px);
            pointer-events: none; z-index: 0;
        }

        /* Ensure main layout sections sit on top of background decorations */
        .main-content, .site-header, .site-footer {
            position: relative;
            z-index: 1;
        }

        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }
        button { cursor: pointer; border: none; background: none; font-family: inherit; }
        input, select, textarea { font-family: inherit; }

        /* ============ HEADER ============ */
        .site-header {
            /* Handled by Tailwind floating capsule classes */
        }
        
        /* Dark glassmorphic dropdown overrides for the premium floating navbar */
        #site-header .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            margin-top: 8px;
            background: rgba(15, 23, 42, 0.95) !important;
            border: 1px solid rgba(51, 65, 85, 0.5) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            min-width: 200px !important;
            padding: 8px 0 !important;
            z-index: 100 !important;
        }
        #site-header .dropdown-menu.show {
            display: block !important;
        }
        #site-header .dropdown-item {
            color: #cbd5e1 !important;
            font-size: 14px !important;
            padding: 10px 20px !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            transition: all 0.2s ease !important;
            background: transparent !important;
        }
        #site-header .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #ffffff !important;
        }
        .header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            gap: 16px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }
        .logo {
            font-size: 22px;
            font-weight: 800;
            color: var(--brand);
            letter-spacing: -0.5px;
        }
        .logo span { color: var(--brand-dark); }

        /* Explore Button */
        .explore-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--brand);
            color: #fff;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
        }
        .explore-btn:hover { background: var(--brand-dark); }
        .explore-btn i { font-size: 12px; }

        /* Search */
        .search-container {
            flex: 1;
            max-width: 520px;
            position: relative;
        }
        .search-input {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-full);
            padding: 10px 48px 10px 20px;
            font-size: 14px;
            outline: none;
            transition: var(--transition);
            background: var(--bg-primary);
        }
        .search-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(0,86,210,0.1);
        }
        .search-input::placeholder { color: var(--text-muted); }
        .search-btn {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--brand);
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        .search-btn:hover { background: var(--brand-dark); }
        .search-btn i { font-size: 14px; }

        .header-right {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .dropdown-menu.dropdown-menu-right {
            left: auto;
            right: 0;
        }
        .nav-icon-btn {
            position: relative;
            font-size: 18px;
            color: var(--text-secondary);
            padding: 8px;
            border-radius: 50%;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .nav-icon-btn:hover {
            background: var(--bg-secondary);
            color: var(--brand);
        }
        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--danger);
            color: #html;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }
        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            padding: 4px;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            cursor: pointer;
        }
        .user-menu-btn:hover {
            background: var(--bg-secondary);
        }
        .user-avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            border: 2px solid var(--border-light);
        }
        .user-menu-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }
        .btn {
            padding: 8px 20px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            line-height: 1.4;
        }
        .btn-primary {
            background: var(--brand);
            color: #fff;
            border: 2px solid var(--brand);
        }
        .btn-primary:hover { background: var(--brand-dark); border-color: var(--brand-dark); }
        .btn-outline {
            background: transparent;
            color: var(--brand);
            border: 2px solid var(--brand);
        }
        .btn-outline:hover { background: var(--brand); color: #fff; }
        .btn-ghost {
            background: transparent;
            color: var(--brand);
            border: 2px solid transparent;
        }
        .btn-ghost:hover { background: rgba(0,86,210,0.06); }
        .btn-white {
            background: #fff;
            color: var(--brand);
            border: 2px solid #fff;
        }
        .btn-white:hover { background: #f0f0f0; border-color: #f0f0f0; }
        .btn-lg { padding: 12px 28px; font-size: 16px; }
        .btn-sm { padding: 6px 14px; font-size: 13px; }
        .btn-danger { background: var(--danger); color: #fff; border: 2px solid var(--danger); }
        .btn-danger:hover { background: #c82333; border-color: #c82333; }
        .btn-success { background: var(--success); color: #fff; border: 2px solid var(--success); }

        .nav-link {
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            padding: 4px 8px;
        }
        .nav-link:hover { color: var(--brand); }

        /* ============ DROPDOWN ============ */
        .dropdown { position: relative; }
        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            background: #fff;
            min-width: 260px;
            border-radius: var(--radius-md);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            border: 1px solid var(--border-light);
            z-index: 100;
            padding: 8px 0;
        }
        .dropdown-menu.show { display: block; }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            font-size: 14px;
            color: var(--text-primary);
            transition: var(--transition);
        }
        .dropdown-item:hover {
            background: var(--bg-secondary);
            color: var(--brand);
        }
        .dropdown-item i { color: var(--text-muted); width: 20px; text-align: center; }

        /* ============ MAIN ============ */
        .main-content { min-height: calc(100vh - 64px); }
        .container {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        /* ============ FOOTER ============ */
        .site-footer {
            background: var(--bg-secondary);
            border-top: 1px solid var(--border-light);
            padding: 48px 0 24px;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr repeat(2, 1fr);
            gap: 40px;
            margin-bottom: 40px;
        }
        .footer-brand { font-size: 22px; font-weight: 800; color: var(--brand); margin-bottom: 12px; }
        .footer-desc { font-size: 14px; color: var(--text-secondary); line-height: 1.7; }
        .footer-heading {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer-links { display: flex; flex-direction: column; gap: 10px; }
        .footer-links a,
        .footer-links a:visited {
            font-size: 14px;
            color: var(--text-secondary) !important;
            transition: var(--transition);
            text-decoration: none;
        }
        .footer-links a:hover {
            color: var(--brand) !important;
            text-decoration: none;
        }
        .footer-bottom {
            border-top: 1px solid var(--border-color);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-copy { font-size: 13px; color: var(--text-muted); }
        .footer-social { display: flex; gap: 16px; }
        .footer-social a,
        .footer-social a:visited { color: var(--text-secondary) !important; font-size: 18px; transition: var(--transition); text-decoration: none; }
        .footer-social a:hover { color: var(--brand) !important; text-decoration: none; }
        .footer-social-round {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }
        .footer-social-round a,
        .footer-social-round a:visited {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: var(--text-secondary, #64748b) !important;
            font-size: 16px;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .footer-social-round a:hover {
            background: var(--brand, #6366f1) !important;
            color: #fff !important;
            border-color: var(--brand, #6366f1) !important;
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.4);
        }

        /* ============ CARDS ============ */
        .card {
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }
        .card-img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .card-body { padding: 16px; }
        .card-provider {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        .card-provider-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-secondary);
        }
        .card-provider-name { font-size: 13px; color: var(--text-secondary); font-weight: 500; }
        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.4;
            margin-bottom: 4px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .card-type { font-size: 13px; color: var(--text-secondary); margin-bottom: 8px; }
        .card-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
        }
        .card-rating .stars { color: var(--star); }
        .card-rating .score { font-weight: 700; color: var(--text-primary); }
        .card-rating .count { color: var(--text-muted); }

        /* ============ FORM ELEMENTS ============ */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.03);
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        .form-control::placeholder { color: var(--text-muted); }



        /* ============ SECTION ============ */
        .section { padding: 48px 0; }
        .section-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .section-subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        /* ============ GRID ============ */
        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        /* ============ BADGE ============ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d1e7dd; color: #0f5132; }
        .badge-warning { background: #fff3cd; color: #664d03; }
        .badge-info { background: #cff4fc; color: #055160; }

        /* ============ TABLE ============ */
        .table-container {
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            overflow: hidden;
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            text-align: left;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-light);
        }
        .data-table td {
            padding: 16px 20px;
            font-size: 14px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover { background: #fafbfc; }

        /* ============ MODAL ============ */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-content {
            background: #fff;
            border-radius: var(--radius-lg);
            width: 90%;
            max-width: 480px;
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        /* ============ ALERT ============ */
        .alert {
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .alert-success { background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: repeat(2, 1fr); }
            .search-container { display: none; }
        }
        @media (max-width: 768px) {
            .grid-4, .grid-3 { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .explore-btn { display: none; }
            .nav-link { display: none; }
        }

        /* Premium Glassmorphism and Custom Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.02) !important;
            backdrop-filter: blur(16px) saturate(120%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(120%) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 24px !important;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.05) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .glass-card:hover {
            border-color: rgba(99, 102, 241, 0.3) !important;
            box-shadow: 0 15px 35px -5px rgba(99, 102, 241, 0.15), inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
            transform: translateY(-2px);
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%) !important;
            color: #fff !important;
            border: none !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.4) !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
        }
        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -3px rgba(99, 102, 241, 0.6) !important;
            filter: brightness(1.1);
            color: #fff !important;
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            transition: all 0.2s ease !important;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.05) !important;
            border-color: var(--brand) !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
            outline: none !important;
        }
    </style>
    @yield('extra-css')
</head>
<body>
    <div id="page-bg-grid" aria-hidden="true"></div>
    <div id="glow1" aria-hidden="true"></div>
    <div id="glow2" aria-hidden="true"></div>
    <div id="glow3" aria-hidden="true"></div>

    <!-- ============ HEADER ============ -->
    <header class="max-w-7xl mx-auto mt-4 rounded-full bg-slate-900/90 backdrop-blur-xl border border-slate-700/60 shadow-2xl shadow-black/40 sticky top-4 z-50 px-5 py-2.5 flex items-center justify-between site-header" id="site-header">

        <!-- Left: Logo -->
        <div class="flex items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 no-underline">
                <img src="{{ asset('new Codify.png') }}" alt="Logo" style="height:34px; max-width:120px; object-fit:contain;">
            </a>
        </div>

        <!-- Center: Nav Links -->
        <div class="hidden md:flex items-center gap-7">
            <a href="{{ url('/courses') }}" class="text-slate-300 hover:text-white text-sm font-medium no-underline" style="transition:color .2s;">{{ __('messages.nav.courses') }}</a>

            <div class="relative dropdown" id="category-dropdown">
                <button class="text-slate-300 hover:text-white text-sm font-medium flex items-center gap-1 focus:outline-none" style="background:none;border:none;cursor:pointer;padding:0;transition:color .2s;" onclick="toggleDropdown('category-dropdown')">
                    {{ __('messages.nav.categories') }} <i class="fas fa-chevron-down" style="font-size:9px;margin-top:1px;"></i>
                </button>
                <div class="dropdown-menu" id="category-menu" style="min-width:220px;left:0;">
                    @php
                        $navCategories = \App\Models\Category::where('is_active', true)->get();
                    @endphp
                    @forelse($navCategories as $category)
                        <a href="{{ route('search', ['category' => $category->id]) }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-slate-800/50 no-underline" style="transition:all .2s;">
                            <i class="{{ $category->icon ?? 'fas fa-laptop-code' }} text-violet-400" style="width:14px;"></i>
                            {{ $category->name }}
                        </a>
                    @empty
                        <span class="px-4 py-2 text-xs text-slate-500 block">{{ __('messages.nav.no_categories') }}</span>
                    @endforelse
                </div>
            </div>

            <a href="{{ url('/contact') }}" class="text-slate-300 hover:text-white text-sm font-medium no-underline" style="transition:color .2s;">{{ __('messages.nav.faq') }}</a>
        </div>

        <!-- Right: Actions (Desktop only) -->
        <div class="hidden md:flex items-center gap-3">

            @guest
                <!-- Login link -->
                <a href="{{ url('/login') }}" class="no-underline" style="color:#cbd5e1;font-size:14px;font-weight:500;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">{{ __('messages.nav.login') }}</a>

                <!-- CTA button -->
                <a href="{{ url('/register') }}" class="no-underline" style="background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border-radius:9999px;padding:9px 22px;font-size:14px;font-weight:700;white-space:nowrap;box-shadow:0 0 25px rgba(99, 102, 241,0.3);transition:all .25s;" onmouseover="this.style.boxShadow='0 0 40px rgba(99, 102, 241,0.55)'" onmouseout="this.style.boxShadow='0 0 25px rgba(99, 102, 241,0.3)'">
                    {{ __('messages.nav.register') }}
                </a>

            @endguest

            @auth
                <!-- Role-based panel link -->
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="no-underline" style="color:#cbd5e1;font-size:13px;font-weight:600;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">
                        <i class="fas fa-chart-pie" style="font-size:13px;color:var(--brand);"></i>
                        {{ __('messages.nav.admin_panel') }}
                    </a>
                @elseif(auth()->user()->isTeacher())
                    <a href="{{ route('teacher.dashboard') }}" class="no-underline" style="color:#cbd5e1;font-size:13px;font-weight:600;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">
                        <i class="fas fa-chalkboard-teacher" style="font-size:13px;color:var(--brand);"></i>
                        {{ __('messages.nav.teacher_panel') }}
                    </a>
                @else
                    <a href="{{ route('my-learning') }}" class="no-underline" style="color:#cbd5e1;font-size:13px;font-weight:600;display:flex;align-items:center;gap:6px;white-space:nowrap;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">
                        <i class="fas fa-graduation-cap" style="font-size:13px;color:var(--brand);"></i>
                        {{ __('messages.nav.my_courses') }}
                    </a>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" id="header-logout-form-new" style="display:none;">@csrf</form>
                <a href="#" onclick="event.preventDefault();document.getElementById('header-logout-form-new').submit();" class="no-underline" style="color:#cbd5e1;font-size:13px;font-weight:500;white-space:nowrap;transition:color .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#cbd5e1'">
                    {{ __('messages.nav.logout') }}
                </a>

            @endauth

        </div>

        <!-- Mobile Menu Toggle Button (Mobile only) -->
        <div class="flex md:hidden items-center gap-3">
            <button id="mobile-menu-toggle" class="text-slate-300 hover:text-white p-2 focus:outline-none" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden absolute top-full left-0 right-0 mt-3 p-5 bg-slate-950/95 backdrop-blur-xl border border-slate-800 rounded-3xl shadow-2xl flex flex-col gap-4 z-50">
            <a href="{{ url('/courses') }}" class="text-slate-200 hover:text-white text-base font-semibold py-2 border-b border-white/5 no-underline">{{ __('messages.nav.courses') }}</a>
            <div class="flex flex-col gap-2 py-2 border-b border-white/5">
                <span class="text-xs text-slate-500 uppercase font-bold tracking-wider">{{ __('messages.nav.categories') }}</span>
                @php
                    $navCategories = \App\Models\Category::where('is_active', true)->get();
                @endphp
                @foreach($navCategories as $category)
                    <a href="{{ route('search', ['category' => $category->id]) }}" class="flex items-center gap-2 text-sm text-slate-300 hover:text-white py-1 no-underline">
                        <i class="{{ $category->icon ?? 'fas fa-laptop-code' }} text-violet-400" style="width:14px;"></i>
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            <a href="{{ url('/contact') }}" class="text-slate-200 hover:text-white text-base font-semibold py-2 border-b border-white/5 no-underline">{{ __('messages.nav.faq') }}</a>

            @guest
                <div class="flex flex-col gap-3 pt-2">
                    <a href="{{ url('/login') }}" class="text-slate-200 hover:text-white text-sm font-semibold text-center py-2.5 rounded-xl bg-white/5 border border-white/10 no-underline">{{ __('messages.nav.login') }}</a>
                    <a href="{{ url('/register') }}" class="text-white text-sm font-bold text-center py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-650 no-underline shadow-lg shadow-indigo-500/20">{{ __('messages.nav.register') }}</a>
                </div>
            @else
                <div class="flex flex-col gap-3 pt-2">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-slate-200 hover:text-white text-sm font-semibold no-underline"><i class="fas fa-chart-pie me-2 text-indigo-400"></i>{{ __('messages.nav.admin_panel') }}</a>
                    @elseif(auth()->user()->isTeacher())
                        <a href="{{ route('teacher.dashboard') }}" class="text-slate-200 hover:text-white text-sm font-semibold no-underline"><i class="fas fa-chalkboard-teacher me-2 text-indigo-400"></i>{{ __('messages.nav.teacher_panel') }}</a>
                    @else
                        <a href="{{ route('my-learning') }}" class="text-slate-200 hover:text-white text-sm font-semibold no-underline"><i class="fas fa-graduation-cap me-2 text-indigo-400"></i>{{ __('messages.nav.my_courses') }}</a>
                    @endif
                    <a href="#" onclick="event.preventDefault();document.getElementById('header-logout-form-new').submit();" class="text-rose-400 hover:text-rose-300 text-sm font-semibold mt-2 no-underline"><i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.nav.logout') }}</a>
                </div>
            @endguest

        </div>
    </header>

    <!-- ============ MAIN ============ -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ============ FOOTER ============ -->
    <footer class="site-footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="footer-grid">
                <div>
                    <div class="footer-brand">{{ \App\Models\SiteSetting::get('site_name', 'EduPlatform') }}</div>
                    <p class="footer-desc">{{ \App\Models\SiteSetting::get('site_description', 'Transform your life through education. Learn from the best instructors and institutions around the world, at your own pace.') }}</p>
                    
                    @php
                        $supportPhone = \App\Models\SiteSetting::get('support_phone');
                        $supportEmail = \App\Models\SiteSetting::get('support_email');
                    @endphp
                    @if($supportPhone || $supportEmail)
                        <div style="margin-top: 14px; display: flex; flex-direction: column; gap: 8px;">
                            @if($supportPhone)
                                <a href="tel:{{ $supportPhone }}" style="font-size: 13px; display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); text-decoration: none; transition: color 0.2s;" class="hover:text-white">
                                    <i class="fa-solid fa-phone" style="color: var(--brand, #6366f1); font-size: 12px;"></i> {{ $supportPhone }}
                                </a>
                            @endif
                            @if($supportEmail)
                                <a href="mailto:{{ $supportEmail }}" style="font-size: 13px; display: inline-flex; align-items: center; gap: 8px; color: var(--text-secondary); text-decoration: none; transition: color 0.2s;" class="hover:text-white">
                                    <i class="fa-solid fa-envelope" style="color: var(--brand, #6366f1); font-size: 12px;"></i> {{ $supportEmail }}
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="footer-social-round">
                        @if($inst = \App\Models\SiteSetting::get('social_instagram'))
                            <a href="{{ $inst }}" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($tg = \App\Models\SiteSetting::get('social_telegram'))
                            <a href="{{ $tg }}" target="_blank" title="Telegram"><i class="fab fa-telegram"></i></a>
                        @endif
                        @if($yt = \App\Models\SiteSetting::get('social_youtube'))
                            <a href="{{ $yt }}" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="footer-heading">Popüler Konular</div>
                    <div class="footer-links">
                        @foreach(\App\Models\Category::withCount('courses')->orderBy('courses_count', 'desc')->take(5)->get() as $footerCategory)
                            <a href="/search?category={{ $footerCategory->id }}" class="hover:text-white transition">{{ $footerCategory->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="footer-heading">Platformumuz</div>
                    <div class="footer-links">
                        <a href="/about">Hakkımızda</a>
                        <a href="/search">Tüm Kurslar</a>
                        <a href="/blog">Blog</a>
                        <a href="/contact">Destek & SSS Sayfası</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">© 2026 EduPlatform. Tüm hakları saklıdır. Gururla sunar.</span>
                <div class="footer-social">
                    @if($tg = \App\Models\SiteSetting::get('social_telegram'))
                        <a href="{{ $tg }}" target="_blank"><i class="fab fa-telegram"></i></a>
                    @endif
                    @if($inst = \App\Models\SiteSetting::get('social_instagram'))
                        <a href="{{ $inst }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($yt = \App\Models\SiteSetting::get('social_youtube'))
                        <a href="{{ $yt }}" target="_blank"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            const menu = el.querySelector('.dropdown-menu');
            menu.classList.toggle('show');
        }
        // Close dropdown on outside click
        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown').forEach(function(dd) {
                if (!dd.contains(e.target)) {
                    const menu = dd.querySelector('.dropdown-menu');
                    if (menu) menu.classList.remove('show');
                }
            });
        });

        // Mobile Menu toggling logic
        const mobileToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && e.target !== mobileToggle) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }


    </script>
    @yield('extra-js')
</body>
</html>
