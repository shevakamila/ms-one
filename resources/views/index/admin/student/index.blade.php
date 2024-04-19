@extends('layouts.dashboard-admin')

@section('content-dashboard')

     <h1 class="h3 mb-2 text-gray-800">Data Siswa</h1>


   
     <div class="card shadow mb-4">
       <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
       </div>
       <div class="card-body">
        <a href="{{ route('pageFormAddStudent') }}" class="btn btn-primary mb-3">Tambah Siswa</a>
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
    
         <div class="table-responsive ">
           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
             <thead>
               <tr>
                <th>No</th>
                <th>Name</th>
                <th>Nisn</th>
                <th>Unique Code</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Action</th>
               </tr>
             </thead>
             <tbody>
                @foreach ($data['students'] as $student)
               <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>{{ $student->user->name }}</td>
                 <td>{{ $student->nisn }}</td>
                 <td>{{ $student->unique_code }}</td>
                 <td>{{ $student->user->email }}</td>
                 <td>{{ $student->classRoom->name }}</td>
                 <td>{{ $student->gender }}</td>
                 <td>{{ $student->birthdate }}</td>
                 <td>
                  <div class="mb-1" role="group">
                    <a href="" class="btn btn-sm btn-primary">
                      <i class="bi bi-eye"></i>
                    </a>
                    <a href="/admin/students/{{ $student->id }}/update-siswa" class="btn btn-sm btn-warning">
                      <i class="bi bi-pencil"></i>
                    </a>
                  </div>
                  <div class="mb-1" role="group">
                    <a href="/admin/students/{{ $student->id }}/hapus-siswa" class="btn btn-sm btn-danger">
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
@endsection


@push('js')
     <!-- Page level plugins -->
     <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
 
     <!-- Page level custom scripts -->
     <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush

