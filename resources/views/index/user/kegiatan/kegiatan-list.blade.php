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

    <h1 class="fs-2 border-bottom border-2 border-dark pb-3">Daftar Kegiatan</h1>
   
    <div class="contain-list-kegiatan mt-4">

         @forelse ($data['activities'] as $activity)
         <div class="card my-3">
            <div class="row flex-row-reverse">
                <div class="col-12 col-md-4">
                    <img src="{{ asset('img/asset/onedek-depan.jpg') }}" alt="" class="img-fluid">
                </div>
                <div class="col-12 col-md-8">
                    <div class="card-body">
                        <h1 class="fs-4">{{ $activity->name }}</h1>
                        <p class="d-none d-md-block">Biaya kegiatan : Rp.{{ number_format($activity->amount, 0, ',', '.') }}  </p>
                        <p class="d-none d-md-block">Tenggat Bayar : {{ $activity->due_date  }} </p>
                        <p class="d-none d-md-block">Deskripsi : {{$activity->description  }}</p>
                        
                    </div>
                </div>
            </div>
        </div>
        @empty
            <h2 class="text-center">Belum ada kegiatan</h2>
        @endforelse
    </div>
   
</div>
@endsection
