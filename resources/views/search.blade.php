@extends('layouts.app')

@section('title', 'Browse Courses — Codify')
@section('meta-description', 'Discover thousands of courses across design, development, marketing, and more.')

@section('extra-css')
<style>
    :root {
        --text: #f1f5f9;
        --text-muted: #94a3b8;
        --text-dim: #64748b;
        --bg-card: #0f172a;
        --border: rgba(255, 255, 255, 0.08);
        --border-md: rgba(99, 102, 241, 0.25);
    }

    .search-page {
        padding: 48px 0 100px;
    }

    /* ── Page Header ─────────────────────────── */
    .search-page-header {
        margin-bottom: 48px;
    }
    .search-page-title {
        font-size: 2.2rem;
        font-weight: 900;
        letter-spacing: -.04em;
        background: linear-gradient(135deg, var(--text), var(--brand));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 8px;
    }
    .search-page-sub {
        color: var(--text-muted);
        font-size: 15px;
    }

    /* ── Search Bar ──────────────────────────── */
    .search-bar-wrap {
        position: relative;
        margin-bottom: 40px;
    }
    .search-bar-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: var(--text-muted);
        pointer-events: none;
        z-index: 2;
    }
    .search-bar-input {
        width: 100%;
        padding: 18px 20px 18px 54px;
        background: var(--bg-card);
        border: 1.5px solid var(--border-md);
        border-radius: var(--radius-full);
        color: var(--text);
        font-family: inherit;
        font-size: 16px;
        font-weight: 500;
        outline: none;
        transition: var(--transition);
    }
    .search-bar-input::placeholder { color: var(--text-dim); }
    .search-bar-input:focus {
        border-color: var(--brand);
        background: rgba(99, 102, 241,.05);
        box-shadow: 0 0 0 4px rgba(99, 102, 241,.1), 0 8px 32px rgba(0,0,0,.3);
    }
    .search-bar-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        padding: 10px 24px;
        background: linear-gradient(135deg, var(--brand), var(--brand-dark));
        color: #fff;
        border: none;
        border-radius: var(--radius-full);
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: var(--transition);
    }
    .search-bar-btn:hover {
        box-shadow: 0 6px 20px rgba(99, 102, 241,.4);
        transform: translateY(-50%) translateY(-1px);
    }

    /* ── Layout ──────────────────────────────── */
    /* Handled by Tailwind grid system in HTML */

    /* ── Sidebar ─────────────────────────────── */
    .search-sidebar {
        position: sticky;
        top: 100px;
    }
    @media (max-width: 1023px) {
        .search-sidebar {
            position: static;
        }
    }
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 16px;
    }
    .filter-card-title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--text-muted);
        margin-bottom: 16px;
    }
    .filter-chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .filter-chip {
        padding: 6px 14px;
        border-radius: var(--radius-full);
        border: 1px solid rgba(255, 255, 255, 0.12);
        font-size: 13px;
        font-weight: 600;
        color: #cbd5e1;
        cursor: pointer;
        transition: var(--transition);
        background: rgba(255, 255, 255, 0.03);
        font-family: inherit;
        text-decoration: none;
        display: inline-block;
    }
    .filter-chip:hover,
    .filter-chip.active {
        border-color: var(--brand);
        color: #ffffff;
        background: rgba(99, 102, 241, 0.18);
        box-shadow: 0 0 12px rgba(99, 102, 241, 0.2);
    }

    .filter-divider {
        height: 1px;
        background: var(--border);
        margin: 20px 0;
    }

    .filter-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition);
        font-size: 14px;
        color: #cbd5e1;
        user-select: none;
    }
    .filter-label:hover { background: rgba(255,255,255,0.04); color: var(--text); }
    .filter-label input[type="radio"] { accent-color: var(--brand); }

    /* ── Results Area ────────────────────────── */
    .search-results-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .results-count {
        font-size: 14px;
        color: var(--text-muted);
    }
    .results-count strong { color: var(--text); font-weight: 700; }

    .results-sort {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: var(--text-muted);
    }
    .results-sort select {
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        border-radius: var(--radius-md);
        color: var(--text);
        padding: 8px 14px;
        font-family: inherit;
        font-size: 13.5px;
        outline: none;
        cursor: pointer;
    }

    /* ── Course Cards Grid ───────────────────── */
    /* Results Grid handled by Tailwind classes in HTML */

    .result-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    .result-card:hover {
        border-color: rgba(99, 102, 241,.35);
        transform: translateY(-5px);
        box-shadow: 0 16px 48px rgba(0,0,0,.4);
    }

    .result-card-img {
        height: 180px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .result-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .result-card:hover .result-card-img img { transform: scale(1.06); }
    .result-card-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(11,11,24,.75) 0%, transparent 55%);
    }
    .result-cat-badge {
        position: absolute;
        top: 12px; left: 12px;
        padding: 4px 10px;
        background: rgba(99, 102, 241,.85);
        backdrop-filter: blur(8px);
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
    }

    .result-card-body {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .result-card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text) !important;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }
    .result-card-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-muted) !important;
        margin-bottom: 14px;
    }
    .result-card-meta .dot { width: 3px; height: 3px; border-radius: 50%; background: var(--text-dim); }

    .result-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid var(--border);
    }
    .result-rating {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 700;
        color: var(--warning);
    }
    .result-rating i { font-size: 11px; }
    .result-rating span { color: var(--text-muted); font-weight: 400; font-size: 12px; }
    .result-price {
        font-size: 16px;
        font-weight: 800;
        color: var(--text) !important;
    }
    .result-price.free {
        font-size: 13px;
        color: var(--success) !important;
    }

    /* Empty state */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
        border: 1px dashed var(--border-md);
        border-radius: var(--radius-xl);
        background: var(--bg-card);
    }
    .empty-icon {
        font-size: 56px;
        margin-bottom: 20px;
        opacity: .4;
    }
    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 10px;
    }
    .empty-desc {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 28px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Pagination */
    .pagination-row {
        display: flex;
        justify-content: center;
    }
    .pagination-row nav { display: flex; gap: 6px; }
    .pagination-row .page-link,
    .pagination-row span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border-radius: var(--radius-md);
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-muted);
        background: var(--bg-card);
        border: 1px solid var(--border-md);
        transition: var(--transition);
        text-decoration: none;
    }
    .pagination-row .page-link:hover {
        background: var(--brand-light);
        border-color: var(--brand);
        color: var(--brand);
    }
    .pagination-row .active span,
    .pagination-row .active .page-link {
        background: var(--brand);
        border-color: var(--brand);
        color: #fff;
    }
    .pagination-row .disabled span {
        opacity: .35;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full search-page">

    <!-- Page Header -->
    <div class="search-page-header fade-in-up">
        <h1 class="search-page-title text-3xl sm:text-4xl lg:text-5xl">
            @if(request('q'))
                Results for "{{ request('q') }}"
            @else
                Browse All Courses
            @endif
        </h1>
        <p class="search-page-sub">Discover skills that will move your career forward.</p>
    </div>

    <!-- Search Bar -->
    <div class="search-bar-wrap fade-in-up">
        <form action="{{ route('search') }}" method="GET">
            <i class="fas fa-search search-bar-icon"></i>
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="What do you want to learn today?"
                class="search-bar-input"
                id="mainSearchInput"
                autocomplete="off"
            >
            <button type="submit" class="search-bar-btn">
                <i class="fas fa-search"></i> <span class="hidden sm:inline">Search</span>
            </button>
        </form>
    </div>

    <!-- Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Sidebar Filters -->
        <aside class="search-sidebar lg:col-span-1 fade-in-up">
            <div class="filter-card">
                <div class="filter-card-title">Category</div>
                <div class="filter-chip-group">
                    <a href="{{ route('search') }}" class="filter-chip {{ !request('category') ? 'active' : '' }}">All</a>
                    @if(isset($categories))
                        @foreach($categories as $cat)
                            <a href="{{ route('search', ['category' => $cat->id, 'q' => request('q')]) }}"
                               class="filter-chip {{ request('category') == $cat->id ? 'active' : '' }}">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    @else
                        @foreach(['Design', 'Development', 'Marketing', 'Business', 'AI & ML'] as $cat)
                            <span class="filter-chip">{{ $cat }}</span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="filter-card">
                <div class="filter-card-title">Price</div>
                <label class="filter-label">
                    <input type="radio" name="price" value="" class="filter-auto-submit" {{ !request('price') ? 'checked' : '' }}> All Prices
                </label>
                <label class="filter-label">
                    <input type="radio" name="price" value="free" class="filter-auto-submit" {{ request('price') == 'free' ? 'checked' : '' }}> Free Only
                </label>
                <label class="filter-label">
                    <input type="radio" name="price" value="paid" class="filter-auto-submit" {{ request('price') == 'paid' ? 'checked' : '' }}> Paid Only
                </label>
            </div>

            <div class="filter-card">
                <div class="filter-card-title">Rating</div>
                <label class="filter-label">
                    <input type="radio" name="rating" value="" class="filter-auto-submit" {{ !request('rating') ? 'checked' : '' }}> Any Rating
                </label>
                <label class="filter-label">
                    <input type="radio" name="rating" value="4.5" class="filter-auto-submit" {{ request('rating') == '4.5' ? 'checked' : '' }}> ⭐ 4.5 & above
                </label>
                <label class="filter-label">
                    <input type="radio" name="rating" value="4.0" class="filter-auto-submit" {{ request('rating') == '4.0' ? 'checked' : '' }}> ⭐ 4.0 & above
                </label>
            </div>
        </aside>

        <!-- Results -->
        <div class="lg:col-span-3">
            <div class="search-results-meta">
                <div class="results-count">
                    @if(isset($courses) && $courses->total() > 0)
                        Showing <strong>{{ $courses->total() }}</strong> {{ Str::plural('course', $courses->total()) }}
                        @if(request('q'))
                            for "<strong>{{ request('q') }}</strong>"
                        @endif
                    @elseif(isset($courses))
                        Showing <strong>0</strong> courses
                    @endif
                </div>
                <div class="results-sort">
                    <span>Sort by:</span>
                    <select id="sortSelect" class="filter-auto-submit">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Newest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>

            @if(isset($courses) && $courses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach($courses as $i => $course)
                        <a href="{{ route('course.show', $course->slug ?? $course->id) }}"
                           class="result-card fade-in-up fade-in-up-delay-{{ min($i % 3 + 1, 4) }}">
                            <div class="result-card-img">
                                <img
                                    src="{{ ($course->thumbnail ?? $course->image)
                                        ? asset('storage/' . ($course->thumbnail ?? $course->image))
                                        : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80' }}"
                                    alt="{{ $course->title }}"
                                    loading="lazy"
                                    onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80'"
                                >
                                <div class="result-card-img-overlay"></div>
                                <div class="result-cat-badge">{{ $course->category->name ?? 'Course' }}</div>
                            </div>
                            <div class="result-card-body">
                                <div class="result-card-title">{{ $course->title }}</div>
                                <div class="result-card-meta">
                                    <i class="fas fa-user-circle" style="color:var(--brand);font-size:11px;"></i>
                                    {{ $course->instructor->name ?? 'Expert Instructor' }}
                                    <span class="dot"></span>
                                    {{ $course->lessons_count ?? 0 }} lessons
                                </div>
                                <div class="result-card-footer">
                                    <div class="result-rating">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($course->average_rating ?? 0, 1) }}
                                        <span>({{ $course->reviews_count ?? 0 }})</span>
                                    </div>
                                    @if(($course->price ?? 0) > 0)
                                        <div class="result-price">${{ number_format($course->price, 2) }}</div>
                                    @else
                                        <div class="result-price free"><i class="fas fa-gift"></i> Free</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($courses->hasPages())
                    <div class="pagination-row">
                        {{ $courses->appends(request()->query())->links() }}
                    </div>
                @endif

            @else
                <div class="empty-state fade-in-up">
                    <div class="empty-icon">🔍</div>
                    <h2 class="empty-title">No courses found</h2>
                    <p class="empty-desc">
                        @if(request('q'))
                            We couldn't find any courses matching "{{ request('q') }}". Try a different search term or browse all courses.
                        @else
                            No courses are available yet. Check back soon!
                        @endif
                    </p>
                    <a href="{{ route('search') }}" class="btn btn-primary">
                        <i class="fas fa-grid-2"></i> Browse All Courses
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterInputs = document.querySelectorAll('.filter-auto-submit');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            const url = new URL(window.location.href);
            
            // Collect price
            const price = document.querySelector('input[name="price"]:checked');
            if (price && price.value) url.searchParams.set('price', price.value);
            else url.searchParams.delete('price');
            
            // Collect rating
            const rating = document.querySelector('input[name="rating"]:checked');
            if (rating && rating.value) url.searchParams.set('rating', rating.value);
            else url.searchParams.delete('rating');
            
            // Collect sort
            const sort = document.getElementById('sortSelect');
            if (sort && sort.value) url.searchParams.set('sort', sort.value);
            
            window.location.href = url.toString();
        });
    });
});
</script>
@endsection