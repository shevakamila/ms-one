@extends('layouts.dashboard-admin')

@section('content-dashboard')
<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800">Data Kegiatan</h1>
  <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
      For more information about DataTables, please visit the <a target="_blank"
          href="https://datatables.net">official DataTables documentation</a>.</p>


  <div class="row">
    <div class="col-md-8">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kelas</h6>
        </div>
        <div class="card-body">
          <a href="{{ route('pageFormAddActivity') }}" class="btn btn-primary mb-3">Tambah Activity</a>
          @if (session()->has('success'))
          <div class="success-alert">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
              {{ session('success') }}
          </div>
          @endif
          @if (session()->has('error'))
          <div class="error-alert">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
              {{ session('failed') }}
          </div>
          @endif
  
  
  
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                   </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                   </tr>
                </tfoot>
                <tbody>
                  @foreach ($data['classRooms'] as $classRoom)
                 <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>
                      <div class="accordion" id="accordionExample">
                          <div class="accordion-item">
                              <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClassRoomStudent{{ $classRoom->id }}" aria-expanded="false" aria-controls="collapseClassRoomStudent{{ $classRoom->id }}">
                                  {{ $classRoom->name }}
                                </button>
                              </h2>
                              <div id="collapseClassRoomStudent{{ $classRoom->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                  <ul>
                                      @forelse ($classRoom->students as $student)
                                      <li>{{ $loop->iteration }}.{{ $student->user->name }}-{{ $student->user->nisn }}</li>
                                      @empty
                                      Tidak Ada siswa
                                      @endforelse
                                  </ul>
                                </div>
                              </div>
                            </div>
                      </div>    
                    </td>
                    <td>   
                      <div class="mb-1" role="group">
                        <a class="btn btn-sm btn-warning btn-update" data-classRoomid="{{ $classRoom->id }}" >
                          <i class="bi bi-pencil"></i>  
                        </a>
                        <a href="/admin/classRoom/{{ $classRoom->id }}/hapus-kelas" class="btn btn-sm btn-danger">
                          <i class="bi bi-trash"></i>
                        </a>
                      </div>
                   </td>
                 </tr>
                 @endforeach
                </tbody>
            </table>
          </div>
  
  
        </div>
      </div>
  
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kelas</h6>
        </div>
        <div class="card-body">
            <form action="/admin/classRoom/tambah-kelas" method="post">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Masukan Nama kelas" name="name">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">Tambah Kelas</button>
                </div>
                
            </form>
        </div>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->


<!-- Modal Update -->
  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Update Class Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formUpdateClassRoom" action="" method="post">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="text" class="form-control" name="name" id="updateClassName" placeholder="Masukkan nama kelas">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button> <!-- Ubah type button menjadi submit -->
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection



@push('js')
     {{-- <!-- Page level plugins -->
     <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
 
     <!-- Page level custom scripts -->
     <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
     <script></script> --}}

     <script>
    $(document).ready(function() {
        $('.btn-update').click(function() {
            var classRoomId = $(this).data('classroomid');
            $.ajax({
                url: `/admin/classRoom/${classRoomId}/show`,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#updateFormContent').html(data);
                    $('#updateModal').modal('show');
                    $('#formUpdateClassRoom').attr("action",`/admin/classRoom/${classRoomId}/update-kelas`);
                    $('#updateClassName').val(data.data.classRoom.name); 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

    </script>
    

@endpush

