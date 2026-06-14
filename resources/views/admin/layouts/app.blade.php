<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduPlatform Admin - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 280px;
            --brand: #f97316;
            --brand-dark: #ea580c;
            --brand-soft: #fff3ea;
            --bg: #f5f7fb;
            --surface: #ffffff;
            --surface-dark: #0f172a;
            --surface-dark-2: #111827;
            --text: #0f172a;
            --text-soft: #64748b;
            --border: rgba(15, 23, 42, 0.08);
            --shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
            --radius-xl: 24px;
            --radius-lg: 18px;
            --radius-md: 14px;
            --radius-sm: 10px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            margin: 0;
            font-family: 'Manrope', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(249, 115, 22, 0.08), transparent 32%),
                linear-gradient(180deg, #f8fafc 0%, #f5f7fb 100%);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        a { text-decoration: none; }
        .admin-shell { min-height: 100vh; }

        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(2px);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: all .25s ease;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0b1220 0%, #111827 100%);
            color: #e5e7eb;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,.06);
            box-shadow: 12px 0 30px rgba(15, 23, 42, 0.14);
            transform: translateX(0);
            transition: transform .25s ease;
        }

        .sidebar-header {
            padding: 24px 22px 18px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .brand-mark {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--brand), #fb923c);
            color: #fff;
            box-shadow: 0 12px 24px rgba(249, 115, 22, .35);
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            color: rgba(226, 232, 240, .65);
            font-size: 12px;
            margin-top: 2px;
        }

        .sidebar-content {
            padding: 18px 14px 18px;
            overflow-y: auto;
            flex: 1;
        }

        .menu-section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: rgba(226, 232, 240, .45);
            padding: 10px 12px 8px;
        }

        .menu-link,
        .submenu-link,
        .user-link {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            border: 0;
            border-radius: 14px;
            color: #e2e8f0;
            background: transparent;
            padding: 12px 14px;
            font-weight: 600;
            text-align: left;
            transition: all .2s ease;
        }

        .menu-link:hover,
        .submenu-link:hover,
        .user-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .menu-link.active,
        .submenu-link.active {
            background: linear-gradient(135deg, rgba(249,115,22,.18), rgba(249,115,22,.08));
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(249,115,22,.22);
        }

        .menu-link i,
        .submenu-link i,
        .user-link i { width: 18px; text-align: center; }

        .submenu-wrap {
            margin: 6px 0 10px;
            padding-left: 10px;
        }

        .submenu-link {
            margin: 4px 0;
            padding-left: 16px;
            font-size: 14px;
            color: rgba(226, 232, 240, .86);
        }

        .content-shell {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: rgba(255, 255, 255, .82);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }

        .page-title {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .search-bar {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 10px 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
        }

        .search-bar input {
            border: 0;
            outline: 0;
            width: 100%;
            font-size: 14px;
            background: transparent;
        }

        .search-bar input::placeholder { color: #94a3b8; }

        .icon-pill {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            position: relative;
        }

        .icon-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            background: var(--brand);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 800;
            padding: 0 5px;
        }

        .avatar-circle {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--brand), #fb923c);
            color: #fff;
            font-weight: 800;
        }

        .content-body {
            flex: 1;
            padding: 28px;
        }

        .edudash-card {
            background: rgba(255,255,255,.92);
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .edudash-card-header {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .edudash-card-title {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .edudash-card-body { padding: 24px; }

        .form-control,
        .form-select {
            border-radius: 14px;
            border-color: rgba(15, 23, 42, 0.12);
            padding: .8rem 1rem;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(249, 115, 22, 0.45);
        }

        .btn {
            border-radius: 14px;
            font-weight: 700;
        }

        .btn-primary {
            --bs-btn-bg: var(--brand);
            --bs-btn-border-color: var(--brand);
            --bs-btn-hover-bg: var(--brand-dark);
            --bs-btn-hover-border-color: var(--brand-dark);
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
        }

        .course-thumb {
            width: 76px;
            height: 54px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: #e2e8f0;
        }

        .course-thumb-fallback {
            width: 76px;
            height: 54px;
            border-radius: 14px;
            background: linear-gradient(135deg, #0f172a, #334155);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .price-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--brand-soft);
            color: #c2410c;
            font-weight: 800;
            white-space: nowrap;
        }

        .dropzone {
            border: 1.5px dashed rgba(249,115,22,.35);
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(249,115,22,.05), rgba(249,115,22,.02));
            padding: 20px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            body.sidebar-open .sidebar-backdrop {
                opacity: 1;
                visibility: visible;
            }

            .content-shell {
                margin-left: 0;
            }

            .content-body {
                padding: 18px;
            }
        }

        @media (max-width: 767.98px) {
            .page-title { font-size: 18px; }
            .edudash-card-header,
            .edudash-card-body { padding: 18px; }
        }
    </style>
    @stack('styles')
    @yield('extra-css')
</head>
<body>
@php
    $currentUser = auth()->user();
    $unreadNotifications = $currentUser
        ? \App\Models\Notification::query()->where('user_id', $currentUser->id)->where('is_read', false)->count()
        : 0;
    $recentNotifications = $currentUser
        ? \App\Models\Notification::query()->where('user_id', $currentUser->id)->latest()->limit(5)->get()
        : collect();
@endphp

<div class="sidebar-backdrop d-lg-none" data-sidebar-close></div>

<div class="admin-shell">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center">
                <div style="background: none; box-shadow: none; height: 38px;">
                    <img src="{{ asset('new Codify.png') }}" alt="Logo" style="height: 100%; object-fit: contain;">
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <div class="menu-section-label">Main</div>

            <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <button class="menu-link {{ (request()->routeIs('admin.courses.*') || request()->routeIs('admin.categories.*')) ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#manageCoursesMenu" aria-expanded="{{ (request()->routeIs('admin.courses.*') || request()->routeIs('admin.categories.*')) ? 'true' : 'false' }}" aria-controls="manageCoursesMenu">
                <i class="fa-solid fa-book-open"></i>
                <span class="flex-grow-1">Manage Courses</span>
                <i class="fa-solid fa-chevron-down small"></i>
            </button>

            <div class="collapse {{ (request()->routeIs('admin.courses.*') || request()->routeIs('admin.categories.*')) ? 'show' : '' }}" id="manageCoursesMenu">
                <div class="submenu-wrap">
                    <a href="{{ route('admin.courses.index') }}" class="submenu-link {{ request()->routeIs('admin.courses.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-list-ul"></i>
                        <span>Course List</span>
                    </a>
                    <a href="{{ route('admin.courses.create') }}" class="submenu-link {{ request()->routeIs('admin.courses.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Add New Course</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="submenu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-tags"></i>
                        <span>{{ __('messages.admin.categories.title') }}</span>
                    </a>
                </div>
            </div>

            <button class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#userManagementMenu" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}" aria-controls="userManagementMenu">
                <i class="fa-solid fa-users-gear"></i>
                <span class="flex-grow-1">User Management</span>
                <i class="fa-solid fa-chevron-down small"></i>
            </button>

            <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="userManagementMenu">
                <div class="submenu-wrap">
                    <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="submenu-link {{ request()->routeIs('admin.users.index') && request('role') === 'student' ? 'active' : '' }}">
                        <i class="fa-solid fa-user-graduate"></i>
                        <span>Students</span>
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'instructor']) }}" class="submenu-link {{ request()->routeIs('admin.users.index') && request('role') === 'instructor' ? 'active' : '' }}">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span>Instructors</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.sales.index') }}" class="menu-link {{ request()->routeIs('admin.sales.index') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i>
                <span>Enrollments & Sales</span>
            </a>

            <a href="{{ route('admin.content-review.index') }}" class="menu-link {{ request()->routeIs('admin.content-review.index') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i>
                <span>Content Review</span>
            </a>

            <a href="{{ route('admin.announcements.index') }}" class="menu-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Announcements</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="menu-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="fa-solid fa-user-gear"></i>
                <span>Profile</span>
            </a>

            <div class="menu-section-label mt-3">System</div>

            <a href="{{ route('home') }}" class="menu-link">
                <i class="fa-solid fa-house"></i>
                <span>View Site</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i>
                <span>Global Settings</span>
            </a>

            <a href="{{ route('admin.modules.index') }}" class="menu-link {{ request()->routeIs('admin.modules.index') ? 'active' : '' }}">
                <i class="fa-solid fa-cubes"></i>
                <span>{{ __('messages.admin.modules.title') }}</span>
            </a>
        </div>

        <div class="p-3 border-top border-white border-opacity-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-link w-100">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="content-shell">
        <header class="topbar">
            <div class="container-fluid py-3">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-light d-lg-none shadow-sm" type="button" data-sidebar-toggle aria-label="Toggle sidebar">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div class="flex-grow-1">
                        <div class="page-title">@yield('title')</div>
                        <div class="text-muted small">Modern LMS admin workspace</div>
                    </div>

                    <form action="{{ route('search') }}" method="GET" class="d-none d-md-flex align-items-center gap-2 search-bar me-auto ms-lg-4" style="min-width: 320px; max-width: 460px; width: 100%;">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        <input type="search" name="q" value="{{ request('q') }}" placeholder="Search courses, instructors, categories">
                    </form>

                    <div class="dropdown">
                        <button class="icon-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-bell"></i>
                            @if($unreadNotifications > 0)
                                <span class="icon-badge">{{ $unreadNotifications > 9 ? '9+' : $unreadNotifications }}</span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-0 overflow-hidden" style="min-width: 320px; border-radius: 18px;">
                            <div class="px-3 py-3 border-bottom bg-light">
                                <div class="fw-bold">Notifications</div>
                                <div class="text-muted small">{{ $unreadNotifications }} unread</div>
                            </div>
                            <div style="max-height: 320px; overflow:auto;">
                                @forelse($recentNotifications as $notification)
                                    <a href="{{ $notification->url ?: '#' }}" class="dropdown-item py-3 px-3 border-bottom">
                                        <div class="fw-semibold">{{ $notification->title }}</div>
                                        <div class="text-muted small">{{ \Illuminate\Support\Str::limit($notification->body, 72) }}</div>
                                    </a>
                                @empty
                                    <div class="px-3 py-4 text-center text-muted">No notifications yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-light d-flex align-items-center gap-2 shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">{{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}</div>
                            <span class="d-none d-lg-inline text-start">
                                <span class="d-block fw-bold">{{ $currentUser->name ?? 'Admin' }}</span>
                                <small class="text-muted">Administrator</small>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="min-width: 240px; border-radius: 18px;">
                            <div class="px-3 py-2 border-bottom mb-2">
                                <div class="fw-bold">{{ $currentUser->name ?? 'Admin' }}</div>
                                <div class="text-muted small">{{ $currentUser->email ?? '' }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item rounded-3 py-2">
                                <i class="fa-solid fa-user-gear me-2 text-muted"></i> Profile
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="dropdown-item rounded-3 py-2">
                                <i class="fa-solid fa-gauge-high me-2 text-muted"></i> Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        const body = document.body;
        const closeBackdrop = document.querySelector('[data-sidebar-close]');
        const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');

        toggleButtons.forEach((button) => {
            button.addEventListener('click', () => body.classList.toggle('sidebar-open'));
        });

        if (closeBackdrop) {
            closeBackdrop.addEventListener('click', () => body.classList.remove('sidebar-open'));
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                body.classList.remove('sidebar-open');
            }
        });
    })();
</script>
@stack('scripts')
@yield('scripts')
</body>
</html>
