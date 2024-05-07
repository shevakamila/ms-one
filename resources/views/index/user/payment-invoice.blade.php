@extends('layouts.view-main')
@push('css')
<style>
    .payment-card {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.border-left-primary {
    border-left: 8px solid #007bff; /* Warna biru */
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

.info-section {
    margin-bottom: 20px;
}

.info-title {
    font-size: 14px;
    margin-bottom: 5px;
}

.info-text {
    font-size: 16px;
    margin-bottom: 0;
}


</style>
@endpush
@section('container')
{{-- @include('partials.view-user.navbar') --}}

<div class="container">

    @if ($data['payment']->status == 'paid')
    <div class="card m-auto  border-success mt-5" style="max-width: 750px">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h1 class="mb-0 fs-4">Detail Pembayaran</h1>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-6">
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-money-bill"></i> Jumlah Bayar:</h5>
                        <p class="info-text text-success">Rp.{{  number_format($data['payment']->amount, 0, ',', '.')  }}</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-user"></i> Akun Pembayar:</h5>
                        <p class="info-text text-muted">{{ $data['payment']->user->email }}</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-user-graduate"></i> Detail Siswa:</h5>
                        <p class="info-text m-0">Nama : {{ $data['payment']->student->user->name }}</p>
                        <p class="info-text m-0">Nisn : {{ $data['payment']->student->nisn }}</p>

                    </div>
                </div>
                <div class="col-6">
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-tasks"></i> Detail Kegiatan:</h5>
                        <p class="info-text">Nama Kegiatan</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title">Status:</h5>
                        <span class="badge bg-success py-2 me-2">Success</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end bg-light">
            <a class="btn btn-primary" href="/">Kembali Ke Home</a>
        </div>
    </div>
    @else
    <div class="card m-auto border-left-warning mt-5" style="max-width: 750px">
        <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
            <h1 class="mb-0 fs-4">Detail Pembayaran</h1>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-6">
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-money-bill"></i> Jumlah Bayar:</h5>
                        <p class="info-text text-success">Rp.{{  number_format($data['payment']->amount, 0, ',', '.')  }}</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-user"></i> Akun Pembayar:</h5>
                        <p class="info-text text-muted">{{ $data['payment']->user->email }}</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-user-graduate"></i> Detail Siswa:</h5>
                        <p class="info-text m-0">Nama : {{ $data['payment']->student->user->name }}</p>
                        <p class="info-text m-0">Nisn : {{ $data['payment']->student->nisn }}</p>

                    </div>
                </div>
                <div class="col-6">
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-tasks"></i> Detail Kegiatan:</h5>
                        <p class="info-text">Nama Kegiatan</p>
                    </div>
                    <div class="info-section">
                        <h5 class="info-title">Status:</h5>
                        <span class="badge bg-warning py-2 me-2">Pending</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end bg-light">
            <a href="/pengguna/payment/payment-batal/{{ $data['payment']->id }}" class="btn btn-danger me-2">Batalkan Pembayaran</a>
            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
        </div>
    </div>
    @endif

  
    



<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <div class="spinner-border text-primary mr-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-primary fs-4 mb-0">Loading</p> 
                </div>
                <p class="text-muted fs-6">Tunggu loading selesai</p> 
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_SERVERKEY') }}"></script>
<script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay("{{ $data['payment']->snap_token }}", {
          // Optional
          onSuccess: function(result){
             window.location.href = "{{ route('paymentSuccess',['payment' => $data['payment'] ]) }}";
          },
          // Optional
          onPending: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          },
          // Optional
          onError: function(result){
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
          }
        });
      };
    </script>
@endpush