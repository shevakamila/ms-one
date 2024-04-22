@extends('layouts.dashboard-admin')

@section('content-dashboard')
<div class="container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold text-primary">Profile</h3>
      </div>
      <div class="card-body d-flex align-items-center" style="min-height: 250px">
        <div class="row w-100">
          <div class="col-md-5 d-flex justify-content-center">
            <div class="c-img d-flex align-items-center">
                <img src="{{ asset('img/asset/onedek-depan.jpg') }}" alt="User Image" style="max-width: 100%; max-height: 200px;" class="rounded img-fluid">
            </div>
          </div>
          <div class="col-md-7 d-flex align-items-center">
            <div>
              <p><strong>Nama:</strong> <span>Zaidar Fadli Mizar</span></p>
              <p><strong>Username:</strong> <span>Zaidar123</span></p>
              <p><strong>Email:</strong> <span>zaidar@gmail.com</span></p>
              <p><strong>Role:</strong> <span>Admin</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

@endsection
