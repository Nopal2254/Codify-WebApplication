<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — EduPlatform Instructor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 280px;
            --topbar-h: 68px;

            /* Brand palette – Modern Indigo & Purple SaaS theme */
            --brand:        #6366f1;
            --brand-dark:   #4f46e5;
            --brand-light:  rgba(99, 102, 241,.12);
            --accent:       #6366f1;

            /* Sidebar */
            --sb-bg:        #0A0A0A;
            --sb-bg2:       #111111;
            --sb-text:      #A0A0A0;
            --sb-text-dim:  rgba(255,255,255,.45);
            --sb-active:    #6366f1;
            --sb-hover:     rgba(99, 102, 241,.12);
            --sb-border:    rgba(255,255,255,.06);

            /* Cards & Panels */
            --card-bg:      rgba(20,20,20,.6);
            --card-bg2:     rgba(30,30,30,.4);
            --card-border:  rgba(255,255,255,.06);
            --card-shadow:  0 10px 30px -10px rgba(0, 0, 0, 0.3);
            --card-shadow-h: 0 15px 35px -5px rgba(0, 0, 0, 0.45);

            /* Main Colors */
            --page-bg:      #090d16;
            --text:         #f1f5f9;
            --text-muted:   #94a3b8;
            --text-dim:     #64748b;
            --white:        #ffffff;

            /* Utility */
            --green:        #10b981;
            --red:          #ef4444;
            --yellow:       #f59e0b;
            --blue:         #3b82f6;

            /* Borders & Radius */
            --radius-xl:    18px;
            --radius-lg:    14px;
            --radius-md:    10px;
            --radius-sm:    6px;
            --radius-full:  999px;

            --transition: all .22s ease;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { 
            font-family: 'Inter', sans-serif;
            background: var(--page-bg);
            color: var(--text);
            font-size: 14.5px;
        }

        /* ── SIDEBAR ───────────────────────────────────────────── */
        .ed-sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-bg2) 100%);
            display: flex;
            flex-direction: column;
            z-index: 1040;
            box-shadow: 4px 0 40px rgba(0,0,0,.5);
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            border-right: 1px solid var(--sb-border);
        }

        /* Logo area */
        .ed-sidebar-logo {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--sb-border);
            text-decoration: none;
            flex-shrink: 0;
        }
        .ed-logo-mark {
            width: 42px; height: 42px;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
            box-shadow: var(--card-shadow-h);
            flex-shrink: 0;
        }
        .ed-logo-text {
            display: flex;
            flex-direction: column;
        }
        .ed-logo-text strong {
            font-size: 16px;
            color: #fff;
            font-weight: 800;
        }
        .ed-logo-text span {
            font-size: 11px;
            color: var(--sb-text-dim);
            display: block;
        }

        /* Nav scroll area */
        .ed-sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.05) transparent;
        }
        .ed-sidebar-nav::-webkit-scrollbar { width: 4px; }
        .ed-sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.05); border-radius: 4px; }

        .ed-nav-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--sb-text-dim);
            padding: 14px 12px 6px;
        }

        /* Nav items */
        .ed-nav-link, .ed-sub-link {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
            gap: 11px;
            width: 100%;
            padding: 10px 13px;
            border-radius: var(--radius-md);
            color: var(--sb-text);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            border: 0;
            background: transparent;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 2px;
        }
        .ed-nav-link .nav-icon {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,.05);
            transition: var(--transition);
        }
        .ed-nav-link:hover, .ed-nav-link.active {
            background: var(--sb-hover);
            color: #fff;
        }
        .ed-nav-link:hover .nav-icon {
            background: var(--brand);
            box-shadow: var(--card-shadow-h);
        }
        .ed-nav-link.active {
            background: linear-gradient(135deg, var(--brand), var(--accent)) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(99, 102, 241, 0.25) !important;
        }
        .ed-nav-link.active .nav-icon {
            background: rgba(255, 255, 255, 0.2) !important;
            box-shadow: none !important;
            color: #ffffff !important;
        }
        .ed-nav-link .chevron { margin-left: auto; transition: transform .22s; font-size: 11px; opacity: .5; }
        .ed-nav-link[aria-expanded="true"] .chevron { transform: rotate(180deg); }

        /* Submenu */
        .ed-submenu { padding-left: 46px; }
        .ed-sub-link {
            padding: 9px 12px;
            font-size: 13px;
            color: rgba(255,255,255,.6);
            margin-bottom: 1px;
        }
        .ed-sub-link:hover, .ed-sub-link.active {
            color: #fff;
            background: rgba(255,255,255,.05);
        }

        .ed-sidebar-footer {
            padding: 16px;
            border-top: 1px solid var(--sb-border);
            background: rgba(0,0,0,.15);
        }
        .ed-user-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .ed-user-avatar-sm {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff;
            font-size: 14px;
        }
        .ed-user-mini-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }
        .ed-user-mini-role {
            font-size: 11px;
            color: var(--sb-text-dim);
        }

        .ed-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            z-index: 1030;
            opacity: 0; visibility: hidden;
            transition: var(--transition);
        }

        .ed-shell { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }

        /* ── TOPBAR ────────────────────────────────────────────── */
        .ed-topbar {
            position: sticky; top: 0; z-index: 1020;
            height: var(--topbar-h);
            background: rgba(10,10,10,.85);
            backdrop-filter: blur(18px) saturate(180%);
            -webkit-backdrop-filter: blur(18px) saturate(180%);
            border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 0 24px; gap: 14px;
        }

        .ed-mobile-toggle {
            display: none;
            width: 38px; height: 38px;
            border-radius: var(--radius-md);
            border: 1px solid var(--card-border);
            background: var(--card-bg);
            color: var(--text);
            align-items: center; justify-content: center;
            cursor: pointer; flex-shrink: 0;
        }

        /* Search */
        .ed-search {
            flex: 1; max-width: 360px;
            position: relative;
        }
        .ed-search input {
            width: 100%;
            height: 40px;
            border-radius: 50px;
            border: 1.5px solid var(--card-border);
            background: rgba(255,255,255,.03);
            padding: 0 16px 0 40px;
            font-size: 13.5px;
            color: var(--text);
            outline: none;
            transition: var(--transition);
        }
        .ed-search input:focus {
            border-color: var(--brand);
            background: rgba(255,255,255,.06);
        }
        .ed-search-icon {
            position: absolute; left: 15px; top: 13px;
            color: var(--text-muted); font-size: 14px;
        }

        .ed-topbar-right {
            display: flex; align-items: center; gap: 12px;
        }

        /* Buttons & Icons */
        .ed-icon-btn {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 1px solid var(--card-border);
            background: rgba(255,255,255,.03);
            color: var(--text);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative;
            text-decoration: none;
            transition: var(--transition);
        }
        .ed-icon-btn:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
        }
        .ed-notif-badge {
            position: absolute; top: 10px; right: 10px;
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--brand);
        }

        .ed-profile-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 5px 12px 5px 6px;
            border-radius: 50px;
            border: 1px solid var(--card-border);
            background: rgba(255,255,255,.03);
            color: var(--text);
            cursor: pointer;
            transition: var(--transition);
        }
        .ed-profile-btn:hover {
            background: rgba(255,255,255,.08);
        }
        .ed-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 12.5px;
        }
        .ed-profile-name {
            font-size: 13.5px; font-weight: 600;
        }

        /* Custom dropdown override for profile and other topbar elements */
        .dropdown-menu {
            background: #111827 !important; /* Solid Slate 900 background */
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5), 0 8px 10px -6px rgba(0, 0, 0, 0.5) !important;
            backdrop-filter: blur(12px);
            z-index: 1060 !important; /* Ensure it is above page actions and all content */
        }
        .dropdown-menu .border-bottom {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dropdown-menu .dropdown-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        }
        .dropdown-item {
            color: #d1d5db !important; /* Light gray text */
            transition: all 0.2s ease;
            font-size: 13.5px;
            font-weight: 500;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
        }
        .dropdown-item i {
            transition: transform 0.2s ease;
        }
        .dropdown-item:hover i {
            transform: scale(1.05);
        }
        .dropdown-item.text-danger {
            color: #ef4444 !important;
        }
        .dropdown-item.text-danger:hover {
            background-color: rgba(239, 68, 68, 0.08) !important;
            color: #fca5a5 !important;
        }

        /* ── BREADBAR ──────────────────────────────────────────── */
        .ed-breadbar {
            padding: 24px 24px 0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .ed-page-title {
            font-size: 24px; font-weight: 800; color: #fff;
            letter-spacing: -.02em;
        }
        .ed-breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 12.5px; color: var(--text-muted);
        }
        .ed-breadcrumb a {
            color: var(--brand); text-decoration: none;
        }
        .ed-breadcrumb a:hover { text-decoration: underline; }

        /* ── CONTENT BODY ──────────────────────────────────────── */
        .ed-content {
            flex: 1; padding: 24px;
        }

        /* ── CARDS ─────────────────────────────────────────────── */
        .ed-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            overflow: hidden;
            transition: var(--transition);
        }
        .ed-card:hover {
            border-color: rgba(255,255,255,.1);
            box-shadow: var(--card-shadow-h);
        }
        .ed-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .ed-card-title {
            font-size: 16px; font-weight: 700; color: #fff;
            display: flex; align-items: center; gap: 8px;
        }
        .ed-card-subtitle {
            font-size: 12px; color: var(--text-muted); margin-top: 2px;
        }
        .ed-card-body { padding: 24px; }

        /* ── ALERTS ────────────────────────────────────────────── */
        .ed-alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-size: 13.5px; margin-bottom: 20px;
        }
        .ed-alert-success { background: rgba(16,185,129,.08); border-left: 3px solid var(--green); color: #10B981; }
        .ed-alert-error   { background: rgba(239,68,68,.08); border-left: 3px solid var(--red); color: #EF4444; }
        .ed-alert-close { margin-left: auto; background: none; border: 0; cursor: pointer; opacity: .5; font-size: 16px; line-height: 1; color: inherit; }
        .ed-alert-close:hover { opacity: 1; }

        /* ── BUTTONS ───────────────────────────────────────────── */
        .ed-btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 20px; border-radius: var(--radius-md);
            font-size: 13.5px; font-weight: 600; text-decoration: none;
            cursor: pointer; transition: var(--transition); border: 0;
        }
        .ed-btn-primary { background: var(--brand); color: #fff; }
        .ed-btn-primary:hover { background: var(--brand-dark); color: #fff; }

        /* Dropzone & form elements */
        .form-control, .form-select {
            background: rgba(255,255,255,.03);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            color: var(--text);
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition);
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,.06);
            border-color: var(--brand);
            color: #fff;
            box-shadow: none;
        }

        /* Badges */
        .ed-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 11px;
            border-radius: 50px;
            font-size: 11.5px; font-weight: 600;
            letter-spacing: .01em;
        }
        .ed-badge-green  { background: rgba(16,185,129,.1); color: #10B981; }
        .ed-badge-yellow { background: rgba(245,158,11,.1); color: #F59E0B; }
        .ed-badge-gray   { background: rgba(15,23,42,.05); color: var(--text-muted); }
        .ed-badge-indigo { background: var(--brand-light);  color: var(--brand); }
        .ed-badge-red    { background: rgba(239,68,68,.1); color: #ef4444; }
        .ed-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: .7; }

        /* Tables */
        .ed-table {
            color: var(--text) !important;
            margin-bottom: 0;
            vertical-align: middle;
        }
        .ed-table th {
            border-bottom: 1px solid var(--card-border) !important;
            color: var(--text-muted) !important;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
            padding: 12px 16px !important;
            background: transparent !important;
        }
        .ed-table td {
            border-bottom: 1px solid var(--card-border) !important;
            padding: 16px !important;
            background: transparent !important;
        }

        /* Custom Inputs & Labels */
        .ed-form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .ed-input, .ed-textarea, .ed-select {
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-md);
            color: var(--text);
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            transition: var(--transition);
        }
        .ed-input:focus, .ed-textarea:focus, .ed-select:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--brand);
            color: #fff;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
        }
        .ed-textarea {
            resize: vertical;
            min-height: 100px;
        }
        .ed-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 12px 12px;
            padding-right: 40px;
        }
        .ed-feedback {
            font-size: 12px;
            color: var(--red);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .ed-feedback i {
            font-size: 11px;
        }

        /* Input groups */
        .ed-input-group {
            display: flex;
            align-items: stretch;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            overflow: hidden;
            transition: var(--transition);
        }
        .ed-input-group:focus-within {
            border-color: var(--brand);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
        }
        .ed-input-prefix {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 14px;
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-muted);
            border-right: 1px solid var(--card-border);
            font-size: 14px;
            font-weight: 600;
        }
        .ed-input-group .ed-input {
            border: 0;
            background: transparent;
            border-radius: 0;
            flex: 1;
        }
        .ed-input-group .ed-input:focus {
            background: transparent;
            box-shadow: none;
        }

        /* Dropzone Upload */
        .ed-dropzone {
            border: 2px dashed rgba(255, 255, 255, 0.15);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.01);
            padding: 32px 20px;
            text-align: center;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
        }
        .ed-dropzone:hover {
            border-color: var(--brand);
            background: rgba(99, 102, 241, 0.02);
        }
        .ed-dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }
        .ed-dropzone-icon {
            font-size: 32px;
            color: var(--text-muted);
            margin-bottom: 12px;
            transition: var(--transition);
        }
        .ed-dropzone:hover .ed-dropzone-icon {
            color: var(--brand);
            transform: translateY(-2px);
        }
        .ed-dropzone-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
        }
        .ed-dropzone-hint {
            font-size: 12px;
            color: var(--text-muted);
        }
        #ed-preview-wrap {
            display: none;
            position: relative;
            z-index: 20;
        }
        #ed-preview-img {
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
            border-radius: var(--radius-md);
            border: 1.5px solid var(--card-border);
        }

        /* Outline & Danger Buttons */
        .ed-btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--text);
        }
        .ed-btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.25);
            color: #fff;
        }
        .ed-btn-danger {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
        }
        .ed-btn-danger:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.35);
            color: #fff;
        }

        /* Thumbnails in Tables */
        .ed-thumb {
            width: 68px;
            height: 44px;
            border-radius: var(--radius-md);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
        }
        .ed-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Action Buttons */
        .ed-action-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--card-border);
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
        }
        .ed-action-btn:hover {
            color: #fff;
        }
        .ed-action-view:hover {
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            color: #3b82f6;
        }
        .ed-action-edit:hover {
            background: rgba(245, 158, 11, 0.15);
            border-color: rgba(245, 158, 11, 0.3);
            color: #f59e0b;
        }
        .ed-action-delete:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        /* KPI Card Styles */
        .t-kpi-card {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
            height: 100%;
            border-radius: 18px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            transition: var(--transition);
        }
        .t-kpi-card:hover {
            transform: translateY(-3px);
            border-color: rgba(99, 102, 241, 0.25);
            box-shadow: var(--card-shadow-h);
        }
        .t-kpi-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .t-kpi-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            margin-bottom: 4px;
        }
        .t-kpi-value {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
        }

        /* ── Responsive ── */
        @media (max-width: 991.98px) {
            .ed-sidebar { transform: translateX(-100%); }
            .ed-shell { margin-left: 0; }
            .ed-mobile-toggle { display: flex; }
            body.ed-sidebar-open .ed-sidebar { transform: translateX(0); }
            body.ed-sidebar-open .ed-backdrop { opacity: 1; visibility: visible; }
        }
    </style>
    @stack('styles')
    @yield('extra-css')
