@extends('layouts.dashboard-admin')

@section('content-dashboard')

<div class="container-fluid">

    <h1 class="h3 mb-0 text-gray-800 mb-4">Dashboard</h1>

    <div class="row row-cols-1 row-col-md-2 row-cols-lg-3 row-cols-xl-3">

        <div class="col mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                                {{ $data['account']['student']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['account']['student']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user-graduate fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-warning text-uppercase mb-1">
                                {{ $data['account']['admin']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['account']['admin']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user-pen fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col mb-4">
            <div class="card border-left-red shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-red text-uppercase mb-1">
                                {{ $data['account']['pengguna']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['account']['pengguna']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user fa-2x text-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row row-cols-2 row-col-md-2 row-cols-lg-3 row-cols-xl-3">

        
        <div class="col mb-4">
            <div class="card border-left-black shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-black text-uppercase mb-1">
                                {{ $data['activity']['total']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['activity']['total']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user-pen fa-2x text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-dark text-uppercase mb-1">
                                {{ $data['activity']['total_true']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['activity']['total_true']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user fa-2x text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-s font-weight-bold text-secondary text-uppercase mb-1">
                                {{ $data['activity']['total_false']['title'] }}</div>
                            <div class="h5 mb-0 font-weight-bold text-secondary">{{ $data['activity']['total_true']['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-calendar-xmark fa-2x text-gray-700"></i>
                        </div>  
                    </div>
                </div>
            </div>
        </div>


        

    </div>


</div>
@endsection


