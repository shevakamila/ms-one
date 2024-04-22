@extends('layouts.view-main')

@push('style')

@endpush

@section('container')
@include('partials.view-user.navbar')

<div class="container mt-5">
    <h1 class="fs-2 text-center fw-bold mb-4">Tentang Kami</h1>

    <div class="row mt-5">
        <div class="col-md-4 d-flex justify-content-center align-items-center">
            <h3 class="text-center fw-bold mb-4">Apa itu MS-ONE</h3>
        </div>
        <div class="col-md-8 card card-body">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget velit ac ipsum tincidunt mattis. Vestibulum
                tristique ipsum nec arcu euismod, vitae gravida mi fermentum. Proin tincidunt ultrices leo, nec feugiat
                ipsum aliquam id. Donec in mi ac augue ultricies rutrum.
            </p>
            <p>
                Sed aliquet metus ut fermentum aliquam. Proin volutpat, mauris at aliquam dignissim, nisi velit aliquam
                lorem, nec malesuada odio nisl vel libero. Mauris sollicitudin dui ut felis condimentum viverra.
            </p>
        </div>
    </div>

   
</div>

@endsection
