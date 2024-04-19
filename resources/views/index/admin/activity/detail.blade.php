@extends('layouts.dashboard-admin')
@push('style')

</style>
@endpush
@section('content-dashboard')
  <div class="row row-cols-1 row-col-md-2 row-cols-lg-3 row-cols-xl-4">

    <div class="col mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row align-items-center">
                  <div class="col mr-2">
                      <div class="text-s font-weight-bold text-primary text-uppercase mb-1">
                        Siswa Terdaftar </div>
                      <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['activity']->student_registered }}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fa-solid fa-user-graduate fa-2x text-primary"></i>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="col mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
          <div class="card-body">
              <div class="row align-items-center">
                  <div class="col mr-2">
                      <div class="text-s font-weight-bold text-danger text-uppercase mb-1">
                        Siswa Belum Lunas </div>
                      <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['activity']->student_not_paid}}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fa-solid fa-user-graduate fa-2x text-danger"></i>
                  </div>
              </div>
          </div>
      </div>
    </div>
    
    <div class="col mb-4">
      <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
              <div class="row align-items-center">
                  <div class="col mr-2">
                      <div class="text-s font-weight-bold text-success text-uppercase mb-1">
                         Siswa Lunas</div>
                      <div class="h5 mb-0 font-weight-bold text-dark">{{ $data['activity']->student_paid }}</div>
                  </div>
                  <div class="col-auto">
                      <i class="fa-solid fa-user-graduate fa-2x text-success"></i>
                  </div>
              </div>
          </div>
      </div>
    </div>

  </div>


  <div class="card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
      <h6 class="m-0 font-weight-bold text-primary">Detail Kegiatan</h6>
      <div>
          <a href="/admin/activities/{{ $data['activity']->id }}/update-kegiatan" class="btn btn-warning">Edit</a>
          <a href="/admin/activities/{{ $data['activity']->id }}/hapus-kegiatan" class="btn btn-danger ml-2">Hapus</a>
      </div>
  </div>
  
    <div class="card-body">
    
      <div class="row mt-2">
        <div class="col-md-4">
          <img src="{{ asset('img/asset/onedek-depan.jpg') }}" alt="Gambar Kegiatan" class="img-fluid rounded">
        </div>
        <div class="col-md-8">
          <h3 class="card-title mb-4 fw-bold">{{ $data['activity']->name }}</h3> 
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

     <div class="card shadow mb-4 mt-3">
       <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Siswa yang terdaftar kegiatan</h6>
       </div>
       <div class="card-body">
        <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            Tambahkan Siswa ke Kegiatan
        </button>

         <div class="table-responsive mt-3 ">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
             <thead>
               <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Name</th>
                <th>Kelas</th>
                <th>Status Pembayaran</th>
                <th>Action</th>
               </tr>
             </thead>
             <tbody>
    
                @foreach ($data['activity']->students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->nisn }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->classRoom->name }}</td>
                    <td class="text-center">
                        @if ($student->pivot->is_paid_off == true)
                        <span class="payment-status font-paid ">Lunas</span>
                        @else 
                        <span class="payment-status font-not-paid">Belum Lunas</span>
                        @endif
                    </td>
                    
                    <td>
                        <a href="" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> 
                        </a>
                        <a href="/admin/activities/{{ $data['activity']->id }}/{{ $student->id }}/hapus-siswa" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> 
                        </a>
                    </td>
                </tr>
                @endforeach
             </tbody>
           </table>
         </div>
       </div>
     </div>



     
<!-- MODAL TAMBAH SISWA KE KEGIATAN -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addStudentModalLabel">Pilih Siswa untuk Ditambahkan ke Kegiatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/admin/activities/{{ $data['activity']->id }}/tambah-siswa" method="post">
            @csrf
            @forelse ($data['unregistered_students'] as $classRoom)
            <div class="accordion my-2" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAddSiswa{{$classRoom->id}}" aria-expanded="false" aria-controls="collapseAddSiswa{{$classRoom->id}}">
                      {{$classRoom->name}}
                      </button>
                    </h2>
                    <div id="collapseAddSiswa{{$classRoom->id}}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                      <div class="accordion-body">
                      
                        @forelse ($classRoom->students as $student)
                        <div class="card p-1 my-2">
                            <div class="card-body p-0 px-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $student->id }}" id="student{{ $student->id }}" name="students[]">
                                    <label class="form-check-label" for="student{{ $student->id }}">
                                        {{ $student->user->name }}
                                    </label>
                                </div> 
                            </div>
                        </div>
                        @empty
                        Semua siswa sudah terdaftar
                        @endforelse
                       
                      </div>
                    </div>
                  </div>
              </div>
            @empty
                <h4 class="text-center">Semua siswa sudah terdaftar untuk kegiatan ini</h4>
            @endforelse
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>






<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-body">
        <h1 class="fs-3">Detail Pembayaran</h1>
        <div class="card border-left-primary">
          <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                  <div>
                      <h5 class="card-title mb-1" style="font-size: 14px;"><i class="fas fa-calendar-alt me-2"></i>12 April 2024</h5>
                      <p class="card-text" style="font-size: 18px;">$50</p>
                  </div>
                  <span class="payment-status font-paid text-success">Lunas</span>
              </div>
              <p class="mt-2 mb-0">Dibayar oleh: namaakun@gmail.com</p>
          </div>
      </div>
      
      
      
      
      
      
      </div>
    </div>
  </div>
</div>
@endsection


@push('js')
     <!-- Page level plugins -->
     <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
 
     <!-- Page level custom scripts -->
     <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush

