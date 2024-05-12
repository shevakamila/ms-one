@extends('layouts.dashboard-admin')

@section('content-dashboard')

@push('style')
    <style>
        .file-name {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .border-danger {
            border: 2px solid red;
            border-radius: 2px;
        }
    </style>
@endpush

<form action="/admin/students/{{ $data['student']['id'] }}/update-siswa" method="post" enctype="multipart/form-data">
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header">
                    <h4 class="m-0 font-weight-bold text-primary">Gambar Siswa</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h3 id="select-image-text">Pilih Gambar</h3>
                        <img id="preview" class="my-2" style="max-width:100%; max-height:200px;">
                    </div>
                </div>
                <div class="card-footer @error('image') border-danger @enderror">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="file-name">
                            <span id="file-name"></span>
                        </div>
                        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" class="d-none">
                        <label for="image" class="btn btn-primary btn-sm mb-0">Pilih Gambar</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h3 class="m-0 font-weight-bold text-primary">Data Siswa</h3>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold">Nama siswa</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama siswa" value="{{ $data['student']->user->name }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nisn" class="form-label font-weight-bold">NISN siswa</label>
                        <input type="text" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" placeholder="Masukkan NISN siswa" value="{{ $data['student']['nisn'] }}">
                        @error('nisn')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label font-weight-bold">Email siswa</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email siswa" value="{{ $data['student']->user->email}}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Gender siswa</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $data['student']['gender']=== 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="male">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $data['student']['gender']=== 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="female">
                                Perempuan
                            </label>
                        </div>
                        @error('gender')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="birthdate" class="form-label font-weight-bold">Tanggal lahir siswa</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ $data['student']['birthdate'] }}">
                        @error('birthdate')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="class_room_id" class="form-label">Pilih Kelas</label>
                        <select name="class_room_id" class="form-control @error('class_room_id') is-invalid @enderror">
                            <option value="" selected>Pilih Kelas</option>
                            @forelse ($data['classRoom'] as $class)
                                <option value="{{ $class->id }}" {{ $data['student']['class_room_id'] == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kelas tersedia</option>
                            @endforelse
                        </select>
                        @error('class_room_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Update Siswa</button>
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
