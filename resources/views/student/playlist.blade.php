@extends('layouts.app')

@section('title', __('My Playlist') . ' | Codify')

@section('content')
<div class="container" style="padding-top: 100px; padding-bottom: 60px;">
    @include('student.layouts.nav')

    <div class="page-header" style="margin-bottom: 40px;">
        <h1 class="page-title" style="font-size: 32px; background: linear-gradient(135deg, #fff 0%, var(--brand) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ __('My Playlist') }}</h1>
        <p style="color: var(--text-muted); margin-top: 8px;">{{ __('Your saved courses grouped by categories.') }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 16px; background: rgba(16, 185, 129, 0.1); color: #047857;">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($groupedPlaylist->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 32px;">
            @foreach($groupedPlaylist as $categoryName => $items)
                <div class="glass-card" style="padding: 28px; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg);">
                    <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa-solid fa-folder-open" style="color: var(--brand, #6366f1) !important;"></i>
                        {{ $categoryName }}
                    </h3>

                    <div class="row g-4">
                        @foreach($items as $item)
                            @if($item->course)
                                @php $course = $item->course; @endphp
                                <div class="col-md-6 col-lg-4 course-card-wrapper">
                                    <div class="card h-100 border-0 overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05) !important; border-radius: var(--radius-md); transition: var(--transition);">
                                        <div style="position: relative; height: 160px; overflow: hidden;">
                                            @if($course->image_path || $course->image)
                                                <img src="{{ asset('storage/' . ($course->image_path ?? $course->image)) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column justify-content-between">
                                            <div>
                                                <small class="text-muted d-block mb-1">{{ $course->category->name ?? '' }}</small>
                                                <h5 class="card-title fw-bold text-white mb-3" style="font-size: 16px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 44px;">
                                                    {{ $course->title }}
                                                </h5>
                                                <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px; display: flex; align-items: center; gap: 6px;">
                                                    <i class="far fa-user"></i> {{ $course->instructor->name ?? 'Instructor' }}
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-3 gap-2">
                                                @if($course->lessons->first())
                                                    <a href="{{ route('course.learn', ['slug' => $course->slug, 'lesson' => $course->lessons->first()->id]) }}" class="btn btn-primary btn-sm flex-grow-1" style="border-radius: var(--radius-sm); font-size: 12.5px;">
                                                        <i class="fas fa-play me-1"></i> {{ __('Start Learning') }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-outline-secondary btn-sm flex-grow-1" style="border-radius: var(--radius-sm); font-size: 12.5px;">
                                                        {{ __('View Course') }}
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('student.playlist.toggle', $course->id) }}" method="POST" class="m-0 playlist-toggle-form" style="display: inline-flex; align-items: center;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm" style="border-radius: var(--radius-sm); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.08); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;" onmouseover="this.style.background='#ef4444'; this.style.color='#ffffff'; this.style.borderColor='#ef4444';" onmouseout="this.style.background='rgba(239, 68, 68, 0.08)'; this.style.color='#ef4444'; this.style.borderColor='rgba(239, 68, 68, 0.4)';" title="{{ __('Remove from Playlist') }}">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="glass-card" style="padding: 60px 40px; text-align: center; background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: var(--radius-lg);">
            <div style="width: 80px; height: 80px; background: rgba(99, 102, 241,0.08); color: var(--text-muted); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px; border: 2px dashed rgba(255,255,255,0.12);">
                <i class="fa-solid fa-list"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px;">{{ __('Your playlist is empty') }}</h3>
            <p style="color: var(--text-muted); font-size: 14.5px; max-width: 420px; margin: 0 auto 24px;">{{ __('Save courses to your playlist from the course page to watch them later.') }}</p>
            <a href="{{ route('my-learning') }}" class="btn btn-primary" style="padding: 10px 24px; border-radius: 10px; font-weight: 600;">
                {{ __('Go to My Learning') }}
            </a>
        </div>
    @endif
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.playlist-toggle-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const cardWrapper = this.closest('.course-card-wrapper');
            const glassCard = this.closest('.glass-card');
            const row = this.closest('.row');
            
            const btn = this.querySelector('button');
            if (btn) btn.disabled = true;

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.action === 'removed') {
                    cardWrapper.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    cardWrapper.style.opacity = '0';
                    cardWrapper.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        cardWrapper.remove();
                        if (row.querySelectorAll('.course-card-wrapper').length === 0) {
                            glassCard.style.transition = 'opacity 0.4s ease';
                            glassCard.style.opacity = '0';
                            setTimeout(() => {
                                glassCard.remove();
                                if (document.querySelectorAll('.glass-card').length === 0) {
                                    window.location.reload();
                                }
                            }, 400);
                        }
                    }, 400);
                } else {
                    if (btn) btn.disabled = false;
                }
            })
            .catch(err => {
                if (btn) btn.disabled = false;
                console.error(err);
            });
        });
    });
});
</script>
@endsection
