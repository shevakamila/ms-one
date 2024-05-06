@extends('layouts.view-main')
@push('css')
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



</style>
@endpush
@section('container')
@include('partials.view-user.navbar')

<div class="container mt-5"  style="min-height: 350px;">
    @if ($data['is_paid_off'] == true)
    <div class="card bg-success text-white mb-3">
        <div class="card-body">
            <h5 class="card-title">Pembayaran Telah Dilunasi</h5>
            <p class="card-text">Terima kasih! Pembayaran untuk kegiatan ini telah dilunasi.</p>
        </div>
    </div>
    @endif

   
      
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('img/activity/'.$data['activity']->image) }}" alt="Gambar Kegiatan" class="img-fluid rounded">
        </div>
        <div class="col-md-7">
            <div class="card-body">
                <h3 class="card-title mb-4 fw-bold">{{ $data['activity']->name }}</h3> <!-- Judul lebih besar dan tebal -->
                <p class="card-text mb-3"><span class="fw-bold">Biaya Kegiatan:</span> Rp. {{ number_format($data['activity']->amount, 0, ',', '.') }}</p>
                <p class="card-text mb-3"><span class="fw-bold">Tenggat Pembayaran:</span> {{ date('d F Y', strtotime($data['activity']->due_date)) }}</p>
                <p class="card-text mb-1"><span class="fw-bold">Deskripsi:</span></p>
                <p class="card-text mb-0">
                    {{ $data['activity']->description }}
                </p>
            </div>
            
        </div>
    </div>
    
</div>


<div class="container mt-4 " style="min-height: 350px;">

    <div class="row">
        <div class="col-md-7 d-flex">
            <div class="row row-cols-2 align-items-center w-100">
                <div class="col mt-2">
                    <div class="card border-left-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Total dibayarkan:</p>
                               
                                <p class="fw-semibold fs-5">{{ number_format($data['activity']->getTotalAmountPayment($data['student']->id,$data['activity']->id), 0, ',', '.') }}</p>
                            </div>
                            <i class="fas fa-money-bill-alt fa-2x text-green"></i>
                        </div>
                    </div>
                </div>
            
                <div class="col mt-2">
                    <div class="card border-left-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Total Kurang:</p>
                                <p class="fw-semibold fs-5">{{ number_format($data['activity']->getOutstandingAmountPayment($data['student']->id,$data['activity']->id), 0, ',', '.') }}</p>
                            </div>
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            
                <div class="col mt-2">
                    <div class="card border-left-success h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Pembayaran Berhasil:</p>
                                <p class="fw-semibold fs-5">{{ $data['activity']->getCountPayment($data['student']->id,$data['activity']->id) }}</p>
                            </div>
                            <i class="fas fa-check-circle fa-2x text-green"></i>
                        </div>
                    </div>
                </div>
            
                <div class="col mt-2">
                    <div class="card border-left-danger h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0">Pembayaran Gagal:</p>
                                <p class="fw-semibold fs-5">{{ number_format($data['activity']->getOutstandingAmountPayment($data['student']->id,$data['activity']->id), 0, ',', '.') }}</p>
                            </div>
                            <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-5 mt-2">

            @if ($data['is_paid_off'] == false)
            <div class="card border-left-primary">
                <div class="card-body">
                    <i class="fas fa-money-bill-wave text-primary"></i>
                    <h5 class="card-title mb-4">Pembayaran</h5>
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
                    <form action="/pengguna/payment/payment-checkout" method="post">
                        @csrf
                        <input type="hidden" name="activity_id" value="{{ $data['activity']->id }}">
                        <input type="hidden" name="student_id" value="{{ $data['student']->id }}">
                        <input type="hidden" name="amount" id="inputAmount">
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah Pembayaran</label>
                            <input type="text" class="form-control" id="inputAmountDummy" placeholder="Masukkan Jumlah Pembayaran" name="amountDummy" oninput="formatAmount(this)">
                        </div>
                        <button class="btn btn-success w-100 pay-button" data-bs-toggle="modal" data-bs-target="#loadingModal" type="submit "><i class="fas fa-money-check"></i> Bayar Sekarang</button>
                    </form>
                    
                </div>
            </div>
            @else

            @endif

        </div>
    </div>



</div>

<footer class="footer bg-dark text-white mt-4">
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h5>MS ONE</h5>
                <h6>SMKN 1 Depok</h6>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore ea in assumenda temporibus consequuntur provident!</p>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2 mb-4">
                <h5>Layanan</h5>
                
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Produk</a></li>
                    <li><a href="#" class="text-white">Harga</a></li>
                    <li><a href="#" class="text-white">Promosi</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h5>Ikuti Kami</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-instagram"></i> Instagram</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <p class="mb-0">&copy; 2024 Nama Situs. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true" aria-labelledby="staticBackdropLabel" data-bs-backdrop="static">
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
<script>
    function formatAmount(input) {

        let value = input.value.replace(/\D/g, '');
        
        let formattedValue = new Intl.NumberFormat('id-ID').format(value);
        input.value = formattedValue;
        
        // Set nilai input amount ke nilai yang sebenarnya
        document.getElementById('inputAmount').value = value;
    }
</script>


@endpush

