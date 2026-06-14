@extends('layouts.app')

@section('title', __('My Orders') . ' | Codify')

@section('content')
<div class="container" style="padding-top: 100px; padding-bottom: 60px;">
    @include('student.layouts.nav')

    <div class="page-header" style="margin-bottom: 40px;">
        <h1 class="page-title" style="font-size: 32px; background: linear-gradient(135deg, #fff 0%, var(--brand) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{{ __('Purchase History') }}</h1>
        <p style="color: var(--text-muted); margin-top: 8px;">{{ __('Track your orders, invoices, and transaction history.') }}</p>
    </div>

    <div class="glass-card" style="overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(255,255,255,0.02); border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <th style="padding: 18px 24px; color: var(--text-muted); font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ __('Order ID') }}</th>
                    <th style="padding: 18px 24px; color: var(--text-muted); font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ __('Courses') }}</th>
                    <th style="padding: 18px 24px; color: var(--text-muted); font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ __('Total Amount') }}</th>
                    <th style="padding: 18px 24px; color: var(--text-muted); font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ __('Status') }}</th>
                    <th style="padding: 18px 24px; color: var(--text-muted); font-size: 13px; font-weight: 700; text-transform: uppercase;">{{ __('Date') }}</th>
                    <th style="padding: 18px 24px; text-align: right;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.04); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.01)'" onmouseout="this.style.background='none'">
                        <td style="padding: 18px 24px; font-weight: 600; color: #fff;">
                            #{{ $order->order_number ?? $order->id }}
                        </td>
                        <td style="padding: 18px 24px; color: var(--text-muted); font-size: 14px;">
                            @if($order->items && $order->items->count() > 0)
                                {{ $order->items->map(fn($item) => $item->course->title ?? '')->implode(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td style="padding: 18px 24px; color: var(--text-primary); font-weight: 700;">
                            ${{ number_format($order->total_amount, 2) }}
                        </td>
                        <td style="padding: 18px 24px;">
                            @if($order->status === 'completed' || $order->status === 'success')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Completed') }}</span>
                            @elseif($order->status === 'pending')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Pending') }}</span>
                            @else
                                <span class="badge" style="background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); font-weight: 600; border-radius: 8px; padding: 4px 10px;">{{ __('Failed') }}</span>
                            @endif
                        </td>
                        <td style="padding: 18px 24px; color: var(--text-muted); font-size: 14px;">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td style="padding: 18px 24px; text-align: right;">
                            <a href="{{ route('student.orders.show', $order->id) }}" class="btn btn-sm" style="padding: 6px 14px; font-size: 12px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.15); color: #fff; background: rgba(255, 255, 255, 0.02); transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.borderColor='rgba(255,255,255,0.15)'">
                                {{ __('Details') }}
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 40px; text-align: center; color: var(--text-muted);">
                            {{ __('You have not placed any orders yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection