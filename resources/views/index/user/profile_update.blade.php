@extends('layouts.view-main')

@push('style')
<style>

</style>
@endpush

@section('container')
@include('partials.view-user.navbar')

<div class="container mt-5">

    <div class="card" style="border-radius: 4px">
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-4">
                        <img src="" alt="">
                    </div>
                    <div class="col-8">
                        <div class="mb-2">
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



@endsection
