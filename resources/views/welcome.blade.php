@extends('layouts.app')

@section('title', 'Codify — Sizi Gerçekten İleriye Taşıyacak Beceriler')

@section('extra-css')
<style>
/* ============================================================
   GLOBAL DARK THEME OVERRIDES (for this page only)
   ============================================================ */
body {
    background: #05070f !important;
    color: #f1f5f9 !important;
}

/* ---- Background grid + glow decorations ---- */
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

/* All page sections sit above fixed decorations */
.lp-wrap {
    position: relative;
    z-index: 1;
}

/* ============================================================
   HERO
   ============================================================ */
.hero-section {
    padding: 80px 24px 60px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 28px;
    max-width: 1200px;
    margin: 0 auto;
}

/* AI badge pill */
.ai-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(99, 102, 241,0.12);
    border: 1px solid rgba(99, 102, 241,0.35);
    border-radius: 9999px;
    padding: 7px 20px;
    font-size: 13px;
    color: #a5b4fc;
    font-weight: 500;
    letter-spacing: 0.2px;
}

/* Main headline */
.hero-title {
    font-size: clamp(2.4rem, 6vw, 4rem);
    font-weight: 900;
    line-height: 1.1;
    letter-spacing: -1.5px;
    color: #ffffff;
    margin: 0;
}
.hero-title .g-text {
    background: linear-gradient(135deg, #818cf8 0%, #38bdf8 55%, #a78bfa 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Subtitle */
.hero-sub {
    font-size: 17px;
    color: #94a3b8;
    max-width: 500px;
    line-height: 1.75;
    margin: 0;
}

/* CTA buttons */
.hero-btns {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    justify-content: center;
}
.btn-primary-lp {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: #fff !important;
    border-radius: 9999px;
    padding: 14px 32px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 0 30px rgba(99, 102, 241,0.35);
    border: none;
    cursor: pointer;
}
.btn-primary-lp:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 50px rgba(99, 102, 241,0.55);
}
.btn-secondary-lp {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.06);
    color: #e2e8f0 !important;
    border: 1px solid rgba(255,255,255,0.14);
    border-radius: 9999px;
    padding: 13px 28px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    backdrop-filter: blur(8px);
    cursor: pointer;
}
.btn-secondary-lp:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.28);
}

