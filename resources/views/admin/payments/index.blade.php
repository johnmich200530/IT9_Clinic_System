@extends('layouts.admin')
@section('title', 'Payments')

@section('content')
<h1><i class="bi bi-credit-card-2-front-fill me-2"></i>Payments</h1>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm h-100" style="background:#059669;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-cash-coin" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:28px;font-weight:800;color:#fff;margin-top:6px;">{{ number_format($totalRevenue, 2) }}</div>
                <div style="font-size:14px;color:rgba(255,255,255,0.8);margin-top:4px;font-weight:500;">Total Revenue</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm h-100" style="background:#4F46E5;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-arrow-left-right" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $totalPayments }}</div>
                <div style="font-size:14px;color:rgba(255,255,255,0.8);margin-top:4px;font-weight:500;">Total Transactions</div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card border-0 shadow-sm h-100" style="background:#D97706;border-radius:14px;">
            <div class="card-body text-center py-4">
                <i class="bi bi-hourglass-split" style="font-size:28px;color:rgba(255,255,255,0.7);"></i>
                <div style="font-size:36px;font-weight:800;color:#fff;margin-top:6px;">{{ $pendingCount }}</div>
                <div style="font-size:14px;color:rgba(255,255,255,0.8);margin-top:4px;font-weight:500;">Pending</div>
            </div>
        </div>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.payments.index') }}" class="mb-3">
    <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" class="search-input"
               placeholder="Search by patient, doctor, service, method or status…"
               value="{{ $search ?? '' }}">
        @if(!empty($search))
            <a href="{{ route('admin.payments.index') }}" class="search-clear">
                <i class="bi bi-x-lg"></i>
            </a>
        @endif
    </div>
</form>

<div class="table-responsive">
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Service</th>
                <th>Doctor</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
                <th>Receipt</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr>
                <td class="td-id">{{ $payment->id }}</td>
                <td class="td-name">{{ $payment->patient->full_name ?? '—' }}</td>
                <td>{{ $payment->appointment->service->service_name ?? '—' }}</td>
                <td>{{ $payment->appointment->doctor->full_name ?? '—' }}</td>
                <td class="td-price" style="font-weight:700;color:#059669;">
                    {{ number_format($payment->amount, 2) }}
                </td>
                <td>
                    @if($payment->method === 'Cash')
                        Cash
                    @elseif($payment->method === 'Card')
                        Card
                    @else
                        Bank Transfer
                    @endif
                </td>
                <td style="font-size:13px;">{{ $payment->created_at->format('M d, Y') }}</td>
                <td>
                    @if($payment->status === 'Paid')
                        <span class="badge" style="background:#D1FAE5;color:#065F46;">
                            Paid
                        </span>
                    @elseif($payment->status === 'Pending')
                        <span class="badge" style="background:#FEF3C7;color:#92400E;">Pending</span>
                    @else
                        <span class="badge" style="background:#FEE2E2;color:#991B1B;">Refunded</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.payments.show', $payment) }}" class="btn-edit">
                         View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted py-4">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
