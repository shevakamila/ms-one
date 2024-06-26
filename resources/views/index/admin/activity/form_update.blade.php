@extends('layouts.dashboard-admin')

@section('content-dashboard')

@php
    $activity = $data['activity'];
@endphp
<div class="container">
    <form action="/admin/activities/{{ $activity->id }}/update-kegiatan" method="post" enctype="multipart/form-data">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h3 class="m-0 font-weight-semibold text-primary">Update Kegiatan</h3>
            </div>
            <div class="card-body">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="image" class="form-label font-weight-bold">Gambar Kegiatan</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" placeholder="Masukkan gambar kegiatan"value="{{ old('name', $activity->image) }}">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label font-weight-bold">Nama Kegiatan</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama kegiatan" value="{{ old('name', $activity->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label font-weight-bold">Biaya Kegiatan</label>
                    <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Masukkan biaya kegiatan" value="{{ old('amount', $activity->amount) }}">
                    @error('amount')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="due_date" class="form-label font-weight-bold">Tanggal Kegiatan</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', $activity->due_date) }}">
                    @error('due_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label font-weight-bold">Deskripsi Kegiatan</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Masukkan deskripsi">{{ old('description', $activity->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_active" class="form-label font-weight-bold">Status Kegiatan</label>
                    <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $activity->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active', $activity->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Tambahkan field lainnya sesuai dengan atribut kegiatan yang ingin diupdate -->

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Update Kegiatan</button>
                </div>

            </div>
            
            
        </div>
    </form>
</div>

@push('js')


@endpush
@endsection
