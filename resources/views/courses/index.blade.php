@extends('layouts.app')

@section('title', 'My Courses | Codify')
@section('page-title', 'My Courses')

@section('extra-css')
<style>
    /* ── Dashboard Page ────────────────────────── */
    .dash-page {
        min-height: calc(100vh - 70px);
    }

    /* ── Header ────────────────────────────────── */
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .dash-header-title {
        font-size: 30px;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.5px;
    }
    .dash-header-sub {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 4px;
    }
    .btn-create {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: var(--brand);
        color: #fff;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
    }
    .btn-create:hover {
        background: var(--brand-dark);
        box-shadow: var(--shadow-brand);
        transform: translateY(-1px);
    }

    /* ── Stats Row ─────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }
    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: var(--transition);
    }
    .stat-card:hover {
        border-color: var(--border-md);
        background: var(--card-bg2);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-icon.courses {
        background: rgba(59,130,246,.12);
        color: var(--brand);
    }
    .stat-icon.students {
        background: rgba(16,185,129,.12);
        color: var(--success);
    }
    .stat-icon.rating {
        background: rgba(245,158,11,.12);
        color: var(--star);
    }
    .stat-icon.revenue {
        background: rgba(139,92,246,.12);
        color: #4f46e5;
    }
    .stat-number {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
    }
    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* ── Table Container ───────────────────────── */
    .table-wrap {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        overflow: hidden;
    }
    .table-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
    }
    .table-title-row h2 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }
    .table-title-row span {
        font-size: 13px;
        color: var(--text-muted);
    }

    .courses-table {
        width: 100%;
        border-collapse: collapse;
    }
    .courses-table thead th {
        padding: 14px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        background: var(--card-bg2);
        border-bottom: 1px solid var(--border);
    }
    .courses-table thead th:last-child {
        text-align: right;
    }
    .courses-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: var(--transition);
    }
    .courses-table tbody tr:last-child {
        border-bottom: none;
    }
    .courses-table tbody tr:hover {
        background: rgba(59,130,246,.03);
    }
    .courses-table tbody td {
        padding: 16px 24px;
        font-size: 14px;
        color: var(--text-secondary);
        vertical-align: middle;
    }
    .courses-table tbody td:last-child {
        text-align: right;
    }

    /* Course cell */
    .course-cell {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .course-thumb {
        width: 60px;
        height: 42px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid var(--border);
    }
    .course-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 14px;
        margin-bottom: 2px;
    }
    .course-cat {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* Rating cell */
    .rating-cell {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .rating-cell i {
        color: var(--star);
        font-size: 12px;
    }

    /* Action buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        transition: var(--transition);
        color: var(--text-muted);
        font-size: 14px;
        border: 1px solid transparent;
        background: none;
        cursor: pointer;
        text-decoration: none;
    }
    .action-btn:hover {
        background: var(--card-bg2);
        border-color: var(--border);
    }
    .action-btn.view:hover {
        color: var(--brand);
        border-color: rgba(59,130,246,.2);
        background: rgba(59,130,246,.08);
    }
    .action-btn.edit:hover {
        color: var(--star);
        border-color: rgba(245,158,11,.2);
        background: rgba(245,158,11,.08);
    }
    .action-btn.delete:hover {
        color: var(--danger);
        border-color: rgba(239,68,68,.2);
        background: rgba(239,68,68,.08);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
    }
    .empty-state-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(59,130,246,.08);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        color: var(--brand);
    }
    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .empty-state p {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    /* Pagination */
    .pagination-wrap {
        padding: 20px 24px;
        border-top: 1px solid var(--border);
    }
    .pagination-wrap nav {
        display: flex;
        justify-content: center;
    }
    .pagination-wrap .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pagination-wrap .page-item .page-link,
    .pagination-wrap .page-item span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        background: transparent;
        border: 1px solid var(--border);
        transition: var(--transition);
        text-decoration: none;
    }
    .pagination-wrap .page-item .page-link:hover {
        background: var(--brand-light);
        color: var(--brand);
        border-color: var(--brand);
    }
    .pagination-wrap .page-item.active span,
    .pagination-wrap .page-item.active .page-link {
        background: var(--brand);
        color: #fff;
        border-color: var(--brand);
    }
    .pagination-wrap .page-item.disabled span {
        color: var(--text-muted);
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* ── Delete Modal ──────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 2000;
        justify-content: center;
        align-items: center;
        padding: 24px;
    }
    .modal-overlay.show {
        display: flex;
    }
    .modal-box {
        background: var(--card-bg2);
        border: 1px solid var(--border-md);
        border-radius: var(--radius-lg);
        width: 100%;
        max-width: 440px;
        padding: 32px;
        box-shadow: var(--shadow-lg);
        text-align: center;
        animation: modalIn 0.2s ease;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        background: rgba(239,68,68,.1);
        color: var(--danger);
    }
    .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .modal-text {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 28px;
        line-height: 1.6;
    }
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    /* ── Responsive ─────────────────────────────── */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .courses-table thead { display: none; }
        .courses-table tbody tr {
            display: block;
            padding: 16px 24px;
        }
        .courses-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border: none;
        }
        .courses-table tbody td::before {
            content: attr(data-label);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-right: 12px;
        }
        .courses-table tbody td:last-child { text-align: left; }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .dash-header { flex-direction: column; align-items: flex-start; }
    }
