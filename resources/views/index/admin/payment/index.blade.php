@extends('layouts.dashboard-admin')

@section('content-dashboard')

     <h1 class="h3 mb-2 text-gray-800">Data Payment</h1>

     <div class="card shadow mb-4">
       <div class="card-header py-3">
         <h6 class="m-0 font-weight-bold text-primary">Data Payment</h6>
       </div>
       <div class="card-body">
        @if (session()->has('success'))
        <div class="success-alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';" >&times;</span> 
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
                <th>Status</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Account Pembayar</th>
                <th>Action</th>
               </tr>
             </thead>
             <tbody>
                @foreach ($data['payments'] as $payment)
               <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td class="text-center">
                    @if ($payment->status === 'paid')
                    <span class="payment-status font-paid ">Success</span>
                    @elseif($payment->status === 'pending')
                    <span class="payment-status font-not-paid-yet">Pending</span>
                    @else 
                    <span class="payment-status font-not-paid">Failed</span>
                    @endif
                </td>
                 <td>{{ $payment->student->user->name }}</td>
                 <td>{{ $payment->student->nisn }}</td>
                 <td>{{ $payment->user->email }}</td>
            
                 <td>
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

