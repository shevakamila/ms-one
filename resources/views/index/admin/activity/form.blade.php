@extends('layouts.dashboard-admin')

@section('content-dashboard')


<div class="container">
    <form action="/admin/activities/tambah-kegiatan" method="post" enctype="multipart/form-data">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h3 class="m-0 font-weight-bold text-primary">Tambah Kegiatan</h3>
            </div>
            <div class="card-body">
                @csrf
                <div class="mb-3">
                    <label for="image" class="form-label font-weight-bold">Gambar Kegiatan</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" placeholder="Masukkan gambar kegiatan" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label font-weight-bold">Nama Kegiatan</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama kegiatan" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label font-weight-bold">Biaya Kegiatan yang harus dibayarkan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Masukkan biaya kegiatan" value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}">
                    </div>
                    @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                
                
                <div class="mb-3">
                    <label for="due_date" class="form-label font-weight-bold">Tenggat Pembayaran</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label font-weight-bold">Deskripsi Kegiatan</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Masukkan deskripsi">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_for_all_students" name="is_for_all_students">
                    <label class="form-check-label" for="is_for_all_students">Kegiatan untuk semua siswa</label>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Tambah Kegiatan</button>
                </div>
            </div>
            
        </div>
    </form>
</div>

@push('js')


@endpush
@endsection
