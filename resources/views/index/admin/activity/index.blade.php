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
          <h6 class="m-0 font-weight-bold text-primary">Data Kegiatan</h6>
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
            {{ session('error') }}
        </div>
        @endif



        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Tenggat Pembayaran</th>
                  <th>Biaya Kegiatan</th>
                  <th>Status Kegiatan</th>
                  <th>Action</th>
                 </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Tenggat Pembayaran</th>
                  <th>Biaya Kegiatan</th>
                  <th>Status Kegiatan</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($data['activities'] as $activity)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $activity->name }}</td>
                  <td>{{ date('d-M-Y', strtotime($activity->due_date)) }}</td>
 
                  <td class="text-center">
                    @if ($activity->is_active == true)
                    <span class="payment-status font-paid ">Active</span>
    
                    @else 
                    <span class="payment-status font-not-paid">Not Active</span>
                    @endif
                  </td>
                  <td>Rp.{{ number_format($activity->amount, 0, ',', '.')  }}</td>
                  <td>
                    <!-- Baris pertama -->
                    <div class="mb-1 d-block" role="group">
                      <a href="/admin/activities/{{ $activity->id }}/detail-kegiatan" class="btn btn-sm btn-primary">
                          <i class="bi bi-eye"></i>
                      </a>
                      <a href="/admin/activities/{{ $activity->id }}/update-kegiatan" class="btn btn-sm btn-warning">
                          <i class="bi bi-pencil"></i>
                      </a>
                    </div>

                    <!-- Baris kedua -->
                    <div class="mb-1 " role="group">
                        <a href="/admin/activities/{{ $activity->id }}/hapus-kegiatan" class="btn btn-sm btn-danger">
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

