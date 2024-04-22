@extends('layouts.view-main')

@push('style')
<style>
    .btn-sm-extra {
        padding: 4px 10px;
        font-size: 10px;
    }

    .card-header.bg-dark {
        border-bottom: none; 
    }

    .card-list-history {
        transition: transform 0.3s ease;
    }
  .card-list-history:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .navbar {
        background-color: #343a40;
        color: #fff;
    }

    .footer {
        background-color: #343a40;
        color: #fff;
        padding: 20px 0;
        text-align: center;

        width: 100%;
    }
</style>
@endpush

@section('container')
@include('partials.view-user.navbar')

<div class="container m-auto" style="max-width: 800px;min-height:1500px">

    <h2 class="fw-bold mt-4 mb-3 ">Payment History</h2>

    @foreach ($data['payment'] as $payment)
    <div class="card my-2 d-block text-decoration-none card-list-history text-dark rounded-3 border">
        <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-2">
                    @if ($payment->student->user->image)
                    <img src="{{ asset('img/user/' . $payment->student->user->image) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $payment->student->user->nisn }}">
                    @else
                    <i class="fas fa-user-circle me-2" style="font-size: 20px;"></i>
                    @endif
                    <h7 class="card-title mb-0" style="font-size: 20px">{{ $payment->student->user->name }}-{{ $payment->student->nisn }}</h7>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-tasks me-2" style="font-size: 20px;"></i>
                    <h5 class="card-title mb-0" style="font-size: 16px">{{ $payment->activity->name }}</h5>
                    
                </div>
                <p class="card-text mb-0 text-muted" style="font-size: 13px">Rp. {{ number_format($payment->amount, 0, ',', '.') }}</p>
                <p class="card-text mb-0 text-muted" style="font-size: 13px">{{ $payment->created_at->diffForHumans() }}</p>
                <p class="card-text mb-0 text-muted" style="font-size: 13px">Email pembayar: {{ $payment->user->email }}</p>
                
            </div>
            <div class="ms-3">
                @if ($payment->status == 'paid')
                <span class="badge bg-success py-2 px-2 me-2"><i class="fas fa-check-circle me-1"></i>Success</span>
                @elseif($payment->status =='failed')
                <span class="badge bg-danger py-2 px-2 me-2"><i class="fas fa-times me-1"></i>Failed</span>

                @else
                <span class="badge bg-warning py-2 px-2 me-2"><i class="fas fa-exclamation-circle me-1"></i>Pending</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="footer">
    <p class="m-0">&copy; 2024 Your Company. All rights reserved.</p>
</div>

@endsection
