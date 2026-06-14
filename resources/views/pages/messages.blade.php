@extends('layouts.app')

@section('title', __('Messages | Codify'))
@section('page-title', __('Messages'))

@section('content')
<div class="card">
    <div class="card-body" style="text-align: center; padding: 60px 20px;">
        <i class="fas fa-comment-dots" style="font-size: 64px; color: var(--brand); margin-bottom: 20px;"></i>
        <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 10px;">{{ __('Your messages') }}</h2>
        <p style="color: var(--text-muted); max-width: 400px; margin: 0 auto;">{{ __('Communicate with teachers and fellow students') }}. {{ __('Your conversations will appear here') }}.</p>
        <br>
        <div style="background: var(--bg); border-radius: var(--radius-md); padding: 15px; max-width: 400px; margin: 20px auto; display: flex; align-items: center; gap: 15px; text-align: left;">
            <div style="width: 40px; height: 40px; background: var(--brand); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">A</div>
            <div>
                <div style="font-size: 14px; font-weight: 600;">{{ __('Support') }}</div>
                <div style="font-size: 13px; color: var(--text-muted);">{{ __('Welcome to') }} Codify!...</div>
            </div>
            <div style="margin-left: auto; width: 8px; height: 8px; background: var(--brand); border-radius: 50%;"></div>
        </div>
    </div>
</div>
@endsection