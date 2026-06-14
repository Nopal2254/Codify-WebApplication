@extends('layouts.app')

@section('title', __('Order Details') . ' | Codify')

@section('content')
<div class="container" style="padding-top: 100px; padding-bottom: 60px;">
    @include('student.layouts.nav')

    <div style="margin-bottom: 30px;">
        <a href="{{ route('student.orders.index') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; font-size: 13px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; background: rgba(255, 255, 255, 0.02); transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.15)'">
            <i class="fas fa-arrow-left me-2"></i> {{ __('Back to Purchase History') }}
        </a>
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="glass-card" style="padding: 32px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 16px;">
                    <h2 style="font-size: 20px; font-weight: 800; color: #fff; margin: 0;">{{ __('Items in Order') }}</h2>
                    <span style="color: var(--text-muted); font-size: 14px;">{{ $order->items->count() }} {{ __('Course(s)') }}</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($order->items as $item)
                        @if($item->course)
                            <div style="display: flex; gap: 16px; align-items: center;">
                                <div style="width: 100px; height: 60px; border-radius: 8px; overflow: hidden; background: #000; flex-shrink: 0;">
                                    <img src="{{ $item->course->image ? asset('storage/' . $item->course->image) : asset('images/course-placeholder.jpg') }}" 
                                         alt="{{ $item->course->title }}"
                                         style="width: 100%; height: 100%; object-fit: cover;"
                                         onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&auto=format&fit=crop&q=80'">
                                </div>
                                <div style="flex-grow: 1;">
                                    <h4 style="font-size: 15px; font-weight: 700; color: #fff; margin: 0;">{{ $item->course->title }}</h4>
                                    <small style="color: var(--text-muted);">{{ __('Instructor') }}: {{ $item->course->user->name ?? 'Unknown' }}</small>
                                </div>
                                <div style="font-weight: 700; color: #fff;">
                                    ${{ number_format($item->price, 2) }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Invoice Summary -->
        <div class="col-lg-4">
            <div class="glass-card" style="padding: 32px;">
                <h3 style="font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 24px; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 16px;">
                    {{ __('Invoice Summary') }}
                </h3>

                <div style="display: flex; flex-direction: column; gap: 16px; font-size: 14px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">{{ __('Order Number') }}</span>
                        <strong style="color: #fff;">#{{ $order->order_number ?? $order->id }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">{{ __('Order Date') }}</span>
                        <strong style="color: #fff;">{{ $order->created_at->format('M d, Y') }}</strong>
                    </div>

                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--text-muted);">{{ __('Order Status') }}</span>
                        @if($order->status === 'completed' || $order->status === 'success')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Completed') }}</span>
                        @elseif($order->status === 'pending')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Pending') }}</span>
                        @else
                            <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Failed') }}</span>
                        @endif
                    </div>

                    <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px;">
                        <span style="color: var(--text-muted);">{{ __('Subtotal') }}</span>
                        <strong style="color: #fff;">${{ number_format($order->subtotal ?? $order->total_amount, 2) }}</strong>
                    </div>

                    @if($order->coupon)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">{{ __('Discount') }} ({{ $order->coupon->code }})</span>
                            <strong class="text-success">-${{ number_format($order->discount_amount ?? 0, 2) }}</strong>
                        </div>
                    @endif

                    @if($order->payment)
                        <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px;">
                            <span style="color: var(--text-muted);">{{ __('Payment Method') }}</span>
                            <strong style="color: #fff;">{{ ucfirst($order->payment->payment_method) }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">{{ __('Transaction ID') }}</span>
                            <code style="color: var(--text-muted); font-size: 12px;">{{ $order->payment->transaction_id ?? '-' }}</code>
                        </div>
                    @endif

                    <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 16px;">
                        <span style="font-size: 16px; font-weight: 700; color: #fff;">{{ __('Total') }}</span>
                        <span style="font-size: 20px; font-weight: 800; color: #a5b4fc;">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection