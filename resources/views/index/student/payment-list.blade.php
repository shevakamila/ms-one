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
    .card-list-activity:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .navbar {
        background-color: #343a40; 
        color: #fff; 
    }
    .card-list-activity {
        transition: transform 0.3s ease;
    }
    .card-list-activity:hover {
        transform: translateY(-5px); 
    }
</style>
@endpush
@section('container')
@include('partials.view-user.navbar')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card" style="border-radius: 4px">
                    <div class="card-header bg-dark">
                        <div class="card-img m-auto text-center pt-3">
                            @if ($data['user']->image)
                                <img src="{{ asset('img/user/'.$data['user']->image ) }}" alt="" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle fa-5x text-light"></i>
                            @endif
                            <p class="fs-5 fw-bold text-light mt-2">{{ $data['user']->name }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-detail ">
                            <p><i class="fas fa-user"></i> Nama: <span class="fw-semibold">{{ $data['user']->name }}</span></p>
                            <p><i class="fas fa-envelope"></i> Email: <span class="fw-semibold">{{ $data['user']->email }}</span></p>
                            <p><i class="fas fa-id-badge"></i> NISN : {{ $data['user']->student->nisn }}</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark fs-5 text-light">
                    List Kegiatan Anda
                </div>
                <div class="card-body">
                    @forelse ($data['activities'] as $activity)
                    <a href="/student/payment/payment-detail/{{ $activity->id }}/{{ $data['user']->student->id }}" class="card mb-3 d-block text-decoration-none card-list-activity text-dark rounded-3 border">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1" style="font-size: 16px">{{ $activity->name }}</h5>
                                <p class="card-text mb-1 text-muted" style="font-size: 13px">Biaya: Rp. {{ number_format($activity->getOutstandingAmountPayment($data['user']->student->id, $activity->id), 0, ',', '.') }}</p>
                            </div>
                            <div class="ms-3">
                                @if ($activity->pivot->is_paid_off)
                                    <span class="badge bg-success py-2 px-2 me-2">Lunas</span>
                                @else
                                    <span class="badge bg-danger py-2 me-2">Belum Lunas</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @empty
                        <p class="mb-0">Tidak ada kegiatan yang harus dibayarkan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


