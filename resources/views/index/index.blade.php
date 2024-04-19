@extends('layouts.view-main')

@push('style')
<style>
    body{
        background-color: #F0F8FF;
    }
    #beranda{
        min-height: 600px;
        padding-top: 60px;
    }

    .text-dongker {
        color: #343F52;
    }

    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px; 
        opacity: 0;
        transition: opacity 0.8s ease; 
    }

    .image-container img {
        width: 100%;
        height: auto; 
        border: 1px solid #dee2e6;
        border-radius: 10px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        transition: transform 0.3s ease, opacity 0.8s ease; /* Menambahkan transition untuk transform dan opacity */
    }

    .image-container:hover img {
        transform: scale(1.05); 
    }

    /* Animasi untuk teks datang dari kiri */
    @keyframes slideInFromLeft {
        0% {
            transform: translateX(-100%);
            opacity: 0;
        }
        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .animated-text {
        animation: slideInFromLeft 1s ease-out forwards; 
    }

    /* Animasi untuk memunculkan gambar */
    .image-container.animate {
        opacity: 1;
    }

    /* Mengatur delay untuk setiap teks */
    .animated-text:nth-child(1) {
        animation-delay: 0.1s;
    }

    .animated-text:nth-child(2) {
        animation-delay: 0.2s;
    }

    .animated-text:nth-child(3) {
        animation-delay: 0.3s;
    }


    .beranda-detail h1 {
        font-size: 44px;
    }
    
  
    
    .beranda-detail p {
        font-size: 20px;
    }
    
    .beranda-detail .btn {
        font-size: 16px; /* Ukuran font tombol lebih kecil */
        padding: 10px 20px; /* Mengurangi padding tombol */
    }
@media (max-width: 768px) {
    #beranda{
        padding-top: 10px;
    }
    .row {
        flex-direction: column-reverse; 
    }
    
    .col-md-5 {
        text-align: center;
    }
    
    .col-md-6 {
        margin-top: 20px; 
    }

    .beranda-detail h1 {
        font-size: 32px; /* Ukuran font lebih kecil */
    }
    
    .beranda-detail h3 {
        font-size: 20px; /* Ukuran font lebih kecil */
    }
    
    .beranda-detail p {
        font-size: 15px; /* Ukuran font lebih kecil */
    }
    
    .beranda-detail .btn {
        font-size: 16px; /* Ukuran font tombol lebih kecil */
        padding: 10px 20px; /* Mengurangi padding tombol */
    }
}


</style>
@endpush

@section('container')
@include('partials.view-user.navbar')
<div  id="beranda">
    <div class="container  " >
        <div class="row beranda-row">
            <div class="col-md-5 beranda-detail">
                <!-- Teks dengan animasi datang dari kiri -->
                <h1 class="text-dongker fw-semibold animated-text my-2">Welcome to <span class="text-primary">MS ONE </span> </h1>
                <h3 class="text-dongker fw-semibold animated-text my-1 ">   <span class="text-primary">SMKN 1 DEPOK</span> </h3>
                <p  class="animated-text mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere perferendis maxime porro ipsam placeat animi dolorem. Quasi ut quos illo fuga vero, asperiores nobis iusto distinctio officiis minus numquam obcaecati?</p>
                <a href="/pengguna/payment/list-payment" class="btn btn-primary animated-text py-2 px-5 mt-2">Cek Tagihan!</a>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <!-- Menambahkan container untuk gambar -->
                <div class="image-container animate">
                    <img src="{{ asset('img/asset/onedek-depan.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

    @include('partials.view-user.footer')
@endsection
