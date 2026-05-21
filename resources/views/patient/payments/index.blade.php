@extends('layouts.patient')
@section('title', 'My Payments')

@section('content')
<h1>My Payments</h1>

@if(!$patient)
    <div class="alert alert-warning">
        
        Your account is not linked to a patient profile. Please contact the clinic.
    </div>
@else
    @if($payments->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                
                <p class="mt-3 mb-0" style="color:#6B7280;">No payment records found.</p>
            </div>
        </div>
    @else
        <div class="table-responsive">
            <table class="product-table">
                <thead>
                    <tr>
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
                    @foreach($payments as $payment)
                    <tr>
                        <td class="td-name">{{ $payment->appointment->service->service_name ?? '—' }}</td>
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
                            <a href="{{ route('patient.payments.receipt', $payment) }}" class="btn-edit">
                                 View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif
@endsection