</head>
<body>
@php
    $__user = auth()->user();
@endphp

{{-- Backdrop --}}
<div class="ed-backdrop" id="edBackdrop"></div>

{{-- Sidebar --}}
<aside class="ed-sidebar" id="edSidebar">
    <a href="{{ route('teacher.dashboard') }}" class="ed-sidebar-logo">
        <div style="background: none; box-shadow: none; height: 38px;">
            <img src="{{ asset('logo_dash.png') }}" alt="Logo" style="height: 100%; object-fit: contain;">
        </div>
    </a>

    <nav class="ed-sidebar-nav">
        <div class="ed-nav-label">{{ __('messages.dash.main') }}</div>

        {{-- Dashboard --}}
        <a href="{{ route('teacher.dashboard') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-gauge-high"></i></span>
            {{ __('messages.dash.dashboard') }}
        </a>

        {{-- Courses (collapsible) --}}
        <button type="button"
                class="ed-nav-link {{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}"
                data-bs-toggle="collapse"
                data-bs-target="#sbCoursesMenu"
                aria-expanded="{{ request()->routeIs('teacher.courses.*') ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fa-solid fa-book-open"></i></span>
            <span class="flex-grow-1">{{ __('messages.dash.my_courses') }}</span>
            <i class="fa-solid fa-chevron-down chevron"></i>
        </button>
        <div class="collapse {{ request()->routeIs('teacher.courses.*') ? 'show' : '' }}" id="sbCoursesMenu">
            <div class="ed-submenu py-1">
                <a href="{{ route('teacher.courses.index') }}"
                   class="ed-sub-link {{ request()->routeIs('teacher.courses.index') ? 'active' : '' }}">
                    {{ __('messages.dash.course_list') }}
                </a>
                <a href="{{ route('teacher.courses.create') }}"
                   class="ed-sub-link {{ request()->routeIs('teacher.courses.create') ? 'active' : '' }}">
                    {{ __('messages.dash.add_course') }}
                </a>
            </div>
        </div>

        {{-- Lessons --}}
        <a href="{{ route('teacher.lessons.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.lessons.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-play-circle"></i></span>
            {{ __('messages.dash.lessons') }}
        </a>

        {{-- Modules --}}
        <a href="{{ route('teacher.modules.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.modules.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-cubes"></i></span>
            {{ __('messages.dash.modules') }}
        </a>

        {{-- Coding Challenges --}}
        <a href="{{ route('teacher.coding.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.coding.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-code"></i></span>
            {{ __('messages.dash.coding_challenges') }}
        </a>

        {{-- Assignments --}}
        <a href="{{ route('teacher.assignments.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.assignments.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-tasks"></i></span>
            {{ __('messages.dash.assignments') }}
        </a>

        {{-- Quizzes --}}
        <a href="{{ route('teacher.quizzes.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.quizzes.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-circle-question"></i></span>
            {{ __('messages.dash.manage_quizzes') }}
        </a>

        {{-- Students --}}
        <a href="{{ route('teacher.students.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.students.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
            {{ __('messages.dash.students_list') }}
        </a>

        {{-- Discussions Q&A --}}
        <a href="{{ route('teacher.discussions.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.discussions.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-comments"></i></span>
            {{ __('messages.dash.discussions_qa') }}
        </a>

        {{-- Announcements --}}
        <a href="{{ route('teacher.announcements.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.announcements.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span>
            {{ __('messages.announcements.announcements') }}
        </a>

        {{-- Reviews --}}
        <a href="{{ route('teacher.reviews.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.reviews.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-star"></i></span>
            {{ __('messages.dash.reviews') }}
        </a>

        {{-- Revenue --}}
        <a href="{{ route('teacher.revenue.index') }}"
           class="ed-nav-link {{ request()->routeIs('teacher.revenue.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-wallet"></i></span>
            {{ __('messages.dash.revenue_payments') }}
        </a>

        <div class="ed-nav-label mt-2">{{ __('messages.dash.account') }}</div>

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="ed-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fa-solid fa-user-pen"></i></span>
            {{ __('messages.dash.profile') }}
        </a>

        {{-- View Site --}}
        <a href="{{ route('home') }}" class="ed-nav-link">
            <span class="nav-icon"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
            {{ __('messages.dash.view_site') }}
        </a>
    </nav>

    <div class="ed-sidebar-footer">
        <div class="ed-user-mini">
            <div class="ed-user-avatar-sm">{{ strtoupper(substr($__user->name ?? 'I', 0, 1)) }}</div>
            <div>
                <div class="ed-user-mini-name">{{ $__user->name ?? 'Instructor' }}</div>
                <div class="ed-user-mini-role">{{ __('messages.dash.instructor') }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="ed-nav-link" style="margin-bottom:0; color:var(--red);">
                <span class="nav-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                {{ __('messages.dash.logout') }}
            </button>
        </form>
    </div>
</aside>

<div class="ed-shell">
    <header class="ed-topbar">
        <button class="ed-mobile-toggle" id="edSidebarToggle" type="button" aria-label="Toggle sidebar">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="ed-search">
            <i class="fa-solid fa-magnifying-glass ed-search-icon"></i>
            <input type="search" id="globalSearch" placeholder="{{ __('messages.dash.search_placeholder') }}" autocomplete="off">
        </div>

        <div class="ed-topbar-right">
            {{-- Notifications --}}
            <a href="{{ route('notifications.index') }}" class="ed-icon-btn" title="Notifications">
                <i class="fa-solid fa-bell"></i>
                @php
                    $unread = auth()->user()->notifications()->where('is_read', false)->count();
                @endphp
                @if($unread > 0)
                    <span class="ed-notif-badge"></span>
                @endif
            </a>

            {{-- Messages --}}
            <a href="{{ route('messages.index') }}" class="ed-icon-btn" style="position: relative;" title="Messages">
                <i class="fa-solid fa-envelope"></i>
                @php
                    $unreadMsgs = \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', false)->count();
                @endphp
                @if($unreadMsgs > 0)
                    <span class="ed-notif-badge" style="position: absolute; top: 2px; right: 2px; width: 8px; height: 8px; background-color: var(--danger, #f43f5e); border-radius: 50%;"></span>
                @endif
            </a>



            {{-- Profile dropdown --}}
            <div class="dropdown">
                <button type="button" class="ed-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="ed-avatar">{{ strtoupper(substr($__user->name ?? 'I', 0, 1)) }}</div>
                    <span class="ed-profile-name">{{ $__user->name ?? 'Instructor' }}</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px; color:var(--text-muted);"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2" style="min-width:200px;">
                    <li class="px-3 py-2 border-bottom">
                        <div style="font-size:13px; font-weight:700; color:var(--text);">{{ $__user->name }}</div>
                        <div style="font-size:12px; color:var(--text-muted);">{{ $__user->email }}</div>
                    </li>
                    <li><a class="dropdown-item py-2" href="{{ route('teacher.dashboard') }}"><i class="fa-solid fa-gauge-high me-2" style="color:var(--brand);"></i>{{ __('messages.dash.dashboard') }}</a></li>
                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen me-2" style="color:var(--brand);"></i>{{ __('messages.dash.profile') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>{{ __('messages.dash.logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="ed-breadbar">
        <div>
            <div class="ed-page-title">@yield('title', 'Dashboard')</div>
            <nav class="ed-breadcrumb mt-1">
                <a href="{{ route('teacher.dashboard') }}">Home</a>
                <span>/</span>
                <span>@yield('breadcrumb', 'Dashboard')</span>
            </nav>
        </div>
        @yield('page-actions')
    </div>

    <main class="ed-content">
        {{-- Flash alerts --}}
        @if(session('success'))
        <div class="ed-alert ed-alert-success" role="alert">
            <i class="fa-solid fa-circle-check" style="font-size:16px;margin-top:1px;"></i>
            <div style="flex:1;">{{ session('success') }}</div>
            <button class="ed-alert-close" onclick="this.closest('.ed-alert').remove()">×</button>
        </div>
        @endif
        @if(session('error'))
        <div class="ed-alert ed-alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation" style="font-size:16px;margin-top:1px;"></i>
            <div style="flex:1;">{{ session('error') }}</div>
            <button class="ed-alert-close" onclick="this.closest('.ed-alert').remove()">×</button>
        </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
    const body = document.body;
    const toggle = document.getElementById('edSidebarToggle');
    const backdrop = document.getElementById('edBackdrop');

    toggle?.addEventListener('click', () => body.classList.toggle('ed-sidebar-open'));
    backdrop?.addEventListener('click', () => body.classList.remove('ed-sidebar-open'));

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 992) body.classList.remove('ed-sidebar-open');
    });

    document.getElementById('globalSearch')?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && e.target.value.trim()) {
            window.location.href = '/search?q=' + encodeURIComponent(e.target.value.trim());
        }
    });
})();
</script>
@yield('scripts')
</body>
</html>
