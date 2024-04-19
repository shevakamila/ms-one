@extends('layouts.dashboard-admin')

@section('content-dashboard')

@push('style')
    <style>
        .file-name {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.border-danger{
    border: 2px solid red;
    border-radius: 2px;
}
    </style>
@endpush


    <form action="/admin/admins/tambah-admin" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="font-weight-semibold text-primary">Gambar</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h4 id="select-image-text">Pilih Gambar
                                <span>
                                    <br>
                                    (Optional)
                                </span>
                            </h4>
                            <img id="preview" class="my-2" style="max-width:100%; max-height:200px;">
                        </div>
                    </div>
                    <div class="card-footer @error('image') border-danger @enderror">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="file-name">
                                <span id="file-name"></span>
                            </div>
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" class="d-none">
                            <label for="image" class="btn btn-primary btn-sm mb-0">Pilih Gambar</label> <!-- Ubah id menjadi "image" -->
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="font-weight-semibold text-primary">Tambah Admin</h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label font-weight-bold">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama admin"  value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label font-weight-bold">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan username admin"  value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label font-weight-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email admin"  value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label font-weight-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password admin"  value="{{ old('password') }}">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmed_password" class="form-label font-weight-bold">Confirmed Password</label>
                            <input type="password" class="form-control @error('confirmed_password') is-invalid @enderror" id="confirmed_password" name="confirmed_password" placeholder="Masukkan Confirmer Password"  value="{{ old('confirmed_password') }}">
                            @error('confirmed_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                       
                        
                     

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Tambah</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </form>

@push('js')
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('preview');
            output.src = reader.result;
            document.getElementById('select-image-text').style.display = 'none'; // Menyembunyikan teks "Pilih Gambar"
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush


@endsection
