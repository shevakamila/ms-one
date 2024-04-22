@extends('layouts.dashboard-admin')

@section('content-dashboard')

<h1 class="h3 mb-2 text-gray-800 border-2 border-bottom border-secondary pb-2">Detail Siswa</h1>


{{-- INFO PEMBAYARAN SISWA --}}
<div class="row row-cols-1 row-col-md-2 row-cols-lg-3 row-cols-xl-3 mt-3">

    <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                        Total Uang Pembayaran</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">Rp.{{number_format($data['info']['total_pembayaran_amount'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                        Pembayaran Berhasil</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{$data['info']['total_pembayaran_success']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-danger text-uppercase mb-1">
                        Pembayaran Berhasil</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{$data['info']['total_pembayaran_failed'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

{{-- INFO KEGIATAN SISWA --}}
<div class="row row-cols-1 row-col-md-2 row-cols-lg-3 row-cols-xl-3">

    <div class="col mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                        Total Kegiatan Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['info']['total_kegiatan'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                        Kegiatan Lunas</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{$data['info']['total_kegiatan_paid']}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-danger text-uppercase mb-1">
                        Kegiatan Belum Lunas</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{$data['info']['total_kegiatan_unpaid'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-user fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>

{{-- CARD DETAIL SISWA --}}
<div class="card">
    <div class="card-header">
        <h3 class="m-0 font-weight-bold text-primary p-0 py-1">Detail Siswa</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="c-img justify-content-center align-item-center">
                            @if ($data['user']->image)
                            <img src="{{ asset('img/user/'.$data['student']->image) }}" class="img-fluid rounded-circle" style="max-width: 200px;" alt="Foto Siswa">
                            @else
                            <i class="fas fa-user-circle fa-5x "></i>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="font-weight-bold">Nama:</label>
                            <span>{{ $data['student']->user->name }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">NISN:</label>
                            <span>{{ $data['student']->nisn }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="font-weight-bold">Email:</label>
                            <span>{{ $data['student']->user->email }}</span>
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
        
{{-- CARD DETAIL KEGIATAN SISWA --}}
<div class="card mt-3">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary p-0 py-1">Daftar kegiatan siswa ini</h5>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <a href="" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#ModalActivity">Tambah Kegiatan</a>
        </div>
        <div class="table-responsive ">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Status Pembayaran</th>
                <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['student']->activities as $activity)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $activity->name }}</td>
                  <td>
                    @if ($activity->pivot->is_paid_off === true)
                    <span class="payment-status font-paid ">Lunas</span>
                    @else 
                    <span class="payment-status font-not-paid">Belum Lunas</span>
                    @endif

                </td>
                  <td>
                  <div class="mb-1" role="group">
                    <a href="{{ route('admin.deleteActivityFromStudent',['activity' => $activity->id,'student'=> $data['student']->id]) }}" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                      </a>
                  </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
</div>

{{-- CARD DETAIL PEMBAYARAN Untuk kegiatan siswa --}}
<div class="card mt-3">
    <div class="card-header">
        <h5 class="m-0 font-weight-bold text-primary p-0 py-1">List Pembayaran siswa</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive ">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Status Pembayaran</th>
                <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data['student']->payments as $payment)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $payment->name }}</td>
                  <td>
                    @if ($payment->status === 'paid')
                    <span class="payment-status font-paid ">Success</span>
                    @elseif($payment->status === 'pending')
                    <span class="payment-status font-not-paid-yet">Pending</span>
                    @else 
                    <span class="payment-status font-not-paid">Failed</span>
                    @endif
                  </td>
                  <td>
                  <div class="mb-1" role="group">
                    <a href="/admin/payments/{{ $payment->id }}/detail-siswa" class="btn btn-sm btn-primary">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/payments/{{ $payment->id }}/hapus-siswa" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i>
                      </a>
                  </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
</div>

<!-- Modal tambah kegiatan ke Siswa -->
<div class="modal fade" id="ModalActivity" tabindex="-1" aria-labelledby="ModalActivityLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.addActivityToStudent', ['student' => $data['student']->id]) }}" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalActivityLabel">Tambahkan Kegiatan ke Siswa ini</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @forelse ($data['activity_notRegistered'] as $activity)
                    <label for="" class="w-100 d-block">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-1">
                                        <input type="checkbox" name="activities[]" value="{{ $activity->id }}">
                                    </div>
                                    <div class="col-md-11">
                                        <h2 class="fs-5 m-0 fw-semibold">{{ $activity->name }}</h2>
                                        <p class="m-0 ">{{ $activity->amount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </label>
                    @empty
                    @endforelse
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection


