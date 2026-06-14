@extends('layouts.app')

@section('title', 'Introduction to Data Analytics | Codify')

@section('extra-css')
<style>
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        margin-bottom: 20px;
        font-weight: 500;
    }
    .breadcrumb a {
        color: var(--text-secondary);
        transition: color 0.2s ease;
    }
    .breadcrumb a:hover {
        color: #fff;
        text-decoration: none;
    }
    .breadcrumb span {
        font-size: 11px;
        opacity: 0.7;
    }

    /* Video Play Button */
    .play-btn {
        position: absolute;
        inset: 0;
        background: rgba(5, 7, 15, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }
    .play-btn:hover { background: rgba(5, 7, 15, 0.6); }
    .play-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%) !important;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #fff !important;
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .play-btn:hover .play-circle { transform: scale(1.1); box-shadow: 0 12px 30px rgba(99, 102, 241, 0.7); }
    
    /* Price Row Styles */
    .price-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 24px;
    }
    .price-current {
        font-size: 34px;
        font-weight: 800;
        color: #fff !important;
        background: linear-gradient(135deg, #ffffff 60%, #c7d2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Sidebar Features */
    .sidebar-features {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
    .sidebar-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        font-size: 14px;
        color: var(--text-secondary);
    }
    .sidebar-feature i { color: var(--brand); width: 20px; font-size: 15px; text-align: center; }
    .guarantee {
        text-align: center;
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .guarantee i {
        color: var(--success);
        font-size: 14px;
    }

    /* Accordion */
    .accordion {
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: var(--radius-md);
        overflow: hidden;
        margin-bottom: 40px;
        background: transparent;
    }
    .accordion-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .accordion-item:last-child {
        border-bottom: none !important;
    }
    .accordion-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        background: rgba(15, 23, 42, 0.7) !important;
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary) !important;
        cursor: pointer;
        transition: all 0.2s ease !important;
        border: none;
        text-align: left;
        outline: none;
    }
    .accordion-header:hover {
        background: rgba(15, 23, 42, 0.9) !important;
        color: #fff !important;
    }
    .accordion-header i { font-size: 12px; color: var(--text-muted); transition: transform 0.3s ease; }
    .accordion-header.active i { transform: rotate(180deg); }
    .accordion-header.active {
        background: rgba(15, 23, 42, 0.9) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
    }
    .accordion-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(10, 15, 30, 0.4) !important;
    }
    .accordion-body.open { max-height: 1000px; }
    .accordion-body-inner { padding: 20px 24px; }
    .lesson-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        font-size: 14px;
        color: var(--text-secondary) !important;
    }
    .lesson-item + .lesson-item { border-top: 1px solid rgba(255, 255, 255, 0.05) !important; }
    .lesson-item .left { display: flex; align-items: center; gap: 12px; }
    .lesson-item .left i { color: var(--brand); font-size: 14px; }
    .lesson-item .left a {
        color: var(--text-primary) !important;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .lesson-item .left a:hover {
        color: var(--brand) !important;
    }
    .lesson-item .left a.preview-link {
        color: var(--brand) !important;
        font-weight: 500;
    }
    .lesson-item .left a.preview-link:hover {
        filter: brightness(1.2);
    }
    .lesson-item .right { color: var(--text-muted) !important; font-size: 13px; }

    /* Instructor */
    .instructor-section { margin-bottom: 40px; }
    .instructor-section h2 { font-size: 22px; font-weight: 700; margin-bottom: 20px; }
    .instructor-card {
        background: rgba(15, 23, 42, 0.4) !important;
        border: 1px solid rgba(255, 255, 255, 0.06) !important;
        border-radius: var(--radius-md);
        padding: 32px;
        margin-top: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .instructor-profile {
        display: flex;
        gap: 24px;
    }
    .instructor-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 3px solid rgba(99, 102, 241, 0.2);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .instructor-name { font-size: 20px; font-weight: 700; color: #fff !important; margin-bottom: 4px; }
    .instructor-title { font-size: 14px; color: var(--text-secondary); margin-bottom: 16px; font-weight: 500; }
    .instructor-stats {
        display: flex;
        gap: 24px;
        font-size: 13px;
        color: var(--text-secondary) !important;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .instructor-stats span { display: flex; align-items: center; gap: 8px; }
    .instructor-stats i { color: var(--brand); font-size: 14px; }
    .instructor-bio { font-size: 14px; color: var(--text-secondary); line-height: 1.7; }

    /* Playlist Buttons */
    .btn-toggle-list {
        background: rgba(255, 255, 255, 0.03) !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: var(--text-secondary) !important;
        border-radius: var(--radius-sm) !important;
        padding: 11px 16px !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
    }
    .btn-toggle-list:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(99, 102, 241, 0.3) !important;
        color: #fff !important;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .instructor-profile { flex-direction: column; align-items: center; text-align: center; }
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-10 mb-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- ЛЕВАЯ КОЛОНКА (Основной контент) -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Хлебные крошки и заголовок -->
            <div>
                <div class="breadcrumb">
                    <a href="{{ url('/') }}">Home</a>
                    <span>›</span>
                    <a href="#">{{ $course->category->name ?? 'Course' }}</a>
                    <span>›</span>
                    <span>{{ $course->title }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-4" style="background: linear-gradient(135deg, #ffffff 50%, #c7d2fe 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 38px; line-height: 1.2;">
                    {{ $course->title }}
                </h1>
                <p class="text-slate-400 text-lg mb-6 leading-relaxed" style="font-size: 16px; color: var(--text-secondary);">{{ Str::limit($course->description, 280) }}</p>

                <!-- Выравнивание звездочек и рейтинга -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400 mb-6">
                    <div class="flex items-center gap-1.5">
                        <span class="text-amber-400 font-bold text-base">{{ number_format($course->average_rating ?? 4.8, 1) }}</span>
                        <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                            @php
                                $rating = $course->average_rating ?? 4.8;
                                $fullStars = floor($rating);
                                $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                $emptyStars = 5 - $fullStars - $halfStar;
                            @endphp
                            @for($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                            @if($halfStar)
                                <i class="fas fa-star-half-alt"></i>
                            @endif
                            @for($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-slate-500">({{ $course->reviews_count ?? 0 }} {{ __('ratings') }})</span>
                    </div>
                    <span class="text-slate-600">•</span>
                    <span class="text-slate-300 font-medium">{{ $course->enrollments_count }} {{ __('already enrolled') }}</span>
                </div>

                <div class="flex items-center gap-3 text-sm text-slate-400">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($course->user->name ?? 'Instructor') }}&background=6366f1&color=fff" alt="{{ $course->user->name ?? 'Instructor' }}" class="w-9 h-9 rounded-full border border-slate-700">
                    <span>Created by <a href="#" class="text-violet-400 hover:text-white font-medium hover:underline">{{ $course->user->name ?? 'Instructor' }}</a></span>
                </div>
            </div>

            <!-- Блок "Description" -->
            <div class="bg-slate-900/40 backdrop-blur-md border border-slate-800/60 rounded-2xl p-6">
                <h2 class="text-xl font-bold text-white mb-4" style="font-size:20px; font-weight:700; color:#fff;">Description</h2>
                <div style="font-size: 15px; color: var(--text-secondary); line-height: 1.8;">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>

            <!-- Блок "Course Content" -->
            <div>
                <h2 style="font-size:22px;font-weight:700;margin-bottom:20px; color:#fff;">Course Content</h2>
                <div class="accordion">
                    @if($course->modules && $course->modules->count() > 0)
                        @foreach($course->modules as $module)
                            <div class="accordion-item">
                                <button class="accordion-header {{ $loop->first ? 'active' : '' }}" onclick="toggleAccordion(this)">
                                    {{ $module->title }}
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="accordion-body {{ $loop->first ? 'open' : '' }}" style="{{ $loop->first ? 'max-height:500px;' : '' }}">
                                    <div class="accordion-body-inner">
                                        @foreach($module->lessons as $l)
                                            <div class="lesson-item">
                                                <div class="left">
                                                    @if($l->is_preview)
                                                        <i class="fas fa-play-circle"></i>
                                                        @if($isEnrolled)
                                                            <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}">{{ $l->title }}</a>
                                                        @else
                                                            <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}" class="preview-link">{{ $l->title }} ({{ __('Preview') }})</a>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-lock"></i>
                                                        @if($isEnrolled)
                                                            <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}">{{ $l->title }}</a>
                                                        @else
                                                            <span>{{ $l->title }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="right">{{ $l->duration_minutes }} min</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback if course has no modules but has lessons directly -->
                        <div class="accordion-item">
                            <button class="accordion-header active" onclick="toggleAccordion(this)">
                                {{ __('All Lessons') }}
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="accordion-body open" style="max-height:1000px;">
                                <div class="accordion-body-inner">
                                    @foreach($course->lessons as $l)
                                        <div class="lesson-item">
                                            <div class="left">
                                                @if($l->is_preview)
                                                    <i class="fas fa-play-circle"></i>
                                                    @if($isEnrolled)
                                                        <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}">{{ $l->title }}</a>
                                                    @else
                                                        <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}" class="preview-link">{{ $l->title }} ({{ __('Preview') }})</a>
                                                    @endif
                                                @else
                                                    @if($isEnrolled)
                                                        <i class="fas fa-play-circle"></i>
                                                        <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $l->id]) }}">{{ $l->title }}</a>
                                                    @else
                                                        <i class="fas fa-lock"></i>
                                                        <span>{{ $l->title }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="right">{{ $l->duration_minutes }} min</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Блок "About the Instructor" -->
            <div class="instructor-section">
                <h2 style="color:#fff;">About the Instructor</h2>
                <div class="instructor-card">
                    <div class="instructor-profile">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($course->user->name ?? 'Instructor') }}&size=128&background=6366f1&color=fff" alt="{{ $course->user->name ?? 'Instructor' }}" class="instructor-avatar">
                        <div>
                            <div class="instructor-name">{{ $course->user->name ?? 'Instructor' }}</div>
                            <div class="instructor-title">{{ $course->user->bio ?? 'Certified Professional Instructor' }}</div>
                            <div class="instructor-stats">
                                <span><i class="fas fa-star" style="color:var(--star);"></i> 4.8 Instructor Rating</span>
                                <span><i class="fas fa-users"></i> {{ $course->user->courses()->withCount('enrollments')->get()->sum('enrollments_count') }} Students</span>
                                <span><i class="fas fa-play-circle"></i> {{ $course->user->courses()->count() }} Courses</span>
                            </div>
                            <p class="instructor-bio">
                                {{ $course->user->bio ?? 'An experienced industry professional teaching students worldwide.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        <!-- ПРАВАЯ КОЛОНКА (Сайдбар с покупкой) -->
        <div class="lg:col-span-1 bg-slate-900/60 backdrop-blur-md border border-slate-800/60 rounded-2xl p-6 sticky top-24">
            <div class="sidebar-card-img rounded-xl overflow-hidden mb-6 relative" style="height:200px;">
                @if($course->image_path || $course->image)
                    <img src="{{ asset('storage/' . ($course->image_path ?? $course->image)) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                @else
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="Course preview" class="w-full h-full object-cover">
                @endif
                @if($course->lessons->first())
                    <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $course->lessons->first()->id]) }}" class="play-btn">
                        <span class="play-circle"><i class="fas fa-play" style="margin-left:3px;"></i></span>
                    </a>
                @endif
            </div>

            <div class="price-row">
                @if($course->price > 0)
                    <span class="price-current">${{ number_format($course->price, 2) }}</span>
                @else
                    <span class="price-current">{{ __('Free') }}</span>
                @endif
            </div>

            @if($isEnrolled)
                <a href="{{ route('course.learn', $course->slug) }}" class="btn btn-primary btn-lg w-full text-center" style="display:block;">{{ __('Resume learning') }}</a>
            @else
                <form action="{{ route('course.enroll', $course->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-full">{{ __('Enroll Now') }}</button>
                </form>
            @endif

            @auth
                @php
                    $inWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->exists();
                    $inPlaylist = \App\Models\StudentList::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->where('list_type', 'playlist')
                        ->exists();
                    $inWatchLater = \App\Models\StudentList::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->where('list_type', 'watch_later')
                        ->exists();
                @endphp
                <div style="display: grid !important; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px;">
                    {{-- 1. Избранное (Wishlist) --}}
                    <button class="btn-toggle-list"
                            data-course-id="{{ $course->id }}"
                            data-list-type="wishlist"
                            data-toggle-url="{{ route('wishlist.toggle', $course->id) }}">
                        <i class="{{ $inWishlist ? 'fas fa-heart text-danger' : 'far fa-heart' }}" {!! $inWishlist ? 'style="color:#f43f5e;"' : '' !!}></i>
                        <span class="btn-toggle-text">{{ __('messages.wishlist.title') }}</span>
                    </button>

                    {{-- 2. В плейлист (Playlist) --}}
                    <button class="btn-toggle-list btn-student-list"
                            data-course-id="{{ $course->id }}"
                            data-list-type="playlist"
                            data-toggle-url="{{ route('courses.toggle-list', $course->id) }}">
                        <i class="fas fa-list {{ $inPlaylist ? 'text-warning' : '' }}" {!! $inPlaylist ? 'style="color:#fbbf24;"' : '' !!}></i>
                        <span class="btn-toggle-text">{{ __('messages.progress.add_playlist') }}</span>
                    </button>

                    {{-- 3. Посмотреть позже (Watch Later) --}}
                    <button class="btn-toggle-list btn-student-list"
                            data-course-id="{{ $course->id }}"
                            data-list-type="watch_later"
                            data-toggle-url="{{ route('courses.toggle-list', $course->id) }}">
                        <i class="{{ $inWatchLater ? 'fas fa-clock text-info' : 'far fa-clock' }}" {!! $inWatchLater ? 'style="color:#0ea5e9;"' : '' !!}></i>
                        <span class="btn-toggle-text">{{ __('messages.progress.add_watch_later') }}</span>
                    </button>

                    {{-- 4. Поделиться (Share) --}}
                    <button class="btn-toggle-list" id="btn-share-course" data-url="{{ request()->url() }}">
                        <i class="fas fa-share-nodes text-indigo-400"></i>
                        <span class="btn-share-text">{{ __('messages.progress.share') }}</span>
                    </button>
                </div>
            @else
                <div style="display: grid !important; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 16px;">
                    <a href="{{ route('login') }}" class="btn-toggle-list" style="text-decoration: none;">
                        <i class="far fa-heart"></i>
                        <span>{{ __('messages.wishlist.title') }}</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn-toggle-list" style="text-decoration: none;">
                        <i class="fas fa-list"></i>
                        <span>{{ __('messages.progress.add_playlist') }}</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn-toggle-list" style="text-decoration: none;">
                        <i class="far fa-clock"></i>
                        <span>{{ __('messages.progress.add_watch_later') }}</span>
                    </a>
                    <button class="btn-toggle-list" id="btn-share-course" data-url="{{ request()->url() }}">
                        <i class="fas fa-share-nodes text-indigo-400"></i>
                        <span class="btn-share-text">{{ __('messages.progress.share') }}</span>
                    </button>
                </div>
            @endauth

            <p class="guarantee" style="margin-top: 20px;"><i class="fas fa-shield-alt text-emerald-500"></i> 30-Day Money-Back Guarantee</p>

            <div class="sidebar-features mt-6 pt-6 border-t border-slate-800/80">
                <div class="sidebar-feature"><i class="far fa-file-video"></i> {{ $course->lessons->count() }} {{ __('lessons') }}</div>
                <div class="sidebar-feature"><i class="fas fa-infinity"></i> Full lifetime access</div>
                <div class="sidebar-feature"><i class="fas fa-mobile-alt"></i> Access on mobile and TV</div>
                <div class="sidebar-feature"><i class="fas fa-certificate"></i> Certificate of completion</div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('extra-js')