</style>
@endsection

@section('content')
<div class="dash-page">

    {{-- Header --}}
    <div class="dash-header">
        <div>
            <h1 class="dash-header-title">My Courses</h1>
            <p class="dash-header-sub">Manage your courses, track performance, and engage with students.</p>
        </div>
        <a href="{{ route('teacher.courses.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> Create New Course
        </a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stats Row --}}
    @php
        $totalCourses = $courses->total();
        $totalStudents = $courses->sum('enrollments_count');
        $ratedCourses = $courses->filter(fn($c) => $c->average_rating > 0);
        $avgRating = $ratedCourses->count() > 0 ? round($ratedCourses->avg('average_rating'), 1) : 0;
        $totalRevenue = $courses->sum(fn($c) => $c->price * $c->enrollments_count);
    @endphp
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon courses"><i class="fas fa-book-open"></i></div>
            <div>
                <div class="stat-number">{{ number_format($totalCourses) }}</div>
                <div class="stat-label">Total Courses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon students"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-number">{{ number_format($totalStudents) }}</div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rating"><i class="fas fa-star"></i></div>
            <div>
                <div class="stat-number">{{ $avgRating > 0 ? $avgRating : '—' }}</div>
                <div class="stat-label">Avg. Rating</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon revenue"><i class="fas fa-dollar-sign"></i></div>
            <div>
                <div class="stat-number">${{ number_format($totalRevenue, 2) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
    </div>

    {{-- Courses Table --}}
    <div class="table-wrap">
        <div class="table-title-row">
            <h2>All Courses</h2>
            <span>{{ $courses->total() }} {{ Str::plural('course', $courses->total()) }}</span>
        </div>

        @if($courses->count() > 0)
            <table class="courses-table">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Students</th>
                        <th>Rating</th>
                        <th>Price</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td data-label="Course">
                                <div class="course-cell">
                                    @if($course->thumbnail)
                                        <img class="course-thumb" src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                                    @else
                                        <div class="course-thumb" style="background:var(--card-bg2);display:flex;align-items:center;justify-content:center;color:var(--text-muted);font-size:16px;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="course-name">{{ Str::limit($course->title, 40) }}</div>
                                        <div class="course-cat">{{ $course->category->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td data-label="Status">
                                @if($course->is_published)
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td data-label="Students">{{ number_format($course->enrollments_count) }}</td>
                            <td data-label="Rating">
                                @if($course->average_rating > 0)
                                    <div class="rating-cell">
                                        <i class="fas fa-star"></i>
                                        <span>{{ number_format($course->average_rating, 1) }}</span>
                                    </div>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td data-label="Price">
                                @if($course->price > 0)
                                    ${{ number_format($course->price, 2) }}
                                @else
                                    <span class="badge badge-success">Free</span>
                                @endif
                            </td>
                            <td data-label="Actions">
                                <a href="{{ route('course.show', $course->slug) }}" class="action-btn view" title="View Course">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('teacher.courses.edit', $course) }}" class="action-btn edit" title="Edit Course">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button class="action-btn delete" title="Delete Course" onclick="openDeleteModal('{{ $course->id }}', '{{ addslashes($course->title) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($courses->hasPages())
                <div class="pagination-wrap">
                    {{ $courses->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-book-open"></i></div>
                <h3>No courses yet</h3>
                <p>Create your first course and start teaching the world.</p>
                <a href="{{ route('teacher.courses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Course
                </a>
            </div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-icon-wrap"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="modal-title">Delete Course</div>
        <div class="modal-text">
            Are you sure you want to delete "<span id="delete-course-name"></span>"?
            All enrolled students and course data will be permanently removed. This action cannot be undone.
        </div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
            <form id="delete-form" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
    function openDeleteModal(courseId, courseName) {
        document.getElementById('delete-course-name').textContent = courseName;
        document.getElementById('delete-form').action = '{{ url("teacher/courses") }}/' + courseId;
        document.getElementById('delete-modal').classList.add('show');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('show');
    }
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endsection
