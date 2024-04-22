@extends('layouts.view-main')

@section('container')
<div class="row vh-100 m-0 flex-column flex-sm-row bg-primary">
    <div class="col d-flex align-items-center justify-content-center">
        <div class="card w-75">
            <div class="card-body">
                <h1 class="text-center text-dark mb-4 fw-bold">Registrasi</h1>
                <p class="text-center">Daftarkan Akun Anda</p>
                <form action="/registrasi" method="post">
                    @csrf
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama" style="background-color: #f8f9fa;" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" style="background-color: #f8f9fa;"  value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" style="background-color: #f8f9fa;"  value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" style="background-color: #f8f9fa;"  value="{{ old('password') }}">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <input type="password" class="form-control @error('confirmed_password') is-invalid @enderror" name="confirmed_password" placeholder="Konfirmasi Password" style="background-color: #f8f9fa;"  value="{{ old('confirmed_password') }}">
                        @error('confirmed_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Registrasi</button>
                </form>

            </div>
        </div>
    </div>
    <div class="col d-flex align-items-center justify-content-center">
        <div class="text-center container">
            <h1 class="mb-1 fw-semibold text-white">MS-ONE</h1>
            <p class="mb-4 text-white" style="font-size: 1.2rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, perferendis.</p>
            {{-- <img src="{{ asset('img/asset/onedek-logo.jpg') }}" alt="" style="max-width: 100%; height: auto;"> --}}
        </div>
    </div>
</div>
@endsection