<script>
    function toggleAccordion(header) {
        const body = header.nextElementSibling;
        const isOpen = body.classList.contains('open');

        // Close all
        document.querySelectorAll('.accordion-body').forEach(b => b.classList.remove('open'));
        document.querySelectorAll('.accordion-header').forEach(h => h.classList.remove('active'));

        // Toggle current
        if (!isOpen) {
            body.classList.add('open');
            header.classList.add('active');
            body.style.maxHeight = '1000px';
        } else {
            body.style.maxHeight = '0px';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.btn-toggle-list');
        toggleButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.getAttribute('data-toggle-url');
                if (!url) return;
                const listType = this.getAttribute('data-list-type');
                const btnObj = this;
                const token = '{{ csrf_token() }}';
                
                const isStudentList = btnObj.classList.contains('btn-student-list');
                const fetchOptions = {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                };

                if (isStudentList) {
                    fetchOptions.body = JSON.stringify({ type: listType });
                }

                fetch(url, fetchOptions)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' || data.success) {
                        const icon = btnObj.querySelector('i');
                        const isAdded = data.added !== undefined ? data.added : (data.action === 'added');
                        if (listType === 'wishlist') {
                            if (isAdded) {
                                icon.className = 'fas fa-heart text-danger';
                                icon.style.color = '#f43f5e';
                            } else {
                                icon.className = 'far fa-heart';
                                icon.style.color = '';
                            }
                        } else if (listType === 'playlist') {
                            if (isAdded) {
                                icon.className = 'fas fa-list text-warning';
                                icon.style.color = '#fbbf24';
                            } else {
                                icon.className = 'fas fa-list';
                                icon.style.color = '';
                            }
                        } else if (listType === 'watch_later') {
                            if (isAdded) {
                                icon.className = 'fas fa-clock text-info';
                                icon.style.color = '#0ea5e9';
                            } else {
                                icon.className = 'far fa-clock';
                                icon.style.color = '';
                            }
                        }
                    }
                })
                .catch(err => console.error('Error toggling list:', err));
            });
        });

        // Share button copy link functionality
        const shareBtn = document.getElementById('btn-share-course');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const url = this.getAttribute('data-url');
                navigator.clipboard.writeText(url).then(() => {
                    const textSpan = this.querySelector('.btn-share-text');
                    const originalText = textSpan.textContent;
                    textSpan.textContent = "{{ __('messages.progress.link_copied') }}";
                    this.style.borderColor = '#10b981';
                    setTimeout(() => {
                        textSpan.textContent = originalText;
                        this.style.borderColor = '';
                    }, 2000);
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                });
            });
        }
    });
</script>
@endsection