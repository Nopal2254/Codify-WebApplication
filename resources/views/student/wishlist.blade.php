@extends('layouts.app')

@section('title', __('messages.wishlist.title') . ' | Codify')

@section('content')
<div class="container" style="padding-top: 100px; padding-bottom: 60px;">
    @include('student.layouts.nav')

    <div class="page-header" style="margin-bottom: 40px;">
        <h1 class="page-title" style="font-size: 32px; background: linear-gradient(135deg, #fff 0%, var(--brand) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ __('messages.wishlist.title') }}</h1>
        <p style="color: var(--text-muted); margin-top: 8px;">{{ __('Manage the courses you are interested in.') }}</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 16px; background: rgba(16, 185, 129, 0.1); color: #047857;">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($wishlists->count() > 0)
        <div class="row g-4">
            @foreach($wishlists as $item)
                @php $course = $item->course; @endphp
                @if($course)
                    <div class="col-md-6 col-lg-4">
                        <div class="glass-card" style="overflow: hidden; height: 100%; display: flex; flex-direction: column;">
                            <!-- Course Thumbnail -->
                            <div style="height: 180px; position: relative; overflow: hidden; background: #000;">
                                <img src="{{ $course->image ? asset('storage/' . $course->image) : asset('images/course-placeholder.jpg') }}" 
                                     alt="{{ $course->title }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80'">
                                
                                <!-- Remove from Wishlist button -->
                                <form action="{{ route('wishlist.toggle', $course->id) }}" method="POST" style="position: absolute; top: 15px; right: 15px;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm" style="background: rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.2); color: #ef4444; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0;" title="{{ __('messages.cart.remove_tooltip') }}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>

                            <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1;">
                                <span style="font-size: 11px; font-weight: 700; color: #a5b4fc; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">
                                    {{ $course->category->name ?? '' }}
                                </span>
                                
                                <h4 style="font-size: 16px; font-weight: 800; color: #fff; margin-bottom: 8px; line-height: 1.4; height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $course->title }}
                                </h4>
                                
                                <div style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 20px;">
                                    {{ __('messages.cart.instructor') }}: <strong style="color: #fff;">{{ $course->user->name ?? 'Unknown' }}</strong>
                                </div>

                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px;">
                                    <span style="font-size: 18px; font-weight: 800; color: #fff;">
                                        @if($course->price > 0)
                                            ${{ number_format($course->price, 2) }}
                                        @else
                                            {{ __('messages.course.free') }}
                                        @endif
                                    </span>
                                    
                                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-gradient btn-sm" style="padding: 8px 16px; font-size: 13px; border-radius: 8px;">
                                        {{ __('View Details') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="glass-card" style="padding: 60px 40px; text-align: center;">
            <div style="width: 80px; height: 80px; background: rgba(99, 102, 241,0.08); color: var(--text-muted); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 32px; margin-bottom: 24px; border: 2px dashed rgba(255,255,255,0.12);">
                <i class="fas fa-heart"></i>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; color: #fff; margin-bottom: 8px;">{{ __('messages.wishlist.empty_title') }}</h3>
            <p style="color: var(--text-muted); font-size: 14.5px; max-width: 420px; margin: 0 auto 24px;">{{ __('messages.wishlist.empty_desc') }}</p>
            <a href="{{ route('search') }}" class="btn btn-gradient" style="padding: 10px 24px; border-radius: 10px; font-weight: 600;">
                {{ __('messages.wishlist.browse') }}
            </a>
        </div>
    @endif
</div>
@endsection