/* Floating info cards row */
.hero-cards {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    justify-content: center;
}
.h-card {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(15,23,42,0.75);
    border: 1px solid rgba(99, 102, 241,0.2);
    border-radius: 14px;
    padding: 12px 18px;
    font-size: 13px;
    color: #cbd5e1;
    backdrop-filter: blur(16px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.h-card-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* ============================================================
   STATS BAR
   ============================================================ */
.stats-strip {
    background: rgba(15,23,42,0.65);
    border-top: 1px solid rgba(99, 102, 241,0.15);
    border-bottom: 1px solid rgba(99, 102, 241,0.15);
    backdrop-filter: blur(10px);
    padding: 28px 24px;
}
.stats-strip-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-wrap: wrap;
    gap: 24px;
}
.s-item { text-align: center; }
.s-num {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.5px;
}
.s-lbl {
    font-size: 13px;
    color: #94a3b8;
    margin-top: 4px;
}
.s-div { width: 1px; height: 40px; background: rgba(99, 102, 241,0.2); }

/* ============================================================
   SECTION SHARED
   ============================================================ */
.lp-section {
    padding: 72px 24px;
    max-width: 1200px;
    margin: 0 auto;
}
.sec-label {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #818cf8;
    margin-bottom: 10px;
}
.sec-title {
    font-size: clamp(1.8rem, 3vw, 2.5rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.15;
    letter-spacing: -0.5px;
    margin: 0 0 12px;
}
.sec-sub {
    font-size: 15px;
    color: #94a3b8;
    margin: 0 0 40px;
    max-width: 540px;
}
.sec-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 36px;
    flex-wrap: wrap;
    gap: 12px;
}
.btn-viewall {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #818cf8;
    text-decoration: none;
    border: 1px solid rgba(129,140,248,0.3);
    border-radius: 9999px;
    padding: 8px 18px;
    transition: all 0.2s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-viewall:hover {
    background: rgba(129,140,248,0.1);
    color: #a5b4fc;
}

/* ============================================================
   COURSE CARDS (glass)
   ============================================================ */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.g-card {
    background: rgba(15,23,42,0.65);
    border: 1px solid rgba(99, 102, 241,0.15);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s;
    backdrop-filter: blur(12px);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    color: inherit;
}
.g-card:hover {
    transform: translateY(-4px);
    border-color: rgba(129,140,248,0.4);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    color: inherit;
}
.g-card-img { width: 100%; height: 150px; object-fit: cover; display: block; }
.g-card-img-wrap { position: relative; overflow: hidden; }
.g-card-badge {
    position: absolute; top: 10px; right: 10px;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(8px);
    color: #fbbf24;
    padding: 4px 10px;
    border-radius: 9999px;
    font-size: 12px; font-weight: 700;
    display: flex; align-items: center; gap: 4px;
    border: 1px solid rgba(251,191,36,0.3);
}
.g-card-body {
    padding: 16px; flex: 1;
    display: flex; flex-direction: column; gap: 5px;
}
.g-card-provider {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: #64748b; font-weight: 600;
}
.g-card-title {
    font-size: 14px; font-weight: 700; color: #e2e8f0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.g-card-type { font-size: 12px; color: #475569; }
.g-card-meta {
    margin-top: auto;
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: #64748b;
}
.g-card-meta .stars { color: #fbbf24; }
.g-card-foot {
    padding: 10px 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
    font-size: 12px; color: #475569;
    display: flex; align-items: center; gap: 6px;
}

/* ============================================================
   CATEGORIES GRID
   ============================================================ */
.cats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.cat-card {
    display: flex; align-items: center; gap: 14px;
    padding: 18px 20px;
    background: rgba(15,23,42,0.6);
    border: 1px solid rgba(99, 102, 241,0.12);
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.25s;
    backdrop-filter: blur(8px);
    color: inherit;
}
.cat-card:hover {
    background: rgba(99, 102, 241,0.1);
    border-color: rgba(129,140,248,0.35);
    transform: translateY(-2px);
    color: inherit;
}
.cat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    background: rgba(99, 102, 241,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #818cf8;
    flex-shrink: 0; transition: all 0.25s;
    overflow: hidden;
    padding: 6px;
}
.cat-icon svg {
    width: 100% !important;
    height: 100% !important;
    max-width: 24px !important;
    max-height: 24px !important;
    fill: currentColor !important;
}
.cat-card:hover .cat-icon { background: rgba(99, 102, 241,0.25); color: #a5b4fc; }
.cat-name { font-size: 14px; font-weight: 700; color: #e2e8f0; margin-bottom: 2px; }
.cat-count { font-size: 12px; color: #64748b; }

/* ============================================================
   CTA SECTION
   ============================================================ */
.cta-section {
    padding: 80px 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.cta-glow {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at center, rgba(99, 102, 241,0.2) 0%, transparent 65%);
    pointer-events: none;
}
.cta-inner {
    position: relative; z-index: 1;
    max-width: 680px; margin: 0 auto;
}
.cta-title {
    font-size: clamp(1.8rem, 3vw, 2.8rem);
    font-weight: 900; color: #fff;
    line-height: 1.15; margin-bottom: 16px;
    letter-spacing: -0.5px;
}
.cta-title span {
    background: linear-gradient(135deg, #818cf8, #38bdf8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.cta-sub {
    font-size: 17px; color: #94a3b8;
    margin-bottom: 36px; line-height: 1.7;
}

/* ============================================================
   FOOTER DARK OVERRIDES
   ============================================================ */
.site-footer {
    background: rgba(5,7,15,0.97) !important;
    border-top: 1px solid rgba(99, 102, 241,0.12) !important;
}
.footer-brand { color: #fff !important; }
.footer-desc  { color: #64748b !important; }
.footer-heading { color: #94a3b8 !important; }
.footer-links a { color: #64748b !important; }
.footer-links a:hover { color: #818cf8 !important; }
.footer-copy  { color: #475569 !important; }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 1024px) {
    .courses-grid { grid-template-columns: repeat(2, 1fr); }
    .cats-grid    { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .courses-grid { grid-template-columns: 1fr; }
    .cats-grid    { grid-template-columns: 1fr; }
    .hero-title   { font-size: 2.1rem; }
    .hero-btns    { flex-direction: column; align-items: stretch; }
    .btn-primary-lp, .btn-secondary-lp { justify-content: center; }
}
</style>
@endsection

@section('content')

{{-- ── ALL PAGE CONTENT (above fixed bg) ──────────────────────── --}}
<div class="lp-wrap">

    {{-- ============ HERO ============ --}}
    <div class="hero-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16 sm:py-24 flex flex-col items-center text-center gap-6">

        {{-- AI pill --}}
        <div class="ai-pill">
            <i class="fas fa-wand-magic-sparkles" style="color:#818cf8;font-size:12px;"></i>
            Şimdi kişiselleştirilmiş yapay zeka destekli öğrenme yolları ile
        </div>

        {{-- Headline --}}
        <h1 class="hero-title text-3xl sm:text-4xl lg:text-6xl font-black leading-tight tracking-tight text-white m-0">
            Sizi Gerçekten<br>
            <span class="g-text">İleriye Taşıyacak</span><br>
            <span class="g-text">Beceriler Edinin</span>
        </h1>

        {{-- Subtitle --}}
        <p class="hero-sub text-base sm:text-lg text-slate-400 max-w-xl leading-relaxed m-0">
            Sektörün en iyi eğitmenlerinden öğrenin ve uygulamalı beceriler kazanın — kendi hızınızda.
        </p>

        {{-- CTA buttons --}}
        <div class="hero-btns">
            <a href="{{ url('/register') }}" class="btn-primary-lp">
                <i class="fas fa-rocket"></i>
                Ücretsiz Öğrenmeye Başla
            </a>
            <a href="{{ url('/courses') }}" class="btn-secondary-lp">
                <i class="fas fa-play" style="font-size:11px;"></i>
                Kursları İncele
            </a>
        </div>

        {{-- Floating info cards --}}
        <div class="hero-cards">
            <div class="h-card">
                <div class="h-card-icon" style="background:rgba(99, 102, 241,0.2);">
                    <i class="fas fa-check" style="color:#818cf8;font-size:13px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#e2e8f0;">Tamamlandı</div>
                    <div style="font-size:11px;color:#64748b;">UI/UX Tasarımı</div>
                </div>
            </div>
            <div class="h-card">
                <div class="h-card-icon" style="background:rgba(251,191,36,0.15);">
                    <i class="fas fa-star" style="color:#fbbf24;font-size:13px;"></i>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;">Değerlendirme</div>
                    <div style="font-size:14px;font-weight:800;color:#e2e8f0;">4.9 / 5.0</div>
                </div>
            </div>
            <div class="h-card">
                <div class="h-card-icon" style="background:rgba(99, 102, 241,0.15);">
                    <i class="fas fa-users" style="color:#818cf8;font-size:13px;"></i>
                </div>
                <div>
                    <div style="font-size:11px;color:#64748b;">Öğrenci</div>
                    @php $heroCount = \App\Models\User::where('role','student')->count(); @endphp
                    <div style="font-size:14px;font-weight:800;color:#e2e8f0;">{{ number_format($heroCount) }}</div>
                </div>
            </div>
            <div class="h-card">
                <div class="h-card-icon" style="background:rgba(16,185,129,0.15);">
                    <i class="fas fa-certificate" style="color:#10b981;font-size:13px;"></i>
                </div>
                <div>
                    <div style="font-size:13px;font-weight:700;color:#e2e8f0;">Sertifika</div>
                    <div style="font-size:11px;color:#10b981;">Kazanıldı!</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ STATS BAR ============ --}}
    @php
        $totalStudents  = \App\Models\User::where('role', 'student')->count();
        $totalCourses   = \App\Models\Course::where('status', 'published')->count();
        $totalReviews   = \App\Models\Review::count();
        $avgRating      = $totalReviews > 0 ? round(\App\Models\Review::avg('rating'), 1) : 4.9;
    @endphp
    <div class="stats-strip py-8 px-4 bg-slate-900/65 border-y border-indigo-500/15 backdrop-blur-md">
        <div class="stats-strip-inner max-w-7xl mx-auto flex flex-col sm:flex-row justify-around items-center gap-6 sm:gap-4 flex-wrap">
            <div class="s-item">
                <div class="s-num text-2xl sm:text-3xl font-extrabold text-white">{{ number_format($totalStudents) }}</div>
                <div class="s-lbl text-xs sm:text-sm text-slate-400 mt-1">Aktif Öğrenci</div>
            </div>
            <div class="hidden sm:block s-div w-px h-10 bg-indigo-500/20"></div>
            <div class="s-item">
                <div class="s-num text-2xl sm:text-3xl font-extrabold text-white">{{ $totalCourses ?: '—' }}</div>
                <div class="s-lbl text-xs sm:text-sm text-slate-400 mt-1">Uzmanlardan Kurslar</div>
            </div>
            <div class="hidden sm:block s-div w-px h-10 bg-indigo-500/20"></div>
            <div class="s-item">
                <div class="s-num text-2xl sm:text-3xl font-extrabold text-amber-400">{{ $avgRating }}★</div>
                <div class="s-lbl text-xs sm:text-sm text-slate-400 mt-1">Ortalama Puan</div>
            </div>
            <div class="hidden sm:block s-div w-px h-10 bg-indigo-500/20"></div>
            <div class="s-item">
                <div class="s-num text-2xl sm:text-3xl font-extrabold text-white">95%</div>
                <div class="s-lbl text-xs sm:text-sm text-slate-400 mt-1">Kursu Tamamlama Oranı</div>
            </div>
        </div>
    </div>

    {{-- ============ POPULAR COURSES ============ --}}
    @php
        $popularCourses = \App\Models\Course::with(['category','user'])
            ->where('status','published')
            ->withCount(['reviews','enrollments'])
            ->withAvg('reviews','rating')
            ->orderByDesc('enrollments_count')
            ->take(4)->get();
    @endphp
    <div class="lp-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16">
        <div class="sec-row flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
            <div>
                <div class="sec-label text-[11px] font-bold text-indigo-400 uppercase tracking-widest mb-1.5">Popüler Kurslar</div>
                <h2 class="sec-title text-2xl sm:text-3xl font-extrabold text-white m-0">En Çok Tercih Edilen Kurslar</h2>
            </div>
            <a href="{{ url('/courses') }}" class="btn-viewall">
                Tüm Kurslar <i class="fas fa-arrow-right" style="font-size:10px;"></i>
            </a>
        </div>

        <div class="courses-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($popularCourses as $course)
            <a href="{{ route('course.show', $course->slug) }}" class="g-card">
                <div class="g-card-img-wrap">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->title }}" class="g-card-img">
                    @else
                        <div style="width:100%;height:150px;background:linear-gradient(135deg,rgba(99, 102, 241,0.3),rgba(59,130,246,0.3));display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-graduation-cap" style="font-size:36px;color:rgba(99, 102, 241,0.6);"></i>
                        </div>
                    @endif
                    <div class="g-card-badge">
                        <i class="fas fa-star"></i> {{ number_format($course->average_rating ?? 4.8, 1) }}
                    </div>
                </div>
                <div class="g-card-body">
                    <div class="g-card-provider">
                        <span style="width:18px;height:18px;border-radius:50%;background:rgba(99, 102, 241,0.3);display:inline-flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#818cf8;flex-shrink:0;">
                            {{ strtoupper(substr($course->user->name ?? 'E', 0, 1)) }}
                        </span>
                        {{ $course->user->name ?? 'Codify' }}
                    </div>
                    <div class="g-card-title">{{ $course->title }}</div>
                    <div class="g-card-type">{{ $course->category->name ?? 'Kurs' }}</div>
                    <div class="g-card-meta">
                        <span style="font-weight:700;color:#e2e8f0;">{{ number_format($course->average_rating ?? 4.8, 1) }}</span>
                        <span class="stars"><i class="fas fa-star" style="font-size:10px;"></i></span>
                        <span>({{ number_format($course->reviews_count ?? 0) }})</span>
                    </div>
                </div>
                <div class="g-card-foot">
                    <i class="far fa-clock"></i>
                    {{ ucfirst($course->level ?? 'Tüm Düzeyler') }}
                    @if(($course->price ?? 0) > 0)
                        · <span style="color:#818cf8;font-weight:700;">{{ number_format($course->price, 0) }} ₺</span>
                    @else
                        · <span style="color:#10b981;font-weight:700;">Ücretsiz</span>
                    @endif
                </div>
            </a>
            @empty
            {{-- Demo cards when DB is empty --}}
            @foreach([
                ['Google Data Analytics Professional Certificate','Google','#4285F4','4.8','Veri Bilimi','https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&q=80'],
                ['Meta Front-End Developer Professional Certificate','Meta','#1877F2','4.7','Web Geliştirme','https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400&q=80'],
                ['IBM Data Science Professional Certificate','IBM','#054ADA','4.6','Veri Bilimi','https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=400&q=80'],
                ['Machine Learning Specialization','Stanford','#8C1515','4.9','Yapay Zeka / Makine Öğrenimi','https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400&q=80'],
            ] as [$dTitle,$dProv,$dColor,$dRating,$dCat,$dImg])
            <a href="{{ url('/courses') }}" class="g-card">
                <div class="g-card-img-wrap">
                    <img src="{{ $dImg }}" alt="{{ $dTitle }}" class="g-card-img">
                    <div class="g-card-badge"><i class="fas fa-star"></i> {{ $dRating }}</div>
                </div>
                <div class="g-card-body">
                    <div class="g-card-provider">
                        <span style="width:18px;height:18px;border-radius:50%;background:{{ $dColor }};display:inline-flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ substr($dProv,0,1) }}
                        </span>
                        {{ $dProv }}
                    </div>
                    <div class="g-card-title">{{ $dTitle }}</div>
                    <div class="g-card-type">{{ $dCat }}</div>
                    <div class="g-card-meta">
                        <span style="font-weight:700;color:#e2e8f0;">{{ $dRating }}</span>
                        <span class="stars"><i class="fas fa-star" style="font-size:10px;"></i></span>
                    </div>
                </div>
                <div class="g-card-foot"><i class="far fa-clock"></i> Başlangıç · 6 Ay</div>
            </a>
            @endforeach
            @endforelse
        </div>
    </div>

    {{-- ============ CATEGORIES ============ --}}
    @php
        $categories = \App\Models\Category::where('is_active', true)
            ->withCount(['courses' => fn($q) => $q->where('status','published')])
            ->get();
        $catIcons = ['fas fa-chart-bar','fas fa-briefcase','fas fa-laptop-code','fas fa-server',
                     'fas fa-heartbeat','fas fa-brain','fas fa-paint-brush','fas fa-globe'];
    @endphp
    <div class="lp-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16" style="padding-top:0;">
        <div class="sec-row mb-8">
            <div>
                <div class="sec-label text-[11px] font-bold text-indigo-400 uppercase tracking-widest mb-1.5">Kategoriler</div>
                <h2 class="sec-title text-2xl sm:text-3xl font-extrabold text-white m-0">Önemli Olanları Öğrenin</h2>
            </div>
        </div>
        <div class="cats-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($categories->take(8) as $i => $cat)
            <a href="{{ route('search', ['category' => $cat->id]) }}" class="cat-card">
                <div class="cat-icon">
                    @if(str_starts_with(trim($cat->icon), '<svg'))
                        {!! $cat->icon !!}
                    @else
                        <i class="{{ $cat->icon ?? ($catIcons[$i % count($catIcons)]) }}"></i>
                    @endif
                </div>
                <div>
                    <div class="cat-name">{{ $cat->name }}</div>
                    <div class="cat-count">{{ $cat->courses_count ?? 0 }} Kurs</div>
                </div>
            </a>
            @empty
            @foreach([
                ['fas fa-chart-bar','Veri Bilimi','425'],
                ['fas fa-briefcase','İşletme','1 095'],
                ['fas fa-laptop-code','Bilgisayar Bilimi','838'],
                ['fas fa-server','BT Altyapısı','145'],
                ['fas fa-heartbeat','Sağlık','471'],
                ['fas fa-brain','Kişisel Gelişim','322'],
                ['fas fa-paint-brush','Sanat ve Tasarım','283'],
                ['fas fa-globe','Yabancı Diller','150'],
            ] as [$ci,$cn,$cc])
            <a href="{{ url('/courses') }}" class="cat-card">
                <div class="cat-icon"><i class="{{ $ci }}"></i></div>
                <div>
                    <div class="cat-name">{{ $cn }}</div>
                    <div class="cat-count">{{ $cc }} Kurs</div>
                </div>
            </a>
            @endforeach
            @endforelse
        </div>
    </div>

    {{-- ============ CTA ============ --}}
    <div class="cta-section py-20 px-4 max-w-7xl mx-auto w-full text-center relative overflow-hidden">
        <div class="cta-glow" aria-hidden="true"></div>
        <div class="cta-inner max-w-2xl mx-auto relative z-10">
            <h2 class="cta-title text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight tracking-tight mb-4">
                Bugün Öğrenmeye Başlayın.<br>
                Geleceğiniz Size <span>Teşekkür Edecek.</span>
            </h2>
            <p class="cta-sub text-base sm:text-lg text-slate-400 mb-8 leading-relaxed">
                Sektör lideri uzmanlardan binlerce kursa, projeye ve sertifikaya sınırsız erişim elde edin.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-stretch sm:items-center">
                <a href="{{ url('/register') }}" class="btn-primary-lp text-center justify-center py-4 px-8 text-base">
                    <i class="fas fa-rocket"></i> Ücretsiz Başla
                </a>
                <a href="{{ url('/courses') }}" class="btn-secondary-lp text-center justify-center py-3.5 px-6 text-sm">
                    Kursları İncele
                </a>
            </div>
        </div>
    </div>

</div>{{-- /.lp-wrap --}}

@endsection
