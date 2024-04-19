@extends('layouts.dashboard-admin')

@section('content-dashboard')
<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800">Data Kegiatan</h1>
  <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
      For more information about DataTables, please visit the <a target="_blank"
          href="https://datatables.net">official DataTables documentation</a>.</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Data Admin</h6>
      </div>
      <div class="card-body">
        <a href="/admin/admins/page-tambah-admin" class="btn btn-primary mb-3">Tambah Admin</a>
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
                  <th>Gambar</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Action</th>
                 </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($data['admins'] as $admin)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td class="text-center">
                    @if($admin->image)
                        <img src="{{ asset('img/admin/'.$admin->image) }}" alt="{{ $admin->name }}" width="50" height="50" style="max-width: 100%; height: auto;">
                    @else
                        <span>No Image</span>
                    @endif
                  </td>
                

                  <td>{{ $admin->name }}</td>
                  <td>{{ $admin->username }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>
                  
                    <div class="mb-1 d-block" role="group">
                      <a href="/admin/admins/{{ $admin->id }}/detail-admin" class="btn btn-sm btn-primary">
                          <i class="bi bi-eye"></i>
                      </a>
                      <a href="/admin/admins/{{ $admin->id }}/hapus-admin" class="btn btn-sm btn-danger">
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
<!-- /.container-fluid -->

   
@endsection


@push('js')
     <!-- Page level plugins -->
     <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
 
     <!-- Page level custom scripts -->
     <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush

