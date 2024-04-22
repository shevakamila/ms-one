{{-- @extends('layouts.view-main')

@push('style')
    <style>
        body {
    background-color: #007bff; /* Warna primer Bootstrap */
    background-image: linear-gradient(to right, #007bff, #4294db); /* Gradient */
    }
    a{
        text-decoration: none;
    }
    </style>
@endpush
@section('container')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-4 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-8">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">LOGIN</h1>
                                </div>
                                @if (session()->has('success'))
                                <div class="success-alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    {{ session('success') }}
                                </div>
                                @endif
                                @if (session()->has('error'))
                                <div class="error-alert">
                                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                                    {{ session('error') }}
                                </div>
                                @endif
                                <form class="user" action="/login" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                            id="email" name="email" aria-describedby="emailHelp"
                                            placeholder="Masukan email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/page-registrasi">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection --}}







@extends('layouts.view-main')


@section('container')
<div class="row vh-100 m-0 flex-column flex-sm-row">
    <div class="col d-flex align-items-center justify-content-center">
        <div class="login-container p-5">
            <h1 class="text-center mb-4 fw-semibold">Login</h1>

            <p class="text-center">Silakan masukkan email dan password</p>
            <form action="/login" method="post">
                @csrf
                @if (session()->has('success'))
                <div class="success-alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    {{ session('success') }}
                </div>
                @endif
                @if (session()->has('error'))
                <div class="error-alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    {{ session('error') }}
                </div>
                @endif
                <div class="mb-3">
                    <input type="email" class="form-control " placeholder="Email" name="email" style="background-color: #f8f9fa;">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control " name="password" placeholder="Password" style="background-color: #f8f9fa;">
                </div>
                <p class="text-center">Belum punya akun? <span><a href="/page-registrasi">Klik disini</a></span></p>
                <button type="submit" class="btn btn-primary  w-100">Login</button>
            </form>
        </div>
    </div>
    <div class="col bg-primary d-flex align-items-center justify-content-center">
        <div class="text-center container">
            <h1 class="mb-1 text-light">MS-ONE</h1>
            <p class="mb-4 text-light" style="font-size: 1.2rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, perferendis.</p>
            {{-- <img src="{{ asset('img/asset/onedek-logo.jpg') }}" alt="" style="max-width: 100%; height: auto;"> --}}
        </div>
    </div>
</div>
@endsection
