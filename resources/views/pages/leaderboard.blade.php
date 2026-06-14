@extends('layouts.app')

@section('title', 'Global Leaderboard | Codify')

@php
    // Fetch all student users and calculate their XP based on completed lessons
    $students = \App\Models\User::where('role', 'student')
        ->withCount(['lessonProgress as lesson_progress_count' => function ($q) {
            $q->whereNotNull('completed_at');
        }])
        ->get()
        ->map(function ($student) {
            // Let's say each completed lesson gives 100 XP (or dynamic value)
            $student->xp = $student->lesson_progress_count * 100;
            return $student;
        })
        ->sortByDesc('xp')
        ->values();

    // Assign ranks dynamically
    $rank = 1;
    $prevXp = null;
    $topStudents = $students->map(function ($student, $index) use (&$rank, &$prevXp) {
        if ($prevXp !== null && $student->xp < $prevXp) {
            $rank = $index + 1;
        }
        $student->rank = $rank;
        $prevXp = $student->xp;
        return $student;
    });

    // Get current logged-in user rank
    $currentUserRank = null;
    if (auth()->check()) {
        $currentUserRank = $topStudents->first(function ($student) {
            return $student->id == auth()->id();
        });
        
        // If current user is not in the collection (e.g. no progress yet), build a fallback object
        if (!$currentUserRank) {
            $currentUserRank = auth()->user();
            $currentUserRank->lesson_progress_count = auth()->user()->lessonProgress()->whereNotNull('completed_at')->count();
            $currentUserRank->xp = $currentUserRank->lesson_progress_count * 100;
            $currentUserRank->rank = count($topStudents) + 1;
        }
    }
    
    // Take top 10 for display
    $topStudents = $topStudents->take(10);
@endphp

@section('extra-css')
<style>
    body {
        background: #090d16 !important;
        color: #f8fafc !important;
    }

    .leaderboard-container {
        max-width: 800px;
        margin: 60px auto;
        padding: 0 20px;
    }
    
    .leaderboard-header {
        text-align: center;
        margin-bottom: 40px;
        color: #fff;
    }
    
    .trophy-icon {
        font-size: 48px;
        color: var(--star, #F5C518);
        margin-bottom: 16px;
    }
    
    .leaderboard-header h1 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
    }
    
    .leaderboard-header p {
        color: #94a3b8;
        font-size: 16px;
    }

    .user-stats-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .user-stats-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(99, 102, 241,0.15) 0%, transparent 60%);
        opacity: 0.5;
        z-index: 0;
    }
    
    .stat-item {
        position: relative;
        z-index: 1;
        text-align: center;
    }
    
    .stat-label {
        font-size: 14px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: #html;
        color: #fff;
    }
    
    .stat-value.rank {
        color: #F5C518;
    }
    
    /* Leaderboard List */
    .leaderboard-list {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
    }
    
    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.2s ease;
        position: relative;
    }
    
    .leaderboard-item:last-child {
        border-bottom: none;
    }
    
    .leaderboard-item:hover {
        background: rgba(255, 255, 255, 0.06);
        transform: scale(1.01);
        z-index: 2;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    
    .rank-badge {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 800;
        border-radius: 50%;
        margin-right: 20px;
        flex-shrink: 0;
        background: rgba(255,255,255,0.05);
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .rank-1 .rank-badge {
        background: linear-gradient(135deg, #FFD700, #FFA500);
        color: #000;
        border: none;
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.4);
    }
    
    .rank-2 .rank-badge {
        background: linear-gradient(135deg, #E0E0E0, #9E9E9E);
        color: #000;
        border: none;
        box-shadow: 0 0 20px rgba(224, 224, 224, 0.4);
    }
    
    .rank-3 .rank-badge {
        background: linear-gradient(135deg, #CD7F32, #A0522D);
        color: #fff;
        border: none;
        box-shadow: 0 0 20px rgba(205, 127, 50, 0.4);
    }
    
    .student-info {
        display: flex;
        align-items: center;
        flex: 1;
    }
    
    .student-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
        border: 2px solid rgba(255,255,255,0.1);
    }
    
    .rank-1 .student-avatar { border-color: #FFD700; }
    .rank-2 .student-avatar { border-color: #E0E0E0; }
    .rank-3 .student-avatar { border-color: #CD7F32; }
    
    .student-details h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 4px 0;
    }
    
    .student-details p {
        font-size: 0.9rem;
        color: #94a3b8;
        margin: 0;
    }
    
    .student-xp {
        text-align: right;
    }
    
    .xp-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #818cf8;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .xp-label {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }
    
    .is-current-user {
        background: rgba(99, 102, 241, 0.1);
        border-left: 4px solid #6366f1;
    }
    .is-current-user:hover {
        background: rgba(99, 102, 241, 0.15);
    }
</style>
@endsection

@section('content')
<div class="leaderboard-container fade-in-up">
    <div class="leaderboard-header">
        <i class="fas fa-trophy trophy-icon"></i>
        <h1>Global Leaderboard</h1>
        <p>Complete lessons, earn XP, and climb to the top!</p>
    </div>

    @if(auth()->check() && auth()->user()->isStudent() && isset($currentUserRank))
    <div class="user-stats-card fade-in-up fade-in-up-delay-1">
        <div class="stat-item">
            <div class="stat-label">Your Rank</div>
            <div class="stat-value rank">#{{ $currentUserRank->rank }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Total XP</div>
            <div class="stat-value">{{ number_format($currentUserRank->xp) }} <span style="font-size:18px; color:#94a3b8">XP</span></div>
        </div>
        <div class="stat-item">
            <div class="stat-label">Lessons Completed</div>
            <div class="stat-value">{{ $currentUserRank->lesson_progress_count }}</div>
        </div>
    </div>
    @endif

    <div class="leaderboard-list fade-in-up fade-in-up-delay-2">
        @forelse($topStudents as $student)
            <div class="leaderboard-item rank-{{ $student->rank }} {{ (auth()->id() == $student->id) ? 'is-current-user' : '' }}">
                <div class="rank-badge">
                    @if($student->rank == 1)
                        <i class="fas fa-crown"></i>
                    @else
                        {{ $student->rank }}
                    @endif
                </div>
                
                <div class="student-info">
                    <img src="{{ $student->avatar ? asset('storage/'.$student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=random' }}" alt="{{ $student->name }}" class="student-avatar">
                    <div class="student-details">
                        <h3>{{ $student->name }} {{ (auth()->id() == $student->id) ? '(You)' : '' }}</h3>
                        <p>Student</p>
                    </div>
                </div>
                
                <div class="student-xp">
                    <div class="xp-value">{{ number_format($student->xp) }} <i class="fas fa-bolt" style="color:#F5C518; font-size: 16px;"></i></div>
                    <div class="xp-label">Total XP</div>
                </div>
            </div>
        @empty
            <div style="padding: 40px; text-align: center; color: #94a3b8;">
                <i class="fas fa-users-slash" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                <p>No students found on the leaderboard yet. Be the first to earn XP!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection