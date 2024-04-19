@extends('layouts.dashboard-admin')

@section('content-dashboard')
     <div class="card">
        <div class="card-header">
            <h3 class="m-0 font-weight-bold text-primary p-0 py-1">Detail Siswa</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="c-img">
                                <img src="{{ asset('student/'.$data['student']->image) }}" class="img-fluid rounded-circle" style="max-width: 200px;" alt="Foto Siswa">
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="font-weight-bold">Nama:</label>
                                <span>{{ $data['student']->name }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">NISN:</label>
                                <span>{{ $data['student']->nisn }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Email:</label>
                                <span>{{ $data['student']->email }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Gender:</label>
                                <span>{{ $data['student']->gender }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Tanggal Lahir:</label>
                                <span>{{ $data['student']->birthdate }}</span>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold">Kelas:</label>
                                <span>{{ $data['student']->classRoom->name }}</span>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    
@endsection


