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
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>Cari siswa</span>
                    <i class="fas fa-search"></i>
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session('error') }}
                    </div>
                    @endif
                    <form action="/pengguna/payment/cek-list-payment" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="nisn" placeholder="NISN" required value="{{ old('nisn') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="text" class="form-control" name="unique_code" placeholder="Kode Unik" required value="{{ old('unique_code') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Cek Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
            
           
        </div>
        <div class="col-md-8">
            <div class="card border-dark shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <i class="fas fa-user-circle fa-3x text-dark me-3"></i>
                        <h5 class="card-title mb-0">Detail Siswa</h5>
                    </div>
                    <div class="text-center">
                        @if (isset($data['student']))
                            <p>Nama Siswa: {{ $data['student']->user->name }}</p>
                        @else
                            <p>Cari siswa terlebih dahulu</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card mt-2 rounded-3 shadow">
                <div class="card-header bg-dark text-white rounded-top">
                    <i class="fas fa-list-alt me-2"></i> List Kegiatan
                </div>
                <div class="card-body">
                    @if (isset($data['student']))
                        @forelse ($data['student']->activities as $activity)
                        <a href="/pengguna/payment/payment-detail/{{ $activity->id }}/{{ $data['student']->id }}" class="card mb-3 d-block text-decoration-none card-list-activity text-dark rounded-3 border">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1" style="font-size: 16px">{{ $activity->name }}</h5>
                                    <p class="card-text mb-1 text-muted" style="font-size: 13px">Biaya: Rp. {{ number_format($activity->getOutstandingAmountPayment($data['student']->id, $activity->id), 0, ',', '.') }}</p>
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
                    @else
                        <p class="mb-0">Cari siswa terlebih dahulu</p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection


