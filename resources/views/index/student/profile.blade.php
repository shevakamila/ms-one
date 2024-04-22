@extends('layouts.view-main')

@push('style')
<style>
        .payment-card {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.border-left-primary {
    border-left: 5px solid #007bff; /* Warna biru */
}

.border-left-success {
    border-left: 5px solid #28a745; /* Warna hijau */
}

.border-left-danger {
    border-left: 5px solid #dc3545; /* Warna merah */
}
a{ 
    text-decoration: none;
}
.icon-text {
    display: inline-block;
    width: 30px; /* Sesuaikan lebar ikon sesuai kebutuhan */
    text-align: center;
    margin-right: 10px; /* Sesuaikan margin kanan ikon sesuai kebutuhan */
}

</style>
@endpush


@section('container')
@include('partials.view-user.navbar')

<div class="container mt-5">
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
    <div class="row mb-3">
        <div class="col-md-4">
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
                    <div class="card-detail">
                        <p><span class="icon-text"><i class="fas fa-user"></i></span> Nama : {{ $data['user']->name }}</p>
                        <p><span class="icon-text"><i class="fas fa-envelope"></i></span> Email : <span class="fw-semibold">{{ $data['user']->email }}</span></p>
                        <p><span class="icon-text"><i class="fas fa-chalkboard-teacher"></i></span> Kelas : <span class="fw-semibold">{{ $data['user']->student->classRoom->name }}</span></p>
                        @if ($data['user']->role == 'student')
                            <p><span class="icon-text"><i class="fas fa-id-badge"></i></span> NISN :  <span class="fw-semibold">{{ $data['user']->student->nisn }}</span></p>
                            <p><span class="icon-text"><i class="fas fa-key"></i></span> Unique Code :  <span class="fw-semibold">{{ $data['user']->student->unique_code }}</span></p>
                        @endif
                    </div>
                    
                    
                </div>
                <div class="card-footer">
                    <button class="btn btn-success  my-1 w-100" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UniqueCodeModal">Generate Unique Code</button>
                    <button class="btn btn-danger my-1 w-100">Logout</button>
                </div>
            </div>
            
        </div>
        
        <div class="col-md-8">
            <div class="row row-cols-2 row-cols-md-2">
                <div class="col mb-3">
                    <div class="card border-left-primary h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Total dibayarkan:</p>
                               
                                <p class="fw-semibold fs-5">Rp.{{ number_format($data['payment']['totalAmountPayment'], 0, ',', '.') }}</p>
                            </div>
                           <i class="fas fa-money-check-alt fa-2x text-primary"></i>
                        </div>
                       
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card border-left-primary h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Pembayaran Dilakukan</p>
                                <p class="fw-semibold fs-5">{{ $data['payment']['totalPaymentDoing'] }}</p>
                            </div>
                            <i class="fas fa-check-circle fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col mb-3">
                    <div class="card border-left-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Pembayaran Berhasil:</p>
                                <p class="fw-semibold fs-5">{{ $data['payment']['totalPaymentSuccess'] }}</p>
                            </div>
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card border-left-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Pembayaran Gagal:</p>
                                <p class="fw-semibold fs-5">{{ $data['payment']['totalPaymentFailed'] }}</p>
                            </div>
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3">
                <div class="col mb-3">
                    <div class="card border-left-primary h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Kegiatan Terdaftar</p>
                               
                                <p class="fw-semibold fs-5">{{ $data['payment']['activityRegistered'] }}</p>
                            </div>
                            <i class="fas fa-tasks fa-2x text-primary"></i> 
                        </div>
                       
                    </div>
                </div>

                <div class="col mb-3">
                    <div class="card border-left-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Kegiatan Lunas</p>
                                <p class="fw-semibold fs-5">{{ $data['payment']['activityPaid'] }}</p>
                            </div>
                            <i class="far fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card border-left-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Kegiatan Belum Lunas</p>
                                <p class="fw-semibold fs-5">{{ $data['payment']['activityUnpaid'] }}</p>
                            </div>
                            <i class="far fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mt-4" style="border-radius: 2px">
                <div class="card-header bg-dark " style="border-radius: 2px">
                    <p class="fw-semibol fs-5 m-0  text-light">Pembayaran Terakhir</p>
                </div>
                <div class="card-body">
                    <a href="/student/payment/payment-history" class="btn btn-primary">Lihat Lebih Banyak</a>
                    @foreach ($data['payment']['paymentHistory'] as $payment)
                    <div class="card my-2 d-block text-decoration-none card-list-history text-dark rounded-3 border">
                        <div class="card-body d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    @if ($payment->student->user->image)
                                    <img src="{{ asset('img/user/'.$payment->student->user->image) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" alt="{{ $payment->student->user->nisn }}">
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
            </div>
        </div>
        
    </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="UniqueCodeModal" tabindex="-1" aria-labelledby="UniqueCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('generateNewUniqueCode') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="UniqueCodeModalLabel">Generate new unique code</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nunique_code_new" class="form-label">New Unique Code</label>
                    <input type="text" class="form-control @error('unique_code_new') is-invalid @enderror" id="unique_code_new" name="unique_code_new" required placeholder="Masukan Unique code baru">
                    @error('unique_code_new')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <input type="hidden" name="student_id" value="{{ $data['user']->id }}">

                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
@include('partials.view-user.footer')
@endsection
